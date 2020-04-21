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
              if ($hoch_range > 18000 OR $rechts_range > 18000) $zoom=12;
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
					projection: 'EPSG:25833',
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxExtent:  new OpenLayers.Bounds(198843,5885901,466202,6054736),
					units: 'm'
				});				
				
				var orka_mv = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V\",
					 $orka_mv_url,
					{'layers': '$orka_mv_layername', transparent: true, format: 'image/png'},
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
				
				var msp_outline_gem = new OpenLayers.Layer.WMS.Untiled(\"Gemeindegrenzen\",
								 $map_msp_url,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var msp_gemeinde = new OpenLayers.Layer.WMS.Untiled(\"$gemeindename\",
								 $gemeindemap_url,
								 {layers: '$gemeinde_id', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var  thema = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								  $themen_map_url,
								 {layers: '$layername_mapfile', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var  schulen = new OpenLayers.Layer.WMS.Untiled(\"$v_schultyp_name\",
								  $map_msp_url,
								 {layers: 'schulen_2016_gs', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
								
				map.addLayers([orka_mv,webatlasde,dtkmv,dop,msp_gemeinde,msp_outline_gem,thema,schulen]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [thema],
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