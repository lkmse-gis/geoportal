<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
					
					
						


					<script >
						proj4.defs("EPSG:25833","+proj=utm +zone=33 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
						proj4.defs('EPSG:2398' , '+proj=tmerc +lat_0=0 +lon_0=12 +k=1 +x_0=4500000 +y_0=0 +ellps=bessel +towgs84=24,-123,-94,0.02,-0.25,-0.13,1.1 +units=m +no_defs'); // EPSG 2398
						var projection25833 = ol.proj.get("EPSG:25833");
					  
						//ORKA MV
						var orka_mv = new ol.layer.Tile({
							title:'ORKA MV',
							visible:<?php echo $orka; ?>,
							type: 'base',
							source: new ol.source.WMTS({
							projection: projection25833,
							url: 'https://www.orka-mv.de/geodienste/orkamv/wmts/'
									+ 'orkamv/{TileMatrixSet}/{TileMatrix}/{TileCol}/{TileRow}.png',
							layer: 'orkamv',
							matrixSet: 'epsg_25833_adv',
							format: 'image/png',
							requestEncoding: 'REST',
							tileGrid: new ol.tilegrid.WMTS({
							origin: [-464849.38, 6310160.14],
							resolutions: [4891.96981025, 2445.98490513, 1222.99245256, 611.496226281,
							305.748113141, 152.87405657, 76.4370282852, 38.2185141426, 19.1092570713,
							9.5546285356, 4.7773142678, 2.3886571339, 1.194328567, 0.5971642835,
							0.2985821417],
							matrixIds: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
							})
						})
					});
						
						//Open Street Map Daten
						var osm = new ol.layer.Tile({												
							title: 'OSM',
							type: 'base',
							visible: <?php echo $osm; ?>,
							source: new ol.source.OSM()						
						});
						
						//DOP40
						
						var wmsDOP20 = new ol.source.TileWMS({
								
								url: 'https://geoport-lk-mse.de/webservices/mse_all',
								params: {	'LAYERS': 'DOP20',
											'VERSION': '1.1.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							});
							
							var DOP20 = new ol.layer.Tile({	
							title: 'DOP20',
							visible:<?php echo $dop20; ?>,
							type: 'base',
							source: wmsDOP20,
							projection: projection25833,
						});	
						
						//Kreisgrenze
						
						var wmsKreisgrenze = new ol.source.ImageWMS({
								
								url: 'https://geoport-lk-mse.de/webservices/mse_all',
								params: {	'LAYERS': 'Kreisgrenze_msp',
											'VERSION': '1.3.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							});
							
							var kreisgrenze = new ol.layer.Image({	
							title: 'Kreisgrenze',
							source: wmsKreisgrenze,
							projection: projection25833,
						});						
						
						//Ämter

						var wmsAemter = new ol.source.ImageWMS({
								
								url: 'https://geoport-lk-mse.de/webservices/mse_all',
								params: {	'LAYERS': 'aemter_msp_outline',
											'VERSION': '1.3.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							});
							
							var Aemter = new ol.layer.Image({	
							title: 'Ämter',
							visible:false,
							source: wmsAemter,
							projection: projection25833,
						});
						
						//Gemeinden

						var wmsGemeinden = new ol.source.ImageWMS({
								
								url: 'https://geoport-lk-mse.de/webservices/mse_all',
								params: {	'LAYERS': 'msp_outline_gem',
											'VERSION': '1.3.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							});
							
							var Gemeinden = new ol.layer.Image({	
							title: 'Gemeinden',
							visible:<?php echo $gemeinden; ?>,
							source: wmsGemeinden,
							projection: projection25833,
						});
						
						//Thema

						var wmsthema = new ol.source.ImageWMS({
								
								url: '<? echo $themaWMS; ?>',
								params: {	'LAYERS': '<? echo $layer ?>',
											'VERSION': '1.3.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							});
							
							var thema = new ol.layer.Image({	
							title: '<? echo $thema; ?>',
							source: wmsthema,
							projection: projection25833,
						});
							
						
						var base_group = new ol.layer.Group({ 
                 			title: 'Basiskarten',
							layers: [DOP20,orka_mv, osm]
						});
							
						var overlay_group = new ol.layer.Group({ 
                 			title: 'Fachdaten',
							layers: [thema,Gemeinden,Aemter,kreisgrenze]
						});
						
						var mousePositionControl = new ol.control.MousePosition({
							coordinateFormat: ol.coordinate.createStringXY(5),
							projection: 'EPSG:4326',	
							// comment the following two lines to have the mouse position
							// be placed within the map.
							className: 'custom-mouse-position',
							target: document.getElementById('mouse-position'),
							undefinedHTML: '&nbsp;'
						});	
					  
						var extent=[318747.977431669, 5852265.44320622, 420431.006675548, 6026285.70868656]; // 318747.977431669, 5852265.44320622, 420431.006675548, 6026285.70868656
						
					  
						var myView = new ol.View({
							projection: projection25833,
							extent: extent,
							center: [<?php echo $zentrum2; ?>],
							resolution: <?php echo $resolution; ?>,
							zoom: 0							
						});
						
						
					  
						var map = new ol.Map({
							controls: ol.control.defaults({
								attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
									collapsible: true
								})
							}).extend([mousePositionControl,new ol.control.FullScreen()]),
							layers: [base_group,overlay_group],
							target: 'map',
							view: myView,
							renderer:'canvas',
							projection: projection25833,							
						});

						var projectionSelect = document.getElementById('projection');
							projectionSelect.addEventListener('change', function(event) {
							mousePositionControl.setProjection(ol.proj.get(event.target.value));
						});
						
						map.on('singleclick', function(evt) {
							document.getElementById('info').innerHTML = '';
							var viewResolution = /** @type {number} */ (myView.getResolution());
							var url = wmsthema.getGetFeatureInfoUrl(
								evt.coordinate, viewResolution, projection25833,
								{'INFO_FORMAT': 'text/html'});
							if (url ) {
							document.getElementById('info').innerHTML =
								
										'<embed  width="100%" height="250px" src="' + url + '" ></embed>'
										$("#myModal").modal('show');
							}
						});

						/////////////////////////////////////////////// verursacht Security Error
						// map.on('pointermove', function(evt) {
						  // if (evt.dragging) {
							// return;
						  // }
						  // var pixel = map.getEventPixel(evt.originalEvent);
						  // var hit = map.forEachLayerAtPixel(pixel, function(layer) {
							// return true;
						  // });
						  // map.getTargetElement().style.cursor = hit ? 'pointer' : '';
						// });
						
						var layerSwitcher = new ol.control.LayerSwitcher({ 
								tipLabel: 'Legende' // Optional label for button 
							});
						
						
						 var attribution = new ol.control.Attribution({
							collapsible: true
						});
						
						
						$('.ol-zoom-in, .ol-zoom-out').tooltip({
							placement: 'right'
						});
						
						$('.ol-rotate-reset, .ol-attribution button[title]').tooltip({
							placement: 'left'
						});

						
						
						
						map.addControl(layerSwitcher);
						//map.getView().fitExtent(extent, map.getSize());
					</script>			  		  


		
</body>
</html>