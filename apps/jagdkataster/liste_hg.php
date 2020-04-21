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
$hg_id=$_POST["hg"];
unset($ejb);
unset($gjb);
$filter=$_POST["filter"];


$wildnachweisung=$_POST["wildnachweisung"];

$count=0;



if ($hg_id >= 1)
  {
    $query="SELECT name FROM jagdkataster.jb_hegegemeinschaften WHERE hege_id='$hg_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $hg_name=$r[name];
	  	
		$query="SELECT a.oid, a.new_gid, a.id, c.bezeichnung, a.flaeche, a.name,h.jab_typ,h.hege_id,hg.name as hg_name,array_to_string(ARRAY( SELECT  jahrgang::text || '<br>' FROM jagdkataster.jb_wildnachweisung WHERE new_gid=a.new_gid ORDER BY jahrgang), ''::text) AS wildnachweisungen  FROM jagdkataster.jagdbezirke as a LEFT JOIN jagdkataster.jb_stammdaten as h ON a.new_gid=h.new_gid,jagdkataster.jagdbezirkart as c,jagdkataster.jb_hegegemeinschaften as hg  WHERE (a.art=c.art) AND a.endet IS NULL AND a.art IN ('ejb','gjb','tjb') AND h.hege_id=hg.hege_id AND h.hege_id ='$hg_id' ";
        if (strlen($filter) > 0) $query=$query." AND hg.name LIKE '%$filter%' ";
		if (isset($wildnachweisung)) $query=$query. " AND length(array_to_string(ARRAY( SELECT  jahrgang::text || '<br>' FROM jagdkataster.jb_wildnachweisung WHERE new_gid=a.new_gid), ''::text)) > 0";
		$query=$query."	ORDER BY a.name";
		#echo $query;
		
	
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
   $hg_name="Gesamtliste";
   if ($modus != 'kvwmap')
   {
	   	$query="SELECT a.oid, a.new_gid, a.id, c.bezeichnung, a.flaeche, a.name,h.jab_typ,h.hege_id,hg.name as hg_name,array_to_string(ARRAY( SELECT  jahrgang::text || '<br>' FROM jagdkataster.jb_wildnachweisung WHERE new_gid=a.new_gid ORDER BY jahrgang), ''::text) AS wildnachweisungen  FROM jagdkataster.jagdbezirke as a LEFT JOIN jagdkataster.jb_stammdaten as h ON a.new_gid=h.new_gid,jagdkataster.jagdbezirkart as c,jagdkataster.jb_hegegemeinschaften as hg  WHERE (a.art=c.art) AND a.endet IS NULL AND a.art IN ('ejb','gjb','tjb') AND h.hege_id=hg.hege_id AND h.hege_id IS NOT NULL ";
        if (strlen($filter) > 0) $query=$query." AND hg.name LIKE '%$filter%' ";
		if (isset($wildnachweisung)) $query=$query. " AND length(array_to_string(ARRAY( SELECT  jahrgang::text || '<br>' FROM jagdkataster.jb_wildnachweisung WHERE new_gid=a.new_gid), ''::text)) > 0 ";
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
	  <form action="liste_jagdkataster_region.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="Jagdkataster-Liste">
	  </form>
	  <td>
  </tr>
</table>
<h2> Jagdbezirke in Hegegemeinschaften - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'kvwmap')
    {
	 echo 'Hegegemeinschaft: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="post" name="region">
	        
			<select class="select_ort" name="hg" onchange="document.region.submit();">
			<option >Bitte auswählen</option>
			<option value="0">Gesamtliste</option>';
			
	  $query="SELECT name,hege_id FROM  jagdkataster.jb_hegegemeinschaften WHERE hege_id >0 ORDER BY name";
	  $result = $dbqueryp($connectp,$query);
      while($r = $fetcharrayp($result))
		{
  		echo "<option ";
		
		echo" value=\"$r[hege_id]\"";
		if ($r[hege_id] == $hg_id) echo "selected";
		echo ">";
		
		echo "$r[name]</option>\n";
		}
		echo "</select></form>";
	}
    else 
	{
	  echo "<h3>",$hg_name," - ";
	  if (!isset($count)) echo "keine";
	  if ($count == 1) echo $count," Jagdbezirk ";
	  if ($count != 1) echo $count," Jagdbezirke ";
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
  </td>';
?>
<td colspan=3><form action="<?php echo $_SERVER["PHP_SELF"] ?>" method=POST name="filter">
    <input type=hidden name="hg" value=<?php echo $hg_id ?>>
    Name (Hegegemeinschaft): <input  type=text name="filter" value="<?php echo $filter ?>" length=50>
	</td>
	<td> 
	
	
	<input type=checkbox id="wildnachweisung" name="wildnachweisung" value="wildnachweisung" <?php if ($wildnachweisung == 'wildnachweisung') echo " checked" ?>> Wildnachweisimg vorhanden
	</td>
	<td>
	<input type=submit value="Filter anwenden">
	</form>
</td></tr>
<?php
echo '<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=150></td>';
echo "<td height=30 width=80><b>Aktenzeichen</b></td>
	<td  align=center height=30 width=150><b>Jagdbezirk</b></td>
	<td  align=center height=30 width=150><b>Wildnachweisungen</b></td>
	<td  align=center height=30 width=300><b>Art</b></td>
	<td  align=center height=30 width=200><b>Art der Jagdausübung</b></td>
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
			echo '<td align=center>',$bd[$v][new_gid],'</td>';
			
			echo '<td align=left>',$bd[$v][name],'</td>';
			echo '<td align=left>',$bd[$v][wildnachweisungen],'</td>';
			
			echo '<td align=left> ',$bd[$v][bezeichnung],'</td>';
			echo '<td align=left> ',$bd[$v][jab_typ],'</td>';
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