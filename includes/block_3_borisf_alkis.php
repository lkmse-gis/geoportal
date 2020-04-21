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
<?
              if ($hoch_range > 2000 OR $rechts_range > 2000) $zoom=24;
			  else if ($hoch_range > 750 AND $hoch_range < 2000 OR $rechts_range > 750 AND $rechts_range < 2000) $zoom=25;
			  else if ($hoch_range > 500 AND $hoch_range < 750 OR $rechts_range > 500 AND $rechts_range < 750) $zoom=26;
			  else if ($hoch_range > 400 AND $hoch_range < 500 OR $rechts_range > 400 AND $rechts_range < 500) $zoom=27;
              else $zoom=28;
?>
<?
	echo"
			var zoom  = $zoom;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:25833',
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxExtent:  new OpenLayers.Bounds(198843,5885901,466202,6054736),
					units: 'm'
				});				
				
				var osm_citymap = new OpenLayers.Layer.WMS.Untiled(\"ORKa MV\",
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
				
				var  adressen = new OpenLayers.Layer.WMS.Untiled(\"Adressen\",
								  $map_msp_url,
								 {layers: 'Adress_Geometrie', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				

				
				map.addLayers([webatlasde,osm_citymap,dtkmv,dop,msp_outline_gemkg,$kuerzel,adressen]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [$kuerzel,adressen],
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
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:2398'), map.getProjectionObject());
				map.setCenter(lonLat,zoom);
			}";
?>