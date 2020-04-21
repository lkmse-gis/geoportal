<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
$text="Verwaltung";

?>
<?php
$lon=4567406;
$lat=5940983;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script language='JavaScript' src='ajax.js'></script>
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
	<style type="text/css">
       #map {
            width: 730px;
            height: 620px;
            border: 1px solid black;
        }
    </style>
	<style type="text/css">
       #layerswitcher {
            width: 120px;
            height: 100%;            
        }
    </style>
<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
    <link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
<script type="text/javascript" language="Javascript">
	var lon   = <?php echo $lon; ?>;
	var lat   = <?php echo $lat; ?>;
	var zoom  = 6;

    var map, info, measureControls;

    function load() {
        map = new OpenLayers.Map({
            div: "map",
            projection: "EPSG:2398",
			scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
			maxResolution: "auto",
      		maxExtent:  new OpenLayers.Bounds(4400000,5880000,4660000,6060000),
      		units: 'm'
        });
		
		var amtssitz = new OpenLayers.Layer.WMS.Untiled("Amtssitze",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Amtsverwaltungen', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false, visibility: false}
				);
				
		var amt_outline = new OpenLayers.Layer.WMS.Untiled("Amtsbereiche",
								 <? echo $map_msp_url;?>,
								 {layers: 'aemter_msp_outline', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);	
		
		var apotheken = new OpenLayers.Layer.WMS.Untiled("Apotheken",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Apotheken', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var arbeitsamt = new OpenLayers.Layer.WMS.Untiled("Arbeitsagenturen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Arbeitsagenturen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
				
		var bioenergie = new OpenLayers.Layer.WMS.Untiled("Bioenergieanlagen",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Bioenergieanlagen', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false, visibility: false}
				);
		
		var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
								<? echo $dop_url; ?>,
								{'layers': 'adv_dop', transparent: true, format: 'image/png'},
								{isBaseLayer: true}
				);
				
		var dtkmv = new OpenLayers.Layer.WMS.Untiled("topografische Karte",
								<? echo $dtk_url; ?>,
								{'layers': 'gdimv_dtk', transparent: true, format: 'image/png'},
								{isBaseLayer: true}
				);
				
		var ffh_fl = new OpenLayers.Layer.WMS.Untiled("FFH Gebiete",
								 <? echo $map_msp_url;?>,
								 {layers: 'Fauna Flora Habitat Gebiete', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var ffh_pkt = new OpenLayers.Layer.WMS.Untiled("FFH Punkte",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Fauna Flora Habitat (Punkte)', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var finanzamt = new OpenLayers.Layer.WMS.Untiled("Finanzämter",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Finanzaemter', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var geotop_fl = new OpenLayers.Layer.WMS.Untiled("Geotope",
								 <? echo $map_msp_url;?>,
								 {layers: 'Geotope', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var geotop_pkt = new OpenLayers.Layer.WMS.Untiled("Geotope Punkte",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Geotope (Punkte)', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var gemarkungen = new OpenLayers.Layer.WMS.Untiled("Gemarkungen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'msp_outline_gemkg', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var gemeinden_msp = new OpenLayers.Layer.WMS.Untiled("Gemeinden",
								 <? echo $map_msp_url;?>,
								 {layers: 'gemeinden_msp', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);				
				
		var gerichte = new OpenLayers.Layer.WMS.Untiled("Gerichte",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Gerichte', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var jcenter = new OpenLayers.Layer.WMS.Untiled("Jobcenter",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Jobcenter', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
				
		var kirchen = new OpenLayers.Layer.WMS.Untiled("Kirchen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Kirchen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var kliniken = new OpenLayers.Layer.WMS.Untiled("Krankenhäuser",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Kliniken', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var kreisgrenze = new OpenLayers.Layer.WMS.Untiled("Kreisgrenze",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Kreisgrenze_msp', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false}
				);	
				
		var kreissitz = new OpenLayers.Layer.WMS.Untiled("Regionalstandorte",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Kreisverwaltungen', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false, visibility: false}
				);
				
		var kunst_offen = new OpenLayers.Layer.WMS.Untiled("KUNST offen",
						 <? echo $map_msp_url; ?>,
						 {layers: 'kunst_offen', transparent: true, format: 'image/png'},
						 {isBaseLayer: false, visibility: false}
				);
				
		var lsg = new OpenLayers.Layer.WMS.Untiled("LSG",
								 <? echo $map_msp_url;?>,
								 {layers: 'Landschaftsschutzgebiete', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var nlp = new OpenLayers.Layer.WMS.Untiled("Nationalparke",
								 <? echo $map_msp_url;?>,
								 {layers: 'Nationalparke', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
				
		var notare = new OpenLayers.Layer.WMS.Untiled("Notare",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Notare', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var npa = new OpenLayers.Layer.WMS.Untiled("Naturparke",
								 <? echo $map_msp_url;?>,
								 {layers: 'Naturparke', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var nsg = new OpenLayers.Layer.WMS.Untiled("NSG",
								 <? echo $map_msp_url;?>,
								 {layers: 'Naturschutzgebiete', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var naturwald = new OpenLayers.Layer.WMS.Untiled("Naturwälder",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Naturwald', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var osm_citymap = new OpenLayers.Layer.WMS.Untiled("OSM Stadtplan",
								<? echo $osm_citymap_url; ?>,
								{'layers': 'stadtplan', transparent: true, format: 'image/png'},
								{isBaseLayer: true}
				);
		
		var plz = new OpenLayers.Layer.WMS.Untiled("PLZ Bereiche",
								 <? echo $map_msp_url;?>,
								 {layers: 'Postleitzahlbereiche', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var polizei = new OpenLayers.Layer.WMS.Untiled("Polizei",
								 <? echo $map_msp_url;?>,
								 {layers: 'Polizeidienststellen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
				
		var regionen = new OpenLayers.Layer.WMS.Untiled("Regionen",
								 <? echo $map_msp_url;?>,
								 {layers: 'Regionen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var sba = new OpenLayers.Layer.WMS.Untiled("Straßenbauämter",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Strassenbauamt', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var sbab = new OpenLayers.Layer.WMS.Untiled("SBA Bereiche",
								 <? echo $map_msp_url;?>,
								 {layers: 'Strassenbauamtsbereiche', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var schablone = new OpenLayers.Layer.WMS.Untiled("Schablone",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'lk_schablone', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false}
				);
				
		var schulen = new OpenLayers.Layer.WMS.Untiled("Schulen",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Schulen', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var sm = new OpenLayers.Layer.WMS.Untiled("Straßenmeisterei",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Strassenmeisterei', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var smb = new OpenLayers.Layer.WMS.Untiled("SM Bereiche",
								 <? echo $map_msp_url;?>,
								 {layers: 'Strassenmeistereibereiche', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
				
		var solar = new OpenLayers.Layer.WMS.Untiled("Solaranlagen",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Solaranlagen', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false, visibility: false}
				);
		
		var spa_fl = new OpenLayers.Layer.WMS.Untiled("SPA Gebiete",
								 <? echo $map_msp_url;?>,
								 {layers: 'Vogelschutzgebiete', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
		
		var spa_pkt = new OpenLayers.Layer.WMS.Untiled("SPA Punkte",
								 <? echo $map_msp_url; ?>,
								 {layers: 'Horststandorte', transparent: true, format: 'image/png'},
								 {isBaseLayer: false, visibility: false}
				);
				
		var tankstellen = new OpenLayers.Layer.WMS.Untiled("Tankstellen",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Tankstellen', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false, visibility: false}
				);
		
		var topomv = new OpenLayers.Layer.WMS.Untiled("Übersichtskarte",
					<? echo $topo_url; ?>,
					{'layers': 'gdimv_topomv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);

        map.addLayers([osm_citymap,
						dtkmv,
						topomv,
						dop,
						schablone,
						kreisgrenze,
						amtssitz,
						apotheken,
						arbeitsamt,
						bioenergie,
						ffh_pkt,
						finanzamt,
						geotop_pkt,
						gerichte,
						jcenter,
						kirchen,
						kliniken,						
						notare,
						polizei,
						kreissitz,
						schulen,
						solar,
						spa_pkt,						
						sba,
						sm,
						tankstellen,
						amt_outline,
						gemeinden_msp,
						ffh_fl,
						gemarkungen,
						geotop_fl,
						lsg,
						nlp,
						npa,
						nsg,
						naturwald,
						plz,
						regionen,						
						sbab,
						smb,
						spa_fl
						]);

        info = new OpenLayers.Control.WMSGetFeatureInfo({
			layers: [apotheken,arbeitsamt,bioenergie,ffh_pkt,finanzamt,geotop_pkt,gerichte,jcenter,kirchen,kliniken,notare,polizei,amtssitz,kreissitz,schulen,solar,spa_pkt,tankstellen,sba,sm,gemeinden_msp,amt_outline,ffh_fl,gemarkungen,geotop_fl,lsg,nlp,npa,nsg,naturwald,plz,regionen,sbab,smb,spa_fl],
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

        map.addControl(new OpenLayers.Control.LayerSwitcher({'div':OpenLayers.Util.getElement('layerswitcher'),roundedCorner:false}));
		map.addControl(new OpenLayers.Control.Permalink());
		map.addControl(new OpenLayers.Control.MousePosition());
		var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:2398"), map.getProjectionObject());
		map.setCenter(lonLat,zoom);
    
		var sketchSymbolizers = {
					"Point": {
						pointRadius: 4,
						graphicName: "square",
						fillColor: "white",
						fillOpacity: 1,
						strokeWidth: 1,
						strokeOpacity: 1,
						strokeColor: "#333333"
					},
					"Line": {
						strokeWidth: 3,
						strokeOpacity: 1,
						strokeColor: "#666666",
						strokeDashstyle: "dash"
					},
					"Polygon": {
						strokeWidth: 2,
						strokeOpacity: 1,
						strokeColor: "#666666",
						fillColor: "white",
						fillOpacity: 0.3
					}
				};
				var style = new OpenLayers.Style();
				style.addRules([
					new OpenLayers.Rule({symbolizer: sketchSymbolizers})
				]);
				var styleMap = new OpenLayers.StyleMap({"default": style});
				
				measureControls = {
					line: new OpenLayers.Control.Measure(
						OpenLayers.Handler.Path, {
							persist: true,
							handlerOptions: {
								layerOptions: {styleMap: styleMap}
							}
						}
					),
					polygon: new OpenLayers.Control.Measure(
						OpenLayers.Handler.Polygon, {
							persist: true,
							handlerOptions: {
								layerOptions: {styleMap: styleMap}
							}
						}
					)
				};
				
				var control;
				for(var key in measureControls) {
					control = measureControls[key];
					control.events.on({
						"measure": handleMeasurements,
						"measurepartial": handleMeasurements
					});
					map.addControl(control);
				}            
				document.getElementById('noneToggle').checked = true;
	}
	
	function handleMeasurements(event) {
            var geometry = event.geometry;
            var units = event.units;
            var order = event.order;
            var measure = event.measure;
            var element = document.getElementById('output');
            var out = "";
            if(order == 1) {
                out += "<b>Strecke: " + measure.toFixed(3) + " " + units + "</b>";
            } else {
                out += "<b>Fläche: " + measure.toFixed(3) + " " + units + "<sup>2</" + "sup></b>";
            }
            element.innerHTML = out;
        }

        function toggleControl(element) {
            for(key in measureControls) {
                var control = measureControls[key];
                if(element.value == key && element.checked) {
                    control.activate();
                } else {
                    control.deactivate();
                }
            }
        }
        
        function toggleGeodesic(element) {
            for(key in measureControls) {
                var control = measureControls[key];
                control.geodesic = element.checked;
            }
        }
        
        function toggleImmediate(element) {
            for(key in measureControls) {
                var control = measureControls[key];
                control.setImmediate(element.checked);
            }
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
				<td valign="top" height=650>
					<div style="margin:1px" id="map"></div><small><? echo $cr; ?>|&nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
				</td>
				<td valign=top align=center rowspan=4 width=150>
					<table border=0>
						<tr>
							<td align=center width=80 height=115 bgcolor=<? echo $header_farbe ?>>								
								<font size="-2" color=white>Basis<br>Themen</font>								
							</td>
						</tr>
						<tr>
							<td align=center height=382 bgcolor=<? echo $element_farbe ?>>								
								<font size="-2">Punkt<br>Themen</font>				
							</td>
						</tr>
						<tr>
							<td align=center height=280 bgcolor=<? echo $header_farbe ?>>								
								<font size="-2" color=white>Fl&auml;chen<br>Themen</font>							
							</td>
						</tr>						
					</table>
				</td>
				<td border=0 valign="top" align=left rowspan=4>					
					<div style="font-family:Arial; font-size: 7pt; font-weight: bold" id="layerswitcher"></div>
				</td>
			</tr>
			<tr>
				<td>
					<div id="output"></div>
				</td>
			</tr>
			<tr>
				<td valign=top>
					<div id="options">					
							<input type="radio" name="type" value="none" id="noneToggle"
							onclick="toggleControl(this);" checked="checked" />
							<label for="noneToggle">Navigieren</label>
							<input type="radio" name="type" value="line" id="lineToggle" onclick="toggleControl(this);" />
							<label for="lineToggle">Streckenmessung</label>								
							<input type="radio" name="type" value="polygon" id="polygonToggle" onclick="toggleControl(this);" />
							<label for="polygonToggle">Fläche messen</label>	
					</div>
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
