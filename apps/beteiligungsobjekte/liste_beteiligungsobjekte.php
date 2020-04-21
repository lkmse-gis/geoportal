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
$ortslage_id=$_GET["ortslage"];
$archiv=$_GET["archiv"];
if ($archiv == 'ja')
   {
     $schalter="nein";
	 $schalter_text='archivierte Beteiligungsobjekte ausblenden';
   }
   else
   {
     $schalter="ja";
	 $schalter_text='archivierte Beteiligungsobjekte einblenden';
	}



if ($ortslage_id >= 1)
  {
    $query="SELECT ortslage FROM management.suchfeld_schnellsprung_ortslagen WHERE gid='$ortslage_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $ortslage=$r[ortslage];
	  
	$query="SELECT DISTINCT a.oid,a.gid,  array_to_string(ARRAY( SELECT DISTINCT ot_lt_rka.gem_name::text || '<br>' FROM management.ot_lt_rka WHERE st_intersects(a.the_geom,ot_lt_rka.the_geom)), ''::text) AS gem_name, substr(a.az,6,4) as az_jahr, substr(a.az,1,4) as az_nr, a.az, a.beschreibung, a.stelle_name, a.stelle_id, a.mitarbeiter, a.time_id, a.ziel_status, a.the_geom FROM organisation.beteiligen_polygon as a, management.ot_lt_rka as b WHERE st_intersects(a.the_geom,b.the_geom) AND b.gid='$ortslage_id' ";
    if ($archiv != 'ja') $query=$query."AND a.ziel_status = 'in Bearbeitung'";
    $query=$query." ORDER BY substr(a.az,6,4) desc, substr(a.az,1,4) desc";
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
          $query="SELECT DISTINCT a.oid,a.gid, array_to_string(ARRAY( SELECT DISTINCT ot_lt_rka.gem_name::text || '<br>' FROM management.ot_lt_rka WHERE st_intersects(a.the_geom,ot_lt_rka.the_geom)), ''::text) AS gem_name, substr(a.az,6,4) as az_jahr, substr(a.az,1,4) as az_nr, a.az, a.beschreibung, a.stelle_name, a.stelle_id, a.mitarbeiter, a.time_id, a.ziel_status, a.the_geom FROM organisation.beteiligen_polygon as a, management.ot_lt_rka as b WHERE st_intersects(a.the_geom,b.the_geom) ";
		  if ($archiv != 'ja') $query=$query."AND a.ziel_status = 'in Bearbeitung'";
		  $query=$query." ORDER BY substr(a.az,6,4) desc, substr(a.az,1,4) desc";
	  
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
		
		<link href="css/style_css.php" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
	</head>
<body>

<div align=center>
<img src="../../images/geoportal_logo.png" width=1200 >
<h2> Liste der Beteiligungsobjekte - Stand: <? echo $heute ?></h2>
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
	  if ($count == 1) echo $count," Beteiligungsobjekt ";
	  if ($count != 1) echo $count," Beteiligungsobjekte ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>
<tr>
  <td colspan=7 valign=top align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=kvwmap"><img src="../../kvwmap/graphics/rows.png" width=20 title="andere Gemeinde oder Ortslage wählen" border=0></a>';
 if ($modus != 'kvwmap' AND isset($count))
 {
	echo '
    <a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
    <form action="',$_SERVER["PHP_SELF"],'" method="get" name="archiv">
	<input type="hidden" name="archiv" value="',$schalter,'">
	<input type="hidden" name="ortslage" value="',$ortslage_id,'">
	<input type="submit" value="',$schalter_text,'">
	</form>
  </td>
</tr>
<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=150></td>';
echo "<td height=30 width=200><b>Gemeinde</b></td>
	<td align=center height=30 width=40><b>Aktenzeichen</b></td>
	<td align=left height=30 width=500><b>Beschreibung</b></td>
	<td align=right height=30 width=80><b>Stelle</b></td>
	<td align=center height=30 width=200><b>zuletzt bearbeitet am</b></td>
	<td align=center height=30 width=60><b>Bearbeitungsstatus</b></td>
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
			   echo '<td>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=beteiligen_polygon&layer_columnname=the_geom&layer_id=191400&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Objekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=beteiligen_polygon&layer_columnname=the_geom&layer_id=191400&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=beteiligen_polygon&layer_columnname=the_geom&layer_id=191400&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=191400&value_gid=',$bd[$v][gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			  else
			  {
			   echo '<td align=center>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=beteiligen_polygon&layer_columnname=the_geom&layer_id=191410&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=beteiligen_polygon&layer_columnname=the_geom&layer_id=191410&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=beteiligen_polygon&layer_columnname=the_geom&layer_id=191410&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=191410&value_gid=',$bd[$v][gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			
			echo '<td>',$bd[$v][gem_name],'</td>';	
			echo '<td align=center>',$bd[$v][az],'</td>';	
			echo '<td align=left>',$bd[$v][beschreibung],'</td>';	
			echo '<td align=center>',$bd[$v][stelle_name],'</td>';	
			echo '<td align=center>',$bd[$v][time_id],'</td>';	
			
			if ($bd[$v][ziel_status]=='in Bearbeitung' ){
				echo '<td align=center>',$bd[$v][ziel_status],'</td>';	
			} else {
				echo '<td align=center bgcolor="red">',$bd[$v][ziel_status],'</td>';	
			}
	    echo '</tr>';
	}
	
echo "</table>";
 }
}
else echo "Zugiff nicht erlaubt...";
?>
</body>
</html>