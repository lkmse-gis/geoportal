<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect_i_procedure_mse.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="aemter_msp_outline";

$amt_id=$_GET["amt"];
$layerid=30800;
$beschriftung_karte="Amstbereiche";
$layer_name="aemter_msp_outline";
$log=write_i_log($db_link,$layerid);

if ($amt_id > 0)
   { 
	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, kataster.amtsbereiche as b WHERE CAST(b.amts_sf as character varying)='$amt_id' AND a.amt_id=CAST(b.amts_sf as character varying) ORDER BY a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$z]=$r;
		   $z++;		   
		}	  	  
	  
	  $query="SELECT box(a.the_geom) as box, box(a.geom_25833) as etrsbox,area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, st_astext(st_centroid(st_transform(a.the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(a.the_geom, 4326))) as geo, a.name as name, st_perimeter(a.the_geom) as umfang, b.gid as vsitzid, a.gliederung as gliederung, a.einwohner as einw, a.mann, a.frau, a.mann_quote, a.frau_quote, a.einw_quote, a.einw_km as einw_km, a.akt_bevoelkerung, a.amtsvorsteher as av FROM kataster.amtsbereiche as a, kataster.amtsbereiche_standorte as b WHERE CAST(a.amts_sf as character varying)='$amt_id' AND  CAST(a.amts_sf as character varying) = b.amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $vsitzid = $r["vsitzid"];
	  $av = $r["av"];
	  $einw = $r["einw"];
	  $mann = $r["mann"];
	  $frau = $r["frau"];
	  $mann_quote = $r["mann_quote"];
	  $frau_quote = $r["frau_quote"];
	  $einw_km = $r["einw_km"];
	  $einw_quote = $r["einw_quote"];
	  $aktualitaet = $r["akt_bevoelkerung"];
	  $gliederung = $r["gliederung"];
	  $area=$r["area"];
	  $amtname = $r["name"];	  
	  $zentrum = $r["center"];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $utm = $r["utm"];
	  $geo = $r["geo"];
	  $umfang = $r["umfang"];
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];
	  $rcenter = $zentrum4[0];
	  $rcenter1 = explode(".",$rcenter);
	  $rcenter2 = $rcenter1[0];
	  $hcenter = $zentrum4[1];
	  $hcenter1 = explode(".",$hcenter);
	  $hcenter2 = $hcenter1[0];
	  $boxstring_etrs = $r["etrsbox"];
	  $boxstring = $r["box"];
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
        <?$aemterkarte= new karte;
        echo $aemterkarte->zeigeKarteBox($boxstring_etrs,'680','450','orka','1','0','0','0','0',$beschriftung_karte,$layer_name); ?>			 
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
								<table border=0 width="100%">
									<tr>
										<td height="40" align="center" valign=center width=300 bgcolor=<? echo $header_farbe ;?> colspan="2">
											<font size="+0.5"<? echo $font_farbe ;?>Amt: <? echo $amtname ?><? echo $font_farbe_end ;?><br>
										</td>
										<td width=30 rowspan=15></td>
										<td border=0 valign=top align=right rowspan="15" colspan=3>
											<div style="margin:1px" id="map"></div>											
											<table border=0 width=650 cellpadding=0 cellspacing=0>
												<tr>																					
													<td>
														<small><? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
													</td>	
													<td>
														<a href="metadaten/metadaten.php?Layer_ID=30800" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
													</td>
													<td align=right>
														<a href="aemter_msp.php?amt=<? echo $amt_id ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
													</td>
												</tr>
											</table>
											<br>
											<table border=0 width=650>
												<tr height="35">
													<td align=center colspan=6 bgcolor=<? echo $header_farbe ;?>><b><font size="+1" color=white>Geodätisches...</font></b></td>
												</tr>
												<tr>
													<td align=center colspan=6 bgcolor=<? echo $header_farbe ;?>><font color=white>Zentrum Position</font></td>
												</tr>
												<tr>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>WGS84<br>(geografisch)</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>UTM-Koordinaten<br>(ETRS89 Zone-33 GRS80)</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>Gauß-Krüger-Koordinaten<br>(S42/83 Zone-4 Krassowski)</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Östliche-Länge:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_long($geo);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lon($utm);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo $rcenter2 ;?></b></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Nördliche-Breite:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_lat($geo);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lat($utm);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo $hcenter2 ;?></b></td>
												</tr>
												<tr>
													<td colspan=4 align=center bgcolor=<? echo $element_farbe ?>>&nbsp;&nbsp;Flächenangaben:</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Fläche:</td>
													<td><b>&nbsp;
														<? 
														   if ($area > 10000) 
																{$area=$area/10000;
																	$area1 = explode(".",$area);
																	$area2 = $area1[0];
																	echo $area2." ha"; 
																} 
															else 
																{
																	echo $area." m²";
																}
														?></b>
													</td>
													<td>&nbsp;&nbsp;Nord-Süd<br>&nbsp;&nbsp;Ausdehnung:</td>
													<td><b>&nbsp;&nbsp;<? echo round($hoch_range,2) ?> m</b></td>
													<td colspan=2 rowspan=2 valign=bottom>
														<table border="1" rules="none" width=120 valign=top align=right>					
															<tr>
																<td colspan=2 align=center height=25><i>Kartenlegende:</i></td>
															</tr>
															<tr>
																<td width=100 align=right><small>Amtsgrenze: </td>
																<td align=right><img src="images/amtsgrenze_2.png" width=30></td>													
															</tr>
															<tr>
																<td align=right><small>Gemeindegrenze: </td>
																<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>											
															</tr>
															<tr>
																<td align=right><small>Gemarkungsgrenze: </td>
																<td align=right><img src="images/gemarkungsgrenze_2.png" width=30></td>											
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Ost-West<br>&nbsp;&nbsp;Ausdehnung:</td>
													<td><b>&nbsp;&nbsp;<? echo round($rechts_range,2) ?> m</b></td>												
													<td>&nbsp;&nbsp;Grenzlänge der<br>&nbsp;&nbsp;Fläche</td>
													<td><b>&nbsp;&nbsp;<? echo $umfang3 ?> m<b></td>
												</tr>
											</table>											
										</td>										
									</tr>
									<tr>										
										<td align="center" valign="center" colspan=2 height=40>
											<form action="aemter_msp.php" method="get" name="amt">
												Amt:&nbsp;
												<select name="amt" onchange="document.amt.submit();">
													<?php
														$query="SELECT * FROM kataster.amtsbereiche ORDER BY name";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
														{
														 echo "<option";if ($amt_id == $r["amts_sf"]) echo " selected"; echo ' value="',$r["amts_sf"],'">',$r["name"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr height="30" bgcolor=<? echo $element_farbe ;?>>										
										<td align=center colspan="2"><a href="aemter_msp.php">zu allen Ämtern</a></td>										
									</tr>
									<tr height="30" bgcolor=<? echo $element_farbe ;?>>
										<td align=center colspan="2"><? echo "<a href=\"vsitz_msp.php?amtsverwaltung=",$vsitzid,"\">zum Verwaltungssitz</a></td>";?>	
									</tr>								
									<tr height=10 colspan="2"></tr>
									<tr>
										<td colspan="2" align="center" height=30 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Informationen zu dem Amt<? echo $font_farbe_end ;?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<?
											if ($gliederung == 'keine')
												echo "<td height=30>B&uuml;rgermeister/in:</td><td>$av</td>";
											else
												echo "<td height=30>Amtsvorsteher/in:</td><td>$av</td>";
										?>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Einwohner:<br><small>(Zensus: <? echo $aktualitaet ?>)</small></td>
										<td><? echo $einw." <small>(Quote: ".$einw_quote."%)</small>" ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Männer:<br><small>(Zensus: <? echo $aktualitaet ?>)</small></td>
										<td><? echo $mann." <small>(Quote: ".$mann_quote."%)</small>" ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Frauen:<br><small>(Zensus: <? echo $aktualitaet ?>)</small></td>
										<td><? echo $frau." <small>(Quote: ".$frau_quote."%)</small>" ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Bev&ouml;lkerungsdichte:</td>
										<td><? echo $einw_km ?> Einw. je km&sup2;</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Amtsgliederung:</td>
										<td><? echo $z ?> Gemeinden</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe ;?>>
										<td height=30 colspan="2" align=center><font color=white><i>Gemeinden</i><? echo $font_farbe_end ;?></td>
									</tr>									
									<tr bgcolor=<? echo $element_farbe ;?>>										
										<td valign=top>
											<?php 
												for($x=0;$x<$z;$x++)
													{ echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$x][0],"\">",$gemeinden[$x][1],"</a><br>";}
											?>													
										</td>
										<td valign=top>										
											<?php 
												for($x=0;$x<$z;$x++)
													{ echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$x][0],"\">",$gemeinden[$x][0],"</a><br>";}
											?>
										</td>															
									</tr>										
									<tr><td colspan="2"></td></tr>									
								</table>							
							</td>							
						</tr>
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
<?  }





else
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM kataster.amtsbereiche";	  
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
		<? include ("includes/meta_popup.php"); 
        $aemterkarte= new karte;
        echo $aemterkarte->zeigeKarteBox($box_mse_gesamt,'680','450','orka','1','0','0','0','0',$beschriftung_karte,$layer_name);			 
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
						<td align="center" valign="top" width=300 height=60 colspan=2>
							<br>
							<h3>Amtsbereiche* Landkreis<br>Mecklenburgische Seenplatte</h3>
							Zu diesem Thema befinden sich<br>
							<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
						</td>
						<td rowspan=8 width=30></td>
						<td border=0 align=center rowspan=7 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Amt ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 	  
							<form action="aemter_msp.php" method="get" name="amt">
								<select name="amt" onchange="document.amt.submit();">
									<option>Bitte auswählen</option>
									 <?php
									 $query="SELECT * FROM kataster.amtsbereiche ORDER BY name";
									 $result = $dbqueryp($connectp,$query);

									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[amts_sf]\">$r[name]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
					<? include ("includes/meta_i_aktualitaet.php"); ?>
 			<!-- Tabelle für Legende -->
						<td valign=bottom align=left >
							<table class="table_legende" >
								<B>Kartenlegende :</B>
								<?php
								 $legende_geo= new legende_geo;
								 echo $legende_geo->zeigeLegende($layer_legende,'','','','');
								?>
							</table> 
						</td>
			<!-- ENDE Tabelle für Legende --> 

					<? include ("includes/block_1_1_uk.php"); ?>
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
<?	} ?>
