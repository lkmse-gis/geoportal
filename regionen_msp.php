<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

$layerid=31000;
$region_id=$_GET["region"];

$log=write_log($db_link,$layerid);

if ($region_id < 1)
    { 
		$query="SELECT COUNT(*) AS anzahl FROM fd_regionen";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl] ;
	
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
			<style type="text/css">
				#map {
				width: 700px;
				height: 490px;
				border: 1px solid black;
				}
			</style>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			var lon   = <?php echo $lon; ?>;
			var lat   = <?php echo $lat; ?>;
			var zoom  = 3;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: "map",
					projection: "EPSG:25833",
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxResolution: "auto",
					maxExtent:  new OpenLayers.Bounds(198843,5885901,466202,6054736),
					units: 'm'
				});

				var orka = new OpenLayers.Layer.WMS.Untiled("ORKa-MV",
                   <? echo $osm_citymap_url; ?>,
                   {'layers': 'orkamv-gesamt', transparent: true, format: 'image/png'},
                   {isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);				
				

				var regionen = new OpenLayers.Layer.WMS.Untiled("Regionen",
								 <? echo $map_msp_url;?>,
								 {layers: 'Regionen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);			

				map.addLayers([orka,dop,regionen]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [regionen],
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
				//var om = map.getControlsByClass("OpenLayers.Control.OverviewMap")[0];
				//om.maximizeControl();
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
									
									<td align="center" valign="top" height=30 colspan=2><br>
										<h3>Regionen*</h3>
										Zu diesem Thema befinden sich<br>
										<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
									</td>
									<td width=30 rowspan=7></td>
									<td border=0 valign=top align=center rowspan=6 colspan=3>
										<br>
										<div style="margin:1px" id="map"></div>
									</td>
								</tr>
								<tr>
									<td align="center"  height=30 colspan=2>
										Region ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=60 colspan=2>
										<form action="regionen_msp.php" method="get" name="region">
										<select name="region" onchange="document.region.submit();">
											<option>Bitte auswählen</option>
											<?php
												$query="SELECT name, gid FROM fd_regionen ORDER BY name";
												$result = $dbqueryp($connectp,$query);

												while($r = $fetcharrayp($result))
													{
														echo "<option value=\"$r[gid]\">$r[name]</option>\n";
													}
											?>
										</select>										
										</form>
									</td>									
								</tr>
                                <tr>
					             <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=31000" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Regionen</a>
						         </td>
					            </tr>
					            <tr><td align=center colspan=2>letzte Aktualisierung: <b><i><? echo get_aktualitaet($dbname,'31000'); ?></td>
								</tr>
                                <tr>
									<td valign=bottom align=center>
										<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die<br>webbasierte Karte?<br>(OpenLayers)</a>																
									</td>	
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=2 align=center height=25><i>Kartenlegende:</i></td>
												</tr>												
												<tr>
													<td align=right><small>Regionen: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>													
												</tr>											
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
					           
								</tr>								
								
								
								<tr>
										<td colspan=2 height=35></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>   
											<a href="metadaten/metadaten.php?Layer_ID=31000" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="lsg.php"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
							</table>
						</div>
					</div>
					<div id="navigation">
						<table border="0" align="left">
							<tr>
								<td>
									<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js"></script>
								</td>
							</tr>
						</table>
					</div>
					<div id="extra">
                    <? include ("includes/news.php") ?>					
					</div>
					<div id="footer">						
					</div>
				</div>
			</body>
		</html>
<?	} 


if ($region_id > 0)
   {   
	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, fd_regionen as b WHERE ST_CONTAINS(ST_BUFFER(b.the_geom,20),a.the_geom) AND b.gid='$region_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, fd_regionen as b WHERE ST_CONTAINS(ST_BUFFER(b.the_geom,20),a.the_geom) AND b.gid='$region_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count=$k;
		}
	  
	  $query="SELECT box(the_geom) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_centroid(st_transform(the_geom, 25833))) as utm,  st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, st_astext(st_centroid(st_transform(the_geom, 4326))) as geo, st_astext(st_transform(the_geom, 2398)) as koordinaten, st_perimeter(the_geom) as umfang, gid, name, einwohner, reg_leiter, ein_km FROM fd_regionen WHERE gid='$region_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);	 
	  $area=$r[area];	  
	  $zentrum = $r[center];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rd83 = $r[rd83];
	  $utm = $r[utm];
	  $geo = $r[geo];
	  $umfang = $r[umfang];
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];
	  $rcenter = $zentrum4[0];
	  $rcenter1 = explode(".",$rcenter);
	  $rcenter2 = $rcenter1[0];
	  $hcenter = $zentrum4[1];
	  $hcenter1 = explode(".",$hcenter);
	  $hcenter2 = $hcenter1[0];
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
			<style type="text/css">
			   #map {
					width: 680px;
					height: 320px;
					border: 1px solid black;
				}
			</style>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			var lon   = <?php echo $lon; ?>;
			var lat   = <?php echo $lat; ?>;
			var lonc  = <?php echo $rcenter; ?>;
			var latc  = <?php echo $hcenter; ?>;
             <?php
              if ($hoch_range > 67000) $zoom=1;
			  else if ($hoch_range > 61000 AND $hoch_range < 66999) $zoom=2;
			  else if ($hoch_range > 52000 AND $hoch_range < 60999) $zoom=4;
			  else if ($hoch_range > 50000 AND $hoch_range < 51999) $zoom=5;
              else $zoom=6;
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

				var orka = new OpenLayers.Layer.WMS.Untiled("ORKa-MV",
                   <? echo $osm_citymap_url; ?>,
                   {'layers': 'orkamv-gesamt', transparent: true, format: 'image/png'},
                   {isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);				
				
				var regionen = new OpenLayers.Layer.WMS.Untiled("Regionen",
								 <? echo $map_msp_url;?>,
								 {layers: 'Regionen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var region_markierung = new OpenLayers.Layer.WMS.Untiled("Markierung <? echo $r[name]; ?>",
								 <? echo $regionmap_url; ?>,
								 {layers: '<? echo $r[gid]; ?>', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);						
				
				var markers = new OpenLayers.Layer.Markers( "Markers" );
				
				map.addLayers([orka,dop,region_markierung,regionen]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [regionen],
					url: '<? echo $featureinfo_url; ?>',
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
				
				map.addControl(new OpenLayers.Control.LayerSwitcher());
				map.addControl(new OpenLayers.Control.Permalink());
				map.addControl(new OpenLayers.Control.OverviewMap());
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:2398"), map.getProjectionObject());
				var lonLatc = new OpenLayers.LonLat(lonc, latc).transform(new OpenLayers.Projection("EPSG:2398"), map.getProjectionObject());
				markers.addMarker(new OpenLayers.Marker(lonLatc));				
				map.setCenter(lonLatc,zoom);
			}
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 2px;}
			td.rahmen {border: solid #000000 1px;}
		</style> 
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
											<? echo $font_farbe ;?>Region <? echo $r[name]; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Regionalbereiche des Kreises</b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">Region:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="regionen_msp.php" method="get" name="region">												
												<select name="region" onchange="document.region.submit();">
													<?php														
															$query="SELECT name, gid FROM fd_regionen ORDER BY name";
															$result = $dbqueryp($connectp,$query);

															while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($region_id == $e[gid]) echo " selected"; echo " value=\"$e[gid]\">$e[name]</option>\n";
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="regionen_msp.php"><? echo $font_farbe ;?>alle Regionen<? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
									<tr>										
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=2 align=center height=25><i>Kartenlegende:</i></td>
												</tr>												
												<tr>
													<td align=right><small>Regionen: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>													
												</tr>											
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>	
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=31000" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="regionen_msp.php?region=<? echo $region_id; ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						    <tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1">Region <? echo $r[name] ;?><? echo $font_farbe_end ;?></td>													
									</tr>									
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Einwohner:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[einwohner] ;?></b></td>													
									</tr>
									<tr>
										<td>Einwohner pro km&sup2;:</td>
										<td><b><? echo $r[ein_km] ;?></b></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top>enthaltene &Auml;mter:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
											<?php 
												for($x=0;$x<$i;$x++)
												{ echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
											?></b>
										</td>
									</tr>
									<tr>
										<td valign=top>enthaltene Gemeinden:</td>
										<td><b>
											<?php 
												for($y=0;$y<$k;$y++)
												{echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$y][0],"\">",$gemeinden[$y][1],"(".$gemeinden[$y][0].")</a><br>";}
											?></b>
										</td>
									</tr>									
								</table>
							</td>
							<td width=30></td>
							<td valign=top align=center width="250">
								<? include ("includes/geo_flaeche.php") ?>
							</td>
						</tr>
					</table>				
				</div>
			</div>
			<div id="navigation">
				<table border="0" align="left">
					<tr>
						<td>
							<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js"></script>
						</td>
					</tr>
				</table>
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

