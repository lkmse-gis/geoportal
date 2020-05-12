<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen
$titel="Solaranlagen";
$layer="";
$titel2="Solaranlage";
$datei="solar_msp.php";
$tabelle="fd_solaranlagen";
$kuerzel="solaranlage";
$layerid="32230";
$leg_bild="solar.gif";

// Legenden - Layer - msp.map
$layer="Solaranlagen";
$layer2="";

$gemarkung_id=$_GET["gemarkung"];
$solaranlagen_id=$_GET["$kuerzel"];
$themen_id=$solaranlagen_id;

$log=write_i_log($db_link,$layerid);

if ($themen_id < 1 AND $gemarkung_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
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
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
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
						<? include ("includes/count_map.php"); ?>
						<tr>
							<td align="center" height=50 colspan=2>
								Ort ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="gemarkung" onchange="document.<? echo $kuerzel;?>.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,$tabelle as c WHERE ST_WITHIN(c.the_geom,b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[gemkgschl]\">$r[gemarkung]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
						<? include ("includes/meta_i_aktualitaet.php"); ?>
						<? // include ("includes/block_1_legende.php"); ?>
						<!-- Tabelle für Legende -->
								<td valign=bottom align=right>
									<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
									<B>Kartenlegende:</B>
										<?php
											$legende_geo= new legende_geo;
//   										function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
											echo $legende_geo->zeigeLegende2('1','0','0','0','0','0',$layer,$layer2)
										?>
								</table> 
								</td>
							<!-- ENDE Tabelle für Legende -->
						
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


if ($gemarkung_id > 0)
   { 	  
	  $query="SELECT a.* FROM $tabelle as a, gemarkung as b WHERE ST_WITHIN (a.the_geom, b.the_geom) AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $solar[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, gemarkung as b WHERE ST_WITHIN (ST_BUFFER(b.the_geom,-10), a.the_geom) AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemarkungsname_kurz as name FROM gemarkung as a WHERE CAST(a.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname = $r["name"];
	  $zentrum = $r["etrscenter"];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rcenter = $zentrum4[0];
	  $hcenter = $zentrum4[1];
	  $boxstring = $r["etrsbox"];
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
			<? include ("includes/block_2_gemkg.php"); ?>
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
										<td height="40" align="center" valign=top width=250 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel;?> in <? echo $gemarkungsname ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="8"></td>
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
										<td align="center" height=30 colspan=2>
											Ort ausw&auml;hlen:
										</td>
									</tr>
									<tr>
										<td align="center" height="40">
											<form action="<? echo $datei;?>" method="get" name="gemarkung">								
												<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
													<option>Bitte auswählen</option>
													<?php
													 $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,$tabelle as c WHERE ST_WITHIN(c.the_geom,b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
													 $result = $dbqueryp($connectp,$query);

													  while($r = $fetcharrayp($result))
													   {
													   echo "<option";if ($gemarkung_id == $r["gemkgschl"]) echo " selected"; echo ' value="',$r["gemkgschl"],'">',$r["gemarkung"],'</option>\n';
														}
													?>
												</select>								
											</form>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>
									<tr><td  height=10></td></tr>
									<!-- Tabelle für Legende  alt -->
									<? //include ("includes/block_2_legende_gemkg.php"); ?>								
							<!-- Tabelle für Legende -->
								<td valign=bottom align=right>
									<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
									<B>Kartenlegende:</B>
										<?php
											$legende_geo= new legende_geo;
//   										function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
											echo $legende_geo->zeigeLegende2('1','0','0','0','0','0',$layer,$layer2)
										?>
								</table> 
								</td>
							<!-- ENDE Tabelle für Legende -->
									<? include ("includes/block_2_uk_gemkg.php"); ?>
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
									<!-- Überschrift für Sachdaten -->
													<? if ($count>0) echo "
															<td align=center height=30></td>
															<td align=center height=30><a name=\"liste\"></a><b>Anlagenschl&uuml;ssel:</b></td>													
															<td align=center height=30><b>Betreiber:</b></td>
															<td align=center height=30><b>Postleitzahl/Ort:</b></td>
															<td align=center height=30><b>Stra&szlig;e:</b></td>
														";
													?>
												</tr>
												<?php for($v=0;$v<$z;$v++)
													{ 
														$bildname = $solar[$v]["bild"];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[3]."/".$bildname3[4];
														echo "<tr bgcolor=",get_farbe($v),">";															
														if(strlen($bildname) < 1 OR $solar[$v][oeffentlich] == 'nein')
															{
																echo "<td></td>";	
															} 
														else 
															{
																echo "<td align='center'><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild height='30'></a></td>";
															}
														echo "
														<td align='center'><a href=\"solar_msp.php?solaranlage=",$solar[$v]["gid"],"\">",$solar[$v]["anls"],"</a></td>",													
														"<td align='center'>",$solar[$v]["betreiber"],"</td>",
														"<td align='center'>",$solar[$v]["plz"]." ".$solar[$v]["ort"],"</td>",
														"<td align='center'>",$solar[$v]["strasse"],"</td>",
														"</tr>";
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
	  $query="SELECT a.gemarkungsname_kurz, a.geographicidentifier as gemarkungid, b.gid FROM gemarkung as a, $tabelle as b WHERE ST_WITHIN(b.the_geom, a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkung_id=$r["gemarkungid"];
	  $gemarkungname=$r["gemarkungsname_kurz"];

	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, $tabelle as b WHERE ST_WITHIN(b.the_geom, a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT astext(the_geom) as koordinaten, astext(st_transform(the_geom, 25833)) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, astext(st_transform(the_geom, 4326)) as geo, gid, anls, betreiber, ort, strasse, plz, plzb, strasseb, ortb, mailb, homeb, kw, kwh, entst, spebene, typ, bild, oeffentlich, urheber FROM $tabelle WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname=$r["bild"];
	  $oeffentlich=$r["oeffentlich"];
	  $koord = $r["koordinaten"];
	  $koord2 = trim($koord,"POINT(");
	  $koord3 = trim($koord2,")");
	  $koord4 = explode(" ",$koord3);
	  $rd83 = $r["rd83"];
	  $utm = $r["utm"];
	  $geo=$r["geo"];
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
										<td height="40" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r["betreiber"]; ?><? echo $font_farbe_end ;?>
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
											<form action="<? echo $datei;?>" method="get" name="gemarkung">
												Ort:&nbsp;
												<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
													<option>Bitte auswählen</option>
													<?php
													 $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,$tabelle as c WHERE ST_WITHIN(c.the_geom,b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
													 $result = $dbqueryp($connectp,$query);

													  while($e = $fetcharrayp($result))
													   {
													   echo "<option";if ($gemarkung_id == $e["gemkgschl"]) echo " selected"; echo ' value="',$e["gemkgschl"],'">',$e["gemarkung"],'
																	</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center height="50" colspan=2>
											<a href="<? echo $datei;?>?gemarkung=<? echo $gemarkung_id; ?>"><? echo $font_farbe ;?>alle <? echo $titel;?><br><? echo $gemarkungname ?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>
									<? //include ("includes/block_3_legende.php"); ?>
								<!-- Tabelle für Legende -->
								<td valign=bottom align=right>
									<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
									<B>Kartenlegende:</B>
										<?php
											$legende_geo= new legende_geo;
//   										function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
											echo $legende_geo->zeigeLegende2('1','0','0','0','0','0',$layer,$layer2)
										?>
								</table> 
								</td>
							<!-- ENDE Tabelle für Legende -->
									<? include ("includes/block_3_uk.php"); ?>
                                 </table>
								 
							 <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r["betreiber"]."<br>&nbsp;&nbsp;Anlage: ".$r["anls"]; ?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Betreiberdaten:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["betreiber"]."<br>".$r["plzb"]." ".$r["ortb"]."<br>".$r["strasseb"]."<br>E-Mail:<br><a href='mailto:".$r["mailb"]."'>".$r["mailb"]."</a><br>Homepage:<br><a href='http://".$r["homeb"]."' target='_blank'>".$r["homeb"]."</a>" ;?></b></td>
										<?											
											$bildname1 = explode("&",$bildname);
											$bildname2 = $bildname1[0];
											$bildname3 = explode("/",$bildname2);
											$bild="pictures/".$bildname3[3]."/".$bildname3[4];											
											if(strlen($bildname) < 1 OR $oeffentlich == 'nein')
												{
													echo "<td valign=center align=center rowspan=5 width=320 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";	
												} 
											else 
												{
													echo "<td valign=top align=right rowspan=5 width=320><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
												}
										?>
									</tr>
									<tr height="30">
										<td>Anlagenschl&uuml;ssel:</td>
										<td><b><? echo $r["anls"] ;?></b></td>																									
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Anlagenstandort:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["plz"]." ".$r["ort"]."<br>".$r["strasse"] ;?></b></td>									
									</tr>
									<tr height="30">
										<td>Spannungsebene:</td>
										<td><b><? echo $r["spebene"] ;?></b></td>																									
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Leistung (KW):</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["kw"] ;?></b></td>									
									</tr>
									<tr height="30">
										<td>Leistung (KWH):</td>
										<td><b><? echo $r["kwh"] ;?></b></td>																									
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Entstehungsjahr:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["entst"] ;?></b></td>									
									</tr>
									<tr height="30">
										<td>Typ:</td>
										<td><b><? echo $r["typ"] ;?></b></td>																									
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Urheber (Bild):</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["urheber"] ;?></b></td>									
									</tr>
								</table>
							</td>									
							<td valign=top align=center width="350">
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

