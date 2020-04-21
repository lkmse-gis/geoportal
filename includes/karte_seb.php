<?
	$klammern=array("(",")");
	 $box = str_replace($klammern,"",$box);
	 
	 $boxkoordinaten=explode(',',$box);
	 $left=$boxkoordinaten[2];
	 $bottom=$boxkoordinaten[3];
	 $right=$boxkoordinaten[0];
	 $top=$boxkoordinaten[1];
	 $boxextent=$left.",".$bottom.",".$right.",".$top;
	 echo"
			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:25833',
					scales: [750000,650000,550000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxExtent:  new OpenLayers.Bounds(312879,5890347,418388,5990994),
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
				
				var msp_gemeinde = new OpenLayers.Layer.WMS.Untiled(\"$gemeindename\",
								 $gemeindemap_url,
								 {layers: '$gemeinde_id', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);

				var  thema = new OpenLayers.Layer.WMS.Untiled(\"$titel\",
								  $map_msp_url,
								 {layers: '$layername_mapfile', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var  umringe = new OpenLayers.Layer.WMS.Untiled(\"SEB-Umringe\",
								  $map_msp_url,
								 {layers: '$layername_mapfile_umringe', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var  schulen = new OpenLayers.Layer.WMS.Untiled(\"$v_schultyp_name\",
								  $map_msp_url,
								 {layers: '$schullayer_karte', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var  ortsteile = new OpenLayers.Layer.WMS.Untiled(\"Ortsteile_lt_rka\",
								  $map_msp_url,
								 {layers: 'Ortsteile_seb', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
								
				map.addLayers([orka_mv,webatlasde,dtkmv,dop,thema,umringe,ortsteile,schulen]);

				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [thema,schulen],
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
				var extent = new OpenLayers.Bounds($boxextent);
				map.zoomToExtent(extent,true);
			}";
?>