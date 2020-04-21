<?php
include ("includes/connect_geobasis.php");
$element_farbe="#d2e8ff";
$ip=getenv('REMOTE_ADDR');
session_start();


$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true) {
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
	  
	$query="SELECT a.oid,a.gid, c.gemeinde, a.bezeichnun, a.plan_nr, a.zusatz, a.rok_nr, 
       a.art, a.art_verfahren, a.datum_stan, a.stand_verfahren, a.in_entwicklung 
       FROM construction.bplan as a, management.ot_lt_rka as b,gemeinden as c WHERE st_intersects(st_transform(a.the_geom,25833),b.the_geom) AND b.gid='$ortslage_id' AND a.in_entwicklung = 'nein'  AND a.gem_nr_neu = c.gem_schl ORDER BY c.gemeinde,a.plan_nr,a.zusatz";
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
   $query="SELECT a.oid,a.gid, c.gemeinde, a.bezeichnun, a.plan_nr, a.zusatz, a.rok_nr, 
       a.art, a.art_verfahren, a.datum_stan, a.stand_verfahren, a.in_entwicklung 
       FROM construction.bplan as a, gemeinden as c WHERE a.in_entwicklung = 'nein'  AND a.gem_nr_neu = c.gem_schl ORDER BY c.gemeinde,a.plan_nr,a.zusatz";
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
<h2> Liste der Bebauungspläne - Stand: <? echo $heute ?></h2>
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
	  else echo $count," Bebauungspläne ";
	  echo "</h3>";
    }	  
?>
<table border=0>
<tr><td colspan=7 valign=top>
<? 
 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=kvwmap"><img src="kvwmap/graphics/rows.png" width=15 title="andere Gemeinde oder Ortslage wählen" border=0></a>';	

if ($modus != 'kvwmap' AND isset($count))
 {
echo '
<a href="javascript:window.print()"><img src="kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
</td></tr>
<tr>';
if ($status == 'angemeldet') echo '<td width=80></td>';
echo "<td align=center height=30 width=40 width=50><b>Gemeinde</b></td>
	<td align=center height=30 width=80><b>Nummer</b></td>
	<td align=center height=30 width=80><b>Zusatz</b></td>
	<td align=center height=30 width=200><b>Bezeichnung</b></td>
	<td align=center height=30 width=120><b>Art</b></td>
	<td align=center height=30 width=120><b>Status</b></td>
	<td align=center height=30 width=80><b>Datum</b></td>
	
</tr>";
if ($status == 'angemeldet') echo "<tr><td colspan=8><hr></td></tr>";
   else echo "<tr><td colspan=7><hr></td></tr>";
   
 for($v=0;$v<$z;$v++)
	{   
	    
	    echo "<tr ";
	    if ($v % 2 == 0) echo "bgcolor=$element_farbe";
		echo ">";
		if ($status == 'angemeldet') echo '<td><a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=bplan&layer_columnname=the_geom&layer_id=40050&selektieren=false"><img src="kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=bplan&layer_columnname=the_geom&layer_id=40050&selektieren=zoomonly"><img src="kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=bplan&layer_columnname=the_geom&layer_id=40050&selektieren=true"><img src="kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> <a href="https://geoport-lk-mse.de/kvwmap/index.php?Stelle_ID=241&go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=40050&value_gid=',$bd[$v][gid],'"><img src="kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
	    echo "<td align=center>",$bd[$v][gemeinde],"</td>";
		echo '<td align=center>',$bd[$v][plan_nr],'</td>';
		echo "<td align=center>",$bd[$v][zusatz],"</td>
	    <td align=center>",$bd[$v][bezeichnun],"</td>
	    <td align=center>",$bd[$v][art],"</td>
	    <td align=center>",$bd[$v][stand_verfahren],"</td>
	    <td align=center>",$bd[$v][datum_stan],"</td>
	     </td></tr>";
	}
	
echo "</table>";
 }
?>
</body>
</html>