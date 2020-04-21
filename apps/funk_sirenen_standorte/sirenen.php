<!doctype html>

<HTML>

<HEAD>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>	
	
		<!-- Latest compiled and minified JavaScript -->
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://openlayers.org/en/v3.20.1/build/ol.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.14/proj4.js"></script>
	<script src="ol3-layerswitcher-master/src/ol3-layerswitcher.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet">
	<link rel="stylesheet" href="ol3-layerswitcher-master/src/ol3-layerswitcher.css" />
	<link rel="stylesheet" href="https://openlayers.org/en/v3.20.1/css/ol.css" type="text/css">
	

	
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
	</script>




<script>
//Variables
var overlay = $("#overlay"),
        fab = $(".fab"),
     cancel = $("#cancel"),
     submit = $("#submit");

//fab click
fab.on('click', openFAB);
overlay.on('click', closeFAB);
cancel.on('click', closeFAB);

function openFAB(event) {
  if (event) event.preventDefault();
  fab.addClass('active');
  overlay.addClass('dark-overlay');

}

function closeFAB(event) {
  if (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
  }

  fab.removeClass('active');
  overlay.removeClass('dark-overlay');
  
}
</script>
<script>
$(document).ready(function(){
	
 	$("body").on("click","#btn",function(){
  	  	
    	$("#myModal").modal("show");
        
    	$(".blue").addClass("after_modal_appended");
    
    	//appending modal background inside the blue div
    	$('.modal-backdrop').appendTo('.blue');   
    
    	//remove the padding right and modal-open class from the body tag which bootstrap adds when a modal is shown
    
    	$('body').removeClass("modal-open")
   	 	$('body').css("padding-right","");     
  });

});
</script>

<?php include("connect_geobasis.php"); ?>
<title>Sirenenstandorte MSE</title>
</HEAD>

<BODY>



<header>						

<div class="conatiner">
<nav class="navbar navbar-default">
   <div class="container-fluid">
     <div class="navbar-header">
       <h3>Sirenenstandorte <small>im Landkreis Mecklenburgische Seenplatte</small></h3>
     </div>
	 <ul class="nav navbar-nav navbar-right">
		<li><img src="logo_landkreis-mecklenburgische-seenplatte.png" style="width:150px;margin-top:10px;margin-right:20px;"></li>
    </ul>
   </div>
</nav>
</div>
<div class="kopf1"></div>
<div class="kopf"></div>
</header>

		<div class="container" >
			<div class="row">
				<div id="sonstwas">
 							<div id="myModal" class="modal fade" role="dialog">
						
						<div class="modal-dialog">
							
							<!-- Modal content-->
							<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="kopf" style="margin-top:0px;" ></div>
							<div class="modal-body">
							
								<div id="info"></div>
							</div>
							<!--<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
							</div>-->
							</div>
						
						</div>
						</div>
					<script src="module/ol3-layerswitcher-master/src/ol3-layerswitcher.js"></script>		
					<link rel="stylesheet" href="module/ol3-layerswitcher-master/src/ol3-layerswitcher.css" />		
							<div id="map" class="map"></div>
							
							
								<form>
									<div class="col-md-6"><p>	
										<label>Projektion: </label>
										<select id="projection" class="form-control select select-primary">
											<option value="EPSG:4326">"WGS84" (EPSG:4326)</option>									
											<option value="projection25833">"ETRS89 ohne führende UTM Zone" (EPSG:25833)</option>									
										</select></p>
									</div>						
									<div class="col-md-6">
										<label>Maus-Position: </label>
										<span class="form-control select select-primary">
											<div id="mouse-position"></div>
										</span>
									</div>
								</form>					
							

					<script >
						proj4.defs("EPSG:25833","+proj=utm +zone=33 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
						proj4.defs('EPSG:2398' , '+proj=tmerc +lat_0=0 +lon_0=12 +k=1 +x_0=4500000 +y_0=0 +ellps=bessel +towgs84=24,-123,-94,0.02,-0.25,-0.13,1.1 +units=m +no_defs'); // EPSG 2398
						var projection25833 = ol.proj.get("EPSG:25833");
					  
						//ORKA MV
						var orka_mv = new ol.layer.Tile({
							title:'ORKA MV',
							visible:true,
							type: 'base',
							opacity:0.7,
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
							visible: false,
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
							visible:true,
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
							visible:true,
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
							visible:true,
							source: wmsGemeinden,
							projection: projection25833,
						});
						
						//Thema

						var wmsSirenen = new ol.source.ImageWMS({
								
								url: 'https://geoport-lk-mse.de/webservices/wms/sirenenstandorte_wms',
								params: {	'LAYERS': 'Sirenenstandorte',
											'VERSION': '1.3.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							});
							
							var sirenen = new ol.layer.Image({	
							title: 'Sirenenstandorte',
							source: wmsSirenen,
							projection: projection25833,
						});	

						var wmsSchablone = new ol.source.ImageWMS({
								
								url: 'https://geoport-lk-mse.de/webservices/mse_all',
								params: {	'LAYERS': 'lk_schablone_geoport_2',
											'VERSION': '1.3.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							});
							
							var schablone = new ol.layer.Image({	
							title: 'Schablone',
							source: wmsSchablone,
							projection: projection25833,
							visible: true,
						});
							
						
						var base_group = new ol.layer.Group({ 
                 			title: 'Basiskarten',
							layers: [DOP20,orka_mv, osm]
						});
							
						var overlay_group = new ol.layer.Group({ 
                 			title: 'Fachdaten',
							layers: [Aemter,kreisgrenze,schablone,sirenen]
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
					  
						var extent=[318747.977431669, 5852265.44320622, 420431.006675548, 6006285.70868656]; // 318747.977431669, 5852265.44320622, 420431.006675548, 6026285.70868656
						
					  
						var myView = new ol.View({
							projection: projection25833,
							extent: extent,
							center: [370900, 5939000],
							resolution: 155,
							zoom: 0,
							minZoom: 10
						});
						
						
					  
						var map = new ol.Map({
							controls: ol.control.defaults({
								attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
									collapsible: true
								})
							}).extend([mousePositionControl]),
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
							var url = wmsSirenen.getGetFeatureInfoUrl(
								evt.coordinate, viewResolution, projection25833,
								{'INFO_FORMAT': 'text/html'});
							if (url ) {
							document.getElementById('info').innerHTML =
								
										'<br><embed  width="100%" height="290px" src="' + url + '" ></embed>'
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
						

						
						
						 var attribution = new ol.control.Attribution({
							collapsible: true
						});
						
						
						$('.ol-zoom-in, .ol-zoom-out').tooltip({
							placement: 'right'
						});
						
						$('.ol-rotate-reset, .ol-attribution button[title]').tooltip({
							placement: 'left'
						});

						
						
						
						//map.addControl(layerSwitcher);
						//map.getView().fitExtent(extent, map.getSize());
					</script>		

					</div>
					</div>
					</div>




</BODY>

</HTML>