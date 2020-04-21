<?php
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');
session_start();

$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);
if ($_SESSION['angemeldet'] === true)
{
	$_SESSION["pruef"] = (isset($_SESSION["pruef"])?$_SESSION["pruef"]:true);
	$status='angemeldet';
}
$filter=$_POST["filter"];
$jahrgang=$_POST["jahrgang"];

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
if (!isset($jahrgang)) $select_jahr=$year;
   else $select_jahr=$jahrgang;
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
<h2> Wildunfall-Statistik</h2>
<? 

	 $query="SELECT count(gid) FROM jagdkataster.wildunfall WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%';";
	 if (isset($filter) AND ($filter != '0' AND $filter != 'alle' AND $filter != 's' AND $filter != 'w')) $query="SELECT count(a.gid)  FROM jagdkataster.wildunfall as a  LEFT JOIN traffic.abschnitte as c ON (a.abschnitt_id=c.gid AND c.gueltig=1) WHERE c.strassenna LIKE '%".$filter."' AND CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%';";
	 if ($filter == 'nicht klassifiziert') $query="SELECT count(a.gid)  FROM jagdkataster.wildunfall as a  LEFT JOIN traffic.abschnitte as c ON (a.abschnitt_id=c.gid AND c.gueltig=1) WHERE c.strassenna IS NULL AND CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%';";
	 $result = $dbqueryp($connectp,$query);
	 $r = $fetcharrayp($result);
	 $anzahl=$r[0];
	 $query="SELECT date_part('day',datum_erf) as day,date_part('month',datum_erf) as month,date_part('year',datum_erf) as year FROM jagdkataster.wildunfall WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%' ORDER BY datum_erf  LIMIT 1;";
	 $result = $dbqueryp($connectp,$query);
	 $r = $fetcharrayp($result);
	 $start_day=$r[day];
	 $start_month=$r[month];
	 $start_year=$r[year];
	 
	 $query="SELECT date_part('day',datum_erf) as day,date_part('month',datum_erf) as month,date_part('year',datum_erf) as year FROM jagdkataster.wildunfall WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%' ORDER BY datum_erf DESC LIMIT 1;";
	 $result = $dbqueryp($connectp,$query);
	 $r = $fetcharrayp($result);
	 $end_day=$r[day];
	 $end_month=$r[month];
	 $end_year=$r[year];
	 
	 
	  echo "<h3>",$anzahl," Wildunfälle";
	  if ($filter == 'nicht klassifiziert') echo " an nicht klassifizierten Straßen ";
	   else  if (isset($filter) AND ($filter != '0' AND $filter != 'alle' AND $filter != 's' AND $filter != 'w')) echo " an der ",$filter," ";
	  echo " vom ",$start_day,".",$start_month,".",$start_year," bis zum ",$end_day,".",$end_month,".",$end_year;
	  echo "</h3>";
    	  

    echo "<div align=center>
         <table border=0>
         <tr><td valign=top align=left>";
    if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
    echo '<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>';
	echo '</td><td><form action="',$_SERVER["PHP_SELF"],'" method="POST" name="filter">
	      <select name="filter" onchange="document.filter.submit();">
		  <option value="0">alle gruppiert nach Abschnitt</option>
		  <option value="s"';
		  if ($filter == 's') echo ' selected';
		  echo '>alle gruppiert nach Straße</option>
		  <option value="alle"';
		  if ($filter == 'alle') echo ' selected';
		  echo '>alle anzeigen</option>
		  <option value="nicht klassifiziert"';
		  if ($filter == 'nicht klassifiziert') echo ' selected';
		  echo '>an nicht klassifizierten Straßen</option>
		  <option value="w"';
		  if ($filter == 'w') echo ' selected';
		  echo '>alle gruppiert nach Wildart</option>';
		  $query="SELECT DISTINCT strassenna FROM traffic.abschnitte WHERE gueltig='1' ORDER BY strassenna";
		  $result = $dbqueryp($connectp,$query);
          while($r = $fetcharrayp($result))
		    {
  		     echo "<option ";		
		     echo" value=\"$r[strassenna]\"";
		     if ($r[strassenna] == $filter) echo "selected";
		     echo ">";		
		     echo "$r[strassenna]</option>\n";
		     }
		echo '</select> Jahr:
		<select name="jahrgang" onchange="document.filter.submit();">
		  
		  <option value="2018"';
		  if ($select_jahr == '2018') echo ' selected';
		  echo '>2018</option>
		  <option value="2019"';
		  if ($select_jahr == '2019') echo ' selected';
		  echo '>2019</option>
		   <option value="2020"';
		  if ($select_jahr == '2020') echo ' selected';
		  echo '>2020</option>
		  </select></form></td>';
	echo '</tr></table><table border=0>';

    if (!isset($filter) OR $filter=='0')
	{
    echo '<tr bgcolor="#3264af" >';
    // bg_color für Überschrift Tabelle

    echo "<td height=30 align=center width=200><b>Straße</b></td>
	<td  align=center height=30 width=200><b>Abschnitt</b></td>
	<td  align=center height=30 width=200><b>Anzahl</b></td>
	</tr>";

    $query="SELECT CASE WHEN c.strassenna IS NULL THEN 'nicht klassifiziert' ELSE c.strassenna END as strassenna,c.abschnitt,c.oid,count(a.gid) as anzahl FROM jagdkataster.wildunfall as a  LEFT JOIN traffic.abschnitte as c ON (a.abschnitt_id=c.gid AND c.gueltig=1) WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%' GROUP BY strassenna,c.abschnitt,c.oid ORDER BY count(a.gid) DESC;";
	$result = $dbqueryp($connectp,$query);
	$z=0;
	while($r = $fetcharrayp($result))
	{   
	 $quot=$z;
	 if($quot%2 != 0) echo "<tr bgcolor='#FCFCFC'";
	  else 	echo "<tr bgcolor='#d2e8ff'";
     echo ">";
	 echo '<td align=center>',$r[strassenna],'</td>';
	 echo '<td align=center>';
	 if ($r[abschnitt] != '') 
	      if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoLine&oid=',$r[oid],'&layer_tablename=abschnitte&layer_columnname=geom&layer_id=70600&selektieren=zoomonly">',$r[abschnitt],'</a>';
		  else echo $r[abschnitt];
	 echo '</td>';
	 echo '<td align=center> ',$r[anzahl],'</td>';
	 echo '</tr>';
	 $z++;
	}
    echo "</table>";
    }

    if (isset($filter) AND $filter=='s')
	{
    echo '<tr bgcolor="#3264af" >';
    // bg_color für Überschrift Tabelle

    echo "<td height=30 align=center width=200><b>Straße</b></td>
	<td  align=center height=30 width=200><b>Anzahl</b></td>
	</tr>";

    $query="SELECT CASE WHEN c.strassenna IS NULL THEN 'nicht klassifiziert' ELSE c.strassenna END as strassenna,count(a.gid) as anzahl FROM jagdkataster.wildunfall as a  LEFT JOIN traffic.abschnitte as c ON (a.abschnitt_id=c.gid AND c.gueltig=1) WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%' GROUP BY strassenna ORDER BY count(a.gid) DESC;";
	$result = $dbqueryp($connectp,$query);
	$z=0;
	while($r = $fetcharrayp($result))
	{   
	 $quot=$z;
	 if($quot%2 != 0) echo "<tr bgcolor='#FCFCFC'";
	  else 	echo "<tr bgcolor='#d2e8ff'";
     echo ">";
	 echo '<td align=center>',$r[strassenna],'</td>';
	 echo '<td align=center> ',$r[anzahl],'</td>';
	 echo '</tr>';
	 $z++;
	}
    echo "</table>";
    }

    if (isset($filter) AND $filter=='w')
	{
    echo '<tr bgcolor="#3264af" >';
    // bg_color für Überschrift Tabelle

    echo "<td height=30 align=center width=200><b>Straße</b></td>
	<td  align=center height=30 width=200><b>Anzahl</b></td>
	</tr>";

    $query="SELECT a.wildart,count(a.gid) as anzahl FROM jagdkataster.wildunfall as a  WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%' GROUP BY a.wildart ORDER BY count(a.gid) DESC;";
	$result = $dbqueryp($connectp,$query);
	$z=0;
	while($r = $fetcharrayp($result))
	{   
	 $quot=$z;
	 if($quot%2 != 0) echo "<tr bgcolor='#FCFCFC'";
	  else 	echo "<tr bgcolor='#d2e8ff'";
     echo ">";
	 echo '<td align=center>',$r[wildart],'</td>';
	 echo '<td align=center> ',$r[anzahl],'</td>';
	 echo '</tr>';
	 $z++;
	}
    echo "</table>";
    }
	
	
	if (isset($filter) AND $filter != 'w' AND $filter != '0' AND $filter != 's')
	{
    echo '<tr bgcolor="#3264af" >';
    // bg_color für Überschrift Tabelle

    echo "<td height=30 align=center width=50><b>Nr.</b></td>
	<td height=30 align=center width=200><b>Straße</b></td>
	<td  align=center height=30 width=100><b>Abschnitt</b></td>
	<td  align=center height=30 width=300><b>Gemeinde</b></td>
	<td  align=center height=30 width=100><b>Datum</b></td>
	<td  align=center height=30 width=200><b>wildart</b></td>";
	if ($status == 'angemeldet') echo "	<td  align=center height=30 width=250><b>Jagdbezirk(e)</b></td>";
	echo "</tr>";

    if ($filter != 'nicht klassifiziert') 
	   {
	   $query="SELECT CASE WHEN c.strassenna IS NULL THEN 'nicht klassifiziert' ELSE c.strassenna END as strassenna,c.abschnitt,c.oid,a.oid as unfall_oid,g.gemeinde,a.gid,CASE WHEN a.unfall_datum IS NULL THEN a.datum_erf::text ELSE a.unfall_datum::text || ' ' || coalesce(a.unfall_zeit::text,'')::text END as zeitpunkt,a.wildart, array_to_string(ARRAY( SELECT name::text || '<br>' FROM jagdkataster.jagdbezirke  WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%' AND st_within(st_transform(a.the_geom,2398),jagdbezirke.the_geom) AND (jagdbezirke.art ='gjb' OR jagdbezirke.art ='tjb' OR jagdbezirke.art ='ejb')), ''::text) AS jagdbezirke  FROM jagdkataster.wildunfall as a  LEFT JOIN traffic.abschnitte as c ON (a.abschnitt_id=c.gid AND c.gueltig=1) LEFT JOIN gemeinden as g ON (st_within(a.the_geom,g.geom_25833)) WHERE CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%'";
	   if ($filter != 'alle') $query=$query."AND strassenna LIKE '%".$filter."'";
       $query=$query." ORDER BY zeitpunkt DESC;";
	   }
	   else 
	   $query="SELECT CASE WHEN c.strassenna IS NULL THEN 'nicht klassifiziert' ELSE c.strassenna END as strassenna,c.abschnitt,c.oid,a.oid as unfall_oid,CASE WHEN a.unfall_datum IS NULL THEN a.datum_erf::text ELSE a.unfall_datum::text || ' ' || coalesce(a.unfall_zeit::text,'')::text END as zeitpunkt,g.gemeinde,a.gid,a.wildart,array_to_string(ARRAY( SELECT  name::text || '<br>' FROM jagdkataster.jagdbezirke WHERE st_within(st_transform(a.the_geom,2398),jagdbezirke.the_geom) AND (jagdbezirke.art ='gjb' OR jagdbezirke.art ='tjb' OR jagdbezirke.art ='ejb')), ''::text) AS jagdbezirke  FROM jagdkataster.wildunfall as a  LEFT JOIN traffic.abschnitte as c ON (a.abschnitt_id=c.gid AND c.gueltig=1) LEFT JOIN gemeinden as g ON (st_within(a.the_geom,g.geom_25833)) WHERE strassenna IS NULL  AND CAST(datum_erf AS CHARACTER VARYING) LIKE '$select_jahr%' ORDER BY a.gid DESC;";
	   
	$result = $dbqueryp($connectp,$query);
	$z=0;
	while($r = $fetcharrayp($result))
	{   
	 $quot=$z;
	 if($quot%2 != 0) echo "<tr bgcolor='#FCFCFC'";
	  else 	echo "<tr bgcolor='#d2e8ff'";
     echo ">";
	 echo '<td align=center>';
	 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPoint&oid=',$r[unfall_oid],'&layer_tablename=wildunfall&layer_columnname=the_geom&layer_id=60081&selektieren=zoomonly">',$r[gid],'</td>';
	 else echo $r[gid],'</td>';
	 echo '<td align=center>',$r[strassenna],'</td>';
	 echo '<td align=center>';
	 if ($r[abschnitt] != '') 
	    if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoLine&oid=',$r[oid],'&layer_tablename=abschnitte&layer_columnname=geom&layer_id=70600&selektieren=zoomonly">',$r[abschnitt],'</a>';
		else echo $r[abschnitt];
	 echo '</td>';
	 echo '<td align=center>',$r[gemeinde],'</td>';
	 echo '<td align=center> ',$r[zeitpunkt],'</td>';
	 echo '<td align=center> ',$r[wildart],'</td>';
	 if ($status == 'angemeldet') echo '<td align=center style="font-size:10px;"> ',$r[jagdbezirke],'</td>';
	 echo '</tr>';
	 $z++;
	}
    echo "</table>";
    }

 
 

?>
</body>
</html>