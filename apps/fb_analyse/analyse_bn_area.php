<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//DE" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="author" content="Andreas Thurm">
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<center>

<?php

error_reporting(E_ALL & ~E_NOTICE);

################# Includes und Variablen ##########################

include("../../includes/connect_geobasis.php");

$gid=$_GET["gid"];
$jahr=$_GET["jahrgang"];


$count = 0;
$query="SELECT gid,bezeichnung,the_geom as search_geom,area(the_geom) as area_search_geom FROM environment.analyseflaechen WHERE gid='$gid'";
$result = $dbqueryp($connectp, $query);
$r = $fetcharrayp($result);
$search_geom=$r[search_geom];
$area_search_geom=round($r[area_search_geom],0);
$bezeichnung=$r[bezeichnung];

############## Datum ##############################################

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
$heute=$year.'-'.$month.'-'.$day;
$print_datum=$day.".".$month.".".$year;
$lfdmon=$year.'-'.$month;

############################## Geoportal Logo ######################################

echo"
<center>
	<img src='../geoportal_logo.png' width='806'>
</center>";



echo"
<table width='800' id='kopf'>
  <tr>
    <td id='tdkopf1' width='520' valign='top' ><b>Flächenanalyse Feldblockkataster $jahr<br><small>Datum: $print_datum<br></td>
	<td></td>
  </tr>
  <tr>
    <td id='tdkopf1' width='520' valign='top' >$bezeichnung</td>
	<td>Recherchefläche:",round($area_search_geom,0)," m²</td>
  </tr>
 </table>";

####################################################################################
######################            Feldblöcke                       ######################
####################################################################################

if (!isset($jahr))
  {
    echo '<br><br><br><table border=0><tr><td>Bitte das Bezugsjahr für das Feldblockkataster auswählen:</td><td>
	<form action="',$_SERVER["PHP_SELF"],'" method="get" name="jahrgang">
	<input type="hidden" value="',$gid,'" name="gid">
	<select  name="jahrgang" >';
    $query="SELECT DISTINCT stichtag FROM environment.feldblock_bn ORDER BY stichtag DESC";
	$result = $dbqueryp($connectp, $query);
    WHILE ($r = $fetcharrayp($result))
     {
  		echo "<option ";
		echo" value=\"$r[stichtag]\"";
		if ($r[stichtag] == $jahr) echo "selected";
		echo ">";
		echo "$r[stichtag]</option>\n";
	 }
		echo '</select></td></tr></table><br><br><input type="submit" value="Start"></form>';
  }
  else
  {

############################### Ausgabe Tabellen ####################################

echo '<table border="0" width="800"  cellspacing="0" cellpadding="5" id="tableinfo">
		<tr id="trinfo">
			<td>Feldblock-ID</td>
			<td>Bodennutzung</td>
			<td>Gesamtfläche</td>
			<td>innerhalb</td>
			<td>Anteil</td>
		</tr>';

$gesamt=0;
$gesamt_af=0;
$gesamt_gl=0;
$query="SELECT id,fbid,bodennutzu,area,area(the_geom) as flaeche,round(st_area(INTERSECTION(st_transform(the_geom,25833),'$search_geom'))::numeric,0) as intersec_area FROM environment.feldblock_bn WHERE stichtag='$jahr' AND st_intersects(st_transform(the_geom,25833),'$search_geom') ORDER BY bodennutzu";
$result = $dbqueryp($connectp, $query);
WHILE ($q = $fetcharrayp($result))
{
    $gesamt=$gesamt+$q[intersec_area];
	$anteil=round(100*$q[intersec_area]/$q[area],2);
	if ($q[bodennutzu] == 'AF') $gesamt_af=$gesamt_af+$q[intersec_area];
	if ($q[bodennutzu] == 'GL' OR $q[bodennutzu] == 'DGL') $gesamt_gl=$gesamt_gl+$q[intersec_area];
	echo"
	
		<tr id='trinfo'>
			<td id='tkopf_links' width='100'><center><b>".$q[fbid]."</td>
			<td id='tkopf_mitte' width='300'><center><b>$q[bodennutzu]</td>
			<td id='tkopf_mitte' width='200' ><center><b>".$q[area]."</td>
			<td id='tkopf_rechts' width='100'><center><b>".$q[intersec_area]."</td>
			<td id='tkopf_rechts' width='100'><center><b>".$anteil." %</td>
		</tr>";
        }					
					
	
    $diff=$area_search_geom-$gesamt;
	$diff_anteil=round(100*$diff/$gesamt,0);
	echo "<tr>
	      <td></td>
		  
		  <td colspan=2>Recherchefläche gesamt:</td>
		  <td>",round($area_search_geom,0),"</td>
		  <td></td>
		  </tr>
		  <tr>
	      <td></td>
		  
		  <td colspan=2>Abdeckung durch Feldblöcke:</td>
		  <td>",round($gesamt,0),"</td>
		  <td>",round(100*$gesamt/$area_search_geom,0)," %</td>
		  </tr>
		  <tr>
	      <td></td>
		  
		  <td colspan=2>davon Ackerfläche (AF):</td>
		  <td>",round($gesamt_af,0),"</td>
		  <td>",round(100*$gesamt_af/$area_search_geom,0)," %</td>
		  </tr>
		  <tr>
	      <td></td>
		  
		  <td colspan=2>davon Grünland (GL/DGL):</td>
		  <td>",round($gesamt_gl,0),"</td>
		  <td>",round(100*$gesamt_gl/$area_search_geom,0)," %</td>
		  </tr>
		  <tr>
	      <td></td>
		  
		  <td colspan=2>nicht durch Feldblöcke abgedeckt:</td>
		  <td>",round($diff,0),"</td>
		  <td>",round(100*$diff/$area_search_geom,0)," %</td>
		  </tr>
		  
		  ";
	echo "</table><br>";
	$count++;
 }
	
	


?>

</center>
</body>
</html>
