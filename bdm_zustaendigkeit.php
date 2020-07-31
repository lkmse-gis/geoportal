<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect_i_procedure_mse.php");

$layerid=160100;

$log=write_i_log($db_link,$layerid);

$gemeinde_id=$_GET["gemeinde"];

if ($gemeinde_id > 0)
   { 
	  
	  
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	 
	 
		
	 
	  
	  $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(st_transform(a.the_geom,4326))) as geo, st_astext(st_centroid(a.the_geom)) as center, st_astext(st_centroid(a.the_geom)) as utm, st_perimeter(a.the_geom) as umfang, a.gemeinde as name, b.gid as vsitzid, a.einwohner as einw, a.buergermeister as bm, a.einw_km as einw_km, a.wappen as wappen, a.vorwahl as vorwahl, a.plz as plz,a.the_geom as gemeindeumring  from gemeinden as a, fd_amtssitze_msp as b WHERE gem_schl='$gemeinde_id' AND a.amt_id=CAST(b.amt_id as character varying)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r["name"];
	  $gemeindeumring=$r["gemeindeumring"];
	  $bm = $r["bm"];
	  $vorwahl = $r["vorwahl"];
	  $einw = $r["einw"];
	  $einw_km = $r["einw_km"];
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
	  
	   $query="SELECT a.mitarbeiter_titel,a.mitarbeiter_name,a.mitarbeiter_vorname,a.mitarbeiter_telefon,a.mitarbeiter_fax,a.mitarbeiter_mail,v.mitarbeiter_titel as v_mitarbeiter_titel,v.mitarbeiter_name as v_mitarbeiter_name,v.mitarbeiter_vorname as v_mitarbeiter_vorname,v.mitarbeiter_telefon as v_mitarbeiter_telefon,v.mitarbeiter_fax as v_mitarbeiter_fax,v.mitarbeiter_mail as v_mitarbeiter_mail,a.sg_name,a.sg_leiter_name,a.sg_leiter_vorname,a.sg_leiter_telefon,a.sg_leiter_mail,a.fachamt_name,a.fachamt_leiter,a.fachamt_leiter_telefon,a.fachamt_leiter_mail FROM organisation.ma_gesamt as a,organisation.ma_gesamt as v,organisation.zustaendigkeiten as b WHERE a.mitarbeiter_sg='60.1' AND a.mitarbeiter_id=CAST(b.mitarbeiter_id AS INTEGER)  AND v.mitarbeiter_id=CAST(b.vertretung_mitarbeiter_id AS INTEGER) AND st_intersects(st_centroid('$gemeindeumring'),st_transform(b.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
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
			<style type="text/css">
			   #map {
					width: 650px;
					height: 620px;
					border: 1px solid black;
				}
			</style>
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			var lon   = <?php echo $lon; ?>;
			var lat   = <?php echo $lat; ?>;
			var lonc  = <?php echo $rcenter; ?>;
			var latc  = <?php echo $hcenter; ?>;
             <?php
              if ($hoch_range > 18000 OR $rechts_range > 18000) $zoom=11;
			  else if ($hoch_range > 10000 AND $hoch_range < 17999 OR $rechts_range > 10000 AND $rechts_range < 17999) $zoom=13;
			  else if ($hoch_range > 8000 AND $hoch_range < 9999 OR $rechts_range > 8000 AND $rechts_range < 9999) $zoom=16;
			  else if ($hoch_range > 7000 AND $hoch_range < 8999 OR $rechts_range > 7000 AND $rechts_range < 7999) $zoom=17;
			  else if ($hoch_range > 6000 AND $hoch_range < 6999 OR $rechts_range > 6000 AND $rechts_range < 6999) $zoom=20;
			  else if ($hoch_range > 5000 AND $hoch_range < 5999 OR $rechts_range > 5000 AND $rechts_range < 5999) $zoom=21;
			  else if ($hoch_range > 4000 AND $hoch_range < 4999 OR $rechts_range > 4000 AND $rechts_range < 4999) $zoom=22;
			  else if ($hoch_range > 3000 AND $hoch_range < 3999 OR $rechts_range > 3000 AND $rechts_range < 3999) $zoom=23;
			  else if ($hoch_range > 2000 AND $hoch_range < 2999 OR $rechts_range > 2000 AND $rechts_range < 2999) $zoom=24;
              else $zoom=25;
             ?>

			var zoom  = <?php echo $zoom ?>;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: "map",
					projection: "EPSG:2398",
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxResolution: "auto",
					maxExtent:  new OpenLayers.Bounds(4400000,5880000,4660000,6060000),
					units: 'm'
				});

				var topomv = new OpenLayers.Layer.WMS.Untiled("Topografie",
					<? echo $topo_url; ?>,
					{'layers': 'gdimv_topomv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var orka_mv = new OpenLayers.Layer.WMS.Untiled("ORKA M-V",
					<? echo $orka_mv_url; ?>,
					{'layers': '<? echo $orka_mv_layername; ?>', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);				
				
				var msp_outline = new OpenLayers.Layer.WMS.Untiled("Gemeindegrenzen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var msp_gemeinde = new OpenLayers.Layer.WMS.Untiled("<? echo $gemeindename; ?>",
								 <? echo $gemeindemap_url; ?>,
								 {layers: '<? echo $gemeinde_id; ?>', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);				
				
				var sg_60_1 = new OpenLayers.Layer.WMS.Untiled("Zuständigkeit",
								 <? echo $map_msp_url;?>,
								 {layers: 'sg_60_1', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var amt_outline = new OpenLayers.Layer.WMS.Untiled("Ämter",
								 <? echo $map_msp_url; ?>,
								 {layers: 'aemter_msp_outline', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var markers = new OpenLayers.Layer.Markers( "Markers" ); 
				
				map.addLayers([orka_mv,dop,sg_60_1,msp_outline,amt_outline]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [msp_outline,sg_60_1],
					url: '<? echo $featureinfo_msp_url; ?>',
					title: 'Identify features by clicking',
					queryVisible: true,
					eventListeners: {
						getfeatureinfo: function(event) {
							map.addPopup(new OpenLayers.Popup.FramedCloud(
								"chicken",
								map.getLonLatFromPixel(event.xy),
								null,
								event.text,
								null,
								true
							));
						}
					}
				});
				map.addControl(info);
				info.activate();

				map.addControl(new OpenLayers.Control.LayerSwitcher({"ascending":false}));				
				map.addControl(new OpenLayers.Control.Permalink());
				map.addControl(new OpenLayers.Control.OverviewMap({"ascending":false}));				
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:2398"), map.getProjectionObject());
				var lonLatc = new OpenLayers.LonLat(lonc, latc).transform(new OpenLayers.Projection("EPSG:2398"), map.getProjectionObject());
				markers.addMarker(new OpenLayers.Marker(lonLatc));
				map.setCenter(lonLat,zoom);
			}
		</script>
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
										<td width=30 rowspan=18><br>
										</td>
										<td border=0 valign=top align=right rowspan=23 colspan=3>
											<div style="margin:1px" id="map"></div>
											<table border=0 cellpadding=0 cellspacing=0 rules="none">
												<tr>													
													<td width=600><small>
														 <? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
													</td>	
													<td width=30>
														<a href="metadaten/metadaten.php?Layer_ID=160100" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
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
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<small><a href="bdm_zustaendigkeit.php">gesamten Landkreis anzeigen</a></b>
										</td>									
									</tr>
									<tr>
										<td align="center" valign="center" colspan=2 height=40>
											<form action="bdm_zustaendigkeit.php" method="get" name="gemeinde">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.gemeinde.submit();">
													<?php
														$query="SELECT * FROM gemeinden WHERE kreis_id = '13071' ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($rx = $fetcharrayp($result))
														{
														 echo "<option";if ($gemeinde_id == $rx["gem_schl"]) echo " selected"; echo ' value="',$rx["gem_schl"],'">',$rx["gemeinde"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>									
									
									<tr height=10 colspan="2"></tr>
									<tr>
										<td colspan="2" align="center" height=20 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>zuständiger Sachbearbeiter<br>Bau-/Bodendenkmalpflege<? echo $font_farbe_end ;?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Name:</td>
										<td><b><? echo $r["mitarbeiter_titel"],' ',$r["mitarbeiter_vorname"],' ',$r["mitarbeiter_name"]; ?></td>
									</tr>									
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Telefon:</td>
										<td><? echo $r["mitarbeiter_telefon"] ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Fax:</td>
										<td><? echo $r["mitarbeiter_fax"] ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>E-Mail:</td>
										<td><a href="mailto:<? echo $r["mitarbeiter_mail"];?>"><? echo $r["mitarbeiter_mail"];?></a></td>
									</tr>
									<tr>
										<td colspan="2" align="center" height=15 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Vertretung<? echo $font_farbe_end ;?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Name:</td>
										<td><b><? echo $r["v_mitarbeiter_titel"],' ',$r["v_mitarbeiter_vorname"],' ',$r["v_mitarbeiter_name"]; ?></td>
									</tr>									
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Telefon:</td>
										<td><? echo $r["v_mitarbeiter_telefon"] ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Fax:</td>
										<td><? echo $r["v_mitarbeiter_fax"] ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>E-Mail:</td>
										<td><a href="mailto:<? echo $r["v_mitarbeiter_mail"];?>"><? echo $r["v_mitarbeiter_mail"];?></a></td>
									</tr>
									<tr>
										<td colspan="2" align="center" height=15 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Sachgebiet: <? echo $r["sg_name"] ?> <? echo $font_farbe_end ;?></td>
									</tr>
									
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Sachgebietsleiter</td>
										<td><? echo $r["sg_leiter_vorname"],' ',$r["sg_leiter_name"]; ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Telefon:</td>
										<td><? echo $r["sg_leiter_telefon"] ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>E-Mail:</td>
										<td><a href="mailto:<? echo $r["sg_leiter_mail"];?>"><? echo $r["sg_leiter_mail"];?></a></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Fachamt</td>
										<td><? echo $r["fachamt_name"] ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Amtsleiter</td>
										<td><? echo $r["fachamt_leiter"]; ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>Telefon:</td>
										<td><? echo $r["fachamt_leiter_telefon"] ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=15><small>E-Mail:</td>
										<td><a href="mailto:<? echo $r["fachamt_leiter_mail"];?>"><? echo $r["fachamt_leiter_mail"];?></a></td>
									</tr>
									
									
																					
									<tr>
										<td colspan=2 valign=bottom>
											<table border="1" rules="none" width=120 valign=bottom align=right>					
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
										<td colspan=6>
											<table border=0 width="100%">
												<tr height="35">
													<td align=center colspan=10 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?><font size="+1">Geodätisches (Gemeinde <? echo $gemeindename,')...',$font_farbe_end ;?></td>
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
			<?php
			
				echo div_navigation(); 
				echo div_extra(); 
				echo div_footer();
				
			?>
		</div>
		</body>
		</html>
<?  }





if ($gemeinde_id < '0'		)
    { 
	
		
	
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
		<? include ("includes/meta_popup.php"); ?>
			<style type="text/css">
			   #map {
					width: 680px;
					height: 490px;
					border: 1px solid black;
				}
			</style>
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			var lon   = <?php echo $lon; ?>;
			var lat   = <?php echo $lat; ?>;
			var zoom  = 3;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: "map",
					projection: "EPSG:2398",
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxResolution: "auto",
					maxExtent:  new OpenLayers.Bounds(4400000,5880000,4660000,6060000),
					units: 'm'
				});

				var topomv = new OpenLayers.Layer.WMS.Untiled("Topografie",
					<? echo $topo_url; ?>,
					{'layers': 'gdimv_topomv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var orka_mv = new OpenLayers.Layer.WMS.Untiled("ORKA M-V",
					<? echo $orka_mv_url; ?>,
					{'layers': '<? echo $orka_mv_layername; ?>', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var gemeinden_msp = new OpenLayers.Layer.WMS.Untiled("Gemeinden",
								 <? echo $map_msp_url;?>,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var sg_60_1 = new OpenLayers.Layer.WMS.Untiled("Zuständigkeit",
								 <? echo $map_msp_url;?>,
								 {layers: 'sg_60_1', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				map.addLayers([orka_mv,dop,gemeinden_msp,sg_60_1]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [gemeinden_msp,sg_60_1],
					url: '<? echo $featureinfo_msp_url; ?>',
					title: 'Identify features by clicking',
					queryVisible: true,
					eventListeners: {
						getfeatureinfo: function(event) {
							map.addPopup(new OpenLayers.Popup.FramedCloud(
								"chicken",
								map.getLonLatFromPixel(event.xy),
								null,
								event.text,
								null,
								true
							));
						}
					}
				});
				map.addControl(info);
				info.activate();

				map.addControl(new OpenLayers.Control.LayerSwitcher({"ascending":false}));				
				map.addControl(new OpenLayers.Control.Permalink());
				map.addControl(new OpenLayers.Control.OverviewMap({"ascending":false}));
				var om = map.getControlsByClass("OpenLayers.Control.OverviewMap")[0];
				om.maximizeControl();
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:2398"), map.getProjectionObject());
				map.setCenter(lonLat,zoom);
			}
		</script>
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
							<h3>Zuständigkeiten<br>Bau-/Bodendenkmalpflege</h3>
							<br><br><b>Bitte beachten Sie:</b><br><br>Die Stadt Neubrandenburg verfügt über eine eigene untere Denkmalschutzbehörde.
							
						</td>
						<td rowspan=6 width=30></td>
						<td border=0 align=center rowspan=6 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<!--Zeile1 Gemeinde wählen -->
					<tr>
						<td align="center" height=30 colspan=2>
							Gemeinde ausw&auml;hlen:
						</td>
					</tr>
					<!--Zeile 2 Gemeinde wählen -->
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="bdm_zustaendigkeit.php" method="get" name="gemeinde">
								<select name="gemeinde" onchange="document.gemeinde.submit();">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT * FROM gemeinden WHERE kreis_id = '13071' AND gem_schl != '13071107' ORDER BY gemeinde";
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
					<!--Zeile 3 Metadaten -->
					<tr>
					    <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=160100" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Zuständigkeiten Bau-/Bodendenkmalpflege</a>
						</td>
					</tr>
					<!--Zeile 4 letzte Aktualisierung -->
					<tr><td align=center colspan=2>letzte Aktualisierung: <b><i><? echo get_i_aktualitaet($db_link,'160100'); ?></i></b></td></tr>
					<!--Zeile 5 Kartenhilfe/Legende -->
					<tr>
									<td valign=bottom align=center>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die<br>webbasierte Karte?<br>(OpenLayers)</a>																
									</td>	
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=2 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Gemeindegrenze: </td>
													<td align=right><img src="images/gemeindegrenze.png" width=30></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>
					<!--Zeile 6 (über die ganze Breite, unter der Karte) Metadaten usw.				-->
								<tr>
									<td height=35 colspan=3></td>									
									<td>
										 <small><? echo $cr; ?>|&nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
									</td>	
									<td>
										<a href="metadaten/metadaten.php?Layer_ID=160100" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
									</td>
									<td align=right>
										<a href="bdm_zustaendigkeit.php"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
<?	} ?>
