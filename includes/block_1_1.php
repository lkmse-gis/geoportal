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
					{'layers': 'mv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var webatlasde = new OpenLayers.Layer.WMS.Untiled(\"WebatlasDE\",
					$webatlasde_url,
					{'layers': 'WebAtlasDE_MV_farbe', transparent: true, format: 'image/gif'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $dop_url,
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var kreisgrenze = new OpenLayers.Layer.WMS.Untiled(\"Kreisgrenze\",
								  $map_msp_url,
								 {layers: 'Kreisgrenze_msp', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var  $get_themenname = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								  $themen_map_url,
								 {layers: '$layername_mapfile', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([orka_mv,webatlasde,dtkmv,dop,kreisgrenze,$get_themenname]);

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