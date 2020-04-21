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
			var lon = $lon
			var lat = $lat
			var zoom = 30;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:2398',
					scales: [1200000,750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxResolution: 'auto',
					maxExtent:  new OpenLayers.Bounds(4400000,5880000,4660000,6060000),
					units: 'm'					         
				});				
				
				var osm_citymap = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V\",
					 $osm_citymap_url,
					{'layers': 'orkamv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				//var osm_mapink = new OpenLayers.Layer.OSM.Mapink('OpenStreetMap (Mapink)');

				var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $dop_url,
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}									
				);
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled(\"topografische Karte\",
					$dtk_url,
					{'layers': 'mv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var $kuerzel = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								 $themen_map_url,
								 {layers: '$titel', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([dop,osm_citymap,dtkmv,$kuerzel]);

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
				map.addControl(new OpenLayers.Control.ScaleLine());
				var om = map.getControlsByClass('OpenLayers.Control.OverviewMap')[0];
				om.maximizeControl();
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:2398'), map.getProjectionObject());
				map.setCenter(lonLat,zoom);
			}";
?>