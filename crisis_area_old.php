<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect.php");
require_once("classes/legenden.class.php");

$layerid=121690;

$log=write_log($db_link,$layerid);

$vorgang_id=$_GET["vorgang_id"];
$sa=$_GET["sa"];


if (strlen($vorgang_id) > 0)
   { 	  
	  $query="SELECT * FROM veterinary.crisis_area WHERE vorgang_id='$vorgang_id'";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gebiet[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT area(the_geom) as flaeche,typ,dokument_verordnung,dokument_karte,art FROM veterinary.crisis_area WHERE vorgang_id='$vorgang_id' ORDER BY flaeche DESC LIMIT 1";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $target_type=$r[typ];
	  if (strlen($r[dokument_verordnung]) >0) $verfuegung_link="http://geoport-lk-mse.de/geoportal/pictures/veterinary/".substr($r[dokument_verordnung],32,30);
	  if (strlen($r[dokument_karte]) >0) $karte_link="http://geoport-lk-mse.de/geoportal/pictures/veterinary/".substr($r[dokument_karte],32,30);
	  $sa=$r[art];
	  
	  
	  
	  
	  $query="SELECT a.gemeinde FROM gemeinden as a,veterinary.crisis_area as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.the_geom,-10)) AND b.vorgang_id='$vorgang_id' AND b.typ = 'Sperrgebiet'";
	  $result = $dbqueryp($connectp,$query);
	  $gs=0;
	  while($r = $fetcharrayp($result))
	    {
	       $sp_gemeinde[$gs]=$r;
		   $gs++;
		   $countgs=$gs;	
		}
		
	  $query="SELECT a.gemeinde FROM gemeinden as a,veterinary.crisis_area as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.the_geom,-10)) AND b.vorgang_id='$vorgang_id' AND b.typ = 'Beobachtungsgebiet'";
	  $result = $dbqueryp($connectp,$query);
	  $gb=0;
	  while($r = $fetcharrayp($result))
	    {
	       $beo_gemeinde[$gb]=$r;
		   $gb++;
		   $countgb=$gb;	
		}
		
	  $query="SELECT a.gemeinde FROM gemeinden as a,veterinary.crisis_area as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.the_geom,-10)) AND b.vorgang_id='$vorgang_id' AND b.typ = 'Schutzzone'";
	  $result = $dbqueryp($connectp,$query);
	  $gsz=0;
	  while($r = $fetcharrayp($result))
	    {
	       $sz_gemeinde[$gsz]=$r;
		   $gsz++;
		   $countgsz=$gsz;	
		}
	  
	  $Kuerzel="crisis_area";
	  $titel="TSN-Meldungen";
	  $query="SELECT box(st_transform(a.the_geom,2398)) as box, area(a.the_geom) as area, st_astext(st_centroid(st_transform(a.the_geom,2398))) as center, a.vorgang,a.beginnt FROM veterinary.crisis_area as a WHERE a.vorgang_id='$vorgang_id' AND a.typ = '$target_type'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
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
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />		
		<script type="text/javascript" language="Javascript">
			
			<?
	echo"
			var lon   = $lon;
			var lat   = $lat;
			var lonc  = $rcenter;
			var latc  = $hcenter;
             "
?>
<?
              if ($hoch_range > 18000 OR $rechts_range > 18000) $zoom=10;
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
<?
	echo"
			var zoom  = $zoom;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:2398',
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxResolution: 'auto',
					maxExtent:  new OpenLayers.Bounds(4400000,5880000,4660000,6060000),
					units: 'm'
				});				
				
				var osm_citymap = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V\",
					 $osm_citymap_url,
					{'layers': 'orkamv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled(\"topografische Karte\",
					$dtk_url,
					{'layers': 'gdimv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $dop_url,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var msp_outline_gem = new OpenLayers.Layer.WMS.Untiled(\"Gemeindegrenzen\",
								 $map_msp_url,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				
				var  krisengebiete = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								  $map_msp_url,
								 {layers: '$sa', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([osm_citymap,dtkmv,dop,krisengebiete]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [krisengebiete],
					url: '$featureinfo_msp_url',
					title: 'Identify features by clicking',
					queryVisible: true,
					eventListeners: {
						getfeatureinfo: function(event) {
							map.addPopup(new OpenLayers.Popup.FramedCloud(
								'chicken',
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

				map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':false}));
				
				map.addControl(new OpenLayers.Control.Permalink());
				map.addControl(new OpenLayers.Control.OverviewMap({'ascending':false}));
				var om = map.getControlsByClass('OpenLayers.Control.OverviewMap')[0];
				om.maximizeControl();
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:2398'), map.getProjectionObject());
				map.setCenter(lonLat,zoom);
			}";
?>
			
			
			
			
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
										
											<? echo $font_farbe ;?>Tierseuchenmeldung<br><h3><? echo $r[vorgang],"<br>(",$r[beginnt],")";?> <? echo $font_farbe_end ;?></h3><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="8"></td>
										<td border=0 valign=top align=left rowspan="8" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="crisis_area.php"><? echo $font_farbe ;?>alle Meldungen ansehen<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr><td align=center><a href="http://geoport-lk-mse.de/mp/portale/start/?layerIDs=11002,121690&visibility=true,true&transparency=0,0&center=366906,5936850&zoomlevel=2" target=_blank><img src="buttons/kartenportal_button.gif" width=100></a>
									</td></tr>
                                               <? if ($gebiet[0][typ] != "Allgemeinverfügung") {

                                                                  	  echo "<tr bgcolor=#FF0000>
									  <td><b><u>Gemeinden im Sperrgebiet:</u></b><br>"; 
									     if ($gs > 0) 
										   {
										     for($v=0;$v<$gs;$v++)
										        echo $sp_gemeinde[$v][0],", ";
										   }
										   else echo "Kein Sperrgebiet angelegt.";
										   
									  echo "</td>
									</tr>
									<tr bgcolor=#fff928>
									  <td><b><u>Gemeinden in der Schutzzone:</u></b><br>";
									 
									     if ($gsz > 0) 
										   {
										     for($v=0;$v<$gsz;$v++)
										        echo $sz_gemeinde[$v][0],", ";
										   }
										   else echo "Keine Schutzzone angelegt.";
										   
									  echo "</td>
									</tr>
									<tr bgcolor=#00FF00>
									<td><b><u>Gemeinden im Beobachtungsgebiet:</u></b><br>";
									
									     if ($gb > 0) 
										   {
										     for($v=0;$v<$gb;$v++)
										        echo $beo_gemeinde[$v][0],", ";
										   }
										   else echo "Kein Beobachtungsgebiet angelegt.";
										   
									  echo "</td>
									</tr>
                                                                        "; }

									else echo "<tr><td align=center>Bitte beachten!</td></tr>
                                                                                   <tr><td align=center>Diese Allgemeinverfügung gilt für alle Gemeinden</td></tr>
                                                                                   <tr><td align=center>des Landkreises<br>Mecklenburgische Seenplatte</td></tr>";
                                                                        ?>
									<tr><td  height=10><b>zum Download verfügbare Dokumente:</b><br>
									    <? if (strlen($verfuegung_link) > 0) echo "<a href=$verfuegung_link target=_blank>Verfügung herunterladen</a><br>";
										   else echo "Keine Verfügung vorhanden.<br>";
										   if (strlen($karte_link) > 0) echo "<a href=$karte_link target=_blank>Detailkarte herunterladen</a><br>";
										   else echo "Keine Detailkarte vorhanden.<br>";
										   ?>
										   </td></tr>
									<tr>										
										<td valign=bottom align=right>
										<?php
										$legende_tsn=new legende;
										$legende_tsn->tsn($sa);
										?>
										</td>
									</tr>									
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gemeinde_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
									<? head_trefferliste($count,5,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
										<? if ($count>0) echo "
											<td height=30></td>
											<td height=30><a name=\"liste\"></a>&nbsp;<b>Vorgang:</b></td>											
											<td height=30>&nbsp;<b>Gebiet:</b></td>				
											<td height=30>&nbsp;<b>Massnahmen:</b></td>
											<td height=30>&nbsp;<b>Datum:</b></td>
											";
										?>							
									</tr>																
									<?php for($v=0;$v<$z;$v++)
										{ 
											$bildname = $gebiet[$v][dokument_verordnung];
											$bildname1 = explode("&",$bildname);
											$bildname2 = $bildname1[0];
											$bildname3 = explode("/",$bildname2);
											$bild="pictures/".$bildname3[5]."/".$bildname3[6];
											echo "<tr bgcolor=",get_farbe($v),">															
													<td>"; 
											if (strlen($bildname) > 0) echo "<a href=$bild target=_blank>Verfügung ansehen</a>";
											echo "</td>";	
												
											echo "<td>",$gebiet[$v][vorgang],"</td>";													
											echo "<td>",$gebiet[$v][typ],"</td>													
											<td>&nbsp;",$gebiet[$v][massnahmen],"</td>
											<td>&nbsp;",$gebiet[$v][beginnt],"</td>														
											</tr>";
										}
									?>																																				
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





if (strlen($sa) > 0  AND strlen($vorgang_id) == 0)
    { 
	
		$query="SELECT COUNT(DISTINCT vorgang_id) AS anzahl FROM veterinary.crisis_area WHERE status='aktuell' AND art='$sa'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
		
		$query="SELECT bezeichnung FROM veterinary.seuchenarten WHERE kuerzel='$sa'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$seuchenart = $r[bezeichnung];
		
	
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
				
				var osm_citymap = new OpenLayers.Layer.WMS.Untiled("ORKA M-V",
					 <? echo $osm_citymap_url;?>,
					{'layers': 'orkamv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
								

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var msp_outline_gem = new OpenLayers.Layer.WMS.Untiled("Gemeinden",
								 <? echo $map_msp_url;?>,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var krisengebiete = new OpenLayers.Layer.WMS.Untiled("Tierseuchenmeldungen",
								 <? echo $map_msp_url;?>,
								 {layers: '<? echo $sa; ?>', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				map.addLayers([osm_citymap,dop,krisengebiete]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [krisengebiete],
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
						<a href="http://geoport-lk-mse.de/mp/portale/start/?layerIDs=11002,121690&visibility=true,true&transparency=0,0&center=366906,5936850&zoomlevel=2" target=_blank><img src="buttons/kartenportal_button.gif"></a>
							<br>
							<h3>Aktuelle<br>Tierseuchenmeldungen* Landkreis<br>Mecklenburgische Seenplatte</h3>
							Aktuell befinden sich<br>
							<b><? echo $count; ?></b> Meldungen zur Seuchenart<br><br><b><? echo $seuchenart; ?></b><br><br>in der Datenbank.
						</td>
						<td rowspan=6 width=30></td>
						<td border=0 align=center rowspan=7 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Meldung ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="crisis_area.php" method="get" name="vorgang">
							    <input type=hidden value='<? echo $sa; ?>' name=sa>
								<select name="vorgang_id" onchange="document.vorgang.submit();">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT DISTINCT vorgang_id,vorgang FROM veterinary.crisis_area WHERE status='aktuell' AND art='$sa' ORDER BY vorgang_id ";
									 $result = $dbqueryp($connectp,$query);
									 
									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[vorgang_id]\">$r[vorgang]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
					<tr>
					   <td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>><a href="crisis_area.php"><? echo $font_farbe ;?>alle Meldungen ansehen<? echo $font_farbe_end ;?></a></td>
					</tr>
					<tr>
					    <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Tierseuchenmeldungen</a>
						</td>
					</tr>
					<tr><td align=center colspan=2>letzte Aktualisierung: <b><i>laufend</i></b></td></tr>
					
					<tr>
									<td valign=bottom align=center>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die<br>webbasierte Karte?<br>(OpenLayers)</a>																
									</td>	
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<?php
										     $legende_tsn=new legende;
										     $legende_tsn->tsn($sa);
										    ?>
										</td>
									</tr>
								<tr>
									<td height=35 colspan=3></td>									
									<td>
										 <small><? echo $cr; ?>|&nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
									</td>	
									<td>
										<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
									</td>
									<td align=right>
										<a href="crisis_area.php?sa=<? echo $sa; ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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

if (strlen($sa) == 0)
    { 
	
		$query="SELECT COUNT(DISTINCT vorgang_id) AS anzahl FROM veterinary.crisis_area WHERE status='aktuell'";	  
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

				var topomv = new OpenLayers.Layer.WMS.Untiled("Topografie",
					<? echo $topo_url; ?>,
					{'layers': 'gdimv_topomv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var osm_citymap = new OpenLayers.Layer.WMS.Untiled("ORKA M-V",
					 <? echo $osm_citymap_url;?>,
					{'layers': 'orkamv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
								

				 var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
									<? echo $dop_url; ?>,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var msp_outline_gem = new OpenLayers.Layer.WMS.Untiled("Gemeinden",
								 <? echo $map_msp_url;?>,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var krisengebiete = new OpenLayers.Layer.WMS.Untiled("Tierseuchenmeldungen",
								 <? echo $map_msp_url;?>,
								 {layers: 'AIV,AFB', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				map.addLayers([osm_citymap,dop,krisengebiete]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [krisengebiete],
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
						<a href="http://geoport-lk-mse.de/mp/portale/start/?layerIDs=11002,121690&visibility=true,true&transparency=0,0&center=366906,5936850&zoomlevel=2" target=_blank><img src="buttons/kartenportal_button.gif"></a>
							<br>
							<h3>Aktuelle<br>Tierseuchenmeldungen* Landkreis<br>Mecklenburgische Seenplatte<br>
							<br><b>Gesamtansicht</b><br><br>- alle Seuchenarten -</h3>
							Aktuell befinden sich<br>
							<b><? echo $count; ?></b> Meldungen in der Datenbank.
						</td>
						<td rowspan=5 width=30></td>
						<td border=0 align=center rowspan=6 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Seuchenart auswählen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="crisis_area.php" method="get" name="vorgang">
								<select name="sa" onchange="document.vorgang.submit();">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT kuerzel,bezeichnung FROM veterinary.seuchenarten ORDER BY bezeichnung ";
									 $result = $dbqueryp($connectp,$query);
									 
									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[kuerzel]\">$r[bezeichnung]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
					<tr>
					    <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Tierseuchenmeldungen</a>
						</td>
					</tr>
					<tr><td align=center colspan=2>letzte Aktualisierung: <b><i>laufend</i></b></td></tr>
					
					<tr>
									<td valign=bottom align=center>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die<br>webbasierte Karte?<br>(OpenLayers)</a>																
									</td>	
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<?php
										     $legende_tsn=new legende;
										     $legende_tsn->tsn('all');
										     ?>
										</td>
									</tr>
								<tr>
									<td height=35 colspan=3></td>									
									<td>
										 <small><? echo $cr; ?>|&nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
									</td>	
									<td>
										<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
									</td>
									<td align=right>
										<a href="crisis_area.php"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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


?>
