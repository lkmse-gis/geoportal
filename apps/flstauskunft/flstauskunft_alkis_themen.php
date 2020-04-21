<!DOCTYPE html>
<html>

<head>

	<title>Flust&uuml;cksauskunft</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="author" content="Olaf Bräunlich">
	<link rel="stylesheet" href="style.css" type="text/css" />
	<!-- ä = &auml; ö = &ouml; ü = &uuml;  Ä = &Auml; Ö = &Ouml;  Ü = &Uuml; ß = &szlig; ² = &sup2; -->
		<script language="javascript">
					function klappe (Id){
					  if (document.getElementById) {
						var mydiv = document.getElementById(Id);
						mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
					  }
					}
		</script>

</head>

<body text="#000000" bgcolor="#ffffff" link="#000000" alink="#000000" vlink="#000000" >

<br>
	<?php
	include("../../includes/connect_geobasis.php");
	$flstkennz=$_GET["flst"];
	$basis=$_GET["basis"];
	$zeichen=$GET["zeich"];

	if (isset($_COOKIE["flur"]))
		{
			$flstkennz = $_COOKIE["flur"];
			$basis = $_COOKIE["basis"];
			setcookie("flur",$flstkennz,time()-3600);
			setcookie("basis",$basis,time()-3600);
		}

	?>

<!--------Baudenkmale ------------------------------------------------------------------------------------------------->
	<?php
	$query="SELECT a.nr,a.lfdnr,a.obj,a.ort, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM fd_baudenkmal as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),b.wkb_geometry) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL;";

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

	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Baudenkmale (Derzeitig keine flächendeckende Erfassung)</a></td>
					</tr>
				</table>
				<div id=\"eintrag_1\" style=\"display: none\">
				<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Keine Baudenkmale gefunden.</td>
					</tr>
				</div>
				</table></p>
				";
		}
		else
		{
			echo "	
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='5'><a href=\"#anker\" onclick=\"klappe('eintrag_1_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'><b>Baudenkmale (Derzeitig keine flächendeckende Erfassung)</a></td></tr>
				</table>
				<div id=\"eintrag_1_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=100 id='tdinfo'><b>Nummer</td>
					<td width=100 id='tdinfo'><b>lfd.-Nr.</td>
					<td width=300 id='tdinfo'><b>Objekt</td>
					<td width=300 id='tdinfo'><b>Ort</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>
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
			echo "</table></div></p>";
		
	?>



<!--------Bodendenkmale blau------------------------------------------------------------------------------------------------->

	<?php
	$query="SELECT a.typ,a.gemarkung,a.fundplatz, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM fd_bod_blue as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),b.wkb_geometry) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL;";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='5'><b><a href=\"#anker\" onclick=\"klappe('eintrag_2')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;color:#808080;'>Bodendenkmale (blau)</a></td>
					</tr>
					</table>
					<div id=\"eintrag_2\" style=\"display: none\">
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=5>Keine Bodendenkmale(blau) gefunden.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='5'><a href=\"#anker\" onclick=\"klappe('eintrag_2_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'><b>Bodendenkmale (blau)</a></td></tr>
				</table>
				<div id=\"eintrag_2_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=100 id='tdinfo'><b>Typ</td>
					<td width=100 id='tdinfo'><b>Gemarkung</td>
					<td width=200 id='tdinfo'><b>Fundplatz</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>
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
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM fd_bod_red as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),b.wkb_geometry) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='5'><b><a href=\"#anker\" onclick=\"klappe('eintrag_3')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Bodendenkmale (rot)</a></td>
					</tr>
					</table>
					<div id=\"eintrag_3\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=5>Keine Bodendenkmale(rot) gefunden.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='5'><b><a href=\"#anker\" onclick=\"klappe('eintrag_3_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Bodendenkmale (rot)</a></td></tr>
				</table>
				<div id=\"eintrag_3_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=100 id='tdinfo'><b>Typ</td>
					<td width=300 id='tdinfo'><b>Gemarkung</td>
					<td width=300 id='tdinfo'><b>Fundplatz</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>
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
		THEN (round(st_area(INTERSECTION(a.the_geom,b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(a.the_geom,b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM construction.baulasten as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='7'><b><a href=\"#anker\" onclick=\"klappe('eintrag_4')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Baulastenkarte</a></td>
					</tr>
					</table>
					<div id=\"eintrag_4\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=7>Keine Eintr&auml;ge in der Baulastenkarte gefunden.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='7'><b><a href=\"#anker\" onclick=\"klappe('eintrag_4_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Baulastenkarte</a></td></tr>
				</table>
				<div id=\"eintrag_4_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=40 id='tdinfo'><b>Nummer</td>
					<td width=40 id='tdinfo'><b>Seite</td>
					<td width=60 id='tdinfo'><b>lfd. Nr.</td>
					<td width=150 id='tdinfo'><b>Art</td>
					<td width=250 id='tdinfo'><b>Bemerkung</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>
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
			
	 //if ($count== 0) echo "<tr><td colspan=5></td></tr>";
	?>



<!--------Baulastenkarte MS-Bau---------------------------------------------------------------------------------------------->

	<?php
	$query="SELECT a.spalte_5, a.spalte_6, a.spalte_7, a.spalte_8, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM construction.baulasten_msbau as a,alkis.ax_flurstueck as b WHERE st_intersects(a.the_geom,st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_5')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Baulasten (MS-Bau)</a></td>
					</tr>
					</table>
					<div id=\"eintrag_5\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Keine Eintr&auml;ge im Baulastenverzeichnis (MS-Bau) gefunden.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "	
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_5_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Baulasten (MS-Bau)</a></td></tr>
				</table>
				<div id=\"eintrag_5_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=25% id='tdinfo'><b>Spalte 5</td>
					<td width=25% id='tdinfo'><b>Spalte 6</td>
					<td width=25% id='tdinfo'><b>Spalte 7</td>
					<td width=25% id='tdinfo'><b>Spalte 8</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>
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
			echo "</table></div></p>";
	?>



<!--------B Pläne----------------------------------------------------------------------------------------------------->

	<?php
	$query="SELECT a.plan_nr,a.zusatz,a.bezeichnun,a.stand_verfahren,a.datum_stan, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM fd_vblp5 as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.wkb_geometry,-1)) AND a.in_entwicklung='nein' AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_6')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>B-Pl&auml;ne</a></td>
					</tr>
					</table>
					<div id=\"eintrag_6\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Das Flurst&uuml;ck liegt nicht in einem B-Plangebiet.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_6_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>B-Pl&auml;ne</a></td></tr>
				</table>
				<div id=\"eintrag_6_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=60 id='tdinfo'><b>Plan-Nr.</td>
					<td width=200 id='tdinfo'><b>Bezeichnung</td>
					<td width=100 id='tdinfo'><b>Verfahrensstand</td>
					<td width=100 id='tdinfo'><b>Datum</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>
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
			echo "</table></div></p>";
	?>

<!--------Störfallbetriebe--------------------------------------------------------------------------------------------------->

<?php
$query="SELECT DISTINCT jahrgang FROM planning.stoerfallanlagen ORDER BY jahrgang DESC LIMIT 1";
$result = $dbqueryp($connectp,$query);
$r = $fetcharrayp($result);
$jahrgang=$r[jahrgang];


$query="SELECT a.jahrgang, a.g_name, a.b_name, a.b_art, a.stoerfall_radius, a.stoerfall_status,
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round(st_area(INTERSECTION(st_buffer(st_transform(a.the_geom,25833),a.stoerfall_radius),b.wkb_geometry))::numeric,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as schnittflaeche, 
CASE 
	WHEN st_isvalid(a.the_geom) = TRUE
	THEN (round((st_area(INTERSECTION(st_buffer(st_transform(a.the_geom,25833),a.stoerfall_radius),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
	ELSE 'Geometrie fehlerhaft'::text
END as anteil FROM planning.stoerfallanlagen as a,alkis.ax_flurstueck as b WHERE st_intersects(st_buffer(st_transform(st_buffer(a.the_geom,a.stoerfall_radius),25833),a.stoerfall_radius),st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL AND a.jahrgang='$jahrgang'";

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
	
    $count++;
	}
	
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_14')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Störfallbetriebe</a></td>
					</tr>
					</table>
					<div id=\"eintrag_14\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Keine Einträge gefunden.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_14_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Störfallbetriebe</a></td></tr>
				</table>
				<div id=\"eintrag_14_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=60 id='tdinfo'><b>Betreiber</td>
					<td width=200 id='tdinfo'><b>Betriebsstätte</td>
					<td width=100 id='tdinfo'><b>Betriebsart</td>
					<td width=100 id='tdinfo'><b>Störfallanlage</td>
					<td width=100 id='tdinfo'><b>Wirkradius</td>
					<td width=80 id='tdinfo'><b>Status</td>
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
		THEN (round(st_area(INTERSECTION(st_transform(a.geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM protection.kbelastete_gebiete as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.geom,25833),st_buffer(b.wkb_geometry,-1))  AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
					<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_7')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Kampfmittel</a></td>
					</tr>
					</table>
					<div id=\"eintrag_7\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Das Flurst&uuml;ck liegt nicht in einem kampfmittelbelasteten Gebiet.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "	
				<table id='tableinfo' border='1'>
					<tr width=800 height='30'><td id='tkopf' colspan='6' ><b><a href=\"#anker\" onclick=\"klappe('eintrag_7_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Kampfmittel</a></td></tr>
					</table>
					<div id=\"eintrag_7_1\" style=\"display: none\">
					<table id='tableinfo' border='1'>
					<tr><td colspan=6 id='tdinfo'><b>Kampfmittelbelastung:</td></tr>
					<tr id='trinfo'>
						<td width=80 id='tdinfo'><b>Nr. KMK</td>
						<td width=200 id='tdinfo'><b>Name</td>
						<td width=200 id='tdinfo'><b>Art</td>
						<td width=200 id='tdinfo'><b>Belastung</td>
						<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
						<td width=80 id='tdinfo'><b>%</td>					
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
		THEN (round(st_area(INTERSECTION(st_transform(a.geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM protection.kberaeumte_gebiete as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.geom,25833),st_buffer(b.wkb_geometry,-1))  AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<div id=\"eintrag_7\" style=\"display: none\">	
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan=6 style='border:solid 1px #A9A9A9'><b><font color='#808080'>Kampfmittelber&auml;umung:</font></td>
					</tr>
					<tr>
						<td colspan=6 style='border:solid 1px #A9A9A9'><font color='#808080'>Falls das Flurst&uuml;ck kampfmittelbelastet ist, wurde es noch nicht ber&auml;umt.</font></td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "<div id=\"eintrag_7_1\" style=\"display: none\">		
					<tr><td colspan=6><b>Kampfmittelber&auml;umung:</td></tr>
					<tr id='trinfo'>
					<td width=80 id='tdinfo'><b>Ber&auml;umungsnr.</td>
					<td width=200 id='tdinfo'><b>Beginn</td>
					<td width=200 id='tdinfo'><b>Ende</td>
					<td width=200 id='tdinfo'><b>Art</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>					
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
			echo "</table></div></p>";
	?>
</b>


<!--------Naturschutzgebiete----------------------------------------------------------------------------------------------------->

	<?php
	$query="SELECT a.label,a.name,a.lage,a.area_ha, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM environment.sg_naturschutzgebiete as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_8')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Naturschutzgebiete</a></td>
					</tr>
					</table>
					<div id=\"eintrag_8\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Das Flurst&uuml;ck liegt nicht in einem Naturschutzgebiet.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "	
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_8_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Naturschutzgebiete</a></td></tr>
				</table>
				<div id=\"eintrag_8_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=60 id='tdinfo'><b>Nummer</td>
					<td width=200 id='tdinfo'><b>Bezeichnung</td>
					<td width=100 id='tdinfo'><b>Lage</td>
					<td width=100 id='tdinfo'><b>Fl&auml;che ha</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>					
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
			echo "</table></div></p>";
	?>



<!--------Nationalpark----------------------------------------------------------------------------------------------------->

	<?php
	$query="SELECT a.nr,a.name,a.area_ha,
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil  FROM environment.sg_nationalparke as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='5'><b><a href=\"#anker\" onclick=\"klappe('eintrag_9')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Nationalparke</a></td>
					</tr>
					</table>
					<div id=\"eintrag_9\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=5>Das Flurst&uuml;ck liegt nicht in einem Nationalpark.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "	
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='5'><b><a href=\"#anker\" onclick=\"klappe('eintrag_9_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Nationalparke</a></td></tr>
				</table>
				<div id=\"eintrag_9_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=60 id='tdinfo'><b>Nummer</td>
					<td width=200 id='tdinfo'><b>Bezeichnung</td>
					<td width=100 id='tdinfo'><b>Fl&auml;che ha</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>					
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
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil  FROM environment.sg_spa_fl as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_10')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Vogelschutzgebiete</a></td>
					</tr>
					</table>
					<div id=\"eintrag_10\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Das Flurst&uuml;ck liegt nicht in einem Vogelschutzgebiet.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "	
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_10_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Vogelschutzgebiete</a></td></tr>
				</table>
				<div id=\"eintrag_10_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=60 id='tdinfo'><b>EU Nummer</td>
					<td width=200 id='tdinfo'><b>Nummer</td>
					<td width=100 id='tdinfo'><b>Bezeichnung</td>
					<td width=100 id='tdinfo'><b>Fl&auml;che ha</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>				
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
			echo "</table></div></p>";
	?>



<!--------Landschaftsschutzgebiet--------------------------------------------------------------------------------------------------->

	<?php
	$query="SELECT a.label,a.name,a.kreis1, a.area_ha,
	CASE 
		WHEN st_isvalid(a.geom) = TRUE
		THEN (round(st_area(INTERSECTION(a.geom,b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.geom) = TRUE
		THEN (round((st_area(INTERSECTION(a.geom,b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM environment.sg_lsg_2016 as a,alkis.ax_flurstueck as b WHERE st_intersects(a.geom,st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

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
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_11')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Landschaftsschutzgebiete</a></td>
					</tr>
					</table>
					<div id=\"eintrag_11\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=6>Das Flurst&uuml;ck liegt nicht in einem Landschaftsschutzgebiet.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='6'><b><a href=\"#anker\" onclick=\"klappe('eintrag_12_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Landschaftsschutzgebiete</a></td></tr>
				</table>
				<div id=\"eintrag_12_1\" style=\"display: none\">	
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=60 id='tdinfo'><b>Nummer</td>
					<td width=200 id='tdinfo'><b>Bezeichnung</td>
					<td width=100 id='tdinfo'><b>Kreis</td>
					<td width=100 id='tdinfo'><b>Fl&auml;che ha</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>					
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
		THEN (round(st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))::numeric,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as schnittflaeche, 
	CASE 
		WHEN st_isvalid(a.the_geom) = TRUE
		THEN (round((st_area(INTERSECTION(st_transform(a.the_geom,25833),b.wkb_geometry))/st_area(b.wkb_geometry))::numeric*100,2))::text 
		ELSE 'Geometrie fehlerhaft'::text
	END as anteil FROM environment.sg_ffh_fl as a,alkis.ax_flurstueck as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.wkb_geometry,-1)) AND b.flurstueckskennzeichen='$flstkennz' AND b.endet IS NULL";

	$result = $dbqueryp($connectp,$query);
	$count=0;


	while($r = $fetcharrayp($result))
	  {
		$eunummer[$count] = $r[eu_nr];
		$name[$count] = $r[name];
		$area[$count] = $r[area_ha];
		
		$count++;
		}
		
	if ($count== 0) 
		{
			echo "<table id='tableinfo_keinerg' border='1'>
					<tr width=800 height='30'>
						<td id='tkopf_keinerg' colspan='5'><b><a href=\"#anker\" onclick=\"klappe('eintrag_13')\" title=\"aufklappen/zuklappen\" style='text-decoration: none; color:#808080;'>Fauna-Flora-Habitat Gebiete</a></td>
					</tr>
					</table>
					<div id=\"eintrag_13\" style=\"display: none\">	
					<table id='tableinfo_keinerg'>
					<tr>
						<td colspan=5>Das Flurst&uuml;ck liegt nicht in einem Fauna-Flora-Habitat Gebiet.</td>
					</tr>
					</div>
					</table></p>
					";
		}
		else
		{
			echo "
				<table id='tableinfo' border='1'>
				<tr width=800 height='30'><td id='tkopf' colspan='5'><b><a href=\"#anker\" onclick=\"klappe('eintrag_13_1')\" title=\"aufklappen/zuklappen\" style='text-decoration: none;'>Fauna-Flora-Habitat Gebiete</a></td></tr>
				</table>
				<div id=\"eintrag_13_1\" style=\"display: none\">
				<table id='tableinfo' border='1'>
				<tr id='trinfo'>
					<td width=60 id='tdinfo'><b>EU Nummer</td>
					<td width=200 id='tdinfo'><b>Bezeichnung</td>
					<td width=100 id='tdinfo'><b>Fl&auml;che ha</td>
					<td width=100 id='tdinfo'><b>&isin; in m&sup2;</td>
					<td width=80 id='tdinfo'><b>%</td>							
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