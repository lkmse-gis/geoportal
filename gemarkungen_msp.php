<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect.php");

$gemarkung_id=$_GET["gemarkung"];
$layerid=30000;

$log=write_log($db_link,$layerid);

if ($gemarkung_id > 0)
   { 

	  $query="SELECT b.gemeinde,b.gem_schl FROM gemarkung as a, gemeinden as b WHERE a.geographicidentifier='$gemarkung_id' AND a.gemeinde=b.gem_schl";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename=$r[0];
	  $gemeinde=$r[1];
	  
	  $query="SELECT b.amt, b.amt_id, c.gid as vsitzid FROM gemarkung as a, gemeinden as b, fd_amtssitze_msp as c WHERE a.geographicidentifier='$gemarkung_id' AND a.gemeinde= b.gem_schl AND b.amt_id=CAST(c.amt_id as character varying)";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $vsitzid = $r[vsitzid];
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT b.name, b.gid FROM gemarkung as a, fd_regionen as b WHERE ST_CONTAINS(ST_BUFFER(b.the_geom,20),a.the_geom) AND a.geographicidentifier='$gemarkung_id' ORDER by b.name";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $region[$k]=$r;
		   $k++;
		   $count=$k;
		}  
		
	  $query="SELECT b.plz, b.gid FROM gemarkung as a, fd_plz as b WHERE ST_INTERSECTS(ST_BUFFER(b.the_geom,-10),a.the_geom) AND a.geographicidentifier='$gemarkung_id' ORDER by b.plz";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $plz[$z]=$r;
		   $z++;		   
		   $count=$z;
		}
   
	  $query="SELECT  box(the_geom) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_centroid(st_transform(the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, st_astext(st_centroid(st_transform(the_geom, 4326))) as geo, st_perimeter(the_geom) as umfang, gemarkungsname_kurz as name from gemarkung WHERE geographicidentifier='$gemarkung_id'";

	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname = $r[name];
	  $area=$r[area];
	  $flaeche = $r[area]/10000;
	  $flaeche2 = explode(".",$flaeche);
	  $flaeche3 = $flaeche2[0];
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
					height: 490px;
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
                var orka = new OpenLayers.Layer.WMS.Untiled("ORKa-MV",
                   <? echo $osm_citymap_url; ?>,
                   {'layers': 'orkamv-gesamt', transparent: true, format: 'image/png'},
                   {isBaseLayer: true}
				);
				
				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var gemarkungen = new OpenLayers.Layer.WMS.Untiled("Gemarkungen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'msp_outline_gemkg', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);				
				
				var msp_gemarkung = new OpenLayers.Layer.WMS.Untiled("<? echo $gemarkungsname; ?>",
								 <? echo $gemarkungmap_url; ?>,
								 {layers: '<? echo $gemarkung_id; ?>', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var msp_outline = new OpenLayers.Layer.WMS.Untiled("Gemeindegrenzen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var amt_outline = new OpenLayers.Layer.WMS.Untiled("Ämter",
								 <? echo $map_msp_url; ?>,
								 {layers: 'aemter_msp_outline', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var markers = new OpenLayers.Layer.Markers( "Markers" ); 
				
				map.addLayers([orka,dop,gemarkungen,msp_gemarkung,msp_outline,amt_outline]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [gemarkungen],
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

				map.addControl(new OpenLayers.Control.LayerSwitcher());
				map.addControl(new OpenLayers.Control.Permalink());
				map.addControl(new OpenLayers.Control.OverviewMap());
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
										<? echo $font_farbe ;?>Gemarkung: <? echo $gemarkungsname ?><? echo $font_farbe_end ;?>									
									</td>
										<td width=30 rowspan=14></td>
										<td border=0 valign=top align=right rowspan=13 colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<b>(Amt: <? echo $amtname ?>)</b>
										</td>									
									</tr>
									<tr>
										<td align="center" valign="center" colspan=2 height=20>		
										<form action="gemarkungen_msp.php" method="get" name="gemarkung">
											Ortschaft (Gemeinde):<br>
											<select name="gemarkung" onchange="document.gemarkung.submit();"  style="font-family:Arial; font-size: 8pt; font-weight: bold">
												<?php
												 $query="SELECT * FROM show_gemarkungen_13071 ORDER BY gemarkung";
												 $result = $dbqueryp($connectp,$query);

												  while($r = $fetcharrayp($result))
												   {
												   echo "<option";if ($gemarkung_id == $r[gemkgschl]) echo " selected"; echo " value=\"$r[gemkgschl]\">$r[gemarkung]";
																
													echo "</option>\n";
												   }
												?>
											</select>
										</form>
									</td>
								</tr>
								<tr height="30" bgcolor=<? echo $element_farbe ;?>>									
									<td align=center colspan="2"><a href="gemarkungen_msp.php">zu allen Gemarkungen</a></td>
								</tr>	
								<tr height="30" bgcolor=<? echo $element_farbe ;?>>
									<td align=center colspan="2"><? echo "<a href=\"vsitz_msp.php?vsitz=",$vsitzid,"\">zur Amtsverwaltung</a></td>";?>
								</tr>
								<tr>
									<td colspan="2" align="center" height=30 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Informationen zu der Gemarkung<? echo $font_farbe_end ;?></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td height=30>Region:</td>
									<td><?php for($j=0;$j<$k;$j++)
									    { echo "<a href=\"regionen_msp.php?region=",$region[$j][1],"\"><b>",$region[$j][0],"</b></a>";}
									?></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td height=30>Amt:</td>
									<td><a href="aemter_msp.php?amt=<? echo $amt; ?>"><b><? echo $amtname ?></b></a></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td>Gemeinde:</td>
									<td><a href="gemeinden_msp.php?gemeinde=<?php echo $gemeinde; ?>"><b><? echo $gemeindename ?></b></a></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td>Gemarkungsnr.:</td>
									<td><b><? echo $gemarkung_id ?></b></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td height=30>Postleitzahl:</td>
									<td>
										<?php
											for($l=0;$l<$z;$l++)												
												{echo "<a href=\"plz_msp.php?plz=",$plz[$l][1],"\"><b>",$plz[$l][0],"</b></a> ";}																							
										?>
									</td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td>Bodenrichtwertzonen</td>
									<td><a href="borisf.php?gemarkung=<? echo $gemarkung_id; ?>&str_schl=x">Wohn-/Bau-/Gewerbe-/Sanierungsflächen</a><br><br><a href="borisagr.php?gemarkung=<? echo $gemarkung_id; ?>">Acker-/Grünland-/Forstflächen</a></td>
									
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
										<td colspan=2></td>
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=30000" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="gemarkungen_msp.php?gemarkung=<? echo $gemarkung_id ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
									<tr>										
										<td colspan=12>
											<table border=0 width="100%">
												<tr height="35">
													<td align=center colspan=12 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?><font size="+1">Geodätisches...<? echo $font_farbe_end ;?></td>
												</tr>
												<tr>
													<td align=center colspan=8 bgcolor=<? echo $header_farbe ;?>><font color=white><i>Zentrum Position</i></font></td>
													<td rowspan=2 colspan=4 align=center bgcolor=<? echo $header_farbe ?>><font color=white><i>Flächenangaben:</i></font></td>
												</tr>
												<tr>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>WGS84<br>(geografisch)</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>UTM<br>ETRS89 6&deg; Zone-33<br>GRS80</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>Gauß-Krüger<br>S42/83 3&deg; 4-Streifen<br>Krassowski</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>Gauß-Krüger<br>RD/83 3&deg; 4-Streifen<br>Bessel</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;östl. L.:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_long($geo);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lon($utm);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo $rcenter2 ;?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_rd83coordinates_lon($rd83);?></b></td>
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
													<td>&nbsp;&nbsp;Grenzlänge:</td>
													<td><b>&nbsp;&nbsp;<? echo $umfang3 ;?> m<b></td>													
												</tr>
												<tr>
													<td>&nbsp;&nbsp;nördl. Br.:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_lat($geo);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lat($utm);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo $hcenter2 ;?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_rd83coordinates_lat($rd83) ;?></b></td>
													<td>&nbsp;&nbsp;Nord-Süd<br>&nbsp;&nbsp;Ausdehnung:</td>													
													<td><b>&nbsp;&nbsp;<? echo round($hoch_range,2) ?> m</b></td>
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
							<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js"></script>
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
	
		$query="SELECT COUNT(*) AS anzahl FROM gemarkung WHERE gemeinde LIKE '13071%'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
	
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

				var orka = new OpenLayers.Layer.WMS.Untiled("ORKa-MV",
                   <? echo $osm_citymap_url; ?>,
                   {'layers': 'orkamv-gesamt', transparent: true, format: 'image/png'},
                   {isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var gemarkungen = new OpenLayers.Layer.WMS.Untiled("Gemarkungen",
								 <? echo $map_msp_url;?>,
								 {layers: 'msp_outline_gemkg', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);	
				
				map.addLayers([orka,dop,gemarkungen]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [gemarkungen],
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
						<td align="center" valign="top" width=300 height=140 colspan=2>
							<br>
							<h3>Ortschaften (Gemarkungen)*</h3>
							Zu diesem Thema befinden sich<br>
							<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
						</td>
						<td rowspan=7 width=30></td>
						<td border=0 align=center rowspan=6 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Ortschaft ausw&auml;hlen:<br>
							<small>Die Angabe in Klammern ist die jeweils zugehörige Gemeinde.
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 8pt; font-weight: bold">   
							<form action="gemarkungen_msp.php" method="get" name="gemarkung">								
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM show_gemarkungen_13071  ORDER BY gemarkung";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($gemarkung_id == $r[gemkgschl]) echo " selected"; echo " value=\"$r[gemkgschl]\">$r[gemarkung]
													</option>\n";
										}
									?>
								</select>								
							</form>
						</td>									
					</tr>
					<tr>
					    <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=30000" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Ortschaften(Gemarkungen)</a>
						</td>
					</tr>
					<tr><td align=center colspan=2>letzte Aktualisierung: <b><i><? echo get_aktualitaet($dbname,'30000'); ?></i></b></td></tr>
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
													<td width=100 align=right><small>Gemarkungsgrenze: </td>
													<td align=right><img src="images/gemarkungsgrenze.png" width=30></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>
								<tr>
									<td height=35 colspan=2></td>									
									<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
									</td>	
									<td>
										<a href="metadaten/metadaten.php?Layer_ID=30000" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
									</td>
									<td align=right>
										<a href="gemarkungen_msp.php"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
						<? include ("includes/news.php"); ?>
					</div>
					<div id="footer">						
					</div>
				</div>
			</body>
		</html>
<?	} ?>
