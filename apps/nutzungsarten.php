<!DOCTYPE html>



<html>
<head>
<meta name="author" content="Olaf Bräunlich">
<meta charset="utf-8" />

<style>
table {
    border-collapse: collapse;
	border:0px;
    width: 800px;
	margin-left:auto;
	margin-right:auto;
	font-size:14px;
}
		
.links{
	text-align:left;
}

.rechts{
	text-align:right;
}

th {
    text-align: left;
    padding: 8px;
}

td {
    text-align: center;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #006085;
    color: white;
	font-size:20px;
}

.kopf{
	font-size:12px;
}

.teil_schnitt{
	font-size:12px; 
	text-align:center;
}

}

</style>


</head>
<body >




<?php

$kreis=$_GET["kreis"];
$gemschl=$_GET["gemeinde"];
$gemarkung=$_GET["gemkgschl"];
$gemarkungsnummer=substr($gemarkung,2,4);
$amtschl_voll=$_GET["amt"];
$amtschl=substr($amtschl_voll,5,4);
$flur=$_GET["flur"];

#$kreis='13071';
#$amtschl = '5155';
#$gemschl = '13071036';
#$gemarkungsnummer = '1355';
#$flur = '1';

$count = 0;



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
	<img src='geoportal_logo.png' width='806'>
</center>";



echo"
<table width='800' class='kopf'>
  <tr>
    <td  width='520' valign='top' class='links'><h2>ALKIS Nutzungsartenanalyse</hr2><br><small>Stand: $print_datum</small><br></td>
	<td></td>
  </tr>
  <tr>
    <td colspan='2'>
	<table class='kopf'>
	<tr>
		<td width='200' class='links'><br>
			Regionalstandort Neubrandenburg<br>
			Platanenstra&szlig;e 43<br>
			17033 Neubrandenburg 
		</td>
		<td width='200' class='links'><br>
			Regionalstandort Waren (M&uuml;ritz)<br>
			Zum Amtsbrink 2<br>
			17192 Waren (M&uuml;ritz)
		</td>
		<td width='200' class='links'><br>
			Regionalstandort Demmin<br>
			Reitweg 1<br>
			17109 Demmin </td>
		</td>
			<td width='200' class='links'><br>
			Regionalstandort Neustrelitz<br>
			Woldegker Chaussee 35<br>
			17235 Neustrelitz 
		</td>
	</tr>
	</table>
	</td>
  </tr>
</table>
<p>";


######################################################################
########################## Flur ######################################
######################################################################

IF ($flur > 0)
	
{


include("../includes/connect_geobasis.php");



$query_kataster="SELECT a.geographicidentifier, a.gemarkungsname_kurz, a.gemarkung,a.gemeinde , b.gemeinde, b.amt, b.amt_id, b.amt_schluessel,b.gem_schl
FROM public.gemarkung as a, public.gemeinden as b
WHERE a.geographicidentifier::integer = 13$gemarkungsnummer
AND b.gem_schl =  a.gemeinde;";

$kataster = $dbqueryp($connectp, $query_kataster);
$dat = $fetcharrayp($kataster);

$dat_amt=$dat[amt];
$dat_amtschl_voll=$dat[amt_schluessel];
$dat_amtschl=substr($dat_amtschl_voll,5,4);
$dat_gemeinde=$dat[gemeinde];
$dat_gemschl=$dat[gem_schl];
$dat_gemarkung=$dat[gemarkungsname_kurz];

$query1="SELECT b.red_flaeche as gesamt_fl,b.flurnummer as flur
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer,flurnummer
                from kataster.lk_flst_information as a
                group by gemarkungsnummer,flurnummer) as b on b.gemarkungsnummer = $gemarkungsnummer and b.flurnummer = $flur
WHERE a.gemarkungsnummer = $gemarkungsnummer and b.flurnummer = $flur
GROUP BY a.gemarkungsnummer,b.flurnummer, b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query1);
$b = $fetcharrayp($result_daten);

$gesamt_flaeche=$b[gesamt_fl];
$amtschl=$b[amt_schl];


echo "<table width='800'   cellspacing='0'>
		<tr>
			<td class='links'><b>Amt</td>
			<td>$dat_amt ($dat_amtschl)</td>
		</tr>
		<tr>
			<td class='links'><b>Gemeinde</td>
			<td>$dat_gemeinde ($dat_gemschl)</td>
		</tr>
		<tr>
			<td class='links'><b>Gemarkung</td>
			<td>$dat_gemarkung ($gemarkungsnummer)</td>
		</tr>
		<tr>
			<td class='links'><b>Flur</td>
			<td>$flur</td>
		</tr>
		<tr>
			<td class='links'><b>Gesamtfläche</td>
			<td>$gesamt_flaeche m² </td>
		<tr>
		</table>
		<br>
";

$query="SELECT a.gemarkungsnummer, a.bereich,b.red_flaeche as gesamt_fl, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil,sum(a.schnittflaeche) as schnittflaeche
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
                from kataster.lk_flst_information as a
                group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
WHERE a.gemarkungsnummer = $gemarkungsnummer
GROUP BY a.gemarkungsnummer, a.bereich,b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query);
		
$result = $dbqueryp($connectp, $query);

WHILE ($a = $fetcharrayp($result))

{	

$k_gemarkungsnummer[$count]=$a[gemarkungsnummer];
$k_flurnr[$count]=$a[flurnummer];
$k_bereich[$count]=$a[bereich];
$k_schnittflaeche[$count]=$a[schnittflaeche];
$k_gesamt_flaeche[$count]=$a[gesamt_fl];
$k_anteil[$count]=$a[anteil];


echo"
	<table width='800' cellspacing='0' >
		<tr>
			<th width='60'><b>$k_bereich[$count]</td>
			<th width='140'></td>
			<th width='400'></td>
			<th width='100' class='teil_schnitt'>$k_schnittflaeche[$count] m²<br></td>
			<th width='100' class='rechts'>$k_anteil[$count] %</td>
		</tr>";
		
		if ($k_bereich[$count] =="Siedlung")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 0 and a.unterglied2_schluessel < 20000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td ><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Verkehr")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 19999 and a.unterglied2_schluessel < 30000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b>s</td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Vegetation")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 29999 and a.unterglied2_schluessel < 40000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b>s</td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		
		if ($k_bereich[$count] =="Gewässer")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 39999 and a.unterglied2_schluessel < 50000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b>s</td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
	echo"</table> <br>";
	
}

};








######################################################################
########################## Gemarkung #################################
######################################################################

IF ($gemarkungsnummer > 0 AND $flur==0)
	
{


include("../includes/connect_geobasis.php");



$query_kataster="SELECT a.geographicidentifier, a.gemarkungsname_kurz, a.gemarkung,a.gemeinde , b.gemeinde, b.amt, b.amt_id,b.amt_schluessel, b.gem_schl
FROM public.gemarkung as a, public.gemeinden as b
WHERE a.geographicidentifier::integer = 13$gemarkungsnummer
AND b.gem_schl =  a.gemeinde;";

$kataster = $dbqueryp($connectp, $query_kataster);
$dat = $fetcharrayp($kataster);

$dat_amt=$dat[amt];
$dat_amtschl_voll=$dat[amt_schluessel];
$dat_amtschl=substr($dat_amtschl_voll,5,4);
$dat_gemeinde=$dat[gemeinde];
$dat_gemschl=$dat[gem_schl];
$dat_gemarkung=$dat[gemarkungsname_kurz];

$query1="SELECT b.red_flaeche as gesamt_fl
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
                from kataster.lk_flst_information as a
                group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
WHERE a.gemarkungsnummer = $gemarkungsnummer
GROUP BY a.gemarkungsnummer, b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query1);
$b = $fetcharrayp($result_daten);

$gesamt_flaeche=$b[gesamt_fl];


echo "<table width='800' valign='left'  cellspacing='0'>
		<tr>
			<td class='links'><b>Amt</td>
			<td>$dat_amt ($dat_amtschl)</td>
		</tr>
		<tr>
			<td class='links'><b>Gemeinde</td>
			<td>$dat_gemeinde ($dat_gemschl)</td>
		</tr>
		<tr>
			<td class='links'><b>Gemarkung</td>
			<td>$dat_gemarkung ($gemarkungsnummer)</td>
		</tr>
		<tr>
			<td class='links'><b>Gesamtfläche</td>
			<td>$gesamt_flaeche m² </td>
		<tr>
		</table>
		<br>
";

$query="SELECT a.gemarkungsnummer, a.bereich,b.red_flaeche as gesamt_fl,sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
                from kataster.lk_flst_information as a
                group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
WHERE a.gemarkungsnummer = $gemarkungsnummer
GROUP BY a.gemarkungsnummer, a.bereich,b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query);
		
$result = $dbqueryp($connectp, $query);

WHILE ($a = $fetcharrayp($result))

{	

$k_gemarkungsnummer[$count]=$a[gemarkungsnummer];
$k_flurnr[$count]=$a[flurnummer];
$k_bereich[$count]=$a[bereich];
$k_schnittflaeche[$count]=$a[schnittflaeche];
$k_gesamt_flaeche[$count]=$a[gesamt_fl];
$k_anteil[$count]=$a[anteil];


echo"
	<table width='800' valign='left'  cellspacing='0'>
		<tr>
			<th width='60'><b>$k_bereich[$count]</td>
			<th width='140'></td>
			<th width='400'></td>
			<th width='100' class='teil_schnitt'>$k_schnittflaeche[$count] m²<br></td>
			<th width='100' class='rechts'>$k_anteil[$count] %</td>
		</tr>";
		
		if ($k_bereich[$count] =="Siedlung")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 0 and a.unterglied2_schluessel < 20000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b><b>Nutzungsartenschlüssel</b></b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td ><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Verkehr")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 19999 and a.unterglied2_schluessel < 30000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Vegetation")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 29999 and a.unterglied2_schluessel < 40000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		
		if ($k_bereich[$count] =="Gewässer")
		{
				
			$query_ug="SELECT a.gemarkungsnummer, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemarkungsnummer
						from kataster.lk_flst_information
						group by gemarkungsnummer) as b on b.gemarkungsnummer = $gemarkungsnummer
						where a.gemarkungsnummer = $gemarkungsnummer and a.unterglied2_schluessel > 39999 and a.unterglied2_schluessel < 50000
						group by a.gemarkungsnummer, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
	echo"</table> <br>";
	
}

};







######################################################################
########################## Gemmeinde #################################
######################################################################

If ($gemschl > 0)
	
{


include("../includes/connect_geobasis.php");



$query_kataster="SELECT  b.gemeinde, b.amt, b.amt_id, b.amt_schluessel,b.gem_schl
FROM  public.gemeinden as b
WHERE b.gem_schl::numeric =  $gemschl;";

$kataster = $dbqueryp($connectp, $query_kataster);
$dat = $fetcharrayp($kataster);

$dat_amt=$dat[amt];
$dat_amtschl=$dat[amt_schluessel];
$dat_amtschl=substr($dat_amtschl,5);
$dat_gemeinde=$dat[gemeinde];
$dat_gemschl=$dat[gem_schl];

$query1="SELECT b.red_flaeche as gesamt_fl
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, gemeindeschluessel
                from kataster.lk_flst_information as a
                group by gemeindeschluessel) as b on b.gemeindeschluessel = $gemschl
WHERE a.gemeindeschluessel = $gemschl
GROUP BY a.gemeindeschluessel, b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query1);
$b = $fetcharrayp($result_daten);

$gesamt_flaeche=$b[gesamt_fl];

echo "<table width='800' valign='left'   cellspacing='0'>
		<tr>
			<td class='links'><b>Amt</td>
			<td>$dat_amt ($dat_amtschl)</td>
		</tr>
		<tr>
			<td class='links'><b>Gemeinde</td>
			<td>$dat_gemeinde ($dat_gemschl)</td>
		</tr>
		<tr>
			<td class='links'><b>Gesamtfläche</td>
			<td>$gesamt_flaeche m² </td>
		<tr>
		</table>
		<br>
";

$query="SELECT a.gemeindeschluessel, a.bereich,b.red_flaeche as gesamt_fl, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil,sum(a.schnittflaeche) as schnittflaeche
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, gemeindeschluessel
                from kataster.lk_flst_information as a
                group by gemeindeschluessel) as b on b.gemeindeschluessel= $gemschl
WHERE a.gemeindeschluessel = $gemschl
GROUP BY a.gemeindeschluessel, a.bereich,b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query);
		
$result = $dbqueryp($connectp, $query);

WHILE ($a = $fetcharrayp($result))

{	

$k_gemarkungsnummer[$count]=$a[gemarkungsnummer];
$k_flurnr[$count]=$a[flurnummer];
$k_bereich[$count]=$a[bereich];
$k_schnittflaeche[$count]=$a[schnittflaeche];
$k_gesamt_flaeche[$count]=$a[gesamt_fl];
$k_anteil[$count]=$a[anteil];


echo"
	<table width='800' valign='left'   cellspacing='0'>
		<tr>
			<th width='60'><b>$k_bereich[$count]</td>
			<th width='140'></td>
			<th width='400'></td>
			<th width='100' class='teil_schnitt'>$k_schnittflaeche[$count] m²<br></td>
			<th width='100' class='rechts'>$k_anteil[$count] %</td>
		</tr>";
		
		if ($k_bereich[$count] =="Siedlung")
		{
				
			$query_ug="SELECT a.gemeindeschluessel, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemeindeschluessel
						from kataster.lk_flst_information
						group by gemeindeschluessel) as b on b.gemeindeschluessel = $gemschl
						where a.gemeindeschluessel = $gemschl and a.unterglied2_schluessel > 0 and a.unterglied2_schluessel < 20000
						group by a.gemeindeschluessel, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td ><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Verkehr")
		{
				
			$query_ug="SELECT a.gemeindeschluessel, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemeindeschluessel
						from kataster.lk_flst_information
						group by gemeindeschluessel) as b on b.gemeindeschluessel= $gemschl
						where a.gemeindeschluessel = $gemschl and a.unterglied2_schluessel > 19999 and a.unterglied2_schluessel < 30000
						group by a.gemeindeschluessel, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Vegetation")
		{
				
			$query_ug="SELECT a.gemeindeschluessel, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemeindeschluessel
						from kataster.lk_flst_information
						group by gemeindeschluessel) as b on b.gemeindeschluessel= $gemschl
						where a.gemeindeschluessel = $gemschl and a.unterglied2_schluessel > 29999 and a.unterglied2_schluessel < 40000
						group by a.gemeindeschluessel, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		
		if ($k_bereich[$count] =="Gewässer")
		{
				
			$query_ug="SELECT a.gemeindeschluessel, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, gemeindeschluessel
						from kataster.lk_flst_information
						group by gemeindeschluessel) as b on b.gemeindeschluessel= $gemschl
						where a.gemeindeschluessel = $gemschl and a.unterglied2_schluessel > 39999 and a.unterglied2_schluessel < 50000
						group by a.gemeindeschluessel, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
	echo"</table> <br>";
	
}

};






######################################################################
########################## Amt #######################################
######################################################################

IF ($amtschl > 0)
	
{


include("../includes/connect_geobasis.php");



$query_kataster="SELECT amt, amt_schluessel
FROM  public.gemeinden
WHERE amt_schluessel::numeric = 13071$amtschl
GROUP BY amt_schluessel, amt";

$kataster = $dbqueryp($connectp, $query_kataster);
$dat = $fetcharrayp($kataster);


$dat_amt=$dat[amt];
$dat_amtschl=$dat[amt_schluessel];
$dat_amtschl=substr($dat_amtschl,5);


$query1="SELECT b.red_flaeche as gesamt_fl
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, amt_schl
                from kataster.lk_flst_information as a
                group by amt_schl) as b on b.amt_schl = $amtschl
WHERE a.amt_schl = $amtschl
GROUP BY a.amt_schl, b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query1);
$b = $fetcharrayp($result_daten);

$gesamt_flaeche=$b[gesamt_fl];

echo "<table width='800' valign='left'   cellspacing='0'>
		<tr>
			<td class='links'><b>Amt</td>
			<td>$dat_amt ($amtschl)</td>
		</tr>
		<tr>
			<td class='links'><b>Gesamtfläche</td>
			<td>$gesamt_flaeche m² </td>
		<tr>
		</table>
		<br>
";

$query="SELECT a.amt_schl, a.bereich,b.red_flaeche as gesamt_fl, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil,sum(a.schnittflaeche) as schnittflaeche
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, amt_schl
                from kataster.lk_flst_information as a
                group by amt_schl) as b on b.amt_schl= $amtschl
WHERE a.amt_schl = $amtschl
GROUP BY a.amt_schl, a.bereich,b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query);
		
$result = $dbqueryp($connectp, $query);

WHILE ($a = $fetcharrayp($result))

{	

$k_gemarkungsnummer[$count]=$a[gemarkungsnummer];
$k_flurnr[$count]=$a[flurnummer];
$k_bereich[$count]=$a[bereich];
$k_schnittflaeche[$count]=$a[schnittflaeche];
$k_gesamt_flaeche[$count]=$a[gesamt_fl];
$k_anteil[$count]=$a[anteil];


echo"
	<table width='800' valign='left'   cellspacing='0'>
		<tr>
			<th width='60'><b>$k_bereich[$count]</td>
			<th width='140'></td>
			<th width='400'></td>
			<th width='100' class='teil_schnitt'>$k_schnittflaeche[$count] m²<br></td>
			<th width='100' class='rechts'>$k_anteil[$count] %</td>
		</tr>";
		
		if ($k_bereich[$count] =="Siedlung")
		{
				
			$query_ug="SELECT a.amt_schl, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, amt_schl
						from kataster.lk_flst_information
						group by amt_schl) as b on b.amt_schl = $amtschl
						where a.amt_schl = $amtschl and a.unterglied2_schluessel > 0 and a.unterglied2_schluessel < 20000
						group by a.amt_schl, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td ><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Verkehr")
		{
				
			$query_ug="SELECT a.amt_schl, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, amt_schl
						from kataster.lk_flst_information
						group by amt_schl) as b on b.amt_schl= $amtschl
						where a.amt_schl = $amtschl and a.unterglied2_schluessel > 19999 and a.unterglied2_schluessel < 30000
						group by a.amt_schl, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td class='rechts'>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Vegetation")
		{
				
			$query_ug="SELECT a.amt_schl, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, amt_schl
						from kataster.lk_flst_information
						group by amt_schl) as b on b.amt_schl= $amtschl
						where a.amt_schl = $amtschl and a.unterglied2_schluessel > 29999 and a.unterglied2_schluessel < 40000
						group by a.amt_schl, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		
		if ($k_bereich[$count] =="Gewässer")
		{
				
			$query_ug="SELECT a.amt_schl, b.red_flaeche, a.unterglied2_schluessel,
						a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, amt_schl
						from kataster.lk_flst_information
						group by amt_schl) as b on b.amt_schl= $amtschl
						where a.amt_schl = $amtschl and a.unterglied2_schluessel > 39999 and a.unterglied2_schluessel < 50000
						group by a.amt_schl, b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
	echo"</table> <br>";
	
}

};






######################################################################
########################## Kreis #####################################
######################################################################

IF ($kreis == 13071)
	
{


include("../includes/connect_geobasis.php");



$query_kataster="SELECT kreis_name 
FROM public.fd_amtsbereiche";

$kataster = $dbqueryp($connectp, $query_kataster);
$dat = $fetcharrayp($kataster);


$kreisnhame=$dat[kreis_name];


$query1="SELECT b.red_flaeche as gesamt_fl
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, kreis
                from kataster.lk_flst_information as a
                group by kreis) as b on b.kreis = 71

GROUP BY  b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query1);
$b = $fetcharrayp($result_daten);

$gesamt_flaeche=$b[gesamt_fl];

echo "<table width='800' valign='left'   cellspacing='0'>
		<tr>
			<td class='links'><b>Kreis</td>
			<td>$kreisnhame</td>
		</tr>
		<tr>
			<td class='links'><b>Gesamtfläche</td>
			<td>$gesamt_flaeche m² </td>
		<tr>
		</table>
		<br>
";

$query="SELECT a.bereich,b.red_flaeche as gesamt_fl, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil,sum(a.schnittflaeche) as schnittflaeche
FROM kataster.lk_nutzungen_zu_flst as a
  left join (select sum(red_flaeche) as red_flaeche, kreis
                from kataster.lk_flst_information as a
                group by kreis) as b on b.kreis = 71
GROUP BY a.bereich,b.red_flaeche";

$result_daten = $dbqueryp($connectp, $query);
		
$result = $dbqueryp($connectp, $query);

WHILE ($a = $fetcharrayp($result))

{	

$k_gemarkungsnummer[$count]=$a[gemarkungsnummer];
$k_flurnr[$count]=$a[flurnummer];
$k_bereich[$count]=$a[bereich];
$k_schnittflaeche[$count]=$a[schnittflaeche];
$k_gesamt_flaeche[$count]=$a[gesamt_fl];
$k_anteil[$count]=$a[anteil];


echo"
	<table width='800' valign='left'   cellspacing='0'>
		<tr>
			<th width='60'><b>$k_bereich[$count]</td>
			<th width='140'></td>
			<th width='400'></td>
			<th width='100' class='teil_schnitt'>$k_schnittflaeche[$count] m²<br></td>
			<th width='100' class='rechts'>$k_anteil[$count] %</td>
		</tr>";
		
		if ($k_bereich[$count] =="Siedlung")
		{
				
			$query_ug="SELECT b.red_flaeche, a.unterglied2_schluessel, a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, kreis
						from kataster.lk_flst_information
						group by kreis) as b on b.kreis = 71
						where a.unterglied2_schluessel > 0 and a.unterglied2_schluessel < 20000
						group by b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td ><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Verkehr")
		{
				
			$query_ug="SELECT b.red_flaeche, a.unterglied2_schluessel, a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, kreis
						from kataster.lk_flst_information
						group by kreis) as b on b.kreis = 71
						where a.unterglied2_schluessel > 19999 and a.unterglied2_schluessel < 30000
						group by b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count]</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		if ($k_bereich[$count] =="Vegetation")
		{
				
			$query_ug="SELECT b.red_flaeche, a.unterglied2_schluessel, a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, kreis
						from kataster.lk_flst_information
						group by kreis) as b on b.kreis = 71
						where a.unterglied2_schluessel > 29999 and a.unterglied2_schluessel < 40000
						group by b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count] m²</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
		
		if ($k_bereich[$count] =="Gewässer")
		{
				
			$query_ug="SELECT b.red_flaeche, a.unterglied2_schluessel, a.last_nutzung, sum(a.schnittflaeche) as schnittflaeche, round((sum(a.schnittflaeche)/b.red_flaeche)*100,2)::numeric as anteil, a.color, a.outline_color
						FROM kataster.lk_nutzungen_zu_flst as a
						left join (select sum(red_flaeche) as red_flaeche, kreis
						from kataster.lk_flst_information
						group by kreis) as b on b.kreis = 71
						where a.unterglied2_schluessel > 39999 and a.unterglied2_schluessel < 50000
						group by b.red_flaeche,a.unterglied2_schluessel, a.last_nutzung,color,outline_color
						order by a.last_nutzung";
  
			$result_ug = $dbqueryp($connectp, $query_ug);
			
			echo"<tr style='padding:5px;'>
					<td></td>
					<td><b>Nutzungsartenschlüssel</b></td>
					<td><b>Gruppe</b></td>
					<td><b>Teilfläche</b></td>
					<td><b>Flächenanteil</b></td>
				</tr>";
			
			WHILE ($a = $fetcharrayp($result_ug))
			{
				$ug_last_nutzung[$count]=$a[last_nutzung];
				$ug_schnittflaeche[$count]=$a[schnittflaeche];
				$ug_color[$count]=$a[color];
				$ug_outline_color[$count]=$a[outline_color];
				$ug_schluessel[$count]=$a[unterglied2_schluessel];
				$ug_anteil[$count]=$a[anteil];
				
				
				$ug_color[$count] = str_replace(" ",",",$ug_color[$count]);
				$ug_outline_color[$count] = str_replace(" ",",",$ug_outline_color[$count]);
				
					echo "<tr>
						<td><div style='background-color:rgb($ug_color[$count]);
											width:50px;
											height:30px;
											border:3px rgb($ug_outline_color[$count]) solid;'></div></td>
						<td>$ug_schluessel[$count]</td>
						<td>$ug_last_nutzung[$count]</td>
						<td>$ug_schnittflaeche[$count]</td>
						<td>$ug_anteil[$count] %</td>
					</tr>";
					
		};	
		};
		
	echo"</table> <br>";
	
}

};



?>
</body>
</html>