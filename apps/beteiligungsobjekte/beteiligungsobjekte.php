
<?php

$_SESSION["pruef"] = (isset($_SESSION["pruef"])?$_SESSION["pruef"]:false);



if ( $_SESSION["pruef"] === false) {
	
	header("Location: errorpage.php");
	
};


?>

<?php

include("../../includes/connect_geobasis.php");
$gid=$_GET["gid"];
$basis=$_GET["basis"];
$puffer=$_GET["puffer"];
$remote = "82.193.248.66";

################# the_geom Puffer und Aktenzeichen ###########################

$query="SELECT st_buffer(the_geom,'$puffer') as the_geom,az FROM organisation.beteiligen_polygon WHERE gid = $gid";
$result = $dbqueryp($connectp,$query);
$r = $fetcharrayp($result);
$the_geom = $r[the_geom];
$aktenzeichen = $r[az];

##############Cookie Abfrage####################

if (isset($_COOKIE["gid"]))
	{
		$gid = $_COOKIE["gid"];
		$basis = $_COOKIE["basis"];
		$puffer = $_COOKIE["puffer"];
		setcookie("flur",$flstkennz,time()-3600);
		setcookie("basis",$basis,time()-3600);
		setcookie("puffer",$puffer,time()-3600);
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	

<title>Beteiligungsobjekt</title>

<meta name="author" content="Olaf Bräunlich">
<link rel="stylesheet" href="style.css" type="text/css" />
<!-- ä = &auml; ö = &ouml; ü = &uuml;  Ä = &Auml; Ö = &Ouml;  Ü = &Uuml; ß = &szlig; ² = &sup2; -->
<script src="http://code.jquery.com/jquery-latest.js"></script>


<script type="text/javascript">
function preload(){
document.getElementById('preload').style.display = 'none';
}
</script>

</head>


<body text="#000000" bgcolor="#ffffff" link="#000000" alink="#000000" vlink="#000000" onLoad="preload()">
	<span id="preload">
		<table style="position:absolute; top:35%;left:30%;" >
			<tr>
				<td>
					<div id="loading-wrapper">
					<div id="loading-text-1"><b>Geoportal<br> Landkreis Mecklenburgische Seenplatte</b><br><br>Beteiligungsobjekte <i><small><b>ALKIS<sup>®</sup></b></small></i></div>
					<div id="loading-text">Lade</div>
					<div id="loading-content"></div>
					</div>
				</td>
			</tr>
		</table>
	</span>
<center>
<img src="geoportal_logo.png" width="806">
<table id="kopf">
  <tr>
    <td id="tdkopf1" width="520" valign="top" style="text-align:left;" ><b>Beteiligungsobjekt<br>
			<?php
			
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

		echo"<small>Stand: $print_datum<br>"
		?>
	</td>
	<td>
	<table>
	<tr>
    <td width="270" valign="top,right" style="text-align:right;">Aktenzeichen: <input type=text name="akte" id="textfeld" value="<? echo $aktenzeichen; ?>"><br></td></tr><tr><td align="right"></td></tr></table>

	</td>
  </tr>
  <tr>
    <td colspan="2">
	<table id="tdkopf2">
	<tr>
		<td width="200" style="text-align:left;"><br>
			Regionalstandort Neubrandenburg<br>
			Platanenstra&szlig;e 43<br>
			17033 Neubrandenburg 
		</td>
		<td width="200" style="text-align:left;"><br>
			Regionalstandort Waren (M&uuml;ritz)<br>
			Zum Amtsbrink 2<br>
			17192 Waren (M&uuml;ritz)
		</td>
		<td width="200" style="text-align:left;"><br>
			Regionalstandort Demmin<br>
			Reitweg 1<br>
			17109 Demmin </td>
		</td>
			<td width="200" style="text-align:left;"><br>
			Regionalstandort Neustrelitz<br>
			Woldegker Chaussee 35<br>
			17235 Neustrelitz 
		</td>
	</tr>
	</table>
	</td>
  </tr>
</table>
</p>


<?php


##############Bildentzerrung###################	
	
$query="SELECT a.flurstueckskennzeichen,a.zaehler, a.nenner, a.ausschrift_amt, flst_ausschrift,a.eigentuemer,st_box(st_buffer(b.the_geom,(100+'$puffer'))) as bounding_box FROM kataster.lk_flst_information as a, organisation.beteiligen_polygon as b where st_intersects(b.the_geom,geo_gepuffert) and b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$r = $fetcharrayp($result);
$box = $r[bounding_box];
$klammer = array("(",")");
$box2 = str_replace($klammer,"",$box);
$array = explode(",",$box2);

//if ($isEmpty===null)
//{ 
//$fehler = "<font color='ff0000'>Keine Anwendung der Kreisgebietsreform f&uuml;r das Flurst&uuml;ck erfolgt !</font>";
//}

//$bbox = $array[2].",".$array[3].",".$array[0].",".$array[1];

$a0 = $array[0];
$a1 = $array[1];
$a2 = $array[2];
$a3 = $array[3];

$x=$a0 - $a2;
$y=$a1 - $a3;

if ($x>$y) 
	{
		$diff=$x-$y;
		$hoch_neu=$a1+$diff;
		$bbox=$a2.",".$a3.",".$a0.",".$hoch_neu;
	}
else 
	{
		$diff=$y-$x;
		$rechts_neu=$a0+$diff;
		$bbox=$a2.",".$a3.",".$rechts_neu.",".$a1;
	};


?> 




<!--------Karte----------------------------------------------------------------------------------------------------->
<br>
<table width="500">
<tr><td>
<form name="form">
 <select  style="width:250px;margin-right:25px;" name="link" SIZE="4" onChange="window.location.href = document.form.link.options[document.form.link.selectedIndex].value;">
									 <option value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session.php?gid=",$gid,"&basis=ORKA&puffer=$puffer"; ?>" 
																<?php if($_GET['basis'] == "ORKA") echo "selected=\"selected\"";?>>Offene Regionalkarte (ORKa)</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session.php?gid=",$gid,"&basis=DOP20&puffer=$puffer"; ?>" 
																<?php if($_GET['basis'] == "DOP20") echo "selected=\"selected\""; ?>>Luftbilder 2013 (DOP20)</option>
 </select>
 </form></td>
 <td>
 <form name="form1">
 <select  style="width:250px;margin-left:25px;" name="link1" SIZE="4" onChange="window.location.href = document.form1.link1.options[document.form1.link1.selectedIndex].value;">
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session.php?gid=",$gid,"&basis=$basis&puffer=-1"; ?>" 
																<?php if($_GET['puffer'] == "-1") echo "selected=\"selected\"";?>>Kein Puffer</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session.php?gid=",$gid,"&basis=$basis&puffer=50"; ?>" 
																<?php if($_GET['puffer'] == "50") echo "selected=\"selected\""; ?>>Puffer 50m</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session.php?gid=",$gid,"&basis=$basis&puffer=100"; ?>" 
																<?php if($_GET['puffer'] == "100") echo "selected=\"selected\""; ?>>Puffer 100m</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session.php?gid=",$gid,"&basis=$basis&puffer=200"; ?>" 
																<?php if($_GET['puffer'] == "200") echo "selected=\"selected\""; ?>>Puffer 200m</option>																
 </select>
 </form></td></tr>
</table> 
<br>
<?php

if ( $basis == 'ORKA'){
echo "<img id='flauszug2' alt='Flurst&uuml;cksfehler' src=\"https://geoport-lk-mse.de/webservices/wms/int_kvwmap_alkis07?REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=",$basis,",ag_t_flurstueck,ag_l_flurstueck,sk2004_zuordnungspfeil_spitze,ag_p_flurstueck,ax_flurstueck,ax_besondereflurstuecksgrenze,ax_punktortta,ax_gebaeude_fl,ax_bauteil,ax_besonderegebaeudelinie,ag_t_gebaeude,ag_t_nebengeb,ag_l_gebaeude,ax_gebaeude_txt,"; if($_GET['puffer'] == "50") echo "beteiligungsobjekt50,"; if($_GET['puffer'] == "100") echo "beteiligungsobjekt100,"; if($_GET['puffer'] == "200") echo "beteiligungsobjekt200,"; echo "beteiligungsobjekt&BBOX=$bbox&SRS=EPSG:25833&FORMAT=image/png&WIDTH=800&HEIGHT=800&STYLES=\">";
}else{
echo "<img id='flauszug2' alt='Flurst&uuml;cksfehler' src=\"https://geoport-lk-mse.de/webservices/wms/int_kvwmap_alkis07?REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=",$basis,",ag_t_flurstueck,ag_l_flurstueck,sk2004_zuordnungspfeil_spitze,ag_p_flurstueck,ax_flurstueck,ax_besondereflurstuecksgrenze,ax_punktortta,ax_gebaeude_fl,ax_bauteil,ax_besonderegebaeudelinie,ag_t_gebaeude,ag_t_nebengeb,ag_l_gebaeude,ax_gebaeude_txt,"; if($_GET['puffer'] == "50") echo "beteiligungsobjekt50,"; if($_GET['puffer'] == "100") echo "beteiligungsobjekt100,"; if($_GET['puffer'] == "200") echo "beteiligungsobjekt200,"; echo "beteiligungsobjekt&BBOX=$bbox&SRS=EPSG:25833&FORMAT=image/png&WIDTH=800&HEIGHT=800&STYLES=\">";	
};

echo"<br><br><br><br>";




?> 

<!----------------------------Abfrage Anzahl Ergebnisse ---------------------------------------------------------------------------------->

<?php

//////////////////////////////////////////Landkreis Eigentum
$query="SELECT a.flurstueckskennzeichen
 FROM kataster.lk_flst_information as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.wkb_geometry,25833),'$the_geom') AND b.gid = $gid and a.eigentuemer LIKE '%Landkreis Mecklenburgische Seenplatte%'";

$result = $dbqueryp($connectp,$query);
$lk_count=0;

while($r = $fetcharrayp($result))
  {
    $lk_count++;
	}

//////////////////////////////////////////Baudenkmale
$query="SELECT a.nr,a.lfdnr,a.obj,a.ort
 FROM construction.baudenkmale as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$baud_count=0;

while($r = $fetcharrayp($result))
  {
    $baud_count++;
	}

/////////////////////////////////////////Bodendenkmale blau
$query="SELECT a.typ,a.gemarkung,a.fundplatz
 FROM construction.bodendenkmale_blau as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$bodenb_count=0;

while($r = $fetcharrayp($result))
  {
    $bodenb_count++;
	}

/////////////////////////////////////////Bodendenkmale rot
$query="SELECT a.typ,gemarkung,a.fundplatz
FROM construction.bodendenkmale_rot as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$bodenr_count=0;


while($r = $fetcharrayp($result))
  {
    $bodenr_count++;
	}
	



/////////////////////////////////////////B-Pläne
$query="SELECT a.plan_nr,a.zusatz,a.bezeichnun,a.stand_verfahren,a.datum_stan 
FROM fd_vblp5 as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";
$result = $dbqueryp($connectp,$query);
$bplan_count=0;


while($r = $fetcharrayp($result))
  {
    $bplan_count++;
	}


//////////////////////////////////Kampfmittelbelastung
$query="SELECT a.kmk,a.name,a.art,a.belastung 
FROM protection.kbelastete_gebiete as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$kampfb_count=0;


while($r = $fetcharrayp($result))
  {
    $kampfb_count++;
	}	
	
//////////////////////////////////Straßen
$query="SELECT a.strassenna
FROM traffic.abschnitte as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid AND a.gueltig = 1";

$result = $dbqueryp($connectp,$query);
$kreisstr_count=0;


while($r = $fetcharrayp($result))
  {
    $kreisstr_count++;
	}

/////////////////////////////////Rastgebiete Land
$query="SELECT a.id,area_qm
FROM environment.rastgebiete_land as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$rastg_l_count=0;

while($r = $fetcharrayp($result))
  {
    $rastg_l_count++;
	}	
	
/////////////////////////////////Biotope
$query="SELECT a.biotopname
FROM environment.biotope as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$biotope_count=0;

while($r = $fetcharrayp($result))
  {
    $biotope_count++;
	}	
	
/////////////////////////////////Naturschutzgebiete
$query="SELECT a.label,a.name,a.lage,a.area_ha 
FROM environment.sg_naturschutzgebiete as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$naturs_count=0;

while($r = $fetcharrayp($result))
  {
    $naturs_count++;
	}
	
////////////////////////////////Nationalparke
$query="SELECT a.nr,a.name,a.area_ha
FROM environment.sg_nationalparke as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$nationalp_count=0;


while($r = $fetcharrayp($result))
  {
    $nationalp_count++;
	}
	
/////////////////////////////Vogelschutzgebiete
$query="SELECT a.eu_nr,a.nr,a.gebiet_nam, a.ha_etrs as area_ha 
FROM environment.sg_spa_fl as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$vogels_count=0;


while($r = $fetcharrayp($result))
  {
    $vogels_count++;
	}
	
///////////////////////////Landschatsschutzgebiete
$query="SELECT a.label,a.name,a.kreis1, a.area_ha
FROM environment.sg_lsg_2016 as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$lands_count=0;

while($r = $fetcharrayp($result))
  {
    $lands_count++;
	}
	
/////////////////////////Flora-Fauna-Habitat
$query="SELECT a.eu_nr,a.name,a.ha_etrs as area_ha
FROM environment.sg_ffh_fl as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$ffh_count=0;


while($r = $fetcharrayp($result))
  {
    $ffh_count++;
	}
?>

<!-------------------------------------Themenübersicht------------------------------------------->
<hr width="900" NOSHADE size="1" color="#000000">	
<table width="900" style="border:0px;">
<tr><h4>Themen&uuml;bersicht</h4></tr>
<tr>
<td style="text-align:left;">
<ul style="list-style-type: disc">
<li>Flurstücke des Landkreises (<?php echo $lk_count; ?>)</li>
<li>Baudenkmale (<?php echo $baud_count; ?>)</li>
<li>Bodendenkmale blau (<?php echo $bodenb_count; ?>)</li>
<li>Bodendenkmale rot (<?php echo $bodenr_count; ?>)</li>
<li>B Pl&aumlne  (<?php echo $bplan_count; ?>)</li>
</ul>
</td>
<td style="text-align:left;">
<ul>
<li>Kampfmittelbelastung (<?php echo $kampfb_count; ?>)</li>
<li>Straßen (<?php echo $kreisstr_count; ?>)</li>
<li>Rastgebiete Land (<?php echo $rastg_l_count; ?>)</li>
<li>Biotope (<?php echo $biotope_count; ?>)</li>
<li>Naturschutzgebiete (<?php echo $naturs_count; ?>)</li>
</ul>
</td>
<td style="text-align:left;">
<li>Nationalpark (<?php echo $nationalp_count; ?>)</li>
<li>Vogelschutzgebiete (<?php echo $vogels_count; ?>)</li>
<li>Landschaftsschutzgebiete (<?php echo $lands_count; ?>)</li>
<li>Fauna-Flora-Habitat Gebiete (<?php echo $ffh_count; ?>)</li>
</td>
</tr>
</table>
<hr width="900" NOSHADE size="1" color="#000000">	
<br>
<br>
<br>
<!--------Landkreis Eigentum----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.flurstueckskennzeichen,
CASE 
	WHEN st_isvalid(a.wkb_geometry) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.wkb_geometry,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.wkb_geometry) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.wkb_geometry,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM kataster.lk_flst_information as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.wkb_geometry,25833),'$the_geom') AND b.gid = $gid and a.eigentuemer LIKE '%Landkreis Mecklenburgische Seenplatte%'";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$flstkennz[$count] = $r[flurstueckskennzeichen];	
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='6'><b>Flurstücke des Landkreises</th>
			<tr>
				<td width=200 ><b>Flurstückskennzeichen</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$flstkennz[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>	
					</tr>";
		}
		
	}
		echo "</table></p>";
?>

<!--------Baudenkmale----------------------------------------------------------------------------------------------------->

<?php

$query="SELECT a.nr,a.lfdnr,a.obj,a.ort, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM construction.baudenkmale  as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;



while($r = $fetcharrayp($result))
  {
	$nummer[$count] = $r[nr];
	$laufdnr[$count] = $r[lfdnr];
	$objekt[$count] = $r[obj];
	$ort[$count] = $r[ort];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}

if ($count>0) 

	{
		echo "
			<table id='customers'>
			<th height='30' colspan='6'><b>Baudenkmale (Derzeitig keine flächendeckende Erfassung)</th>
			<tr >
				<td width=100 ><b>Nummer</td>
				<td width=100 ><b>lfd.-Nr.</td>
				<td width=300 ><b>Objekt</td>
				<td width=300 ><b>Ort</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$nummer[$i]</td>
						<td>$laufdnr[$i]</td>
						<td>$objekt[$i]</td>
						<td>$ort[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>
					</tr>";
		}
		
	}
		echo "</table></p>";
	
?>

<!--------Bodendenkmale blau------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.typ,a.gemarkung,a.fundplatz, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM construction.bodendenkmale_blau as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$typ[$count] = $r[typ];
	$gemarkung[$count] = $r[gemarkung];
	$fundpl[$count] = $r[fundplatz];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='5'><b>Bodendenkmale (blau)</th>
			<tr >
				<td width=100 ><b>Typ</td>
				<td width=100 ><b>Gemarkung</td>
				<td width=200 ><b>Fundplatz</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$typ[$i]</td>
						<td>$gemarkung[$i]</td>
						<td>$fundpl[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i]</td>
					</tr>
					
					";
		}
		
	}
		echo "</table></div></p>";
?>

<!--------Bodendenkmale rot------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.typ,gemarkung,a.fundplatz, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM construction.bodendenkmale_rot as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$typ[$count] = $r[typ];
	$gemarkung[$count] = $r[gemarkung];
	$fundpl[$count] = $r[fundplatz];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='5'><b>Bodendenkmale (rot)</th>
			<tr>
				<td width=100 ><b>Typ</td>
				<td width=300 ><b>Gemarkung</td>
				<td width=300 ><b>Fundplatz</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80  ><b>%</td>
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$typ[$i]</td>
						<td>$gemarkung[$i]</td>
						<td>$fundpl[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>
					</tr>";
		}
		
	}
		echo "</table></div></p>";
?>






<!--------B Pläne----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.plan_nr,a.zusatz,a.bezeichnun,a.stand_verfahren,a.datum_stan, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM fd_vblp5 as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$plannr[$count] = $r[plan_nr];
	$zusatz[$count] = $r[zusatz];
	$bezeich[$count] = $r[bezeichnun];
	$standverf[$count] = $r[stand_verfahren];
	$datumstan[$count] = $r[datum_stan];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th  height='30' colspan='6'><b>B-Pl&auml;ne</th>
			<tr>
				<td ><b>Plan-Nr.</td>
				<td ><b>Bezeichnung</td>
				<td ><b>Verfahrensstand</td>
				<td ><b>Datum</td>
				<td  ><b>Teilfläche m²</td>
				<td ><b>%</td>
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$plannr[$i] $zusatz[$i]</td>
						<td>$bezeich[$i]</td>
						<td>$standverf[$i]</td>
						<td>$datumstan[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>						
					</tr>";
		}
		
	}
		echo "</table></p>";
?>



<!--------Kampfmittelbelastung----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.kmk,a.name,a.art,a.belastung, 
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM protection.kbelastete_gebiete as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$kmk[$count] = $r[kmk];
	$name[$count] = $r[name];
	$art[$count] = $r[art];
	$belast[$count] = $r[belastung];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}
	
if ($count > 0) 
	{
		echo "
			<table id='customers' >
				<th height='30' colspan='6'><b>Kampfmittel</th>
				<tr><td colspan=6 ><b>Kampfmittelbelastung:</td></tr>
				<tr>
					<td width=80 ><b>Nr. KMK</td>
					<td width=200 ><b>Name</td>
					<td width=200 ><b>Art</td>
					<td width=200 ><b>Belastung</td>
					<td width=100 ><b>Teilfläche m²</td>
					<td width=80 ><b>%</td>					
				</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$kmk[$i]</td>
						<td>$name[$i]</td>
						<td>$art[$i]</td>
						<td>$belast[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>							
					</tr>";
		}
		
	}


$query="SELECT a.br_id,a.beginn,a.art,a.ende, 
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM protection.kberaeumte_gebiete as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$brid[$count] = $r[br_id];
	$beginn[$count] = $r[beginn];
	$ende[$count] = $r[ende];
	$art1[$count] = $r[art];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "	<tr><td colspan=6><b>Kampfmittelber&auml;umung:</td></tr>
				<tr id='trinfo'>
				<td width=80 ><b>Ber&auml;umungsnr.</td>
				<td width=200 ><b>Beginn</td>
				<td width=200 ><b>Ende</td>
				<td width=200 ><b>Art</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
				</tr>";
				
		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$brid[$i]</td>
						<td>$beginn[$i]</td>
						<td>$ende[$i]</td>
						<td>$art1[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>							
					</tr>";
		}
		
	}
		echo "</table></p>";
?>

<!--------Straßen----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.strassenna,a.abschnitt ,
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM traffic.abschnitte as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid AND a.gueltig = 1";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$strassenna[$count] = $r[strassenna];	
	$abschnitt[$count] = $r[abschnitt];	
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='6'><b>Straßen/Abschnitte</th>
			<tr>
				<td width=200 ><b>Straße</td>
				<td width=200 ><b>Abschnitt</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$strassenna[$i]</td>
						<td>$abschnitt[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>	
					</tr>";
		}
		
	}
		echo "</table></p>";
?>

<!--------Rastgebiete Land----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.id,a.area_qm,
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM environment.rastgebiete_land as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$id[$count] = $r[id];	
	$area_qm[$count] = $r[area_qm];	
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='6'><b>Rastgebiete Land</th>
			<tr>
				<td width=200 ><b>ID</td>
				<td width=200 ><b>Fläche in m²</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$id[$i]</td>
						<td>$area_qm[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>	
					</tr>";
		}
		
	}
		echo "</table></p>";
?>

<!--------Biotope----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.giscode,a.biotopname,
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM environment.biotope as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$giscode[$count] = $r[giscode];	
	$biotopname[$count] = $r[biotopname];	
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='6'><b>Biotope</th>
			<tr>
				<td width=200 ><b>Gis-Code</td>
				<td width=200 ><b>Biotopname</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$giscode[$i]</td>
						<td>$biotopname[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>	
					</tr>";
		}
		
	}
		echo "</table></p>";
?>

<!--------Naturschutzgebiete----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.label,a.name,a.lage,a.area_ha, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM environment.sg_naturschutzgebiete as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$label[$count] = $r[label];
	$name[$count] = $r[name];
	$lage[$count] = $r[lage];
	$area[$count] = $r[area_ha];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];	
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='6'><b>Naturschutzgebiete</th>
			<tr>
				<td width=60 ><b>Nummer</td>
				<td width=200 ><b>Bezeichnung</td>
				<td width=100 ><b>Lage</td>
				<td width=100 ><b>Fl&auml;che ha</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$label[$i]</td>
						<td>$name[$i]</td>
						<td>$lage[$i]</td>
						<td>$area[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>	
					</tr>";
		}
		
	}
		echo "</table></p>";
?>

<!--------Nationalpark----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.nr,a.name,a.area_ha,
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil  FROM environment.sg_nationalparke as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$nummer[$count] = $r[nr];
	$name[$count] = $r[name];
	$area[$count] = $r[area_ha];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];	
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='5'><b>Nationalparke</th>
			<tr>
				<td width=60 ><b>Nummer</td>
				<td width=200 ><b>Bezeichnung</td>
				<td width=100 ><b>Fl&auml;che ha</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$nummer[$i]</td>
						<td>$name[$i]</td>
						<td>$area[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>							
					</tr>";
		}
		
	}
		echo "</table></div></p>";
?>

<!--------Vogelschutzgebiete----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.eu_nr,a.nr,a.gebiet_nam, a.ha_etrs as area_ha, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil  FROM environment.sg_spa_fl as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$eunummer[$count] = $r[eu_nr];
	$nummer[$count] = $r[nr];
	$gebiet[$count] = $r[gebiet_nam];
	$area[$count] = $r[area_ha];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];		
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "	
			<table id='customers' >
			<th height='30' colspan='6'><b>Vogelschutzgebiete</tr>
			<tr>
				<td width=60 ><b>EU Nummer</td>
				<td width=200 ><b>Nummer</td>
				<td width=100 ><b>Bezeichnung</td>
				<td width=100 ><b>Fl&auml;che ha</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>				
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$eunummer[$i]</td>
						<td>$nummer[$i]</td>
						<td>$gebiet[$i]</td>
						<td>$area[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>							
					</tr>";
		}
		
	}
		echo "</table></p>";
?>

<!--------Landschaftsschutzgebiet--------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.label,a.name,a.kreis1, a.area_ha,
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM environment.sg_lsg_2016 as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$label[$count] = $r[label];
	$name[$count] = $r[name];
	$kreis1[$count] = $r[kreis1];
	$area[$count] = $r[area_ha];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];		
	
    $count++;
	}

	
if ($count > 0) 

	{
		echo "	
			<table id='customers' >
			<th height='30' colspan='6'><b>Landschaftsschutzgebiete</th>
			<tr>
				<td width=60 ><b>Nummer</td>
				<td width=200 ><b>Bezeichnung</td>
				<td width=100 ><b>Kreis</td>
				<td width=100 ><b>Fl&auml;che ha</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>					
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$label[$i]</td>
						<td>$name[$i]</td>
						<td>$kreis1[$i]</td>
						<td>$area[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>								
					</tr>";
		}
		
	}
		echo "</table></div></p>";
?>

<!--------Fauna-Flora-Habitat Gebiete--------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.eu_nr,a.name,a.ha_etrs as area_ha,
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM environment.sg_ffh_fl as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$eunummer[$count] = $r[eu_nr];
	$name[$count] = $r[name];
	$area[$count] = $r[area_ha];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];	
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "
			<table id='customers' >
			<th height='30' colspan='5'><b>Fauna-Flora-Habitat Gebiete</th>
			<tr>
				<td width=60 ><b>EU Nummer</td>
				<td width=200 ><b>Bezeichnung</td>
				<td width=100 ><b>Fl&auml;che ha</td>
				<td width=100 ><b>Teilfläche m²</td>
				<td width=80 ><b>%</td>							
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$eunummer[$i]</td>
						<td>$name[$i]</td>
						<td>$area[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>						
					</tr>";
			
		}
	}
		echo "</table></div></p>";
	
?>

</body>
</html>

