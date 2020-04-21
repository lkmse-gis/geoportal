<?php
include ("connect_geobasis.php");
include ("connect.php");
include ("portal_functions.php");

//globale Varibalen
$titel="Offenen Denkmäler";
$titel2="Veranstaltungsorte";
$datei="offenes_denkmal_msp.php";
$tabelle="fd_offenes_denkmal";
$kuerzel="offenes_denkmal";
$layerid="40080";
$legende="museum.gif";

$gemarkung_id=$_GET["gemarkung"];
$denkmal_id=$_GET["$kuerzel"];

$log=write_log($db_link,$layerid);

if ($denkmal_id < 1 AND $gemarkung_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle";	  
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
		<? include ("zeit.php"); ?>
		<? include ("meta_popup.php"); ?>
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

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var kreisgrenze = new OpenLayers.Layer.WMS.Untiled("Kreisgrenze",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Kreisgrenze_msp', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var offenes_denkmal = new OpenLayers.Layer.WMS.Untiled("<? echo $titel;?>",
								 <? echo $offenes_denkmal_msp_url; ?>,
								 {layers: 'Offene Denkmale', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([topomv,dop,kreisgrenze,offenes_denkmal]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [offenes_denkmal],
					url: '<? echo $featureinfo_offenes_denkmal_msp_url; ?>',
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
								<h3>Tag des Offenen Denkmals<br>
								(09.09.2012)</h3>
								Zu diesem Thema befinden sich<br>
								<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
							</td>
							<td rowspan=8 width=30>
							<td border=0 valign=top rowspan=7 colspan=3>
								<br>
								<div style="margin:1px" id="map"></div>
							</td>
						</tr>
						<tr>
							<td align="center" height=50 colspan=2>
								Ort ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="gemarkung">
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
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
						<tr>
					             <td valign=bottom align="center" colspan=2>
					    *) <a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema <? echo $titel;?></a>
						         </td>
					            </tr>
					            <tr><td align="center" colspan=2>letzte Aktualisierung: <b><i><? echo get_aktualitaet($dbname,$layerid); ?></td>
								</tr>
                                <tr>
									<td valign=bottom align=center>
										<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die webbasierte Karte?<br>(OpenLayers)</a>																
									</td>
								</tr>
								<tr>
									<td valign=bottom align=right>
										<!-- Tabelle für Legende -->
										<table border="1" rules="none" width="100%" valign=bottom align=right>					
											<tr>
												<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
											</tr>
											<tr>
												<td width=100 align=right><small><? echo $titel2;?>: </td>
												<td align=right><img src="<? echo $bildpfad.$legende ; ?>" width=30></td>
												<td align=right><small>Kreisgrenze: </td>
												<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>
											</tr>																					
										</table> <!-- Ende der Tabelle für die Legende -->
									</td>
					           </tr>						
						
						
						<tr>
										<td colspan=2 height=35></td>				
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
				<? include ("news.php"); ?>
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
	       $denkmal[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, gemarkung as b WHERE ST_WITHIN (ST_BUFFER(b.the_geom,-10), a.the_geom) AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemarkungsname_kurz as name FROM gemarkung as a WHERE CAST(a.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname = $r[name];
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
		<? include ("zeit.php"); ?>
		<? include ("meta_popup.php"); ?>
		<? include ("bilder_popup.php"); ?>
			<style type="text/css">
			   #map {
					width: 670px;
					height: 300px;
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

			var zoom  = <?php echo $zoom; ?>;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: "map",
					projection: "EPSG:2398",
					scales: [1200000,750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxResolution: "auto",
					maxExtent:  new OpenLayers.Bounds(4300000,5870000,4670000,6070000),
					units: 'm'
				});

				var topomv = new OpenLayers.Layer.WMS.Untiled("Topografie",
					<? echo $topo_url; ?>,
					{'layers': 'gdimv_topomv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);

				var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled("Topografie",
					<? echo $dtk_url; ?>,
					{'layers': 'gdimv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var msp_outline = new OpenLayers.Layer.WMS.Untiled("gemarkunggrenzen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'msp_outline', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var msp_gemarkung = new OpenLayers.Layer.WMS.Untiled("<? echo $gemarkungsname; ?>",
								 <? echo $gemarkungmap_url; ?>,
								 {layers: '<? echo $gemarkung_id; ?>', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var gemarkungen = new OpenLayers.Layer.WMS.Untiled("Gemarkungen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Gemarkungen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var offenes_denkmal = new OpenLayers.Layer.WMS.Untiled("<? echo $titel;?>",
								 <? echo $offenes_denkmal_msp_url; ?>,
								 {layers: 'Offene Denkmale', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var markers = new OpenLayers.Layer.Markers( "Markers" ); 
				
				map.addLayers([dtkmv,dop,gemarkungen,msp_gemarkung,offenes_denkmal]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [offenes_denkmal],
					url: '<? echo $featureinfo_offenes_denkmal_msp_url; ?>',
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
													   echo "<option";if ($gemarkung_id == $r[gemkgschl]) echo " selected"; echo " value=\"$r[gemkgschl]\">$r[gemarkung]
																	</option>\n";
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
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width="100%" valign=bottom align=right>					
											<tr>
												<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
											</tr>
											<tr>
												<td width=100 align=right><small><? echo $titel2;?>: </td>
												<td align=right><img src="<? echo $bildpfad.$legende ; ?>" width=30></td>
												<td align=right><small>Gemarkungsgrenze: </td>
												<td align=right><img src="images/gemarkungsgrenze_2.png" width=30></td>
											</tr>																					
										</table>
										</td>
									</tr>									
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?gemarkung=<? echo $gemarkung_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
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
									<? head_trefferliste($count,4,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
									<!-- Überschrift für Sachdaten -->
													<? if ($count>0) echo "
															<td align=center height=30><a name=\"liste\"></a><b>Name:</b></td>													
															<td align=center height=30><b>Beschreibung:</b></td>															
														";
													?>
												</tr>
												<?php for($v=0;$v<$z;$v++)
													{ 
														echo "<tr bgcolor=",get_farbe($v),">";															
														echo "
														<td align='center'><a href=\"offenes_denkmal_msp.php?$kuerzel=",$denkmal[$v][gid],"\">",$denkmal[$v][bezeichnung],"</a></td>",													
														"<td align='center'>",$denkmal[$v][beschreibung],"</td>",																											
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
				<table border="0" align="left">
					<tr>
						<td>
							<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js"></script>
						</td>
					</tr>
				</table>
			</div>
			<div id="extra">
            <? include ("news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  }

 if ($denkmal_id > 0)
   {   
	  $query="SELECT a.gemarkungsname_kurz, a.geographicidentifier as gemarkungid, b.gid FROM gemarkung as a, $tabelle as b WHERE ST_WITHIN(b.the_geom, a.the_geom) AND b.gid='$denkmal_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkung_id=$r[gemarkungid];
	  $gemarkungname=$r[gemarkungsname_kurz];

	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, $tabelle as b WHERE ST_WITHIN(b.the_geom, a.the_geom) AND b.gid='$denkmal_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT astext(the_geom) as koordinaten, astext(st_transform(the_geom, 25833)) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, astext(st_transform(the_geom, 4326)) as geo, gid, bezeichnung, beschreibung FROM $tabelle WHERE gid='$denkmal_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname=$r[bild];
	  $oeffentlich=$r[oeffentlich];
	  $koord = $r[koordinaten];
	  $koord2 = trim($koord,"POINT(");
	  $koord3 = trim($koord2,")");
	  $koord4 = explode(" ",$koord3);
	  $rd83 = $r[rd83];
	  $utm = $r[utm];
	  $geo=$r[geo];
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
		<? include ("zeit.php"); ?>
		<? include ("meta_popup.php"); ?>
		<? include ("bilder_popup.php"); ?>
			<style type="text/css">
			   #map {
					width: 720px;
					height: 320px;
					border: 1px solid black;
				}
			</style>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			var lon   = <?php echo $lon; ?>;
			var lat   = <?php echo $lat; ?>;
			var zoom  = 31;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: "map",
					projection: "EPSG:2398",
					scales: [1200000,750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,750,500,400,300,200,100],
					maxResolution: "auto",
					maxExtent:  new OpenLayers.Bounds(4300000,5870000,4670000,6070000),
					units: 'm'
				});

				var topomv = new OpenLayers.Layer.WMS.Untiled("Topografie",
					<? echo $topo_url; ?>,
					{'layers': 'gdimv_topomv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var gemarkungen = new OpenLayers.Layer.WMS.Untiled("Gemarkungen",
								 <? echo $map_url; ?>,
								 {layers: 'gemarkungen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var offenes_denkmal = new OpenLayers.Layer.WMS.Untiled("<? echo $titel;?>",
								 <? echo $offenes_denkmal_msp_url; ?>,
								 {layers: 'Offene Denkmale', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var markers = new OpenLayers.Layer.Markers( "Markers" );
				
				map.addLayers([dop,topomv,gemarkungen,offenes_denkmal]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [offenes_denkmal],
					url: '<? echo $featureinfo_offenes_denkmal_msp_url; ?>',
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
				markers.addMarker(new OpenLayers.Marker(lonLat));				
				map.setCenter(lonLat,zoom);
			}
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
											<? echo $font_farbe ;?><? echo $r[bezeichnung]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10></td>
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
													   echo "<option";if ($gemarkung_id == $e[gemkgschl]) echo " selected"; echo " value=\"$e[gemkgschl]\">$e[gemarkung]
																	</option>\n";
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
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width="100%" valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small><? echo $titel2;?>: </td>
													<td align=right><img src="<? echo $bildpfad.$legende ; ?>" width=30></td>
													<td align=right><small>Gemarkungsgrenze: </td>
													<td align=right><img src="images/gemarkungsgrenze_2.png" width=30></td>
												</tr>																					
											</table>
										</td>
									</tr>
									<tr>
										<td colspan=3></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?<? echo $kuerzel;?>=<? echo $denkmal_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
                                 </table>
								 
							 <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r[bezeichnung]; ?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Bezeichnung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[bezeichnung] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Beschreibung:</td>
										<td><b><? echo $r[beschreibung] ;?></b></td>																									
									</tr>									
								</table>
							</td>									
							<td valign=top align=center width="350">
							<? include("geo_point.php"); ?>	
							</td>
						</tr>
						</table>
						</td></tr>
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
             <? include ("news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  }

