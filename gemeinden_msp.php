<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect_i_procedure_mse.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende_1="msp_outline_gem";
$layer_legende_2="aemter_msp_outline";

$beschriftung_karte="Gemeinden";


$gemeinde_id=$_GET["gemeinde"];
$layer_name=$gemeinde_id;
$layerid=30500;

$log=write_i_log($db_link,$layerid);

if ($gemeinde_id > 0)
   { 
	  
	  $query="SELECT gemarkungsname_kurz as gemkgname,geographicidentifier as gemkgschl FROM kataster.gemarkung WHERE gemeinde='$gemeinde_id' ORDER BY gemkgname";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemarkungen[$i]=$r;
		   $i++;
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];	  
		
	  $query="SELECT b.plz, b.gid FROM gemeinden as a, osm.plz as b WHERE ST_INTERSECTS(b.geom,st_buffer(a.geom_25833,-500)) AND a.gem_schl='$gemeinde_id' ORDER by b.plz";
	  $result = $dbqueryp($connectp,$query);
	  $l=0;
	  while($r = $fetcharrayp($result))
	    {
	       $plz[$l]=$r;
		   $l++;		   
		   $count=$l;
		}
	  
	  $query="SELECT box(a.the_geom) as box, box(st_buffer(a.geom_25833,1000)) as etrsbox,area(a.the_geom) as area, st_astext(st_centroid(st_transform(a.the_geom,4326))) as geo, st_astext(st_centroid(a.the_geom)) as center, st_astext(st_centroid(a.the_geom)) as utm, st_perimeter(a.the_geom) as umfang, a.gemeinde as name, b.gid as vsitzid, a.einwohner as einw, a.mann, a.frau, a.einw_quote, a.mann_quote, a.frau_quote, a.buergermeister as bm, a.einw_km as einw_km, a.wappen as wappen, a.vorwahl as vorwahl, a.plz as plz, a.akt_bevoelkerung from gemeinden as a, kataster.amtsbereiche_standorte as b WHERE gem_schl='$gemeinde_id' AND a.amt_id=CAST(b.amt_id as character varying)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r["name"];
	  $bm = $r["bm"];
	  $vorwahl = $r["vorwahl"];
	  $einw = $r["einw"];
	  $einw_quote = $r["einw_quote"];
	  $mann = $r["mann"];
	  $frau = $r["frau"];
	  $mann_quote = $r["mann_quote"];
	  $frau_quote = $r["frau_quote"];
	  $einw_km = $r["einw_km"];
	  $aktualitaet = $r["akt_bevoelkerung"];
	  $wappen = $r["wappen"];
	  $vsitzid = $r["vsitzid"];
	  $area=$r["area"];	  
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
		<? include ("includes/bilder_popup.php"); ?>
        <?$gemeinde_karte= new karte;
        echo $gemeinde_karte->zeigeKarteBox($boxstring_etrs,'680','450','orka','1','1','1','0','0',$beschriftung_karte,$layer_name); ?>			 
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
										<td height="40" align="center" valign=center width=300 bgcolor=<? echo $header_farbe ;?> colspan="2">
											<? echo $font_farbe ;?>Gemeinde: <? echo $gemeindename ?><? echo $font_farbe_end ;?>										
										</td>
										<td width=30 rowspan=19><br>
										</td>
										<td border=0 valign=top align=right rowspan=19 colspan=3>
											<div style="margin:1px" id="map"></div>
											<table border=0 cellpadding=0 cellspacing=0 rules="none">
												<tr>													
													<td width=600><small>
														 <? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
													</td>	
													<td width=30>
														<a href="metadaten/metadaten.php?Layer_ID=30500" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
													</td>
													<td align=right>
														<a href="gemeinden_msp.php?gemeinde=<? echo $gemeinde_id ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<b>(Amt: <? echo $amtname ?>)</b>
										</td>									
									</tr>
									<tr>
										<td align="center" valign="center" colspan=2 height=40>
											<form action="gemeinden_msp.php" method="get" name="gemeinde">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.gemeinde.submit();">
													<?php
														$query="SELECT * FROM gemeinden ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
														{
														 echo "<option";if ($gemeinde_id == $r["gem_schl"]) echo " selected"; echo ' value="',$r["gem_schl"],'">',$r["gemeinde"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>									
									<tr height="30" bgcolor=<? echo $element_farbe ;?>>									
										<td align=center colspan="2"><a href="gemeinden_msp.php">zu allen Gemeinden</a></td>										
									</tr>
									<tr height="30" bgcolor=<? echo $element_farbe ;?>>
										<td align=center colspan="2"><? echo "<a href=\"vsitz_msp.php?amtsverwaltung=",$vsitzid,"\">zur Amtsverwaltung</a></td>";?>	
									</tr>
									<tr height=10 colspan="2"></tr>
									<tr>
										<td colspan="2" align="center" height=30 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Informationen zu der Gemeinde<? echo $font_farbe_end ;?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Gemeindenummer:</td>
										<td><? echo $gemeinde_id; ?></td>
									</tr>									
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Amt:</td>
										<td><a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a></td>
									</tr>									
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>B&uuml;rgermeister/in:</td>
										<td><? echo $bm ?></td>
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
										<td height=30>Postleitzahl/en:</td>
										<td>
											<?php
												for($l=0;$l<$i;$l++)												
													{echo "<a href=\"plz_msp.php?plz=",$plz[$l][1],"\">",$plz[$l][0],"</a> ";}																							
											?>
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Vorwahl/en:</td>
										<td><? echo $vorwahl ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=30>Wappen:</td>
										<?											
											$bildname1 = explode("&",$wappen);
											$bildname2 = $bildname1[0];
											$bildname3 = explode("/",$bildname2);
											$bild="pictures/".$bildname3[5]."/".$bildname3[6];											
											if(strlen($wappen) < 1)
												{
													echo "<td><font color=red><b>kein Wappen vorhanden</b></font></td>";	
												} 
											else 
												{
													echo "<td><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild></a></td>";
												}
										?>
									</tr>
									<tr bgcolor=<? echo $header_farbe ;?>>
										<td colspan="2" align=center><font color=white><i>Gemarkungen</i><? echo $font_farbe_end ;?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>									    
										<td><?php for($y=0;$y<$i;$y++)
										    { echo "<a href=\"gemarkungen_msp.php?gemarkung=",$gemarkungen[$y][1],"\">",$gemarkungen[$y][0],"</a><br>";}
											?>
										</td>
										<td align=center><?php for($y=0;$y<$i;$y++)
										    { echo "<a href=\"gemarkungen_msp.php?gemarkung=",$gemarkungen[$y][1],"\">",$gemarkungen[$y][1],"</a><br>";}
											?>
										</td>
									</tr>												
									<tr>
                     			<!-- Tabelle für Legende -->
						<td valign=bottom align=left >
							<table class="table_legende" >
								<B>Kartenlegende :</B>
								<?php
								 $legende_geo= new legende_geo;
								 echo $legende_geo->zeigeLegende($layer_legende_1,$layer_legende_2,'','','');
								?>
							</table> 
						</td>
			<!-- ENDE Tabelle für Legende --> 
									</tr>								
									<tr>										
										<td colspan=6>
											<table border=0 width="100%">
												<tr height="35">
													<td align=center colspan=10 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?><font size="+1">Geodätisches...<? echo $font_farbe_end ;?></td>
												</tr>
												<tr>
													<td align=center colspan=6 bgcolor=<? echo $header_farbe ;?>><font color=white>Zentrum Position</font></td>
													<td rowspan=2 colspan=4 align=center bgcolor=<? echo $header_farbe ?>><font color=white><i>Flächenangaben:</i><? echo $font_farbe_end ;?></td>
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
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Nördliche-Breite:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_lat($geo);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lat($utm);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo $hcenter2 ;?></b></td>
													<td>&nbsp;&nbsp;Grenzlänge<br>&nbsp;&nbsp;Fläche:</td>
													<td><b>&nbsp;&nbsp;<? echo $umfang3 ;?> m<b></td>
													<td>&nbsp;&nbsp;Ost-West<br>&nbsp;&nbsp;Ausdehnung:</td>
													<td><b>&nbsp;&nbsp;<? echo round($rechts_range,2) ?> m</b></td>												
												</tr>												
											</table>
										</td>
									</tr>
								</table>
							</td>							
						</tr>
					</table>
				</div>
			</div>
			<div id="navigation">
				<table border="0" align="left">
					<tr>
						<td>
							<script type="text/javascript" language="JavaScript1.2" src="menu_mse_geoportal.js"></script>
						</td>
					</tr>
				</table>
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
	
		$query="SELECT COUNT(*) AS anzahl FROM gemeinden WHERE kreis_id='13071'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
	?>
		<?php
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
		<? include ("includes/meta_popup.php"); 
        $gemeinde_karte= new karte;
        echo $gemeinde_karte->zeigeKarteBox($box_mse_gesamt,'680','450','orka','1','0','1','0','0',$beschriftung_karte,'msp_outline_gem');	
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
							<h3>Gemeinden* Landkreis<br>Mecklenburgische Seenplatte</h3>
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
							Gemeinde ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="gemeinden_msp.php" method="get" name="gemeinde">
								<select name="gemeinde" onchange="document.gemeinde.submit();">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT * FROM gemeinden WHERE kreis_id='13071' ORDER BY gemeinde";
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
					<? include ("includes/meta_i_aktualitaet.php"); ?>
                     			<!-- Tabelle für Legende -->
						<td valign=bottom align=left >
							<table class="table_legende" >
								<B>Kartenlegende :</B>
								<?php
								 $legende_geo= new legende_geo;
								 echo $legende_geo->zeigeLegende($layer_legende_1,'','','','');
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
		  </div>				</div>
			</body>
		</html>
<?	} ?>
