<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="Angebote";
$titel2="Angebot";
$datei="psy_a_msp.php";
$tabelle="psy_angebote_2015";
$schema="health";
$kuerzel="psy_a";
$layerid="110610";
$gemeinde_id=$_GET["gemeinde"];
$katalog_id=$_GET["katalog"];
$psy_a_id=$_GET["$kuerzel"];
$themen_id=$psy_a_id;

$log=write_log($db_link,$layerid);

if ($themen_id < 1 AND $gemeinde_id < 1 AND $katalog_id < 1)
    { 
	
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
		<? include ("includes/block_1_css_map.php"); ?>			
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_1.php"); ?>
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
						<tr>							
							<td width="30%" align="center" valign="top" height=30 colspan=2><br>
								<h3><? echo $titel;?></h3>
									Zu diesem Thema befinden sich<br>
									<b><? echo $count;?></b> Datens&auml;tze in der Datenbank.
							</td>
							<td rowspan=10 width="5%">
							<td width="75%" border=0 valign=top rowspan=9 colspan=3>
								<br>
								<div style="margin:1px" id="map"></div>
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>
								Gemeinde ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="gemeinde">
								<select name="gemeinde" style="width: 200px" onchange="document.gemeinde.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.wkb_geometry,2398), b.the_geom) ORDER BY gemeinde";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[gem_schl]\">$r[gemeinde]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>
								oder aus Angebotskategorie:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="katalog">
								<select name="katalog" style="width: 200px" onchange="document.katalog.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT psy_katalog_kt_nr, psy_katalog_angebot FROM $schema.$tabelle as a WHERE 1=1 ORDER BY psy_katalog_angebot";
										$result = $dbqueryp($connectp,$query);

										while($t = $fetcharrayp($result))
											{
												echo "<option value=\"$t[psy_katalog_kt_nr]\">$t[psy_katalog_angebot]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>
						<? include ("includes/meta_aktualitaet.php"); ?>
						<tr>
							<td valign=bottom align=right>
								<!-- Tabelle für Legende -->											
								<table border="1" rules="none" width=140 valign=bottom align=right>					
									<tr>
										<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
									</tr>
									<tr>
										<td width=100 align=right><small>vollstation&auml;re Angebote: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>vollstationaer.png" width=20></td>
										<td width=100 align=right><small>teilstation&auml;re Angebote: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>teilstationaer.png" width=20></td>
									</tr>
									<tr>
										<td width=100 align=right><small>ambulante Hilfen: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>ambulant.png" width=20></td>
										<td align=right><small>Kreisgrenze: </td>
										<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
									</tr>																						
								</table> <!-- Ende der Tabelle für die Legende -->
							</td>
						</tr>
						<? include ("includes/block_1_uk.php"); ?>						
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


if ($gemeinde_id > 0)
   { 	  
	  $query="SELECT a.psy_katalog_art, a.psy_katalog_angebot, a.psy_haeuser_haus_strasse, a.psy_haeuser_haus_hnr, a.oid, a.psy_haeuser_haus_plz, a.psy_haeuser_haus_ort, a.psy_angebote_a_angebot_name, a.psy_angebote_b_anrede, a.psy_angebote_b_ansprechpartner, a.psy_angebote_b_telefon FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(a.the_geom, b.the_geom) AND b.gem_schl='$gemeinde_id' ORDER BY a.psy_angebote_a_angebot_name";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $psy_a[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemeinde as name FROM gemeinden as a WHERE a.gem_schl='$gemeinde_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r[name];
	  $zentrum = $r[center];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rcenter = $zentrum4[0];
	  $hcenter = $zentrum4[1];
	  $boxstring = $r[box];
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
			<? include ("includes/block_2.php"); ?>
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
										<td height="40" align="center" valign=top width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Angebote in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>(Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>)</b>
										</td>
									</tr>
									<tr>
										<td align="center" height="40">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Stadt:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(a.the_geom, b.the_geom) ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
															{
																echo "<option";if ($gemeinde_id == $r[gem_schl]) echo " selected"; echo " value=\"$r[gem_schl]\">$r[gemeinde]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Angebote<? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
									<tr>
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->											
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>vollstation&auml;re Angebote: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht4.png" width=20></td>
													<td width=100 align=right><small>teilstation&auml;re Angebote: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht5.png" width=20></td>
												</tr>
												<tr>
													<td width=100 align=right><small>ambulante Hilfen: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht6.png" width=20></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
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
									<? head_trefferliste($count,5,$header_farbe);?><!-- Header für Trefferliste wird geladen -->											
									<tr>													
													<td align=center height=30><b>Angebot:</b></td>
													<td align=center height=30><b>Adresse:</b></td>
													<td align=center height=30><b>Kontakt:</b></td>
												    <td align=center height=30><b>Bezeichnung:</b></td>
													<td align=center height=30><b>Art:</b></td>													
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{ 
														echo "<tr bgcolor=",get_farbe($v),">";
														echo "
														<td height='30'><a href=\"$datei?psy_a=",$psy_a[$v][oid],"\">",$psy_a[$v][psy_angebote_a_angebot_name],"</a></td>",
														"<td align='center'>",$psy_a[$v][psy_haeuser_haus_strasse],"&nbsp;",$psy_a[$v][psy_haeuser_haus_hnr],"<br>",$psy_a[$v][psy_haeuser_haus_plz],"&nbsp;",$psy_a[$v][psy_haeuser_haus_ort],"</td>",
														"<td align='center'>",$psy_a[$v][psy_angebote_b_anrede],"&nbsp;",$psy_a[$v][psy_angebote_b_ansprechpartner],"<br>",$psy_a[$v][psy_angebote_b_telefon],"</td>",
														"<td align='center'>",$psy_a[$v][psy_katalog_angebot],"</td>",
														"<td align='center'>",$psy_a[$v][psy_katalog_art],"</td></tr>";
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
$lon=4580000;
$lat=5940000;
if ($katalog_id > 0)
   { 	  
	  $query="SELECT a.psy_katalog_art, a.psy_katalog_angebot, a.psy_angebote_c_katalog_nummer, a.psy_haeuser_haus_strasse, a.psy_haeuser_haus_hnr, a.oid, a.psy_haeuser_haus_plz, a.psy_haeuser_haus_ort, a.psy_angebote_a_angebot_name, a.psy_angebote_b_anrede, a.psy_angebote_b_ansprechpartner, a.psy_angebote_b_telefon FROM $schema.$tabelle as a WHERE a.psy_angebote_c_katalog_nummer='$katalog_id' ORDER BY a.psy_katalog_angebot";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $psy_a[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	$query="SELECT a.psy_katalog_art, a.psy_katalog_angebot, a.psy_angebote_c_katalog_nummer, a.psy_haeuser_haus_strasse, a.psy_haeuser_haus_hnr, a.oid, a.psy_haeuser_haus_plz, a.psy_haeuser_haus_ort, a.psy_angebote_a_angebot_name, a.psy_angebote_b_anrede, a.psy_angebote_b_ansprechpartner, a.psy_angebote_b_telefon FROM $schema.$tabelle as a WHERE a.psy_angebote_c_katalog_nummer='$katalog_id' ORDER BY a.psy_katalog_angebot";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $katalogname = $r[psy_katalog_angebot];
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
			<? include ("includes/block_psy_a.php"); ?>
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
										<td height="40" align="center" valign=top width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Angebote f&uuml;r <br> <? echo $katalogname ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="6"></td>
										<td border=0 valign=top align=left rowspan="5" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>									
									<tr>
										<td align="center" height="40">
											<form action="<? echo $datei;?>" method="get" name="katalog">
												Angebotskategorie:&nbsp;
												<select name="katalog" style="width: 200px" onchange="document.katalog.submit();">
													<?php
														$query="SELECT DISTINCT a.psy_angebote_c_katalog_nummer, a.psy_katalog_angebot FROM $schema.$tabelle as a WHERE 1=1 ORDER BY a.psy_katalog_angebot";
														$result = $dbqueryp($connectp,$query);

														while($t = $fetcharrayp($result))
															{
																echo "<option";if ($katalog_id == $t[psy_angebote_c_katalog_nummer]) echo " selected"; echo " value=\"$t[psy_angebote_c_katalog_nummer]\">$t[psy_katalog_angebot]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Angebote<? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
									<tr>
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->											
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>vollstation&auml;re Angebote: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht4.png" width=20></td>
													<td width=100 align=right><small>teilstation&auml;re Angebote: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht5.png" width=20></td>
												</tr>
												<tr>
													<td width=100 align=right><small>ambulante Hilfen: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht6.png" width=20></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
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
									<? head_trefferliste($count,5,$header_farbe);?><!-- Header für Trefferliste wird geladen -->											
									<tr>													
													<td align=center height=30><b>Angebot:</b></td>
													<td align=center height=30><b>Adresse:</b></td>
													<td align=center height=30><b>Kontakt:</b></td>
												    <td align=center height=30><b>Bezeichnung:</b></td>
													<td align=center height=30><b>Art:</b></td>													
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{ 
														echo "<tr bgcolor=",get_farbe($v),">";
														echo "
														<td height='30'><a href=\"$datei?psy_a=",$psy_a[$v][oid],"\">",$psy_a[$v][psy_angebote_a_angebot_name],"</a></td>",
														"<td align='center'>",$psy_a[$v][psy_haeuser_haus_strasse],"&nbsp;",$psy_a[$v][psy_haeuser_haus_hnr],"<br>",$psy_a[$v][psy_haeuser_haus_plz],"&nbsp;",$psy_a[$v][psy_haeuser_haus_ort],"</td>",
														"<td align='center'>",$psy_a[$v][psy_angebote_b_anrede],"&nbsp;",$psy_a[$v][psy_angebote_b_ansprechpartner],"<br>",$psy_a[$v][psy_angebote_b_telefon],"</td>",
														"<td align='center'>",$psy_a[$v][psy_katalog_angebot],"</td>",
														"<td align='center'>",$psy_a[$v][psy_katalog_art],"</td></tr>";
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

 if ($themen_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.oid FROM gemeinden as a, $schema.$tabelle as b WHERE ST_WITHIN(b.the_geom, a.the_geom) AND b.oid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[amt];
	  $amt=$r[amt_id];
	  $gem_id=$r[gemeindeid];
	  $gemeindename=$r[gemeinde];
	  
	  $query="SELECT astext(the_geom) as koordinaten, astext(st_transform(the_geom, 25833)) as utm,astext(st_transform(the_geom, 4326)) as geo,astext(st_transform(the_geom, 31468)) as rd83, oid,
psy_angebote_a_traeger_nr,
psy_traeger_a_name_organisation,
psy_traeger_a_strasse,
psy_traeger_a_haus_nr,
psy_traeger_a_ort,
psy_traeger_a_plz,
psy_traeger_a_block_j_n,
psy_traeger_b_anrede,
psy_traeger_b_titel,
psy_traeger_b_nachname_org,
psy_traeger_b_vorname_org,
psy_traeger_b_tel,
psy_traeger_b_mobil,
psy_traeger_b_fax,
psy_traeger_b_mail,
psy_traeger_b_internet,
psy_traeger_b_block_j_n,
psy_traeger_c_a_haus_nr,
psy_traeger_c_b_haus_nr,
psy_traeger_c_c_haus_nr,
psy_traeger_c_d_haus_nr,
psy_traeger_c_e_haus_nr,
psy_traeger_c_f_haus_nr,
psy_traeger_c_g_haus_nr,
psy_traeger_c_h_haus_nr,
psy_traeger_c_i_haus_nr,
psy_traeger_c_j_haus_nr,
psy_traeger_c_k_haus_nr,
psy_traeger_c_l_haus_nr,
psy_traeger_c_m_haus_nr,
psy_traeger_c_n_haus_nr,
psy_traeger_c_o_haus_nr,
psy_traeger_c_p_haus_nr,
psy_traeger_c_q_haus_nr,
psy_traeger_c_r_haus_nr,
psy_traeger_c_s_haus_nr,
psy_traeger_c_t_haus_nr,
psy_traeger_c_block_j_n,
psy_traeger_d_gpv_mitwirken,
psy_traeger_d_gpv_anrede,
psy_traeger_d_gpv_titel,
psy_traeger_d_gpv_vorname,
psy_traeger_d_gpv_nachname,
psy_traeger_d_gpv_tel,
psy_traeger_d_gpv_mobil,
psy_traeger_d_gpv_fax,
psy_traeger_d_gpv_mail,
psy_traeger_d_block_j_n,
psy_angebote_a_standort_nr,
psy_haeuser_haus_name,
psy_haeuser_haus_strasse,
psy_haeuser_haus_hnr,
psy_haeuser_haus_ort,
psy_haeuser_haus_plz,
psy_angebote_a_angebot_name,
psy_angebote_a_block_j_n,
psy_angebote_b_anrede,
psy_angebote_b_titel,
psy_angebote_b_ansprechpartner,
psy_angebote_b_telefon,
psy_angebote_b_mobil,
psy_angebote_b_fax,
psy_angebote_b_email,
psy_angebote_b_internet,
psy_angebote_b_block_j_n,
psy_angebote_c_angebot_nummer,
psy_angebote_c_katalog_nummer,
psy_katalog_angebot,
psy_katalog_art,
psy_angebote_c_leistungstyp_ksv,
psy_angebote_c_besondere_merkmale,
psy_angebote_c_block_j_n,
psy_angebote_d_gesamtfallzahl,
psy_angebote_d_gesamtfallzahl_j_n,
psy_angebote_d_neuzugaenge,
psy_angebote_d_neuzugaenge_j_n,
psy_angebote_d_abgaenge,
psy_angebote_d_abgaenge_j_n,
psy_angebote_d_belegungskapazitaet,
psy_angebote_d_belegungskapazitaet_j_n,
psy_angebote_d_durchschn_belegung,
psy_angebote_d_durchschn_j_n,
psy_angebote_e_alter_k_u_j,
psy_angebote_e_alter_junge_erw,
psy_angebote_e_alter_erw,
psy_angebote_e_alter_aeltere_erw,
psy_angebote_e_el_mit_k,
psy_angebote_e_sonstige,
psy_angebote_e_sonstige_text,
psy_angebote_e_diag_psychis_erkran_stoer_auffael,
psy_angebote_e_diag_suchterkra,
psy_angebote_e_diag_doppeldiag_sucht_u_psychi_erkrank,
psy_angebote_e_diag_geisti_behinde,
psy_angebote_e_diag_doppeldiag_geisti_behind_u_psychi_erkr,
psy_angebote_e_diag_doppeldiag_geist_behinde_u_sucht,
psy_angebote_e_diag_mit_koerperliche_behinderung,
psy_angebote_e_diag_demenz,
psy_angebote_e_block_j_n,
psy_angebote_dak_wk_17033,
psy_angebote_dak_wk_17034,
psy_angebote_dak_wk_17036,
psy_angebote_dak_wk_17039,
psy_angebote_dak_wk_17087,
psy_angebote_dak_wk_17089,
psy_angebote_dak_wk_17091,
psy_angebote_dak_wk_17094,
psy_angebote_dak_wk_17098,
psy_angebote_dak_wk_17099,
psy_angebote_dak_wk_17109,
psy_angebote_dak_wk_17111,
psy_angebote_dak_wk_17139,
psy_angebote_dak_wk_17153,
psy_angebote_dak_wk_17154,
psy_angebote_dak_wk_17159,
psy_angebote_dak_wk_17192,
psy_angebote_dak_wk_17194,
psy_angebote_dak_wk_17207,
psy_angebote_dak_wk_17209,
psy_angebote_dak_wk_17213,
psy_angebote_dak_wk_17214,
psy_angebote_dak_wk_17217,
psy_angebote_dak_wk_17219,
psy_angebote_dak_wk_17235,
psy_angebote_dak_wk_17237,
psy_angebote_dak_wk_17248,
psy_angebote_dak_wk_17252,
psy_angebote_dak_wk_17255,
psy_angebote_dak_wk_17258,
psy_angebote_dak_wk_17337,
psy_angebote_dak_wk_17348,
psy_angebote_dak_wk_17349,
psy_angebote_dak_wk_ohne_angabe,
psy_angebote_dak_wk_mv,
psy_angebote_dak_wk_bundesweit,
psy_angebote_dak_block_j_n,
psy_angebote_kf_gs_arbeitssuch_sgb_ii,
psy_angebote_kf_arbeitsfoerd_sgb_iii,
psy_angebote_kf_krankenver_sgb_v,
psy_angebote_kf_rentenver_sgb_vi,
psy_angebote_kf_unfallversi_sgb_vii,
psy_angebote_kf_kin_u_jugenhilfe_sgb_viii,
psy_angebote_kf_pflegeversi_sgb_xi,
psy_angebote_kf_sozialhilfe_sgb_xii,
psy_angebote_kf_eigenmi_klient,
psy_angebote_kf_eigenmit_anbie_einschlies_spen,
psy_angebote_kf_foerd_lk,
psy_angebote_kf_foerd_landesmit,
psy_angebote_kf_foerde_bundesmit,
psy_angebote_kf_sonsti_benne,
psy_angebote_kf_sonsti_benne_text,
psy_angebote_kf_block_j_n,
psy_angebote_f_kostensatz,
psy_angebote_f_pauschal,
psy_angebote_f_block_j_n,
psy_angebote_g_leistung_nach_persoe_budget,
psy_angebote_g_leistung_nach_persoe_budget_j_n,
psy_angebote_quali_af_vi,
psy_angebote_quali_f_vi,
psy_angebote_quali_a_vi,
psy_angebote_quali_af_vsq,
psy_angebote_quali_f_vsq,
psy_angebote_quali_a_vsq,
psy_angebote_quali_block_j_n,
psy_angebote_fw_angebote,
psy_angebote_fw_ressourcen,
psy_angebote_fw_bedarfe,
psy_angebote_fw_oeffentlichkeitsarbeit,
psy_angebote_quali_af_angaben,
psy_angebote_quali_f_angaben,
psy_angebote_quali_a_angaben,
psy_angebote_fw_block_j_n,
psy_angebote_dok_flyer FROM $schema.$tabelle WHERE oid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname=$r[psy_angebote_dok_flyer];
	  $koord = $r[koordinaten];
	  $koord2 = trim($koord,"POINT(");
	  $koord3 = trim($koord2,")");
	  $koord4 = explode(" ",$koord3);
	  $utm = $r[utm];
	  $geo=$r[geo];
	  $rd83=$r[rd83];
	  $utm2 = trim($utm,"POINT(");
	  $utm3 = trim($utm2,")");
	  $utm4 = explode(" ",$utm3);
	  $utm5 = explode(".",$utm4[0]);
	  $utm_lon = $utm5[0];
	  $utm6 = explode(".",$utm4[1]);
	  $utm_lat = $utm6[0];
	  $lon = $koord4[0];
	  $lon1 = explode(".",$koord4[0]);
	  $lon2 = $lon1[0];
	  $lat = $koord4[1];
	  $lat1 = explode(".",$koord4[1]);
	  $lat2 = $lat1[0];
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
			<? include ("includes/block_3.php"); ?>
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
											<? echo $font_farbe ;?><? echo $r[psy_angebote_a_angebot_name]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <? echo $amtname; ?></b>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Stadt:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(a.the_geom, b.the_geom) ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($e = $fetcharrayp($result))
															{
																echo "<option";if ($gem_id == $e[gem_schl]) echo " selected"; echo " value=\"$e[gem_schl]\">$e[gemeinde]</option>\n";
															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>zu allen Angeboten<br><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gem_id; ?>"><? echo $font_farbe ;?>zu allen Angeboten<br><? echo $gemeindename ?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr>
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->											
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>vollstation&auml;re Angebote: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht4.png" width=20></td>
													<td width=100 align=right><small>teilstation&auml;re Angebote: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht5.png" width=20></td>
												</tr>
												<tr>
													<td width=100 align=right><small>ambulante Hilfen: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sucht6.png" width=20></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>
									<? include ("includes/block_3_uk.php"); ?>	
                                 </table>
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>											
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r[psy_angebote_a_angebot_name] ;?><? echo $font_farbe_end ;?></td>													
										</tr>
										<tr>
											<td valign="top" bgcolor=<? echo $element_farbe ?>>Adresse:</td>
											<td width="100%" bgcolor=<? echo $element_farbe ?>>
												<b><? echo $r[psy_haeuser_haus_name],
												"<br>",$r[psy_haeuser_haus_strasse]," ",$r[psy_haeuser_haus_hnr],
												"<br>",$r[psy_haeuser_haus_plz]," ",$r[psy_haeuser_haus_ort] ;?></b>
											</td>											
										</tr>
										<tr>
											<td valign="top">Kontakt:</td>
											<td>
												<b><? echo $r[psy_angebote_b_anrede]," ",$r[psy_angebote_b_ansprechpartner],
												"<br>Telefon: ",$r[psy_angebote_b_telefon],
												"<br>E-Mail: <a href=\"$r[psy_angebote_b_email]\" target=blank>$r[psy_angebote_b_email]</a>
												<br>Homepage: <a href=\"$r[psy_angebote_b_internet]\" target=blank>$r[psy_angebote_b_internet]</a>" ;?></b>
											</td>										
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Bezeichnung:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[psy_katalog_angebot] ;?></b></td>																									
										</tr>
										<tr>
											<td>Art:</td>
											<td><b><? echo $r[psy_katalog_art] ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?> valign="top">besondere Merkmale:</td>
											<td bgcolor=<? echo $element_farbe ?>>
												<b>
													<? 
														$string = $r[psy_angebote_c_besondere_merkmale];
														$merkmale = str_replace("&*&","<br><br>",$string);
														echo $merkmale;
													;?>
												</b>
											</td>																										
										</tr>
										<tr>
											<td valign="top">Ausrichtung:</td>
											<td>
												<table style="border-spacing:0px" border=0 width="100%" cellspacing="0" cellpadding="0">
													<tr height="30" valign="top">
														<td width="50%"><b>Prim&auml;r:</b></td>
														<td><b>Sekund&auml;r:</b></td>
													</tr>
													<tr>
														<td valign="top"><b>
															<?	
																if ($r[psy_angebote_e_alter_k_u_j] == "primär") echo "Kinder- und Jugendliche<br>";
																if ($r[psy_angebote_e_alter_junge_erw] == "primär") echo "junge Erwachsene<br>";
																if ($r[psy_angebote_e_alter_erw] == "primär") echo "Erwachsene<br>";
																if ($r[psy_angebote_e_alter_aeltere_erw] == "primär") echo "&auml;ltere Erwachsene<br>";
																if ($r[psy_angebote_e_el_mit_k] == "primär") echo "Eltern mit Kind<br>";
																if ($r[psy_angebote_e_sonstige] == "primär") echo "Sonstige (",$r[psy_angebote_e_sonstige_text],")<br>";
															?></b>
														</td>
														<td valign="top"><b>
															<?	
																if ($r[psy_angebote_e_alter_k_u_j] == "sekundär") echo "Kinder- und Jugendliche<br>";
																if ($r[psy_angebote_e_alter_junge_erw] == "sekundär") echo "junge Erwachsene<br>";
																if ($r[psy_angebote_e_alter_erw] == "sekundär") echo "Erwachsene<br>";
																if ($r[psy_angebote_e_alter_aeltere_erw] == "sekundär") echo "&auml;ltere Erwachsene<br>";
																if ($r[psy_angebote_e_el_mit_k] == "sekundär") echo "Eltern mit Kind<br>";
																if ($r[psy_angebote_e_sonstige] == "sekundär") echo "Sonstige<br>";
															?></b>
														</td>
													</tr>
												</table>
											</td>											
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?> valign="top">Diagnose:</td>
											<td bgcolor=<? echo $element_farbe ?>>
												<table style="border-spacing:0px" border=0 width="100%" cellspacing="0" cellpadding="0">
													<tr height="30" valign="top">
														<td width="50%"><b>Prim&auml;r:</b></td>
														<td><b>Sekund&auml;r:</b></td>
													</tr>
													<tr>
														<td valign="top"><b>
															<?	
																if ($r[psy_angebote_e_diag_psychis_erkran_stoer_auffael] == "primär") echo "psychischen Erkrankung / St&ouml;rung / Auff&auml;lligkeit<br>";
																if ($r[psy_angebote_e_diag_suchterkra] == "primär") echo "Suchterkrankung<br>";
																if ($r[psy_angebote_e_diag_doppeldiag_sucht_u_psychi_erkrank] == "primär") echo "Doppeldiagnose Sucht & psychische Erkrankung<br>";
																if ($r[psy_angebote_e_diag_geisti_behinde] == "primär") echo "geistige Behinderung<br>";
																if ($r[psy_angebote_e_diag_doppeldiag_geisti_behind_u_psychi_erkr] == "primär") echo "Doppeldiagnose geistige Behinderung und psychische Erkrankung <br>";
																if ($r[psy_angebote_e_diag_doppeldiag_geist_behinde_u_sucht] == "primär") echo "Doppeldiagnose geistige Behinderung und Sucht<br>";
																if ($r[psy_angebote_e_diag_mit_koerperliche_behinderung] == "primär") echo "mit k&ouml;rperliche Behinderung<br>";
																if ($r[psy_angebote_e_diag_demenz] == "primär") echo "Demenz<br>";
															?></b>
														</td>
														<td valign="top"><b>
															<?	
																if ($r[psy_angebote_e_diag_psychis_erkran_stoer_auffael] == "sekundär") echo "psychischen Erkrankung / St&ouml;rung / Auff&auml;lligkeit<br>";
																if ($r[psy_angebote_e_diag_suchterkra] == "sekundär") echo "Suchterkrankung<br>";
																if ($r[psy_angebote_e_diag_doppeldiag_sucht_u_psychi_erkrank] == "sekundär") echo "Doppeldiagnose Sucht & psychische Erkrankung<br>";
																if ($r[psy_angebote_e_diag_geisti_behinde] == "sekundär") echo "geistige Behinderung<br>";
																if ($r[psy_angebote_e_diag_doppeldiag_geisti_behind_u_psychi_erkr] == "sekundär") echo "Doppeldiagnose geistige Behinderung und psychische Erkrankung <br>";
																if ($r[psy_angebote_e_diag_doppeldiag_geist_behinde_u_sucht] == "sekundär") echo "Doppeldiagnose geistige Behinderung und Sucht<br>";
																if ($r[psy_angebote_e_diag_mit_koerperliche_behinderung] == "sekundär") echo "mit k&ouml;rperliche Behinderung<br>";
																if ($r[psy_angebote_e_diag_demenz] == "sekundär") echo "Demenz<br>";
															?></b>
														</td>
													</tr>
												</table>
											</td>																									
										</tr>
										<?
											$string1 = $r[psy_angebote_fw_angebote];
											$fortbildung1 = str_replace("&*&","<br>",$string1);
											$string2 = $r[psy_angebote_fw_ressourcen];
											$fortbildung2 = str_replace("&*&","<br>",$string2);
											$string3 = $r[psy_angebote_fw_bedarfe];
											$fortbildung3 = str_replace("&*&","<br>",$string3);
											$string4 = $r[psy_angebote_fw_oeffentlichkeitsarbeit];
											$fortbildung4 = str_replace("&*&","<br>",$string4);
											if ($string1 AND $string2 AND $string3 AND $string4 == "0")
												echo "<tr><td>Weiter- Fortbildung:</td><td><font color=red><b>keine Eintr&auml;ge vorhanden</b></font></td></tr>";
												else
													{
														echo "<tr><td valign=\"top\">Weiter- Fortbildung:</td>
															<td>
																<b>";
																	if ($fortbildung1 != "0") echo "<i>Angebote:</i><br>",$fortbildung1,"<br>";									
																	if ($fortbildung2 != "0") echo "<i>Ressourcen:</i><br>",$fortbildung2,"<br>";														
																	if ($fortbildung3 != "0") echo "<i>Bedarfe:</i><br>",$fortbildung3,"<br>";														
																	if ($fortbildung4 != "0") echo "<i>&Ouml;ffentlichkeitsarbeit:</i><br>",$fortbildung4,"<br>";																
															echo "<b/></td></tr>";
													}
										?>										
										<tr>
											<td valign="top" bgcolor=<? echo $element_farbe ?>>Träger:</td>
											<td bgcolor=<? echo $element_farbe ?>>
												<b><? echo $r[psy_traeger_a_name_organisation],
												"<br>",$r[psy_traeger_a_strasse]," ",$r[psy_traeger_a_haus_nr],
												"<br>",$r[psy_traeger_a_ort]," ",$r[psy_traeger_a_plz] ;?></b>
											</td>																									
										</tr>
										<?	
											if (strlen($bildname) > 0) 
												{									
													$bildname1 = explode("&",$bildname);													
													$bildname2 = $bildname1[0];													
													$bildname3 = explode("/",$bildname2);													
													$bild="pictures/".$bildname3[3]."/".$bildname3[4];													
													echo "<tr><td valign=\"top\">Flyer</td><td><b><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=\"images/PDF.png\" alt=\"PDF\" width=\"50px\"></a></b></td></tr>";
												}	
											else echo "<tr><td>Flyer</td><td><font color=red><b>kein Flyer vorhanden</b></font></td></tr>";
										?>							
									</table>
							</td>									
							<td valign=top align=center width="250">
							<? include("includes/geo_point.php"); ?>	
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

