<?php
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');
session_start();

$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true)
{
	$_SESSION["pruef"] = (isset($_SESSION["pruef"])?$_SESSION["pruef"]:true);
	$status='angemeldet';
	

$datum = getdate(time());
$year=$datum[year];
$month=$datum[mon];
$day=$datum[mday];
$hour=$datum[hours];
$minute=$datum[minutes];
$second=$datum[seconds];
if (strlen($month) == 1) $month='0'.$month;
if (strlen($day) == 1) $day='0'.$day;
if (strlen($hour) == 1) $hour='0'.$hour;
if (strlen($minute) == 1) $minute='0'.$minute;
if (strlen($second) == 1) $second='0'.$second;
$heute=$day.'.'.$month.'.'.$year;
$modus=$_GET["modus"];
$post_modus=$_POST["post_modus"];
if (!isset($modus) AND isset($post_modus)) $modus="kvwmap";
$region_id=$_POST["region"];
unset($ejb);
unset($gjb);
$filter=$_POST["filter"];
if (strlen($filter) == 0) unset($filter);
$art=$_POST["art"];
if ($art == "x") unset($art);
$hg=$_POST["hg"];
$verzicht=$_POST["verzicht"];
$jaa=$_POST["jaa"];
if ($jaa == "x") unset($jaa);
$ejb_klass=$_POST["ejb_klass"];
if ($ejb_klass == "x") unset($ejb_klass);
$count=0;



if ($region_id >= 1)
  {
    $query="SELECT name FROM government.regionen WHERE gid='$region_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $region=$r[name];
	  	
		$query="SELECT a.oid, a.new_gid, a.id, c.bezeichnung, a.flaeche, a.name,h.jab_typ,h.ejb_eigentumsform,h.hege_id,h.ejb_interner_name,(SELECT name FROM jagdkataster.jb_hegegemeinschaften WHERE hege_id=h.hege_id) as hg_name FROM jagdkataster.jagdbezirke as a LEFT JOIN jagdkataster.jb_stammdaten as h ON a.new_gid=h.new_gid, government.regionen as b, jagdkataster.jagdbezirkart as c  WHERE (a.art=c.art) AND a.endet IS NULL  AND st_intersects(st_transform(a.the_geom,25833),b.the_geom) AND b.gid='$region_id'";
        if (isset($filter)) $query=$query." AND (a.name LIKE '%$filter%' OR h.ejb_interner_name LIKE '%$filter%') ";
		if (isset($art)) 
          	if ($art != 'ejb') $query=$query. " AND a.art = '$art' ";
			else $query=$query." AND (a.art='ejb' OR a.art='atf') ";
		if (isset($hg)) $query=$query. " AND h.hege_id IS NOT NULL ";
		if (isset($verzicht)) $query=$query. " AND a.verzicht ";
		if (isset($jaa)) $query=$query. " AND h.jab_typ = '$jaa' ";
		if (isset($ejb_klass)) $query=$query. " AND h.ejb_eigentumsform = '$ejb_klass' ";
		$query=$query."	ORDER BY a.name";
		
		
	
	$result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
  }
  else 
  {
   $region="Gesamtliste";
   if ($modus != 'kvwmap')
   {
	   	$query="SELECT a.oid, a.new_gid, a.id, c.bezeichnung, a.flaeche, a.name,h.jab_typ,h.ejb_eigentumsform,h.hege_id,h.ejb_interner_name,(SELECT name FROM jagdkataster.jb_hegegemeinschaften WHERE hege_id=h.hege_id) as hg_name FROM jagdkataster.jagdbezirke as a LEFT JOIN jagdkataster.jb_stammdaten as h ON a.new_gid=h.new_gid, jagdkataster.jagdbezirkart as c WHERE (a.art=c.art) AND a.endet IS NULL";
		if (isset($filter)) $query=$query." AND (a.name LIKE '%$filter%' OR h.ejb_interner_name LIKE '%$filter%') ";
		if (isset($art)) 
          	if ($art != 'ejb') $query=$query. " AND a.art = '$art' ";
			else $query=$query." AND (a.art='ejb' OR a.art='atf') ";
		if (isset($hg)) $query=$query. " AND h.hege_id IS NOT NULL ";
		if (isset($verzicht)) $query=$query. " AND a.verzicht ";
		if (isset($jaa)) $query=$query. " AND h.jab_typ = '$jaa' ";
		if (isset($ejb_klass)) $query=$query. " AND h.ejb_eigentumsform = '$ejb_klass' ";
		$query=$query."	ORDER BY a.name";
		
		
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	}
	
  }
  #echo $query;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
	<head>
		
		<link href="css/style_css.php" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
	</head>
<body>

<div align=center>
<img src="../../images/geoportal_logo.png" width=1200 >
<table>
  <tr>
    <td width=200>
	  <form action="liste_jab_region.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="JAB-Liste">
	  </form>
	  <td>
	  <td width=200>
	  <form action="liste_vorstand_region.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="Vorstandssuche">
	  </form>
	  <td>
	  <td width=200>
	  <form action="liste_hg.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="JB in Hegegemeinschaften">
	  </form>
	  <td>
  </tr>
</table>  
<h2> Liste der Jagdbezirke - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'kvwmap')
    {
	 echo 'Region: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="post" name="region">
	        
			<select class="select_ort" name="region" onchange="document.region.submit();">
			<option >Bitte auswählen</option>
			<option value="0">Gesamtliste</option>';
			
	  $query="SELECT name,gid FROM  government.regionen ORDER BY name";
	  $result = $dbqueryp($connectp,$query);
      while($r = $fetcharrayp($result))
		{
  		echo "<option ";
		
		echo" value=\"$r[gid]\"";
		if ($r[gid] == $region_id) echo "selected";
		echo ">";
		
		echo "$r[name]</option>\n";
		}
		echo "</select></form>";
	}
    else 
	{
	  echo "<h3>",$region," - ";
	  if (!isset($count)) echo "keine";
	  if ($count == 1) echo $count," Jagdbezirk ";
	  if ($count != 1) echo $count," Jagdbezirke ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>
<tr valign=top>
<td align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=kvwmap"><img src="../../kvwmap/graphics/rows.png" width=20 title="andere Gemeinde oder Ortslage wählen" border=0></a>';
 if ($modus != 'kvwmap' AND isset($count))
 {
	echo '
<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
  </td>
';
?>
<td><form action="<?php echo $_SERVER["PHP_SELF"] ?>" method=POST name="filter">
    <input type=hidden name="region" value=<?php echo $region_id ?>>
    Name (auch intern): <input  type=text name="filter" value="<?php echo $filter ?>" length=50>
	</td>
	<td> Art:
	<select name="art">
	  <option value="x">alle Arten</option>
	  <?
	    $query="SELECT art,bezeichnung FROM jagdkataster.jagdbezirkart ORDER BY bezeichnung;";
		$result = $dbqueryp($connectp,$query);
         while($r = $fetcharrayp($result))
		  {
  		   echo "<option ";		
		   echo" value=\"$r[art]\"";
		   if ($r[art] == $art) echo "selected";
		   echo ">",$r[bezeichnung],"</option>\n";
		  }
		?>
	 </select>
	 Jagdausübung:
	 <select name="jaa">
	  <option value="x">alle Arten</option>
	  <?
	    $query="SELECT art FROM jagdkataster.jagdausuebung_art;";
		$result = $dbqueryp($connectp,$query);
         while($r = $fetcharrayp($result))
		  {
  		   echo "<option ";		
		   echo" value=\"$r[art]\"";
		   if ($r[art] == $jaa) echo "selected";
		   echo ">",$r[art],"</option>\n";
		  }
		?>
	 </select>
	 EJB-Eigentumsform:
	 <select name="ejb_klass">
	  <option value="x">alle Arten</option>
	  <option  value="Bund" <? if ($ejb_klass == "Bund") echo " selected"; ?>>Bund</option>
	  <option  value="Bundesanstalt" <? if ($ejb_klass == "Bundesanstalt") echo " selected"; ?>>Bundesanstalt</option>
	  <option  value="BVVG" <? if ($ejb_klass == "BVVG") echo " selected"; ?>>BVVG</option>
	  <option  value="Gemeinschaft" <? if ($ejb_klass == "Gemeinschaft") echo " selected"; ?>>Gemeinschaft</option>
	  <option  value="Kirche" <? if ($ejb_klass == "Kirche") echo " selected"; ?>>Kirche</option>
	  <option  value="Kommune" <? if ($ejb_klass == "Kommune") echo " selected"; ?>>Kommune</option>
	  <option  value="Land" <? if ($ejb_klass == "Land") echo " selected"; ?>>Land</option>
	  <option  value="Landesforst" <? if ($ejb_klass == "Landesforst") echo " selected"; ?>>Landesforst</option>
	  <option  value="Nationalparkamt" <? if ($ejb_klass == "Nationalparkamt") echo " selected"; ?>>Nationalparkamt</option>
	  <option  value="privat" <? if ($ejb_klass == "privat") echo " selected"; ?>>privat</option>
	  <option  value="Stiftung" <? if ($ejb_klass == "Stiftung") echo " selected"; ?>>Stiftung</option>
	 </select>
    	
	<input type=checkbox id="hg" name="hg" value="hg" <?php if ($hg == 'hg') echo " checked" ?>> in HG
	<input type=checkbox id="verzicht" name="verzicht" value="verzicht" <?php if ($verzicht == 'verzicht') echo " checked" ?>> Verzicht
	
	
	<input type=submit value="Filter anwenden">
	</form></td>
	<td>
	<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method=POST name="filter_reset">
	<input type=hidden name="region" value=<?php echo $region_id ?>>
	<input type=submit value="Filter zurücksetzen">
	</form>
</td></tr>
</table>
<table>
<?php
echo '<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=150></td>';
echo "<td height=30 width=80><b>Aktenzeichen</b></td>
	<td  align=center height=30 width=150><b>Jagdbezirk</b></td>
	<td  align=center height=30 width=150><b>interner Name</b></td>
	<td  align=center height=30 width=300><b>Art</b></td>
	<td  align=center height=30 width=200><b>Art der Jagdausübung</b></td>
	<td  align=center height=30 width=200><b>EJB-Eigentumsform</b></td>
	<td align=center height=30 width=80><b>Fläche</b></td>
	<td align=center height=30 width=200><b>Hegegemeinschaft</b></td>
</tr>";

 for($v=0;$v<$z;$v++)
	{   
			$quot=$v;
			if($quot%2 != 0){
				echo "<tr bgcolor='#FCFCFC'";
			} else { 
			echo "<tr bgcolor='#d2e8ff'";
			}
		echo ">";
		
		if ($status == 'angemeldet') 
		 
			  {
			   echo '<td align=center>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_new_gid==&selected_layer_id=60040&value_new_gid=',$bd[$v][new_gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			echo '<td align=center>',$bd[$v][new_gid],'</td>';
			
			echo '<td align=left>',$bd[$v][name],'</td>';
			echo '<td align=left>',$bd[$v][ejb_interner_name],'</td>';
			
			echo '<td align=left> ',$bd[$v][bezeichnung],'</td>';
			echo '<td align=left> ',$bd[$v][jab_typ],'</td>';
			echo '<td align=left> ',$bd[$v][ejb_eigentumsform],'</td>';
			echo '<td align=left>',$bd[$v][flaeche],' ha</td>';
			echo '<td align=left>',$bd[$v][hg_name],'</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 }
}
else echo "Zugiff nicht erlaubt...";
?>
</body>
</html>