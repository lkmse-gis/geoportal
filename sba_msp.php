
<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="Strassenbauamt";
$titel2="Stra&szlig;enbauamt";
$datei="sba_msp.php";
$tabelle="fd_sba_sitz";
$kuerzel="sbas";
$layerid="70410";
$legende="sba.gif";

$sbas_id=$_GET["kuerzel"];

$log=write_log($db_link,$layerid);

if ($sbas_id < 1)
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
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
			<style type="text/css">
				#map {
				width: 750px;
				height: 490px;
				border: 1px solid black;
				}
			</style>
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
						<tr>							
							<td align="center" valign="top" height=30 colspan=2><br>
								<h3>Stra&szlig;enbau&auml;mter*</h3>
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
								<? echo $titel2; ?> ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="kuerzel" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
									<?php
										$query="SELECT name, gid FROM $tabelle ORDER BY name";
										$result = $dbqueryp($connectp,$query);
										echo "<option>-- Bitte ausw&auml;hlen --</option>\n";
										while($r = $fetcharrayp($result))											
											{												
												echo "<option value=\"$r[gid]\"  title=\"$r[name]\">$r[name]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
						<tr>
					             <td valign=bottom align="center" colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Stra&szlig;enbau&auml;mter</a>
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
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small><? echo $titel2;?>: </td>
													<td align=right><img src="../../kvwmapmsp/symbols/<? echo $legende; ?>" width=30></td>
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
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
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
				<? include ("includes/news.php"); ?>
			</div>
			<div id="footer">			
		  </div>
		</div>
		</body>
		</html>
<?	}

if ($sbas_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid as sbaid FROM gemeinden as a, $tabelle as b WHERE ST_WITHIN(b.the_geom,a.the_geom) AND b.gid='$sbas_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[amt];
	  $amt=$r[amt_id];
	  $gem_id=$r[gemeindeid];
	  $gemeindename=$r[gemeinde];
	  
	  $query="SELECT a.name, a.gid FROM fd_sba_bereich as a, $tabelle as b WHERE ST_WITHIN(b.the_geom,a.the_geom) AND b.gid='$sbas_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $sbabname=$r[name];
	  $sbabid=$r[gid];
	  
	  $query="SELECT astext(the_geom) as koordinaten, astext(st_transform(the_geom, 25833)) as utm,  st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, astext(st_transform(the_geom, 4326)) as geo, gid, name, strasse, plz, ort, tel, fax, mail, bild, oeffentlich FROM $tabelle WHERE gid='$sbas_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $name = $r[name];
	  $bildname = $r[bild];
	  $bildname2 = trim($bildname,"/data/Bilder/");
	  $bildname3 = explode(".",$bildname2);
	  $bildname4 = $bildname3[0];
	  $id = $r[gid];
	  $koord = $r[koordinaten];
	  $koord2 = trim($koord,"POINT(");
	  $koord3 = trim($koord2,")");
	  $koord4 = explode(" ",$koord3);
	  $rd83 = $r[rd83];
	  $utm = $r[utm];
	  $geo = $r[geo];
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
			<style type="text/css">
			   #map {
					width: 680px;
					height: 450px;
					border: 1px solid black;
				}
			</style>
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
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
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var <? echo $kuerzel;?> = new OpenLayers.Layer.WMS.Untiled("<? echo $titel;?>",
								 <? echo $map_msp_url; ?>,
								 {layers: '<? echo $titel;?>', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var markers = new OpenLayers.Layer.Markers( "Markers" );
				
				map.addLayers([dop,topomv,<? echo $kuerzel;?>,markers]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [<? echo $kuerzel;?>],
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
											<? echo $font_farbe ;?><? echo $r[name]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10></td>
										<td border=0 valign=top align=left rowspan="5" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b><a href="sbab_msp.php?kuerzel=<? echo $sbabid; ?>">Zum Bereich</a></b>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<? echo $titel2;?>:&nbsp;
												<select name="kuerzel" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT a.name, a.gid FROM $tabelle as a ORDER BY a.name";
														$result = $dbqueryp($connectp,$query);
													
														while($e = $fetcharrayp($result))
															{
																echo "<option";if ($sbas_id == $e[gid]) echo " selected"; echo " value=\"$e[gid]\"  title=\"$e[name]\">$e[name]</option>\n";															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Stra&szlig;enbau&auml;mter<? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small><? echo $titel2;?>: </td>
													<td align=right><img src="../../kvwmapmsp/symbols/<? echo $legende; ?>" width=30></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>
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
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?<? echo $kuerzel;?>=<? echo $sbas_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
                                 </table>
								 
							 <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<font size="+1"><? echo $font_farbe ;?><? echo $r[name] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Postleitzahl:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[plz] ;?></b></td>
										<?
											$bildname="bilder/schulen/$bildname4.jpg";
											if (file_exists($bildname)) {
												echo "<td valign=top align=right rowspan=7 width=420><a href='bilder/schulen/$bildname4.jpg' target='_blank' onclick='return popup(this.href);'><img height='235' src='bilder//schulen/$bildname4.jpg'></a></td>";
												} else {
												echo "<td valign=center align=right rowspan=7 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";
												}
										?>
									</tr>
									<tr>
										<td>Ort:</td>
										<td><b><? echo $r[ort] ;?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Straße:</td>
										<td bgcolor=<? echo $element_farbe ?> width="300"><b><? echo $r[strasse] ;?></b></td>
									</tr>									
									<tr>
										<td>Telefon:</td>
										<td><b>
										<? 
											if ($r[tel] == "") echo "<font color=red>keine Telefonnummer vorhanden</font>";
											else echo $r[tel];
										?></b></td>
									</tr>	
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>FAX:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
										<? 
											if ($r[fax] == "") echo "<font color=red>keine Faxnummer vorhanden</font>";
											else echo $r[fax];
										?></b>
										</td>												
									</tr>									
									<tr>
										<td>E-Mail:</td>
										<td><b>
											<? 
												if ($r[mail] == "") echo "<font color=red>keine E-Mail Adresse vorhanden</font>";
												else echo "<a href='mailto:$r[mail]'>$r[mail]</a>";
											?></b>
										</td>												
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>zum Zust&auml;ndigkeitsbereich:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo "<a href=\"sbab_msp.php?sbab=",$sbabid,"\">",$sbabname,"</a></b>" ;?></td>												
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