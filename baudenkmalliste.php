<?php
include ("includes/connect_geobasis.php");
$element_farbe="#d2e8ff";
$ip=getenv('REMOTE_ADDR');
session_start();


$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true AND $ip == '82.193.248.86'){
	$_SESSION["pruef"] = (isset($_SESSION["pruef"])?$_SESSION["pruef"]:true);
	$status='angemeldet';
	}

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
	  
	$query="SELECT a.oid,a.gid, a.kuerzel, a.typ, a.nr, a.lfdnr, a.ort, a.bemerk, a.strasse, a.obj, a.bild, 
       a.oeffentlich, a.copyright, a.datum, a.aender, a.datum_ueberarbeitet, a.flurstuecke, 
       a.the_geom FROM construction.baudenkmale as a, management.ot_lt_rka as b WHERE st_intersects(a.the_geom,b.the_geom) AND b.gid='$ortslage_id' ORDER BY a.ort,a.strasse";
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
   $query="SELECT oid,gid, kuerzel, typ, nr, lfdnr, ort, bemerk, strasse, obj, bild, 
       oeffentlich, copyright, datum, aender, datum_ueberarbeitet, flurstuecke, 
       the_geom FROM construction.baudenkmale as a ORDER BY a.ort,a.strasse";
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
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<div align=center>
<img src="images/geoportal_logo.png" width=1200 >
<h2> Liste der Baudenkmale - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'kvwmap')
    {
	 echo 'Gemeinde/Ort/Ortslage: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="get" name="ortslage">
	        
			<select class="select_ort" name="ortslage" onchange="document.ortslage.submit();">
			<option >Bitte auswählen</option>
			<option value="0">Gesamtliste</option>';
			
	  $query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen  WHERE gemschl != '13071107' ORDER BY ortslage";
	  $result = $dbqueryp($connectp,$query);
      while($r = $fetcharrayp($result))
		{
  		echo "<option ";
		#if ($r[typ] == 'Gemeinde') echo "class=bld";
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
	  else echo $count," Denkmale ";
	  echo "</h3>";
    }	  
?>
<table border=0>
<tr><td colspan=7 valign=top>
<? 
 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="baudenkmalliste.php?modus=kvwmap"><img src="kvwmap/graphics/rows.png" width=15 title="andere Gemeinde oder Ortslage wählen" border=0></a>';	

if ($modus != 'kvwmap' AND isset($count))
 {
echo '
<a href="javascript:window.print()"><img src="kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
</td></tr>
<tr>';
if ($status == 'angemeldet') echo '<td width=120></td>';
echo "<td align=center height=30 width=40 width=50><b>Region</b></td>
	<td align=center height=30 width=80><b>Nummer</b></td>
	<td align=center height=30 width=80><b>lfd. Nr.</b></td>
	<td align=center height=30 width=200><b>Objekt</b></td>
	<td align=center height=30 width=200><b>Ort</b></td>
	<td align=center height=30 width=200><b>Straße</b></td>
	<td align=center height=30 width=150><b>Typ</b></td>
</tr>";
if ($status == 'angemeldet') echo "<tr><td colspan=8><hr></td></tr>";
   else echo "<tr><td colspan=7><hr></td></tr>";
   
 for($v=0;$v<$z;$v++)
	{   
	    
	    echo "<tr ";
	    if ($v % 2 == 0) echo "bgcolor=$element_farbe";
		echo ">";
		if ($status == 'angemeldet') echo '<td><a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baudenkmale&layer_columnname=the_geom&layer_id=40110&selektieren=false"><img src="kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baudenkmale&layer_columnname=the_geom&layer_id=40110&selektieren=zoomonly"><img src="kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=baudenkmale&layer_columnname=the_geom&layer_id=40110&selektieren=true"><img src="kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?Stelle_ID=322&go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=40110&value_gid=',$bd[$v][gid],'"><img src="kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
	    echo "<td align=center>",$bd[$v][kuerzel],"</td>";
		echo '<td align=center>',$bd[$v][nr],'</td>';
		echo "<td align=center>",$bd[$v][lfdnr],"</td>
	    <td align=center>",$bd[$v][obj],"</td>
	    <td align=center>",$bd[$v][ort],"</td>
	    <td align=center>",$bd[$v][strasse],"</td>
	    <td align=center>",$bd[$v][typ],"</td>
	     </td></tr>";
	}
	
echo "</table>";
 }
?>
</body>
</html>