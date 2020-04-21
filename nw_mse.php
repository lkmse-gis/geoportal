<?php
// Bearbeiter: Andreas Thurm/ Uwe Popp
// Datum: 2018-04-26
// Umstellung Menue fehlt noch!
// Fehler Ebene 3 keine Anzeige der Aktuellen Fläche!

include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen
$titel="Naturwald";
$kuerzel="nw";

$v_auswahl="Waldgebiet";
$v_breite="700";
$v_hoehe="490";

// holt sich selber!!
$datei="nw_mse.php";

// Legenden - Layer - msp.map - 2 spaltig - Standard|Themen 
//$breite1="90";
//$breite2="180";

 $breite1="100";
 $breite2="140";

$beschriftung_karte="Naturwald_2018";
$layer="Naturwald_fl_2018";
$layer1="Naturwald_2018";
$layer2="Kreisgrenze_msp";
$layer3="aemter_msp_outline";
$layer4="msp_outline_gem";
$layer5="msp_outline_gemkg";
$layer6="Postleitzahlbereiche";
$layer7="Ortsteile_lt_rka";
$layer8="Naturwald";
$layer9="lk_line_geom_gemeinden";
$layer99="";

// Datenbank
$tabelle="sg_naturwald";
$schema="environment";
$layerid="32045";



$nat_wald_gebiet=$_POST["waldgebiet"];
$nat_wald_id=$_GET["$kuerzel"];

$log=write_log($db_link,$layerid);

// 1.Ebene
if (!isset($nat_wald_gebiet) AND !isset($nat_wald_id))
    { 
		$query="SELECT COUNT(DISTINCT name) AS anzahl FROM $schema.$tabelle";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count2 = $r[anzahl];
		
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
	
	?>
		<?php
		$lon=368607;
		$lat=5937811;
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		<?
           $geotopkarte= new karte;
           echo $geotopkarte->zeigeKarteBox($box_mse_gesamt,$v_breite,$v_hoehe,'orka','1','1','0','0','0',$beschriftung_karte,$layer8);
        ?>
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		
		</head>
		<body onload="load();init()">
		<div id="container">
			<div id="header">
				<?php
					head_portal();
				?>
			</div>
			<div id="wrapper">
				<div id="content">
					<table width="100%" border=0 cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td align="center" valign="top" height=30 colspan=2><br>
								<h3><? echo $titel;?>*</h3>
								Zu diesem Thema befinden sich<br>
								<b><? echo $count2; ?></b> Gebiete mit<br><b><? echo $count; ?></b> Teilfl&auml;chen in der Datenbank.
							</td>
							<td rowspan=8 width=30>
							<td border=0 valign=top rowspan=7 colspan=3>
								<br>
								<div style="margin:1px" id="map"></div>
							</td>
						</tr>
						<tr>
							<td align="center" height=50 colspan=2>
								<? echo $titel; ?> (Gebiet) ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>
								<form action="<? echo $datei;?>" method="post" name="waldgebiet">
								<select name="waldgebiet" onchange="document.waldgebiet.submit();" style="width: 200px;">
									<?php
										$query="SELECT DISTINCT name FROM $schema.$tabelle ORDER BY name";
										$result = $dbqueryp($connectp,$query);
										echo "<option>Bitte ausw&auml;hlen</option>\n";
										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[name]\">$r[name]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>
						<? include ("includes/meta_aktualitaet.php"); ?>
<!-- Tabelle für Legende -->
                    <td valign=bottom align=right>
                        <table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                            <B>Kartenlegende :</B>
                            <?php
                                 $legende_geo= new legende_geo;

//								 function zeigeLegende2th($breite1,$breite2,$layer,$layer2,$layer3,$layer4,$layer5,$layer6)
                                 echo $legende_geo->zeigeLegende2th($breite1,$breite2,$layer2,$layer99,$layer99,$layer,$layer99,$layer99)
                            ?>
                     </table> 
                    </td>
<!-- ENDE Tabelle für Legende --> 
						<? include ("includes/block_1_uk.php"); ?>
					</table>
				</div>
			</div>
			<?php 
				echo div_navigation(); 
				echo div_extra(); 
				echo div_footer(); 
			?>
		</div>
		</body>
		</html>
<?	} 

// 2.Ebene
if (isset($nat_wald_gebiet) AND !isset($nat_wald_id))
   { 	  
	  $query="SELECT gid, name, nr_num, abk_nr, area_ha FROM $schema.$tabelle WHERE name='$nat_wald_gebiet' ORDER BY name";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $nw[$z]=$r;
		   $z++;
		   $count=$z;	
		}  
	  
	  $query="SELECT a.oid,a.status,a.name as amtname,a.amt_schluessel,a.amts_sf,a.amtsvorsteher,a.lvb,a.lvb_tel,a.ansprechpartner,a.ap_email,a.ap_tel,a.gliederung,a.flaeche,a.einw_km,'' as nutzungsarten_link,a.geom_25833 FROM kataster.amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom, a.geom_25833) AND b.name='$nat_wald_gebiet' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $amt[$i]=$r;
		   
		   $i++;
		   $count2=$i;	
		}
	  
	  $query="SELECT box(st_buffer(st_union(geom),100)) as box,name FROM $schema.$tabelle WHERE name='$nat_wald_gebiet' GROUP BY name";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $boxstring = $r[box];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		
		
		<?php
		// function zeigeKarteBox($box,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$beschriftung,$layer)
            $geotopkarte= new karte;
            echo $geotopkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'orka','0','0','1','0','0',$beschriftung_karte,$layer8);
        ?> 
		
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		</head>
		<body onload="init();load();">
		<div id="container">
		  <div id="header">
			<?php
				head_portal();
			?>
		  </div>
			<div id="wrapper">
				<div id="content">
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>
								<table border=0>
									<tr>
										<td height="40" align="center" valign=top width=250 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Naturwald-Gebiet<br>"<? echo $r[name];?>"<? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="8"></td>
										<td border=0 valign=top align=left rowspan="7" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>( Amt:<?php 
												 echo " <a href=\"aemter_msp.php?amt=",$amt[1][1],"\">",$amt[1][0],"</a>&nbsp;";
													?>)
											</b>
										</td>
									</tr>
									<tr>
										<td align="center" height=30 colspan=2>
											<? echo $titel; ?> (Gebiet):
										</td>
									</tr>
									<tr>
										<td align="center" height=40 colspan=2>
											<form action="<? echo $datei;?>" method="post" name="waldgebiet">
											<select name="waldgebiet" onchange="document.waldgebiet.submit();" style="width: 200px;">
												<?php
													$query="SELECT DISTINCT name FROM $schema.$tabelle ORDER BY name";
													$result = $dbqueryp($connectp,$query);
													while($r = $fetcharrayp($result))
															{
																echo "<option";if ($nat_wald_gebiet == $r[name]) echo " selected"; echo " value=\"$r[name]\">$r[name]</option>\n";
															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
									
										<td align=center>
											<a href="<? echo $_SERVER["PHP_SELF"] ;?> "><? echo $font_farbe ;?>alle <? echo $titel;?> Gebiete<? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
									<tr>
			<!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                                            <B>Kartenlegende :</B>
                                            <?php
                                                    $legende_geo= new legende_geo;
	//											function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
												echo $legende_geo->zeigeLegende2('0','0','0','1','0','0',$layer,$layer1)
                                            ?>
											</table> 
										</td>
		<!-- ENDE Tabelle für Legende --> 
									</tr>
										<? include ("includes/block_1_uk.php"); ?>
								</table> <!-- Ende innere Tablle oberer Block -->
							</td>
						</tr>
					</table>	<!-- Ende äußere Tablle oberer Block -->
					<!-- Beginn grosse Tabelle unterer Block -->
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
							    <!-- Beginn Sachdatentabelle -->
								<table border="0" width="100%" valign=top>
									<? head_trefferliste($count,4,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->
									<tr>
													<td align=center height=30><a name="Liste"></a><b>Nummer:</b></td>
													<td align=center height=30><b>Name:</b></td>
													<td align=center height=30><b>Schl&uuml;ssel:</b></td>
													<td align=center height=30><b>Fl&auml;che in ha:</b></td>
												</tr>
												<?php for($v=0;$v<$z;$v++)
													{ 
														echo "<tr bgcolor=",get_farbe($v),">";
														echo "
														<td align='center' height='30'><a href=\"$datei?$kuerzel=",$nw[$v][gid],"\">",$nw[$v][nr_num],"</a></td>",
														"<td align='center'>",$nw[$v][name],"</td>",
														"<td align='center'>",$nw[$v][abk_nr],"</td>",
														"<td align='center'>",$nw[$v][area_ha],"</td>";
													}
												?>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							
						</tr>
					</table>
				</div>
			</div>
			<?php 
				echo div_navigation(); 
				echo div_extra(); 
				echo div_footer(); 
			?>
		</div>
		</body>
		</html>
<?  }

// 3.Ebene
if (isset($nat_wald_id))
   {   
	  $query="SELECT a.gen,a.name,a.amt_schluessel,a.amts_sf,a.amtsvorsteher,a.lvb,a.lvb_tel,a.ansprechpartner,a.ap_email,a.ap_tel,a.gliederung,a.flaeche,a.akt_bevoelkerung,a.einwohner,'' as nutzungsarten_link,a.geom_25833 FROM kataster.amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom,a.geom_25833) AND b.gid='$nat_wald_id' ORDER by b.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom,a.geom_25833) AND b.gid='$nat_wald_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count=$k;
		}
		
	  $query="SELECT gid,name FROM $schema.$tabelle WHERE gid='$nat_wald_id'";
	  $result = $dbqueryp($connectp,$query);
	  $z = $fetcharrayp($result);
	  $wald_gebiet_id = $z[gid];
	  $na_wald_gebiet = $z[name];
	  
	  $query="SELECT box(geom) as box, area(geom) as area, st_astext(st_centroid(geom)) as center, st_astext(st_centroid(geom)) as utm, st_astext(st_centroid(st_transform(geom, 31468))) as rd83, st_astext(st_centroid(st_transform(geom, 4326))) as geo, st_astext(st_centroid(st_transform(geom, 2398))) as koordinaten, st_perimeter(geom) as umfang, gid, nr_num, recht_q, abk_nr, name, schl_gis_t, area_ha, oer_vo, oer_br, erl_fe, erl_nwr, foerdpro, uebtr_nne, dbk, zert_fsc, frei_wid, sonst, vo_datum, br_datum, erlass_nam, dbk_z_guns, meta_mv, entwertung, entw_jahr, entw_verur, entw_quell, quelle, bemerkung, pruef_lfoa, foa_detail, foa, aktual_14 FROM $schema.$tabelle WHERE gid='$nat_wald_id'";
	   
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $result = $dbqueryp($connectp,$query);
      $r = $fetcharrayp($result);     
      $area=$r[area];
	  $s4283 = $r[koordinaten];
      $rd83 = $r[rd83];
      $utm = $r[utm];
      $geo = $r[geo];
	  $umfang = $r[umfang];
      $boxstring = $r[box];
      $klammern=array("(",")");
      $boxstring = str_replace($klammern,"",$boxstring);
      $koordinaten = explode(",",$boxstring);
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
      $rechts_range = $koordinaten[0]-$koordinaten[2];
	  
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
 
		<?php
		
		//	function zeigeKarteBox($box,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$beschriftung,$layer)
            $geotopkarte= new karte;
            echo $geotopkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'orka','0','0','0','1','0',$beschriftung_karte,$layer8);
        ?>  
		
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		
		<script type="text/javascript">
			function popup (url) {
				fenster = window.open(url, "Popupfenster", "width=700,height=1000,resizable=yes");
				fenster.focus();
				return false;
								}
		</script>
		
		</head>
		
		<body onload="init();load();">
		<div id="container">
		  <div id="header">
			<?php
				head_portal();
			?>
		  </div>
			<div id="wrapper">
				<div id="content">
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>
								<table border=0>
									<tr>
										<td height="40" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r[name]." ".$r[nr_num]; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=8></td>
										<td border="0" align=center rowspan="7" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Schl&uuml;ssel: <? echo $r[abk_nr]; ?></b><br>
										</td>
									</tr>
									<tr>
										<td align="center" height=30 colspan=2>
											<? echo $titel; ?> (Gebiet):
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="post" name="waldgebiet">
												<select name="waldgebiet" onchange="document.waldgebiet.submit();" style="width: 200px;">
												<?php
													$query="SELECT DISTINCT a.name FROM $schema.$tabelle as a ORDER BY a.name";
													$result = $dbqueryp($connectp,$query);
													while($e = $fetcharrayp($result))
															{
															echo "<option"; if ($na_wald_gebiet == $e[name]) echo " selected"; echo " value=\"$e[name]\">$e[name]</option>\n"; 
															}
												?>
												</select>
										</td>
									</tr>
									<tr>
										<td align=center height=25 colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?> Gebiete<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										<td align=center width=250 height=50 colspan=2>
										  <?php echo $font_farbe ; echo "zu allen Flächen: "; echo $font_farbe_end ; ?> <BR>
										  <input type="hidden" value="<?php echo $na_wald_gebiet; ?>">
										  <input type="submit" value="<?php echo $na_wald_gebiet; ?>">
										</form>
										</td>
									</tr>
									<tr>
									<!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
												<B>Kartenlegende :</B>
												<?php
                                                $legende_geo= new legende_geo;
	//											function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer1)
												echo $legende_geo->zeigeLegende2('0','0','0','0','1','0',$layer,$layer1)
                                            ?>
											</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
									</tr>
									<? include ("includes/block_1_uk.php"); ?> 
								</table>
							</td>
						</tr>
					</table>
					
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						    <tr>
							<td valign=top>
								<table border="0" valign=top>
									<tr height="35">
										<td colspan=2  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r[name] ;?><? echo $font_farbe_end ;?></td>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">zuständiges Forstamt:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[foa] ;?></b></td>
									</tr>
									</tr>
										<tr height="30">
										<td>Fl&auml;che in ha:</td>
										<td><b><? echo $r[area_ha] ;?></b></td>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Festsetzung Verordnung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[oer_vo] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Festsetzung Behandlungsrichtlinie::</td>
										<td><b><? echo $r[oer_br] ;?></b></td>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Entwertung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[entwertung] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Jahr der Entwertung:</td>
										<td><b><? echo $r[entw_jahr] ;?></b></td>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Verursacher der Entwertung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[entw_verur] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Fl&auml;che in ha:</td>
										<td><b><? echo $r[area_ha] ;?></b></td>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Bemerkung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[bemerkung] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Schl&uuml;ssel:</td>
										<td><b><? echo $r[abk_nr] ;?></b></td>
									</tr>
									
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Abstimmung mit Forstamt:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[pruef_lfoa] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Dokumentation der Aktualisierung:</td>
										<td><b><? echo $r[aktual_14] ;?></b></td>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Erläuterung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><a href="<? echo $r[meta_mv] ;?>" ><? echo 'Link ' ;?></a></b></td>
									</tr>
									<tr>
										<td valign=top><? echo $titel;?> schneidet folgende<br>&Auml;mter des Kreises:</td>
										<td><b>
											<?php 
												for($x=0;$x<$i;$x++)
												{ echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
											?></b>
										</td>
									</tr>
									<tr>
										<td  bgcolor=<? echo $element_farbe ?> width="30%" valign=top><? echo $titel;?> schneidet folgende<br>Gemeinden des Kreises:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
											<?php 
												for($y=0;$y<$k;$y++)
												{echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$y][0],"\">",$gemeinden[$y][1],"(".$gemeinden[$y][0].")</a><br>";}
											?></b>
										</td>
									</tr>
								</table>
							</td>
							<td width=30></td>
							
							<td valign=top align=center width="350">
								<? // include ("includes/geo_flaeche.php") ?>
								<? include ("includes/geo_flaeche_25833.php") ?>
							</td>
							
						</tr>
					</table>
					
				</div>
			</div>
			<?php 
				echo div_navigation(); 
				echo div_extra(); 
				echo div_footer(); 
			?>
		</div>
		</body>
		</html>
<?  }

