<?php
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');
session_start();

$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true AND $ip == '82.193.248.66')
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
$ortslage_id=$_GET["ortslage"];



if ($ortslage_id >= 1)
  {
    $query="SELECT ortslage FROM management.suchfeld_schnellsprung_ortslagen WHERE gid='$ortslage_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $ortslage=$r[ortslage];
	  	
		$query="SELECT a.oid, a.new_gid, a.id, c.bezeichnung, a.flaeche, a.name, a.color, b.gem_name, d.contact, d.jagdvorsteher, d.strasse_nr, d.ortsteil, d.plz_ort, d.telefon, d.mail_1, d.mail_2, d.stellvertreter, d. schriftfuehrer, d.kassenwart, '' as flst_link, '' as eigentuemer_link, '' as edit_link, '' as jab_link, a.the_geom FROM jagdkataster.jagdbezirke as a LEFT JOIN jagdkataster.jb_stammdaten as d ON (a.new_gid=d.new_gid), management.ot_lt_rka as b, jagdkataster.jagdbezirkart as c WHERE (a.art=c.art) AND (a.art='ejb' OR a.art='gjb' OR a.art='tjb') AND st_intersects(st_transform(st_centroid(a.the_geom),25833),b.the_geom) AND b.gid='$ortslage_id' ORDER BY a.art,a.name";
	
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
   $ortslage="Gesamtliste";
   if ($modus != 'kvwmap')
   {
	   	$query="SELECT a.oid, a.new_gid, a.id, c.bezeichnung, a.flaeche, a.name, a.color, b.gem_name, d.contact, d.jagdvorsteher, d.strasse_nr, d.ortsteil, d.plz_ort, d.telefon, d.mail_1, d.mail_2, d.stellvertreter, d. schriftfuehrer, d.kassenwart, '' as flst_link, '' as eigentuemer_link, '' as edit_link, '' as jab_link, a.the_geom FROM jagdkataster.jagdbezirke as a LEFT JOIN jagdkataster.jb_stammdaten as d ON (a.new_gid=d.new_gid), management.ot_lt_rka as b, jagdkataster.jagdbezirkart as c WHERE (a.art=c.art) AND (a.art='ejb' OR a.art='gjb' OR a.art='tjb') AND st_intersects(st_transform(st_centroid(a.the_geom),25833),b.the_geom) AND b.typ='Gemeinde' ORDER BY a.art,a.name";
		
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
<h2> Liste des Jagdkatasters - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'kvwmap')
    {
	 echo 'Gemeinde/Ort/Ortslage: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="get" name="ortslage">
	        
			<select class="select_ort" name="ortslage" onchange="document.ortslage.submit();">
			<option >Bitte auswählen</option>
			<option value="0">Gesamtliste</option>';
			
	  $query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen ORDER BY ortslage";
	  $result = $dbqueryp($connectp,$query);
      while($r = $fetcharrayp($result))
		{
  		echo "<option ";
		if ($r[typ] == 'Gemeinde') echo "class=bld";
		echo" value=\"$r[gid]\"";
		if ($r[gid] == $ortslage_id) echo "selected";
		echo ">";
		if ($r[typ] == 'Gemeinde') ;
		echo "$r[ortslage]</option>\n";
		}
		echo "</select></form>";
	}
    else 
	{
	  echo "<h3>",$ortslage," - ";
	  if (!isset($count)) echo "keine";
	  if ($count == 1) echo $count," Jagdkatatsterobjekt ";
	  if ($count != 1) echo $count," Jagdkatatsterobjekte ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>
<tr><td colspan=8 valign=top align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=kvwmap"><img src="../../kvwmap/graphics/rows.png" width=20 title="andere Gemeinde oder Ortslage wählen" border=0></a>';
 if ($modus != 'kvwmap' AND isset($count))
 {
	echo '
<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
  </td>
</tr>
<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=150></td>';
echo "<td height=30 width=80><b>Aktenzeichen</b></td>
	<td  align=center height=30 width=200><b>Gemeinde</b></td>
	<td  align=center height=30 width=300><b>Jagdbezirk</b></td>
	<td  align=center height=30 width=300><b>Jagdgenossenschaft</b></td>
	<td  align=center height=30 width=300><b>Jagdvorsteher</b></td>
	<td  align=center height=30 width=300><b>Art</b></td>
	<td align=center height=30 width=80><b>Fläche</b></td>
	
	
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
			echo '<td align=left>',$bd[$v][gem_name],'</td>';
			echo '<td align=left>',$bd[$v][name],'</td>';
			echo '<td align=left>',$bd[$v][contact],'</td>';
			echo '<td align=left>',$bd[$v][jagdvorsteher],'</td>';
			echo '<td align=left> ',$bd[$v][bezeichnung],'</td>';
			echo '<td align=left>',$bd[$v][flaeche],' ha</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 }
}
else echo "Zugiff nicht erlaubt...";
?>
</body>
</html>