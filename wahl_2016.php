<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect.php");
$layerid=131100;
$get_themenname="wb";
$layername_mapfile="wahlen";
$titel="Wahlkreise";
$headline="Wahlkreise Landtagswahl MV 2016";

$log=write_log($db_link,$layerid);

$wb=$_GET["wb"];

if (strlen($wb) > 0)
   { 	  
	  $query="SELECT * FROM election.landtagswahlen_2016 WHERE wk_nr='$wb'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $wk_name=$r[wk_name];
	  
	  
	  
	  if ($wb != 2 AND $wb != 3)
          {
	  $query="SELECT a.gen FROM government.gemeinden_mv as a, election.landtagswahlen_2016 as b WHERE st_intersects(b.simple_geom,st_transform(a.geom,25833)) AND b.wk_nr='$wb' ORDER BY a.gen ";
	  #echo $query;
	  $result = $dbqueryp($connectp,$query);
	  $gs=0;
	  while($r = $fetcharrayp($result))
	    {
	       $wb_gemeinde[$gs]=$r;
		   $gs++;
		   echo $wb_gemeinde[$gs][gen];
		   	
		}
		#echo "Anzahl: ",$gs;
          }
          else
          {
          $query="SELECT a.ortsteil FROM management.ot_lt_rka as a, election.landtagswahlen_2016 as b WHERE st_intersects(b.simple_geom,a.the_geom) AND b.wk_nr='$wb' ORDER BY a.ortsteil";
	  #echo $query;
	  $result = $dbqueryp($connectp,$query);
	  $gs=0;
	  while($r = $fetcharrayp($result))
	    {
	       $wb_gemeinde[$gs]=$r;
		   $gs++;
		   echo $wb_gemeinde[$gs][ortsteil];
		   	
		}
		#echo "Anzahl: ",$gs;
	  	  
	  $Kuerzel="wb";
          }
	  
	  $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.wk_name FROM election.landtagswahlen_2016 as a WHERE a.wk_nr='$wb'";
	  
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
	  if ($hoch_range > 18000 OR $rechts_range > 18000) $zoom=1;
			  else if ($hoch_range > 10000 AND $hoch_range < 17999 OR $rechts_range > 10000 AND $rechts_range < 17999) $zoom=3;
			  else if ($hoch_range > 8000 AND $hoch_range < 9999 OR $rechts_range > 8000 AND $rechts_range < 9999) $zoom=16;
			  else if ($hoch_range > 7000 AND $hoch_range < 8999 OR $rechts_range > 7000 AND $rechts_range < 7999) $zoom=17;
			  else if ($hoch_range > 6000 AND $hoch_range < 6999 OR $rechts_range > 6000 AND $rechts_range < 6999) $zoom=20;
			  else if ($hoch_range > 5000 AND $hoch_range < 5999 OR $rechts_range > 5000 AND $rechts_range < 5999) $zoom=21;
			  else if ($hoch_range > 4000 AND $hoch_range < 4999 OR $rechts_range > 4000 AND $rechts_range < 4999) $zoom=22;
			  else if ($hoch_range > 3000 AND $hoch_range < 3999 OR $rechts_range > 3000 AND $rechts_range < 3999) $zoom=23;
			  else if ($hoch_range > 2000 AND $hoch_range < 2999 OR $rechts_range > 2000 AND $rechts_range < 2999) $zoom=24;
              else $zoom=25;
			  #echo "Zoom: ",$zoom;
	  
	  
	  #echo $lon," ",$lat," ",$hoch_range," ",$rechts_range;
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
			var lon = $lon
			var lat = $lat
			var zoom = $zoom;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:25833',
					scales: [800000,300000,150000,75000,50000,25000,12500,6000,3000,2500,2000,1500,1000,500],					
					maxExtent:  new OpenLayers.Bounds(198843,5885901,466202,6054736),
					units: 'm'
				});				
				
				var orka_mv = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V\",
					 $orka_mv_url,
					{'layers': '$orka_mv_layername', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled(\"topografische Karte\",
					$dtk_url,
					{'layers': 'gdimv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var webatlasde = new OpenLayers.Layer.WMS.Untiled(\"WebatlasDE\",
					$webatlasde_url,
					{'layers': 'WebAtlasDE_MV_farbe', transparent: true, format: 'image/gif'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $dop_url,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var kreisgrenze = new OpenLayers.Layer.WMS.Untiled(\"Kreisgrenze\",
								  $map_msp_url,
								 {layers: 'Kreisgrenze_msp', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var amtsbereiche = new OpenLayers.Layer.WMS.Untiled(\"Amtsbereiche\",
								 $map_msp_url,
								 {layers: 'amtsbereiche_mv', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

                var gemeinden_mv = new OpenLayers.Layer.WMS.Untiled(\"Gemeinden MV\",
								 $map_msp_url,
								 {layers: 'gemeinden_mv', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var landkreise_mv = new OpenLayers.Layer.WMS.Untiled(\"Landkreise MV\",
								 $map_msp_url,
								 {layers: 'landkreise_mv', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var msp_outline_gem = new OpenLayers.Layer.WMS.Untiled(\"Gemeindegrenzen\",
								 $map_msp_url,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var  $get_themenname = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								  $map_msp_url,
								 {layers: '$layername_mapfile', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([orka_mv,webatlasde,dtkmv,dop,kreisgrenze,gemeinden_mv,landkreise_mv,$get_themenname]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [$get_themenname],
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
				//var om = map.getControlsByClass('OpenLayers.Control.OverviewMap')[0];
				//om.maximizeControl();
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:25833'), map.getProjectionObject());
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
										<td height="40" width=350 align="center" valign=top bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Wahlkreis <? echo $wb,"<br><br>",$wk_name;?> <? echo $font_farbe_end ;?></h3>
										</td>
										<td width=30 rowspan="4"></td>
										<td border=0 valign=top align=left rowspan="4" colspan="3" >
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="wahl_2016.php"><? echo $font_farbe ;?>zurück zu allen Wahlkreisen<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr>
									  <td><div align=center>Gemeinden/Stadteile im Wahlkreis <?php echo $wb ?>:<br><br><b><?php echo $wk_name ?></b></div><br><br>
									  <?php 
									     if ($gs > 0) 
										   {
										     for($v=0;$v<$gs;$v++)
										        echo $wb_gemeinde[$v][0]," | ";
										    }
										   ?>
									  </td>
									</tr>
									
									
									
									<tr>										
										<td valign=bottom align=right>
											<table border="0" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE I: </td>
													<td align=right bgcolor=#FF0000 width=30></td>
													
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE II: </td>
													<td align=right bgcolor=#00FF00 width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE III: </td>
													<td align=right bgcolor=#0000FF width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE IV: </td>
													<td align=right bgcolor=#ff9642 width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE V: </td>
													<td align=right bgcolor=#7d14ff width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis NB I: </td>
													<td align=right bgcolor=#00def9 width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis NB II: </td>
													<td align=right bgcolor=#ff0080 width=30></td>
												</tr>
												
												<tr>
													<td align=right><small>Gemeindegrenze: </td>
													<td align=right><img src="images/gemeindegrenze_schwarz.png" width=20></td>
													
												</tr>
                                                <tr>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/kreisgrenze_blau.png" width=20>
												</tr>			
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>									
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?wb=<? echo $wb;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
								</table> <!-- Ende innere Tablle oberer Block -->
							</td>
						</tr>
					</table>	<!-- Ende äußere Tablle oberer Block -->
					
										
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
	
		$query="SELECT COUNT(DISTINCT vorgang_id) AS anzahl FROM veterinary.crisis_area";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
	
	?>
		<?php
		$lon=369208;
		$lat=5941775;
		 
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
			<?
	echo"
			var lon = $lon
			var lat = $lat
			var zoom = 0;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:25833',
					scales: [600000,300000,150000,75000,50000,25000,12500,6000,3000,2500,2000,1500,1000,500],					
					maxExtent:  new OpenLayers.Bounds(198843,5885901,466202,6054736),
					units: 'm'
				});				
				
				var orka_mv = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V\",
					 $orka_mv_url,
					{'layers': '$orka_mv_layername', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled(\"topografische Karte\",
					$dtk_url,
					{'layers': 'gdimv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var webatlasde = new OpenLayers.Layer.WMS.Untiled(\"WebatlasDE\",
					$webatlasde_url,
					{'layers': 'WebAtlasDE_MV_farbe', transparent: true, format: 'image/gif'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $dop_url,
									{'layers': 'adv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var landkreise_mv = new OpenLayers.Layer.WMS.Untiled(\"Landkreise MV\",
								 $map_msp_url,
								 {layers: 'landkreise_mv', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var amtsbereiche = new OpenLayers.Layer.WMS.Untiled(\"Amtsbereiche\",
								 $map_msp_url,
								 {layers: 'amtsbereiche_mv', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

                                var gemeinden_mv = new OpenLayers.Layer.WMS.Untiled(\"Gemeinden MV\",
								 $map_msp_url,
								 {layers: 'gemeinden_mv', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var  $get_themenname = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								  $map_msp_url,
								 {layers: '$layername_mapfile', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([webatlasde,orka_mv,dtkmv,dop,landkreise_mv,gemeinden_mv,$get_themenname]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [$get_themenname],
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
				//var om = map.getControlsByClass('OpenLayers.Control.OverviewMap')[0];
				//om.maximizeControl();
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:25833'), map.getProjectionObject());
				map.setCenter(lonLat,zoom);
			}";
?>
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
							<h3>Wahlkreise<br>Landtagswahl in MV 2016<br>(04.09.2016)</h3>
							
						</td>
						<td rowspan=5 width=30></td>
						<td border=0 align=center rowspan=6 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Wahlkreis ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="wahl_2016.php" method="get" name="vorgang">
								<select name="wb" onchange="document.vorgang.submit();">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT wk_nr,wk_name FROM election.landtagswahlen_2016 ORDER BY wk_name";
									 $result = $dbqueryp($connectp,$query);
									 
									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[wk_nr]\">$r[wk_name]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
					
					<?php
					echo "<tr>
						<td valign=bottom align=\"center\" colspan=2>
						*) <a href=\"metadaten/metadaten.php?Layer_ID=$layerid\" target=\"_blank\" onclick=\"return meta_popup(this.href)\">Info zum Thema $headline</a>
						</td>
						</tr>
						<tr>
						<td align=\"center\" colspan=2>letzte Aktualisierung: <b><i>";
					echo get_aktualitaet($db_link,$layerid);
					echo"</td></tr>";
					?>
					<tr>
									<td valign=bottom align=center>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die<br>webbasierte Karte?<br>(OpenLayers)</a>																
									</td>	
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<table border="0" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE I: </td>
													<td align=right bgcolor=#FF0000 width=30></td>
													
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE II: </td>
													<td align=right bgcolor=#00FF00 width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE III: </td>
													<td align=right bgcolor=#0000FF width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE IV: </td>
													<td align=right bgcolor=#ff9642 width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis MSE V: </td>
													<td align=right bgcolor=#7d14ff width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis NB I: </td>
													<td align=right bgcolor=#00def9 width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Wahlkreis NB II: </td>
													<td align=right bgcolor=#ff0080 width=30></td>
												</tr>
												
												<tr>
													<td align=right><small>Gemeindegrenze: </td>
													<td align=right><img src="images/gemeindegrenze_schwarz.png" width=20></td>
													
												</tr>
                                                <tr>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/kreisgrenze_blau.png" width=20>
												</tr>			
											</table> <!-- Ende der Tabelle für die Legende -->
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
										<a href="gemeinden_msp.php"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
