<?
    if (isset($special_service))
       {
	     $themen_map_url='"'.$special_service.'"';
		 $featureinfo_msp_url='..'.$special_service;
	    }
	     else 
		{
		 $themen_map_url=$map_msp_url;
		}

	echo"
			var lon   = $lon;
			var lat   = $lat;
			var lonc  = $rcenter;
			var latc  = $hcenter;
             "
?>
<?php
              if ($hoch_range > 3000 OR $rechts_range > 3000) $zoom=20;
			  else if ($hoch_range > 2500 AND $hoch_range < 2999 OR $rechts_range > 2500 AND $rechts_range < 2999) $zoom=21;
			  else if ($hoch_range > 1800 AND $hoch_range < 2499 OR $rechts_range > 1800 AND $rechts_range < 2499) $zoom=22;
			  else if ($hoch_range > 1400 AND $hoch_range < 1799 OR $rechts_range > 1400 AND $rechts_range < 1799) $zoom=23;
			  else if ($hoch_range > 1000 AND $hoch_range < 1399 OR $rechts_range > 1000 AND $rechts_range < 1399) $zoom=24;
			  else if ($hoch_range > 800 AND $hoch_range < 999 OR $rechts_range > 800 AND $rechts_range < 999) $zoom=25;
			  else if ($hoch_range > 600 AND $hoch_range < 799 OR $rechts_range > 600 AND $rechts_range < 799) $zoom=26;
			  else if ($hoch_range > 400 AND $hoch_range < 599 OR $rechts_range > 400 AND $rechts_range < 599) $zoom=27;
			  else if ($hoch_range > 200 AND $hoch_range < 399 OR $rechts_range > 200 AND $rechts_range < 399) $zoom=28;
			  else if ($hoch_range > 0 AND $hoch_range < 199 OR $rechts_range > 0 AND $rechts_range < 199) $zoom=30;
              else $zoom=31;
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
					{'layers': 'orkamv-gesamt', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var webatlasde = new OpenLayers.Layer.WMS.Untiled(\"WebatlasDE\",
					$webatlasde_url,
					{'layers': 'WebAtlasDE_MV_farbe', transparent: true, format: 'image/gif'},
					{isBaseLayer: true}
				);
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled(\"topografische Karte\",
					$dtk_url,
					{'layers': 'mv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $dop_url,
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var msp_outline_gemkg = new OpenLayers.Layer.WMS.Untiled(\"Gemarkungsgrenzen\",
								 $map_msp_url,
								 {layers: 'msp_outline_gemkg', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var msp_gemarkung = new OpenLayers.Layer.WMS.Untiled(\"$gemarkungsname\",
								 $gemarkungmap_url,
								 {layers: '$gemarkung_id', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var  $kuerzel = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								  $themen_map_url,
								 {layers: '$titel', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([osm_citymap,dtkmv,dop,msp_outline_gemkg,$kuerzel]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [$kuerzel],
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