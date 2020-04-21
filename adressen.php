<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");

//globale Varibalen
$layername_mapfile="Adress_Geometrie";
$titel="Adressen";
$titel_legende="Adresse";
$scriptname="adressen.php";
$tabelle="adresstabelle";
$schema="address_registry";
$get_themenname="adresse";
$layerid="170010";
$leg_bild="hk.png";
$gemeinde_id=$_GET["gemeinde"];
$themen_id=$_GET["$get_themenname"];

$str_schl=$_GET["strasse"];
$haus_nr=$_GET["hausnummer"];
$ortslage_id=$_GET["ortslage"];

$log=write_i_log($db_link,$layerid);

if ($themen_id < 1 AND $gemeinde_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle WHERE alkis_konform ='Ja'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r['anzahl'];
	
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
		<? include ("includes/block_1_css_map.php"); ?>			
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_1_adressen.php"); ?>
		</script>
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
							<? include ("includes/count_map.php"); ?>
						<tr>
							<td align="center" height=50 colspan=2>
							<form action="./apps/strassen/liste_strassen.php" method="GET">
							  <input type="hidden" name="modus" value="start">
							  <input type="submit" value="zur Straßenliste">
							</form>
							<br>
							<br>
								Gemeinde ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
								<input type=hidden name=strasse value="x">
								<input type=hidden name=hausnummer value="x">
								<select name="gemeinde" onchange="document.<? echo $get_themenname;?>.submit();">
									<option>Bitte auswählen</option>
									<?php
										//$query="SELECT DISTINCT a.gem_schl, a.gemeinde_name FROM $schema.$tabelle as a ORDER BY gemeinde_name";
										$query="SELECT schluesselgesamt,bezeichnung FROM alkis.ax_gemeinde WHERE endet IS NULL ORDER BY bezeichnung";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[schluesselgesamt]\">$r[bezeichnung]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
						<? include ("includes/meta_i_aktualitaet.php"); ?>
						<? include ("includes/block_1_adressen_legende.php"); ?>
						<? include ("includes/block_1_adressen_uk.php"); ?>						
					</table>
				</div>
			</div>
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
				<? include ("includes/news.php"); ?>
			</div>
			<div id="footer">			
		  </div>
		</div>
		</body>
		</html>
<?	} 


if ($gemeinde_id > 0 AND $str_schl =='x' AND $haus_nr =='x')
   { 	  
	  $query="SELECT distinct a.ortsteil, a.ortsteil_typ FROM $schema.$tabelle as a WHERE a.gem_schl='$gemeinde_id' ORDER BY a.ortsteil";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $ortsteile[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(st_transform(a.the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(a.the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemeinde as name FROM gemeinden as a WHERE a.gem_schl='$gemeinde_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r['name'];
	  $zentrum = $r['etrscenter'];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rcenter = $zentrum4[0];
	  $hcenter = $zentrum4[1];
	  $boxstring = $r['etrsbox'];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $rechts = $koordinaten[2]+($rechts_range/2);
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	  $hoch = $koordinaten[3]+($hoch_range/2);
	  $range = $hoch_range;
	  if ($rechts_range > $hoch_range) $range=$rechts_range;
    

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
		<? include ("includes/bilder_popup.php"); ?>
		<? include ("includes/block_2_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />		
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_2_adressen.php"); ?>
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 1px;}
		</style>
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
										<td height="40" align="center" valign=center width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Orts-/Stadtteile in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="7" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>(Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>)</b>
										</td>
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="gemeinde">
											<input type=hidden name=strasse value="x">
											<input type=hidden name=hausnummer value="x">
												Gemeinde (<? echo $gemeinde_id; ?>):<br>
												<select name="gemeinde" onchange="document.gemeinde.submit();">
													<?php
														$query="SELECT DISTINCT a.gem_schl, a.gemeinde_name FROM $schema.$tabelle as a ORDER BY a.gemeinde_name";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
															{
																echo "<option";if ($gemeinde_id == $r['gem_schl']) echo " selected"; echo ' value=',$r["gem_schl"],'>',$r["gemeinde_name"],'</option>\n';
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="strasse">
											<input type=hidden name=gemeinde value=<? echo $gemeinde_id; ?>>
											<input type=hidden name=hausnummer value="x">
												Straße:&nbsp;												
												<select name="strasse" onchange="document.strasse.submit();">
													<option>Bitte auswählen</option>
													<?php
														$query="SELECT DISTINCT a.strasse_schluessel, a.strasse_name FROM $schema.$tabelle as a where a.gem_schl = $gemeinde_id AND alkis_konform ='Ja' ORDER BY a.strasse_name";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
														   {
															   echo "<option value=\"$r[strasse_schluessel]\">$r[strasse_name]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>alle <? echo $titel ;?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
									<? include ("includes/block_2_adressen_legende.php"); ?>								
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
									<? head_trefferliste($count,2,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
													<td align=center height=30><a name="Liste"></a><b>Ortsteile:</b></td>
													<td align=center height=30><b>Ortsteil-Typ:</b></td>																								
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{ 
														echo "<tr bgcolor=",get_farbe($v),">
														<td align='center' height='30'>",$ortsteile[$v]['ortsteil'],"</td>",
														"<td align='center'>",$ortsteile[$v]['ortsteil_typ'],"</td></tr>";
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
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
				<? include ("includes/news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  }

if ($gemeinde_id > 0 AND $str_schl !='x' AND $haus_nr =='x')
   { 	  
	  $query="SELECT a.gid, a.gemeinde_name, a.gem_schl, a.strasse_name, a.strasse_schluessel, a.geoportal_anschrift, a.ortsteil, a.ortsteil_typ, a.hausnummer, a.adressschluessel FROM $schema.$tabelle as a where a.gem_schl = '$gemeinde_id' and a.strasse_schluessel = '$str_schl' AND alkis_konform ='Ja' ORDER BY a.ortsteil, a.hausnummer";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $adressen[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(a.wkb_geometry) as etrsbox, st_astext(st_centroid(a.wkb_geometry)) as etrscenter, a.gemeindename as name FROM kataster.lk_lb_flst_strassen as a WHERE substring(a.schluesselgesamt from 1 for 8) = '$gemeinde_id' and a.lage = '$str_schl'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r['name'];
	  $zentrum = $r['etrscenter'];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rcenter = $zentrum4[0];
	  $hcenter = $zentrum4[1];
	  $boxstring = $r['etrsbox'];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $rechts = $koordinaten[2]+($rechts_range/2);
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	  $hoch = $koordinaten[3]+($hoch_range/2);
	  $range = $hoch_range;
	  if ($rechts_range > $hoch_range) $range=$rechts_range;
    

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
		<? include ("includes/bilder_popup.php"); ?>
		<? include ("includes/block_2_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />		
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_3_adressen.php"); ?>
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 1px;}
		</style>
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
										<td height="40" align="center" valign=center width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel ;?> in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="9"></td>
										<td border=0 valign=top align=left rowspan="9" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>(Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>)</b>
										</td>
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="gemeinde">
											<input type=hidden name=hausnummer value="x">
											<input type=hidden name=strasse value="x">
												Gemeinde (<? echo $gemeinde_id; ?>):<br>
												<select name="gemeinde" onchange="document.gemeinde.submit();">
													<?php
														$query="SELECT DISTINCT a.gem_schl, a.gemeinde_name FROM $schema.$tabelle as a ORDER BY a.gemeinde_name";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
															{
																echo "<option";if ($gemeinde_id == $r['gem_schl']) echo " selected"; echo ' value=',$r["gem_schl"],'>',$r["gemeinde_name"],'</option>\n';
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="strasse">
											<input type=hidden name=gemeinde value=<? echo $gemeinde_id; ?>>
											<input type=hidden name=hausnummer value="x">
												Straße (<? echo $str_schl; ?>):<br>
												<select name="strasse" onchange="document.strasse.submit();">
													<?php
														$query="SELECT DISTINCT a.strasse_schluessel, a.strasse_name FROM $schema.$tabelle as a where a.gem_schl = $gemeinde_id AND alkis_konform ='Ja' ORDER BY a.strasse_name";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
														   {
															   echo "<option";if ($str_schl == $r['strasse_schluessel']) echo " selected"; echo " value=\"$r[strasse_schluessel]\">$r[strasse_name]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="hausnummer">
											<input type=hidden name=gemeinde value=<? echo $gemeinde_id; ?>>
											<input type=hidden name=strasse value=<? echo $str_schl; ?>>										
												Hausnummer:&nbsp;
												<select name="hausnummer" onchange="document.hausnummer.submit();">
													<option>Bitte auswählen</option>
													<?php
														$query="SELECT a.hausnummer FROM $schema.$tabelle as a where a.gem_schl = '$gemeinde_id' and a.strasse_schluessel = '$str_schl' AND alkis_konform ='Ja' ORDER BY a.hausnummer";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
														   {
															   echo "<option value=\"$r[hausnummer]\">$r[hausnummer]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr>
									<td align=center>
									  <?php if (isset($ortslage_id)) 
									    echo '<form action="./apps/strassen/liste_strassen.php" method="post">
										      <input type="hidden" name="ortslage" value=',$ortslage_id,'>
											  <input type="submit" value="Zurück zur Straßenliste">
											  </form>';
							          ?>
									</td></tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center>
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>alle <? echo $titel ;?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>
									<tr><td  height=10></td></tr>
									<? include ("includes/block_3_adressen_legende.php"); ?>								
									<? include ("includes/block_3_adressen_uk.php"); ?>	
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
									<? head_trefferliste($count,5,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
													<td align=center height=30><a name="Liste"></a><b>Adressschlüssel:</b></td>
													<td align=center height=30><b>Anschrift:</b></td>													
													<td align=center height=30><b>Ortsteil:</b></td>
													<td align=center height=30><b>Straßen:</b></td>
													<td align=center height=30><b>Hausnummer:</b></td>
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{
														$adresse=$adressen[$v]['geoportal_anschrift'];
														$adresse1 = explode(";",$adresse);
														$anschrift = $adresse1[0]."<br>".$adresse1[1]."<br>".$adresse1[2];
														echo "<tr bgcolor=",get_farbe($v),">
														<td align='center' height='30'><a href=\"$scriptname?gemeinde=",$adressen[$v]['gem_schl'],"&strasse=",$adressen[$v]['strasse_schluessel'],"&hausnummer=",$adressen[$v]['hausnummer'],"\">",$adressen[$v]['adressschluessel'],"</a></td>",
														"<td align='center'>",$anschrift,"</td>",
														"<td align='center'>",$adressen[$v]['ortsteil'],"</td>",
														"<td align='center'>",$adressen[$v]['strasse_name'],"</td>",
														"<td align='center'>",$adressen[$v]['hausnummer'],"</td></tr>";
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
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
				<? include ("includes/news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  }

 if ($gemeinde_id > 0 AND $str_schl !='x' AND $haus_nr !='x')
   {   
	  $adressschluessel = $gemeinde_id.$str_schl.$haus_nr;
	  
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid FROM gemeinden as a, $schema.$tabelle as b WHERE ST_WITHIN(st_transform(b.wkb_geometry,2398), a.the_geom) AND b.adressschluessel='$adressschluessel'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r['amt'];
	  $amt=$r['amt_id'];
	  $gem_id=$r['gemeindeid'];
	  $gemeindename=$r['gemeinde'];
	  
	  $query="SELECT astext(wkb_geometry) as utm, astext(st_transform(wkb_geometry,2398)) as gk4283,astext(st_transform(wkb_geometry, 4326)) as geo,astext(st_transform(wkb_geometry, 31468)) as rd83, gid, adressschluessel, geoportal_anschrift, kreis_name, kreisschluessel, gemeinde_name, gem_schl, ortsteil, ortsteil_typ, strasse_name, strasse_schluessel, hausnummer, postleitzahl, wkb_geometry FROM $schema.$tabelle WHERE adressschluessel='$adressschluessel'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $adresse=$r['geoportal_anschrift'];
	  $adresse1 = explode(";",$adresse);
	  $anschrift = $adresse1[0]."<br>".$adresse1[1]."<br>".$adresse1[2];
	  $kreis = $r['kreis_name']." (".$r['kreisschluessel'].")";
	 
	  $s4283 = $r['gk4283'];
	  $geo=$r['geo'];
	  $rd83=$r['rd83'];
	  $utm=$r['utm'];
	  $lon = get_utmcoordinates_lon($utm);
	  $lat=get_utmcoordinates_lat($utm);
	  
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
		<? include ("includes/bilder_popup.php"); ?>
		<? include ("includes/block_3_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_3_1_point.php"); ?>
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 2px;}
		</style> 
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
										<td height="40" align="center" valign=center width=270 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $anschrift; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="10"></td>
										<td border=0 valign=top align=left rowspan="9" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <? echo $amtname; ?></b>
										</td>
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="gemeinde">
											<input type=hidden name=hausnummer value="x">
											<input type=hidden name=strasse value="x">
												Gemeinde (<? echo $gemeinde_id; ?>):<br>
												<select name="gemeinde" onchange="document.gemeinde.submit();">
													<?php
														$query="SELECT DISTINCT a.gem_schl, a.gemeinde_name FROM $schema.$tabelle as a ORDER BY a.gemeinde_name";
														$result = $dbqueryp($connectp,$query);

														while($p = $fetcharrayp($result))
															{
																echo "<option";if ($gemeinde_id == $p['gem_schl']) echo " selected"; echo ' value=',$p["gem_schl"],'>',$p["gemeinde_name"],'</option>\n';
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="strasse">
											<input type=hidden name=gemeinde value=<? echo $gemeinde_id; ?>>
											<input type=hidden name=hausnummer value="x">
												Straße (<? echo $str_schl; ?>):<br>
												<select name="strasse" onchange="document.strasse.submit();">
													<?php
														$query="SELECT DISTINCT a.strasse_schluessel, a.strasse_name FROM $schema.$tabelle as a where a.gem_schl = $gemeinde_id AND alkis_konform ='Ja' ORDER BY a.strasse_name";
														$result = $dbqueryp($connectp,$query);

														while($s = $fetcharrayp($result))
														   {
															   echo "<option";if ($str_schl == $s['strasse_schluessel']) echo " selected"; echo " value=\"$s[strasse_schluessel]\">$s[strasse_name]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr>
										<td align="center">
											<form action="<? echo $scriptname;?>" method="get" name="hausnummer">
											<input type=hidden name=gemeinde value=<? echo $gemeinde_id; ?>>
											<input type=hidden name=strasse value=<? echo $str_schl; ?>>										
												Hausnummer (<? echo $haus_nr; ?>):<br>
												<select name="hausnummer" onchange="document.hausnummer.submit();">
													<?php
														$query="SELECT a.hausnummer FROM $schema.$tabelle as a where a.gem_schl = '$gemeinde_id' and a.strasse_schluessel = '$str_schl' AND alkis_konform ='Ja'ORDER BY a.hausnummer";
														$result = $dbqueryp($connectp,$query);

														while($t = $fetcharrayp($result))
														   {
															   echo "<option";if ($haus_nr == $t['hausnummer']) echo " selected"; echo " value=\"$t[hausnummer]\">$t[hausnummer]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr>
										<td align="center">Adressschlüssel: <? echo $adressschluessel ; ?></td>
									</tr>
									<tr>
										<td height=50></td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center colspan=2>
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>zu allen <? echo $titel;?><br><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
									<? include ("includes/block_4_adressen_legende.php"); ?>
									<? include ("includes/block_4_adressen_uk.php"); ?>	
                                 </table>
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>											
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?><font size="+1"><? echo $anschrift ;?><? echo $font_farbe_end ;?></td>													
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Adressschlüssel:</td>
											<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $adressschluessel ;?></b></td>												
											<td valign=center align=right rowspan=7 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>
										</tr>
										<tr>
											<td>Kreis:</td>
											<td><b><? echo $kreis ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Gemeinde:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r['gemeinde_name']." (".$r['gem_schl'].")" ;?></b></td>																									
										</tr>
										<tr>
											<td>Orts-/Stadteil:</td>
											<td><b><? echo $r['ortsteil']." (".$r['ortsteil_typ'].")" ; ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Straße:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r['strasse_name']." (".$r['strasse_schluessel'].")" ;?></b></td>																									
										</tr>
										<tr>
											<td>Postleitzahl:</td>
											<td><b><? echo $r['postleitzahl'] ;?></b></td>																									
										</tr>																		
									</table>
							</td>									
							<td valign=top align=center width="250">
							<? include("includes/geo_point_25833.php"); ?>	
							</td>
						</tr>
						</table>
						</td></tr>
					</table>
				</div>
			</div>
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
             <? include ("includes/news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  }

