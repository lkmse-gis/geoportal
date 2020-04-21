
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
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.4/css/ol.css" type="text/css">
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v4.6.4/build/ol.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.14/proj4.js"></script>


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
					<div id="loading-text-1"><b>Geoportal<br> Landkreis Mecklenburgische Seenplatte</b></div>
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
    <td id="tdkopf1" width="520" valign="top" ><b>Beteiligungsobjekt (Entwicklerversion)<br>
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
    <td width="270" valign="top,right" align="right">Aktenzeichen: <input type=text name="akte" id="textfeld" value="<? echo $aktenzeichen; ?>"><br></td></tr><tr><td align="right"></td></tr></table>

	</td>
  </tr>
  <tr>
    <td colspan="2">
	<table id="tdkopf2" >
	<tr>
		<td width="200"><br>
			Regionalstandort Neubrandenburg<br>
			Platanenstra&szlig;e 43<br>
			17033 Neubrandenburg 
		</td>
		<td width="200"><br>
			Regionalstandort Waren (M&uuml;ritz)<br>
			Zum Amtsbrink 2<br>
			17192 Waren (M&uuml;ritz)
		</td>
		<td width="200"><br>
			Regionalstandort Demmin<br>
			Reitweg 1<br>
			17109 Demmin </td>
		</td>
			<td width="200"><br>
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


<?php 
   	$geom="SELECT box(st_transform(a.the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(a.the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center FROM organisation.beteiligen_polygon as a WHERE a.gid = $gid";
	$result_geom = $dbqueryp($connectp,$geom);
	$g = $fetcharrayp($result_geom);
	$zentrum = $g[center];
	$klammer = array("POINT(",")");
	$zentrum2 = str_replace($klammer,"",$zentrum);
	$zentrum2 = str_replace(' ',",",$zentrum2);
?>


<!--------Karte----------------------------------------------------------------------------------------------------->

<br>
<table width="500">
<tr><td>
<form name="form">
 <select  style="width:250px;margin-right:25px;" name="link" SIZE="4" onChange="window.location.href = document.form.link.options[document.form.link.selectedIndex].value;">
									 <option value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session_dev.php?gid=",$gid,"&basis=ORKA&puffer=$puffer"; ?>" 
																<?php if($_GET['basis'] == "ORKA") echo "selected=\"selected\"";?>>Offene Regionalkarte (ORKa)</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session_dev.php?gid=",$gid,"&basis=DOP20&puffer=$puffer"; ?>" 
																<?php if($_GET['basis'] == "DOP20") echo "selected=\"selected\""; ?>>Luftbilder 2013 (DOP20)</option>
 </select>
 </form></td>
 <td>
 <form name="form1">
 <select  style="width:250px;margin-left:25px;" name="link1" SIZE="4" onChange="window.location.href = document.form1.link1.options[document.form1.link1.selectedIndex].value;">
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session_dev.php?gid=",$gid,"&basis=$basis&puffer=-1"; ?>" 
																<?php if($_GET['puffer'] == "-1") echo "selected=\"selected\"";?>>Kein Puffer</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session_dev.php?gid=",$gid,"&basis=$basis&puffer=50"; ?>" 
																<?php if($_GET['puffer'] == "50") echo "selected=\"selected\""; ?>>Puffer 50m</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session_dev.php?gid=",$gid,"&basis=$basis&puffer=100"; ?>" 
																<?php if($_GET['puffer'] == "100") echo "selected=\"selected\""; ?>>Puffer 100m</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/beteiligungsobjekte/beteiligungsobkekte_session_dev.php?gid=",$gid,"&basis=$basis&puffer=200"; ?>" 
																<?php if($_GET['puffer'] == "200") echo "selected=\"selected\""; ?>>Puffer 200m</option>																
 </select>
 </form></td></tr>
</table> 
<br>
<br>

<br>
<?php

if ( $basis == 'ORKA'){
echo "<img id='flauszug2' alt='Flurst&uuml;cksfehler' src=\"http://www.geoport-lk-mse.de/webservices/alkis07?REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=",$basis,",ag_t_flurstueck,ag_l_flurstueck,sk2004_zuordnungspfeil_spitze,ag_p_flurstueck,ax_flurstueck,ax_besondereflurstuecksgrenze,ax_punktortta,ax_gebaeude_fl,ax_bauteil,ax_besonderegebaeudelinie,ag_t_gebaeude,ag_t_nebengeb,ag_l_gebaeude,ax_gebaeude_txt,"; if($_GET['puffer'] == "50") echo "beteiligungsobjekt50,"; if($_GET['puffer'] == "100") echo "beteiligungsobjekt100,"; if($_GET['puffer'] == "200") echo "beteiligungsobjekt200,"; echo "beteiligungsobjekt&BBOX=$bbox&SRS=EPSG:25833&FORMAT=image/png&WIDTH=800&HEIGHT=800&STYLES=\">";
}else{
echo "<img id='flauszug2' alt='Flurst&uuml;cksfehler' src=\"http://www.geoport-lk-mse.de/webservices/alkis07?REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=",$basis,",ag_t_flurstueck,ag_l_flurstueck,sk2004_zuordnungspfeil_spitze,ag_p_flurstueck,ax_flurstueck,ax_besondereflurstuecksgrenze,ax_punktortta,ax_gebaeude_fl,ax_bauteil,ax_besonderegebaeudelinie,ag_t_gebaeude,ag_t_nebengeb,ag_l_gebaeude,ax_gebaeude_txt,"; if($_GET['puffer'] == "50") echo "beteiligungsobjekt50,"; if($_GET['puffer'] == "100") echo "beteiligungsobjekt100,"; if($_GET['puffer'] == "200") echo "beteiligungsobjekt200,"; echo "beteiligungsobjekt&BBOX=$bbox&SRS=EPSG:25833&FORMAT=image/png&WIDTH=800&HEIGHT=800&STYLES=\">";	
};

echo"<br><br><br><br>";




?> 

<!----------------------------Abfrage Anzahl Ergebnisse ---------------------------------------------------------------------------------->

<?php

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
	
////////////////////////////////////////Baulastenkarte
$query="SELECT a.bl_bl_nr, a.bl_bl_s, a.ldf_nr, a.art, a.bemerk
 FROM construction.baulasten as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$baul_count=0;


while($r = $fetcharrayp($result))
  {
    $baul_count++;
	}
/////////////////////////////////////////Baulastenkarte MSBAU
$query="SELECT a.spalte_5, a.spalte_6, a.spalte_7, a.spalte_8 
FROM construction.baulasten_msbau as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$msbau_count=0;

while($r = $fetcharrayp($result))
  {
    $msbau_count++;
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

/////////////////////////////////////Störfallbetriebe
$query="SELECT a.g_name, a.b_name, a.b_art, a.stoerfallbetrieb, a.stoerfall_radius, a.stoerfall_status
FROM planning.stoerfallanlagen as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$stoerb_count=0;


while($r = $fetcharrayp($result))
  {
    $stoerb_count++;
	}
	
//////////////////////////////////Kampfmittelbelastung
$query="SELECT a.kmk,a.name,a.art,a.belastung 
FROM protection.kbelastete_gebiete_2015 as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$kampfb_count=0;


while($r = $fetcharrayp($result))
  {
    $kampfb_count++;
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
<table width="800" border="0">
<tr><h4>Themen&uuml;bersicht</h4></tr>
<tr>
<td>
<ul style="list-style-type: disc">
<li>Baudenkmale (<?php echo $baud_count; ?>)</li>
<li>Bodendenkmale blau (<?php echo $bodenb_count; ?>)</li>
<li>Bodendenkmale rot (<?php echo $bodenr_count; ?>)</li>
<li>Baulastenkarte (<?php echo $baul_count; ?>)</li>
<li>Baulastenkarte MS-Bau (<?php echo $msbau_count; ?>)</li>
</ul>
</td>
<td>
<ul>
<li>B Pl&aumlne  (<?php echo $bplan_count; ?>)</li>
<li>Störfallbetriebe (<?php echo $stoerb_count; ?>)</li>
<li>Kampfmittelbelastung (<?php echo $kampfb_count; ?>)</li>
<li>Naturschutzgebiete (<?php echo $naturs_count; ?>)</li>
</ul>
</td>
<td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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


<!--------Baulastenkarte----------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.bl_bl_nr, a.bl_bl_s, a.ldf_nr, a.art, a.bemerk, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM construction.baulasten as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$nummer[$count] = $r[bl_bl_nr];
	$seite[$count] = $r[bl_bl_s];
	$laufdnr[$count] = $r[ldf_nr];
	$art[$count] = $r[art];
	$bemerk[$count] = $r[bemerk];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}
	
if ($count > 0) 

	{
		echo "	
			<table id='customers' >
			<th height='30' colspan='7'><b>Baulastenkarte</th>
			<tr>
				<td width=40 ><b>Nummer</td>
				<td width=40 ><b>Seite</td>
				<td width=60 ><b>lfd. Nr.</td>
				<td width=150 ><b>Art</td>
				<td width=250 ><b>Bemerkung</td>
				<td width=100 ><b>&isin; in m&sup2;</td>
				<td width=80 ><b>%</td>
			</tr>";

		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$nummer[$i]</td>
						<td>$seite[$i]</td>
						<td>$laufdnr[$i]</td>
						<td>$art[$i]</td>
						<td>$bemerk[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>						
					</tr>";
		}
		
	}
		echo "</table></div></p>";
		
?>

<!--------Baulastenkarte MS-Bau---------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.spalte_5, a.spalte_6, a.spalte_7, a.spalte_8, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM construction.baulasten_msbau as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.the_geom,25833),'$the_geom') AND b.gid = $gid";

$result = $dbqueryp($connectp,$query);
$count=0;

while($r = $fetcharrayp($result))
  {
	$spalte5[$count] = $r[spalte_5];
	$spalte6[$count] = $r[spalte_6];
	$spalte7[$count] = $r[spalte_7];
	$spalte8[$count] = $r[spalte_8];
	$schnittflaeche[$count] = $r[schnittflaeche];
	$anteil[$count] = $r[anteil];
	
    $count++;
	}
	
	
if ($count > 0) 
	{
		echo "	
			<table id='customers' >
			<th height='30' colspan='6'><b>Baulasten (MS-Bau)</th>
			<tr>
				<td width=25%><b>Spalte 5</td>
				<td width=25%><b>Spalte 6</td>
				<td width=25%><b>Spalte 7</td>
				<td width=25%><b>Spalte 8</td>
				<td width=100><b>&isin; in m&sup2;</td>
				<td width=80><b>%</td>
			</tr>";
		
		for ($i = 0; $i < $count; $i++)
		{	
			echo "	<tr>
						<td>$spalte5[$i]</td>
						<td>$spalte6[$i]</td>
						<td>$spalte7[$i]</td>
						<td>$spalte8[$i]</td>
						<td>$schnittflaeche[$i]</td>
						<td>$anteil[$i] %</td>	
					</tr>";
		}
		
	}
		echo "</table></p>";
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
				<td  ><b>&isin; in m&sup2;</td>
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


<!--------Störfallbetriebe--------------------------------------------------------------------------------------------------->

<?php
$query="SELECT a.jahrgang, a.g_name, a.b_name, a.b_art, a.stoerfall_radius, a.stoerfall_status,
CASE 
	WHEN st_isvalid(st_buffer(a.the_geom,a.stoerfall_radius)) = TRUE
	THEN (round(st_area(INTERSECTION(st_buffer(st_transform(a.the_geom,25833),a.stoerfall_radius),'$the_geom'))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_buffer(st_transform(a.the_geom,25833),a.stoerfall_radius),'$the_geom'))/st_area('$the_geom'))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM planning.stoerfallanlagen as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_buffer(a.the_geom,a.stoerfall_radius),'$the_geom') AND b.gid = $gid ORDER BY a.jahrgang DESC";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$gname[$count] = $r[g_name];
	$bname[$count] = $r[b_name];
	$art[$count] = $r[b_art];
	$stoerfallbetrieb[$count] = $r[stoerfallbetrieb];
	$stoerfallradius[$count] = $r[stoerfall_radius];
	$stoerfallstatus[$count] = $r[stoerfall_status];
	$jahr[$count] = $r[jahrgang];
	
	
	
    $count++;
	}

	if ($count> 0) 
		{
			echo "
				<table id='customers' >
				<th  height='30' colspan='6'><b>Störfallbetriebe ( $jahr[0] )</th>
				<tr>
					<td width=60 ><b>Betreiber</td>
					<td width=200 ><b>Betriebsstätte</td>
					<td width=100 ><b>Betriebsart</td>
					<td width=100 ><b>Störfallanlage</td>
					<td width=100 ><b>Wirkradius</td>
					<td width=80 ><b>Status</td>
				</tr>";

			for ($i = 0; $i < $count; $i++)
			{	
				echo "	<tr>
							<td>$gname[$i]</td>
							<td>$bname[$i]</td>
							<td>$art[$i]</td>
							<td>$stoerfallbetrieb[$i]</td>
							<td>$stoerfallradius[$i] m</td>
							<td>$stoerfallstatus[$i]</td>						
						</tr>";
				
			}
		}
			echo "</table></div></p>";
		
	
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
END as anteil FROM protection.kbelastete_gebiete_2015 as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

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
					<td width=100 ><b>&isin; in m&sup2;</td>
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
END as anteil FROM protection.kberaeumte_gebiete_2015 as a,organisation.beteiligen_polygon as b WHERE st_intersects(st_transform(a.geom,25833),'$the_geom') AND b.gid = $gid";

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
				<td width=100 ><b>&isin; in m&sup2;</td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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
				<td width=100 ><b>&isin; in m&sup2;</td>
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

