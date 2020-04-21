<!DOCTYPE html>
<html>

<head>
<title> Geoportal 2.0 Admin</title>
<? include('../head.php'); ?>
<?php include ("../include/connect_geobasis_geoportal2.php"); ?>
<link href="style_admin.css" rel="stylesheet">
<meta charset="utf-8"  />
	<style>

	.map {
	height:80%;
	width:100%;
	background-color:#b5d0d0;
	z-index:-1;
	border:0px solid;
	box-shadow:0px 1px 5px 0px rgba(0,0,0,0.15);
}
	</style>


</head>

<body>


<div class="admin-panel" >

<?php include ("navigation.php"); ?>




    <div class="main">
         <div id="tab1">
			<header>
				<h1>Übersicht</h1>
			</header>		
			<p>
			<div class="container">
				 <div id="map" class="map"></div>
    <div id="info">&nbsp;</div>
    <script>
proj4.defs('EPSG:25833', '+proj=utm +zone=33 +ellps=GRS80 +units=m +no_defs');		// EPSG 25833
proj4.defs('EPSG:2398' , '+proj=tmerc +lat_0=0 +lon_0=12 +k=1 +x_0=4500000 +y_0=0 +ellps=bessel +towgs84=24,-123,-94,0.02,-0.25,-0.13,1.1 +units=m +no_defs'); // EPSG 2398
var projection = ol.proj.get('EPSG:25833');
	
	
      var wmsSource1 = 	new ol.source.ImageWMS({
							projection: projection,
                            url: 'https://geoport-lk-mse.de/webservices/kse',
                            params: {	'LAYERS': 'KSE',
										'VERSION': '1.3.0',
										'FORMAT': 'image/png',
										'TILED': true
										},
                            serverType: 'mapserver',
                        });
						
		      var wmsSource = 	new ol.source.ImageWMS({
							projection: projection,
                            url: 'https://www.geoport-lk-mse.de/webservices/alkis07?service=WMS&REQUEST=GetFeatureInfo&VERSION=1.1.1',
                            params: {	'LAYERS': 'Beteiligungen',
										'VERSION': '1.3.0',
										'FORMAT': 'image/png',
										'TILED': true
										},
                            serverType: 'mapserver',
                        });				
	  
                

      var wmsLayer1 = new ol.layer.Image({
        source: wmsSource
      });
	  
	  var wmsLayer = new ol.layer.Image({
        source: wmsSource
      });

      var view = new ol.View({
            center: [370900, 5939000],
			extent: [276396, 5892709, 480000, 6000000],
			resolution:170,
			projection: projection,
      });

      var map = new ol.Map({
        layers: [
		
		new ol.layer.Tile({												// ORKA MV
                        title: 'ORKA MV',
                       // type: 'base'
                        source: new ol.source.XYZ({
						projection: 'EPSG:3857',
						url: 'http://www.orka-mv.de/geodienste/orkamv/tiles/1.0.0/'
						+ 'orkamv/GLOBAL_WEBMERCATOR/{z}/{x}/{y}.png'
                        })
                    }),
		wmsLayer,
		
		
		
		],
        target: 'map',
        view: view,
		projection: projection,
      });

      map.on('singleclick', function(evt) {
        document.getElementById('info').innerHTML = '';
        var viewResolution = /** @type {number} */ (view.getResolution());
        var url = wmsSource.getGetFeatureInfoUrl(
            evt.coordinate, viewResolution, 'EPSG:25833',
            {'INFO_FORMAT': 'text/html'});
        if (url) {
          document.getElementById('info').innerHTML =
              '<embed width="100%" src="' + url + '"></embed>';
        }
      });

    </script>
				

			</div>
			</p>
		</div> 

 
</div>

</body>

</html>