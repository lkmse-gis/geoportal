<?php
include ("../includes/connect_geobasis.php");
$element_farbe="#d2e8ff";
$ip=getenv('REMOTE_ADDR');
session_start();


$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true AND $ip == '82.193.248.66'){
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
	  
	$query="SELECT a.bl_bl_nr,a.oid,a.gid, b.gem_name, a.bl_bl_s, a.art, a.bemerk,'kvwmap' as status 
              FROM construction.baulasten as a, management.ot_lt_rka as b WHERE st_intersects(a.the_geom,b.the_geom) AND b.gid='$ortslage_id' ORDER BY b.gem_name,a.bl_bl_nr,a.bl_bl_s ";
	$result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	$query="SELECT a.spalte_11 as bl_bl_nr,a.oid,a.gid, b.gem_name,  a.spalte_12 as bl_bl_s, a.spalte_13 as art, a.spalte_14 as bemerk,'MS-Bau' as status 
              FROM construction.baulasten_msbau as a, management.ot_lt_rka as b WHERE st_intersects(a.the_geom,b.the_geom) AND b.gid='$ortslage_id' AND a.uebernommen = 'nein' ORDER BY b.gem_name,a.spalte_11,a.spalte_12 ";
	$result = $dbqueryp($connectp,$query);
	  
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
   $query="SELECT a.oid,a.gid, b.gem_name, a.bl_bl_nr, a.bl_bl_s, a.art, a.bemerk,'kvwmap' as status 
              FROM construction.baulasten as a, management.ot_lt_rka as b WHERE st_intersects(a.the_geom,b.the_geom) AND b.typ='Gemeinde' ORDER BY b.gem_name,CAST(a.bl_bl_nr AS INTEGER),CAST(a.bl_bl_s AS INTEGER)";
		
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
		
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="../styles.css" />
		<link href="css/style_css.php" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<div align=center>
<img src="../images/geoportal_logo.png" width=1200 >
<h2> Liste der Baulasten - Stand: <? echo $heute ?></h2>
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
	  if ($count == 1) echo $count," Baulast ";
	  if ($count != 1) echo $count," Baulasten ";
	  echo "</h3>";
	  
	  
    }	  
?>
<div align=center>
<table border=0>
<tr><td colspan=7 valign=top>
<? 
 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=kvwmap"><img src="../kvwmap/graphics/rows.png" width=20 title="andere Gemeinde oder Ortslage wählen" border=0></a>';	

if ($modus != 'kvwmap' AND isset($count))
 {
echo '
<a href="javascript:window.print()"><img src="../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
 </td>
</tr>
<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=80></td>';
echo "<td align=center height=30 width=40 width=50><b>Gemeinde</b></td>
	<td align=center height=30 width=80><b>Nummer</b></td>
	<td align=center height=30 width=80><b>Seite</b></td>
	<td align=center height=30 width=200><b>Art</b></td>
	<td align=center height=30 width=120><b>Bemerkung</b></td>
	<td align=center height=30 width=120><b>Status</b></td>
	
</tr>";
if ($status == 'angemeldet') echo "<tr><td colspan=8><hr></td></tr>";
   else echo "<tr><td colspan=7><hr></td></tr>";
 sort($bd,SORT_REGULAR);  

 for($v=0;$v<$z;$v++)
	{   
	
	//    
	
			$quot=$v;
			if($quot%2 != 0){
				$element_farbe='#FCFCFC';
			} else { 
				$element_farbe='#d2e8ff';
			}
			if ($bd[$v][status] == 'MS-Bau') $element_farbe='#FF8080';
		
		echo "<tr bgcolor='$element_farbe'>";
				
		if ($status == 'angemeldet') 
		  if ($bd[$v][status] == 'kvwmap') 
		     {
			   echo '<td><a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baulasten&layer_columnname=the_geom&layer_id=40041&selektieren=false"><img src="../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baulasten&layer_columnname=the_geom&layer_id=40041&selektieren=zoomonly"><img src="../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baulasten&layer_columnname=the_geom&layer_id=40041&selektieren=true"><img src="../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?Stelle_ID=321&go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=40041&value_gid=',$bd[$v][gid],'"><img src="../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			  else
			  {
			   echo '<td><a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baulasten_msbau&layer_columnname=the_geom&layer_id=40039&selektieren=false"><img src="../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baulasten_msbau&layer_columnname=the_geom&layer_id=40039&selektieren=zoomonly"><img src="../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baulasten_msbau&layer_columnname=the_geom&layer_id=40039&selektieren=true"><img src="../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?Stelle_ID=321&go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=40039&value_gid=',$bd[$v][gid],'"><img src="../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			 
	    echo "<td align=center>",$bd[$v][gem_name],"</td>";
		echo '<td align=center>',$bd[$v][bl_bl_nr],'</td>';
		echo "<td align=center>",$bd[$v][bl_bl_s],"</td>
	    <td align=center>",$bd[$v][art],"</td>
	    <td align=left>",$bd[$v][bemerk],"</td>
	    <td align=center>",$bd[$v][status],"</td>
	    
	     </td></tr>";
	}
	
echo "</table>";
 }
}
else echo "Zugiff nicht erlaubt...";
?>
</body>
</html>