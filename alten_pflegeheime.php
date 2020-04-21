<?php
// Script wurde angepasst von: Uwe Popp
// Datum: 2017-08-22
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen

$beschriftung_karte="Einrichtungen zur Altenpflege";
$titel="Einrichtungen zur Altenpflege";
$titel2="Alten Betreuung/ Pflegeheim";
$v_auswahl="Gemeinde, Ort oder Ortsteil";
$v_breite="700";
$v_hoehe="490";

// Legenden - Layer - msp.map - 2 spaltig - Standard|Themen
$breite1="180";
$breite2="180";
$layer="alten_pflegeheime";
$layer1="";
$layer2="Kreisgrenze_msp";
$layer3="aemter_msp_outline";
$layer4="msp_outline_gem";
$layer5="msp_outline_gemkg";
$layer6="Postleitzahlbereiche";
$layer7="Ortsteile_lt_rka";
$layer99="";

// Datenbank
$schema="geoportal";
$tabelle="geoportal_altenpflegeheime";

$layerid=110740;
//Block 2
$orts_gid=$_GET["orts_gid"];
$gemeinde_id=$_GET["orts_gid"];

//Block 3
$altpfl_gid=$_GET["altpfl_gid"];
$themen_id=$_GET["altpfl_gid"];


$log=write_log($db_link,$layerid);

// Ebene 1
if ($orts_gid < 1 AND $altpfl_gid < 1)
	{ 
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle WHERE typ != 'Gemeinde'";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
				
		$lon=4567406;
		$lat=5938983; 
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
//		   function zeigeKarteBox2($box,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$plz,$orts_teile,$beschriftung,$layer)
		   echo $geotopkarte->zeigeKarteBox2($box_mse_gesamt,$v_breite,$v_hoehe,'orka','1','0','0','0','0','0','0',$beschriftung_karte,$layer);
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
					<? //include ("includes/uberschr_map.php"); ?>
					<?php
						echo "
						<tr>
							<td width=\"30%\" align=\"center\" valign=\"top\" height=30 colspan=2><br>
								<h3>$titel</h3>
									(  $count Einrichtungen)<br><br>
							</td>
							<td rowspan=8 width=\"5%\">
							<td width=\"75%\" border=0 valign=top rowspan=7 colspan=3>
								<br>
								<div style=\"margin:1px\" id=\"map\"></div>
							</td>
						</tr>";
					?>
					<tr>
						<td align="center" height=30 colspan=2>
							<? echo $v_auswahl ;?> ausw&auml;hlen :<br><br><small>(Es werden nur die Gemeinden/Orte/Ortsteile angeboten in denen sich <? echo $titel ;?> befinden)
						</td>
					</tr>
					
					<tr>
										<td align="center" height=60 colspan=2> 
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gid_ortsl">
								<select name="orts_gid" onchange="document.gid_ortsl.submit();" style="width: 200px;">
									<option>Bitte auswählen</option>	
									 <?php
										$query="SELECT DISTINCT a.ortsteil as ortslage,a.gem_name,a.typ,a.gid FROM  management.ot_lt_rka as a,$schema.$tabelle as b WHERE st_intersects(b.wkb_geometry,a.the_geom) ORDER BY a.gem_name,a.typ,a.ortsteil";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												if ($r[typ] == 'Gemeinde') echo "class=bld ";
												echo" value=\"$r[gid]\"";
												if ($r[gid] == $orts_gid) echo "selected";
												echo ">$r[ortslage]</option>\n";
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
//								 function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer99)
								 echo $legende_geo->zeigeLegende2('1','1','0','0','0','0',$layer,$layer99)
							?>
					 </table> 
					</td>
<!-- ENDE Tabelle für Legende --> 
					<? include ("includes/block_1_uk.php");?>
					
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
		
<? }

// --- Ebene 2 --- 

if ($orts_gid > 0 AND $altpfl_gid < 1)
	{
	
$query="SELECT gid_heim, gid_ortsl, heimname, strasse_namen, hausnummer, hausnummer_zusatz, postleitzahl, ort, kontaktperson, telefon, fax,  email, homepage, paragraphen, fertigstellung_bau, bezogen_bau, the_geom_heim, adressschluessel, tagespflege, vollstationaer, betreutes_wohnen, kurzzeitpflege, heimaufsicht, traeger_id, platzanzahl, kreisschluessel, kreis_name, amt_name, amt_schluessel, gem_schl, gemeinde_name, kvwmap_anschrift, geoportal_anschrift, typ, the_geom, wkb_geometry FROM $schema.$tabelle WHERE $orts_gid=gid_ortsl ";

// echo $query;
	
		$result = $dbqueryp($connectp,$query);
		$z=0;
		
		while($r = $fetcharrayp($result))
			{
			$alt_pflegeheime_jahr[$z]=$r;
			$z++;
			$count=$z;
			}
//  echo var_dump($r);

	  $query="SELECT ortsteil,box(the_geom) as etrsbox, st_astext(st_centroid(the_geom)) as etrscenter, box(the_geom) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, gemeinde_name as name FROM $schema.$tabelle WHERE $orts_gid=gid_ortsl";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $ortslage = $r[ortsteil];
	  
	  $boxstring = $r[etrsbox];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	 
		$lon=$rechts;
		$lat=$hoch;
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
//		   function zeigeKarteBox2($boxstring,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$plz,$orts_teile,$beschriftung,$layer)
		   echo $geotopkarte->zeigeKarteBox2($boxstring,$v_breite,$v_hoehe,'orka','1','0','0','0','0','0','0',$beschriftung_karte,$layer);
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
										<td height="40" align="center" valign=top width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel ;?> in <br> <h3><? echo $ortslage ?><? echo $font_farbe_end ;?></h3><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
									 <td align="center" height=30 colspan=2>
									 <? echo $v_auswahl ;?> ausw&auml;hlen :<br><br><small>(Es werden nur die Gemeinden/Orte/Ortsteile angeboten in denen sich <? echo $titel ;?> befinden)
									 </td>
									</tr>
									<tr>
										<td align="center" height=60 colspan=2> 
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gid_ortsl">
								<select name="orts_gid" onchange="document.gid_ortsl.submit();" style="width: 200px;">
									<option>Bitte auswählen</option>	
									 <?php
										$query="SELECT DISTINCT a.ortsteil as ortslage,a.gem_name,a.typ,a.gid FROM  management.ot_lt_rka as a,$schema.$tabelle as b WHERE st_intersects(b.wkb_geometry,a.the_geom) ORDER BY a.gem_name,a.typ,a.ortsteil";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												if ($r[typ] == 'Gemeinde') echo "class=bld ";
												echo" value=\"$r[gid]\"";
												if ($r[gid] == $orts_gid) echo "selected";
												echo ">$r[ortslage]</option>\n";
											}
									?>
								</select>
							</form>
						</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										<td align=center>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>alle <? echo $titel ;?><? echo $font_farbe_end ;?></a>
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
	//								 function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer99)
									echo $legende_geo->zeigeLegende2('1','0','0','0','0','1',$layer,$layer99)
								?>
							</table> 
						</td>
						<!-- ENDE Tabelle für Legende --> 
							</tr>								
							<? include ("includes/block_2_uk_gem.php"); ?>	
							</table> <!-- Ende innere Tablle oberer Block -->
					</td>
					</tr>
					</table>	<!-- Ende äußere Tablle oberer Block -->
					
					<!-- Beginn grosse Tabelle unterer Block -->
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
								<!-- Beginn Sachdatentabelle -->
								<table border=0 width="100%" valign=top>
									<? head_trefferliste($count,6,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->
									<tr> 
										<td align=center height=30 ><a name="Liste"></a><b>Bezeichnung:</b></td>
										<td align=center height=30><b>Kontaktperson:</b></td>
										<td align=center height=30><b>Anschrift:</b></td>
										<td align=center height=30><b>Telefon:</b></td>
										<td align=center height=30><b>Fax:</b></td>
										<td align=center height=30><b>E-Mail:</b></td>
									</tr>
								<?php for($v=0;$v<$z;$v++)
								{
											$anschrift = $alt_pflegeheime_jahr[$v][geoportal_anschrift];
											$anschrift1 = explode(";",$anschrift);
											$anschrift2 = $anschrift1[0];
											$anschrift3 = $anschrift1[1];
											
								echo "<tr bgcolor=",get_farbe($v),">";
								echo "
									<td align='center' height='30'><a href=",$scriptname,"?altpfl_gid=",$alt_pflegeheime_jahr[$v][gid_heim],"&orts_gid=",$orts_gid,">",$alt_pflegeheime_jahr[$v][heimname],"</a></td>",
									"<td align='center'>",$alt_pflegeheime_jahr[$v][kontaktperson],"</td>",
									"<td align='center'>",$anschrift2," <BR> ",$anschrift3,"</td>",
									"<td align='center'>",$alt_pflegeheime_jahr[$v][telefon],"</td>",
									"<td align='center'>",$alt_pflegeheime_jahr[$v][fax],"</td>",
									"<td align='center'>",$alt_pflegeheime_jahr[$v][email],"</td></tr>";
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
			  //  echo div_footer(); 
			?>
		</div>
		</body>
		</html>
<?  }

// Ebene 3 Adressschlüssel gesucht! Luftbild / Bild fehlt!
if ($altpfl_gid > 0)
   { 
// echo $orts_gid; echo '|'; echo $altpfl_gid;
$query="SELECT gid_heim, gid_ortsl, heimname, strasse_namen, hausnummer, dokument_bvs, hausnummer_zusatz, postleitzahl, ort, kontaktperson, telefon, fax,  email, homepage, paragraphen, fertigstellung_bau, bezogen_bau, the_geom_heim, adressschluessel, tagespflege, vollstationaer, betreutes_wohnen, kurzzeitpflege, haeuslich, geist_behind, psych_krank, sucht, koerperl_behind, phase_f, heimaufsicht, traeger_id, platzanzahl, kreisschluessel, kreis_name, amt_name, amt_schluessel, gem_schl, gemeinde_name, kvwmap_anschrift, typ, geoportal_anschrift,box(st_transform(wkb_geometry,25833)) as box, area(wkb_geometry) as area, st_astext(st_centroid(st_transform(wkb_geometry,4326))) as geo, st_astext(st_centroid(wkb_geometry)) as center, st_astext(st_centroid(wkb_geometry)) as utm, st_perimeter(wkb_geometry) as umfang, st_astext(st_centroid(st_transform(wkb_geometry, 31468))) as rd83, st_astext( st_centroid(st_transform(wkb_geometry,2398))) as koordinaten4283, the_geom, wkb_geometry FROM $schema.$tabelle WHERE gid_heim=$altpfl_gid AND gid_ortsl=$orts_gid";

	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);

	  $area=$r[area];
	  $s4283 = $r[koordinaten4283];
	  $utm = $r[utm];
	  $geo = $r[geo];
	  $rd83 = $r[rd83];
	  $umfang = $r[umfang];
	  $boxstring = $r[box];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  
	  $gemeinde_name = $r[gemeinde_name];
	  $amt_name = $r[amt_name];
	  $heimname = $r[heimname];
		$kreis_name = $r[kreis_name];
		$kontaktperson = $r[kontaktperson];
		$ort = $r[ort];
		$amt_name = $r[amt_name];
		
		$anschrift = $r[geoportal_anschrift];
		$anschrift1 = explode(";",$anschrift);
		$anschrift_strasse = $anschrift1[0];
		$anschrift_ort = $anschrift1[1];
		$anschrift_ortsteil = $anschrift[2];

		$geo_anschrift = $r[geoportal_anschrift];
		$telefon = $r[telefon];
		$fax = $r[fax];
		$email = $r[email];
		$homepage = $r[homepage];
		$ortsteil = $r[ortsteil];
		$typ = $r[typ];
		$tagespflege = $r[tagespflege];
		$kurzzeitpflege = $r[kurzzeitpflege];
		$vollstationaer = $r[vollstationaer];
		$betreutes_wohnen = $r[betreutes_wohnen];
		$haeuslich = $r[haeuslich];
		$geist_behind = $r[geist_behind];
		$psych_krank = $r[psych_krank];
		$sucht = $r[sucht]; 
		$phase_f = $r[phase_f]; 
		$koerperl_behind = $r[koerperl_behind];
		$platzanzahl = $r[platzanzahl];
			
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
			$geotopkarte= new karte;
			echo $geotopkarte->zeigeKarteBox2($boxstring,$v_breite,$v_hoehe,'dop','0','0','0','0','0','0','0',$beschriftung_karte,$layer);
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
								<table border="0">
									<tr>
									   <td height="20" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe ; ?>> 
											<? echo $font_farbe ;?> <? echo $beschriftung_karte ;?><br> <? echo $r[heimname] ;?><? echo $font_farbe_end ;?></td>
										<td width=5 rowspan="9"></td>
										<td border=0 valign=center align=right rowspan=7 colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									

									<tr>
										<td align="center" height="50" colspan="2"><B><? foreach ($anschrift1 as $index => $anschrift_zeile)
												   {
													 echo $anschrift_zeile,'<br>';
												   }
											  ?></B></td>
									</tr>
									
									<tr bgcolor=<? echo $header_farbe; ?>>	
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<a href="<? echo $scriptname;?>?orts_gid=<? echo $orts_gid ;?>">zu den <? echo $titel ;?> <BR> in: <? echo $ort ;?><? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									
									<tr>
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<a href="<? echo $_SERVER["PHP_SELF"] ;?> " title="zurück">gesamten Landkreis anzeigen
											<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr>
									 <td align="center" height=30 colspan=2>
									 <? echo $v_auswahl ;?> ausw&auml;hlen :<br><br><small>(Es werden nur die Gemeinden/Orte/Ortsteile angeboten in denen sich <? echo $titel ;?> befinden)
									 </td>
									</tr>
									<tr>
										<td align="center" height=60 colspan=2> 
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gid_ortsl">
								<select name="orts_gid" onchange="document.gid_ortsl.submit();" style="width: 200px;">
									<option>Bitte auswählen</option>	
									<?php
										$query="SELECT DISTINCT a.ortsteil as ortslage,a.gem_name,a.typ,a.gid FROM  management.ot_lt_rka as a,$schema.$tabelle as b WHERE st_intersects(b.wkb_geometry,a.the_geom) ORDER BY a.gem_name,a.typ,a.ortsteil";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												if ($r[typ] == 'Gemeinde') echo "class=bld ";
												echo" value=\"$r[gid]\"";
												if ($r[gid] == $orts_gid) echo "selected";
												echo ">$r[ortslage]</option>\n";
											}
									?>
								</select>
							</form>
						</td>
									</tr>
									<tr>
									<!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
											<BR><B>Kartenlegende :</B>
											<?php
												$legende_geo= new legende_geo;
//											function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
												echo $legende_geo->zeigeLegende2('0','1','0','1','0','0',$layer,$layer99)
											?>
											</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
									</tr>
									<? include ("includes/block_3_1_uk.php"); ?>
								</table>
							</td>
						</tr>
					</table>
					<?$z = 0 ;?>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td border="0" valign=top>
								<table width="100%" border="0" valign="top">
									<tr height="35">
										<td colspan="2 align="center" height=30 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?><? echo $titel2 ;?> - <? echo $heimname ;?> - <? echo $font_farbe_end ;?>
										</td>
									</tr>
									
									<? if ($kontaktperson <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspKontaktperson: </th>
										<td>&nbsp <? echo $kontaktperson ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($anschrift_zeile <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspAnschrift: </th>
										<td>&nbsp<? foreach ($anschrift1 as $index => $anschrift_zeile)
												{
													echo $anschrift_zeile,'<br>';
												}
										   ?>
										</td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($telefon <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspTelefon: </th>
										<td>&nbsp<? echo $telefon ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($fax <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspFax: </th>
										<td>&nbsp<? echo $fax ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($email <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspE-Mail: </th>
										<td>&nbsp<a href="mailto:<? echo $email ;?> "> <? echo $email;?></a></td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($homepage <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspHome page:</th>
										<td><a href="<? echo $homepage ;?>" target=blank><? echo $homepage ;?></a></td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($haeuslich <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspTagespflege:</th>
										<td>&nbsp<? echo $tagespflege ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($haeuslich <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspKurzzeitpflege:</th>
										<td>&nbsp<? echo $kurzzeitpflege ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($haeuslich <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspVollstationär:</th>
										<td>&nbsp<? echo $vollstationaer ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($betreutes_wohnen <> '') { ?>
									<tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspBetreutes Wohnen:</th>
										<td>&nbsp<? echo $betreutes_wohnen ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($haeuslich <> '') { ?>
									 <tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspHäusliche Krankenpflege:</th>
										<td>&nbsp<? echo $haeuslich ;?> </td>
									</tr>
									<?$z = $z+1; };?>
									
									<? if ($platzanzahl <> '') { ?>
									 <tr bgcolor=<? echo get_farbe($z) ;?>>
										<th height=20>&nbspPlatzanzahl:</th>
										<td>&nbsp<? echo $platzanzahl ;?> </td>
										</tr>
									<?$z = $z+1; };?>
									
								</table>
								
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr width="50%" height="20">
										<td colspan="2 align="center" height=20 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Spezialisierung <? echo $font_farbe_end ;?>
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<th height=20>&nbspauf Phase F:</th>
										<td>&nbsp<? echo $phase_f ;?> </td>
									</tr>
									<tr>
										<th height=20>&nbspauf Suchterkrankung :</th>
										<td>&nbsp<? echo $sucht ;?> </td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<th height=20>&nbspauf geistige Behinderung:</th>
										<td>&nbsp<? echo $geist_behind ;?> </td>
									</tr>
									<tr>
										<th height=20>&nbspauf körperliche Behinderung:</th>
										<td>&nbsp<? echo $koerperl_behind ;?> </td>
									</tr>

									<tr bgcolor=<? echo $element_farbe ;?>>
										<th height=20>&nbspauf psychische Erankung:</th>
										<td>&nbsp<? echo $psych_krank ;?> </td>
									</tr>

									
								</table>
								<td valign=top align=center width="350">
									<? include ("includes/geo_point2.php") ?>
								</td>
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
<? }
 ?>
