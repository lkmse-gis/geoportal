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
$art=$_POST["art"];
$count=0;


if ($region_id >= 1)
  {
    $query="SELECT name FROM government.regionen WHERE gid='$region_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $region=$r[name];
	  	
		$query="SELECT c.oid,a.new_gid,a.jab_name,a.ortsteil, a.plz_ort,a.telefon,a.mail_1,a.strasse_hnr, d.jab_typ,to_char(d.pacht_ende,'dd.mm.yyyy') as pacht_ende, c.name  FROM jagdkataster.jagdbezirke as c , government.regionen as b, jagdkataster.jb_jab as a, jagdkataster.jb_stammdaten as d WHERE a.endet IS NULL AND c.endet IS NULL AND (a.new_gid=c.new_gid) AND (a.new_gid=d.new_gid) AND st_intersects(st_transform(c.the_geom,25833),b.the_geom) AND b.gid='$region_id'";
        if (strlen($filter) > 0) $query=$query." AND a.jab_name LIKE '%$filter%' ";
		if ($art != '') $query=$query. " AND d.jab_typ = '$art' ";
		$query=$query."	ORDER BY a.jab_name";
		
		
	
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
	   	$query="SELECT c.oid,a.new_gid,a.jab_name, a.ortsteil,a.plz_ort,a.strasse_hnr,a.telefon,a.mail_1, d.jab_typ,to_char(d.pacht_ende,'dd.mm.yyyy') as pacht_ende, c.name  FROM jagdkataster.jagdbezirke as c ,  jagdkataster.jb_jab as a, jagdkataster.jb_stammdaten as d WHERE a.endet IS NULL AND c.endet IS NULL AND (a.new_gid=c.new_gid) AND (a.new_gid=d.new_gid) ";
        if (strlen($filter) > 0) $query=$query." AND a.jab_name LIKE '%$filter%' ";
		if ($art != '') $query=$query. " AND d.jab_typ = '$art' ";
		$query=$query."	ORDER BY a.jab_name";
		
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
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css" />
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
	<form action="liste_jagdkataster_region.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="Jagdkataster-Liste">
	  </form>
	  </td>
	  <td width=200>
	  <form action="liste_vorstand_region.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="Vorstandssuche">
	  </form>
	  </td>
  </tr>
</table>  
<h2> Liste der Jagdausübungsberechtigten - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'kvwmap')
    {
	 echo 'Region: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="post" name="region">
	        
			<select  name="region" onchange="document.region.submit();">
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
	  if ($count == 1) echo $count," Jagdausübungsberechtigter ";
	  if ($count != 1) echo $count," Jagdausübungsberechtigte ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>
<tr><td valign=top align=left>
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
    Name: <input  type=text name="filter" value="<?php echo $filter ?>" length=50>
	</td>
	<td colspan=2> Art der Jagdausübung:  
	<select name="art">
	<option value=''>kein Filter</option>
	<option value="Pacht" <?php if ($art == 'Pacht') echo " selected"; ?>>Pacht</option>
	<option value="Eigentümer" <?php if ($art == 'Eigentümer') echo " selected"; ?>>Eigentümer</option>
	<option value="angestellter Jäger" <?php if ($art == 'angestellter Jäger') echo " selected"; ?>>angestellter Jäger</option>
	<option value="Benennung" <?php if ($art == 'Benennung') echo " selected"; ?>>Benennung</option>
	<option value="Anpacht" <?php if ($art == 'Anpacht') echo " selected"; ?>>Anpacht</option>
	<option value="Verzicht" <?php if ($art == 'Verzicht') echo " selected"; ?>>Verzicht</option>
	</select>
	
	<input type=submit value="Filter anwenden">
	</form>
</td></tr>
<?php
echo '<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=150></td>';
echo "<td height=30 width=200><b>JAB</b></td>
	<td  align=center height=30 width=300><b>PLZ/Ort</b></td>
	<td align=center height=30 width=100><b>Art/Ende</b></td>
	<td align=center height=30 width=200><b>Jagdbezirk</b></td>
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
		  if ($bd[$v][ziel_status] == 'in Bearbeitung') 
		     {
			   echo '<td align=center>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Objekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_new_gid==&selected_layer_id=60040&value_new_gid=',$bd[$v][new_gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			  else
			  {
			   echo '<td align=center>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_new_gid==&selected_layer_id=60040&value_new_gid=',$bd[$v][new_gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			echo '<td align=center>',$bd[$v][jab_name],'</td><td>';
			
			if (strlen($bd[$v][strasse_hnr]) > 0) echo $bd[$v][strasse_hnr];
			if (strlen($bd[$v][ortsteil]) > 0) echo '<br>',$bd[$v][ortsteil];
			if (strlen($bd[$v][plz_ort]) > 0) echo '<br>',$bd[$v][plz_ort];
			if (strlen($bd[$v][telefon]) > 0) echo '<br>',$bd[$v][telefon];
			if (strlen($bd[$v][mail_1]) > 0) echo '<br>',$bd[$v][mail_1];
			echo '</td>';
			
			
			echo '<td align=left> ',$bd[$v][jab_typ];
			if (strlen($bd[$v][pacht_ende]) > 0) echo '<br>',$bd[$v][pacht_ende];
			echo '</td>';
			echo '<td align=left>',$bd[$v][name],'</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 }
}
else echo "Zugiff nicht erlaubt...";
?>
</body>
</html>