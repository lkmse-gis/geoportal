<?
	include ("include/connect_geobasis_geoportal2.php");


	$ip=getenv('REMOTE_ADDR');
	$ip_array=explode(".",$ip);
		
	$query="SELECT box(st_transform(the_geom,2398)) as box, box(st_transform(the_geom,25833)) as etrsbox, area(st_transform(the_geom,2398)) as area, st_perimeter(st_transform(the_geom,2398)) as umfang, astext(st_transform(st_centroid(the_geom), 4326)) as geo, astext(st_transform(st_centroid(the_geom), 25833)) as etrs FROM fd_kreis WHERE 1=1"; 
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $etrs = $r[etrs];							//ETRS89 Koordinaten ermitteln (Polygonschwerpunkt)
	  $etrs2 = trim($etrs,"POINT(");
	  $etrs3 = trim($etrs2,")");
	  $etrs4 = explode(" ",$etrs3);
	  $etrs_lon = substr($etrs4[0],0,7);
	  $etrs_lat = substr($etrs4[1],0,7);
	  $geo = $r[geo];							//geografische Koordinaten ermitteln (Polygonschwerpunkt)
	  $geo2 = trim($geo,"POINT(");
	  $geo3 = trim($geo2,")");
	  $geo4 = explode(" ",$geo3);
	  $geo_lon = substr($geo4[0],0,7);
	  $geo_grad = substr($geo4[0],0,2);
	  $geo_minute_berechnung = $geo_lon-$geo_grad;
	  $geo_minute_berechnung1 = $geo_minute_berechnung*60;
	  $geo_minute_berechnung2 = explode(".",$geo_minute_berechnung1);
	  $geo_minute = $geo_minute_berechnung2[0];
	  $geo_sekunde_berechnung = $geo_minute_berechnung1-$geo_minute; 
	  $geo_sekunde_berechnung1 = $geo_sekunde_berechnung*60;
	  $geo_sekunde_berechnung2 = explode(".",$geo_sekunde_berechnung1);
	  $geo_sekunde = $geo_sekunde_berechnung2[0];
	  $coord_string_lon=$geo_grad."°&nbsp;". $geo_minute."'&nbsp;". $geo_sekunde."''";
	  $geo_lat = substr($geo4[1],0,7);
	  $geo_grad_lat = substr($geo4[1],0,2);
	  $geo_minute_lat = $geo_lat-$geo_grad_lat;
	  $geo_minute_lat1 = $geo_minute_lat*60;
	  $geo_minute_lat2 = explode(".",$geo_minute_lat1);
	  $geo_minute_lat3 = $geo_minute_lat2[0];
	  $geo_sekunde_lat = $geo_minute_lat1-$geo_minute_lat3;
	  $geo_sekunde_lat1 = $geo_sekunde_lat*60;
	  $geo_sekunde_lat2 = explode(".",$geo_sekunde_lat1);
	  $geo_sekunde_lat3 = $geo_sekunde_lat2[0];
	  $coord_string_lat=$geo_grad_lat."°&nbsp;". $geo_minute_lat3."'&nbsp;". $geo_sekunde_lat3."''";
	  $umfang = $r[umfang];						//Umfang ermitteln
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];
      $umfang4 = $umfang3/1000;
	  $umfang5 = explode(".",$umfang4);
	  $umfang6 = $umfang5[0];
	  $flaeche = $r[area]/1000000;				//Fläche wird geteilt durch 1.000.000 um km² zu ermitteln
	  $flaeche2 = explode(".",$flaeche);		//Fläche wird zerlegt in zwei Arrays
	  $flaeche3 = $flaeche2[0];					//Ausgabe der Fläche ohne Kommastellen
	  $boxstring = $r[etrsbox];						//Ausdehnung ermitteln
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $lur = $koordinaten[0];
	  $lur1 = explode(".",$lur);
	  $lur2 = $lur1[0];
	  $luh = $koordinaten[1];
	  $luh1 = explode(".",$luh);
	  $luh2 = $luh1[0];
	  $ror = $koordinaten[2];
	  $ror1 = explode(".",$ror);
	  $ror2 = $ror1[0];
	  $roh = $koordinaten[3];
	  $roh1 = explode(".",$roh);
	  $roh2 = $roh1[0];
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $rechts = $rechts_range/1000;
	  $rechts1 = explode(".",$rechts);
	  $rechts2 = $rechts1[0];
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	  $hoch = $hoch_range/1000;
	  $hoch1 = explode(".",$hoch);
	  $hoch2 = $hoch1[0];
	  
	  $query="SELECT COUNT(*) AS anzahl FROM gemeinden WHERE kreis_id = 13071;";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_gemeinden = $r[anzahl];
		
	  $query="SELECT COUNT(*) AS anzahl FROM gemarkung WHERE gemeinde LIKE '13071%';";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_gemarkungen = $r[anzahl];
		
	  $query="SELECT COUNT(*) AS anzahl FROM fd_amtsbereiche;";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_aemter = $r[anzahl];		
	  
	  $query="SELECT einwohner, mann, mann_quote, frau, frau_quote, aktualitaet as stand FROM fd_kreis;";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_einwohner = $r[einwohner];
		$mann = $r[mann];
		$frau = $r[frau];
		$mann_quote = $r[mann_quote];
		$frau_quote = $r[frau_quote];		
		$stand = $r[stand];
		
	  $query="SELECT round(SUM(amtlicheflaeche)::numeric/1000000,2) as buchflaeche, round(SUM(st_area(wkb_geometry)::numeric/1000000),2) as geoflaeche
				FROM alkis.ax_flurstueck
				WHERE endet IS NULL;";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$buchflaeche = $r[buchflaeche];
		$geoflaeche = $r[geoflaeche];
?>
<!DOCTYPE html>
<html lang="de">
  <head>
	
	<? include('head.php'); ?>
	
<style class="cp-pen-styles">
.search {
  max-width: 100%;
  position: relative;
  position:center;
  margin-left:auto;
  margin-right:auto;
  box-shadow:0px 1px 5px 0px rgba(0,0,0,0.15);
}
.search:before {
  position: absolute;
  top: 0;
  right: 0;
  width: 50px;
  height: 50px;
  line-height: 40px;
  font-family: 'FontAwesome';
  content: '\f002';
  background: #75b726;
  text-align: center;
  color: #fff;
  border-radius: 0px 5px 5px 0px;
  -webkit-font-smoothing: subpixel-antialiased;
  font-smooth: always;
  border: 5px solid #75b726;
}

.searchTerm {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  width: 100%;
  border: 1px solid lightgrey;
  padding: 5px;
  height: 50px;
  border-radius: 5px;
  outline: none;
  text-align:center;
  font-weight:bold;
}

.searchButton {
  position: absolute;
  top: 0;
  right: 0;
  width: 40px;
  height: 40px;
  opacity: 0;
  cursor: pointer;
}
</style>

  </head>
  <body>
  
	<header >

		<?php include('navbar.php'); ?>
		
		<script>
		 $(function() {
    $('.scroll-down').click (function() {
      $('html, body').animate({scrollTop: $('#factBack').offset().top }, 'slow');
      return false;
    });
  });
  </script>
  

	</header>
<div class="kopf"></div>
	

<section>
		
	
	<div id="content">
		<div class="container" style="width:100%;">
			<div class="row">
		
			<ul class="head">
				<li>
					<div class="blog-card">
					<div class="photo photo1"></div>
			<ul class="details">
				<li class="tags">
					<ul>
						<li>Startet das WebGis kvwmap - Anmeldedaten notwendig</li>
					</ul>
				</li>
			</ul>
	<div class="description">
		<h1>kvwmap</h1>
		<h2>Version 2.6</h2>
		<p class="summary"></p>
		<a href="https://geoport-lk-mse.de/kvwmap" target="_blank" data-toggle="tooltip" data-placement="bottom"> Weiter</a>
	</div>
	</div>
	</li>
	<li>
	<div class="blog-card">
	<div class="photo photo2"></div>
	<ul class="details">
		<li class="tags">
			<ul>
				<li>Startet die freie Version von kvwmap</li>
			</ul>
		</li>
	</ul>
	<div class="description">
		<h1>Bürgerportal</h1>
		<h2>Version 2.6</h2>
		<p class="summary"></p>
		<a href="https://geoport-lk-mse.de/kvwmap/index.php?gast=50" target="_blank" data-toggle="tooltip" data-placement="bottom">Weiter</a>
	</div>
	</div>
	</li>
		<li>
	<div class="blog-card">
	<div class="photo photo3"></div>
	<ul class="details">
		<li class="tags">
			<ul>
				<li>Startet das mobile Kartenportal</li>
			</ul>
		</li>
	</ul>
	<div class="description">
		<h1>Kartenportal</h1>
		<h2>Version</h2>
		<p class="summary"></p>
		<a href="http://geoport-lk-mse.de/mp/portale/start" target="_blank" data-toggle="tooltip" data-placement="bottom">Weiter</a>
	</div>
	</div>
	</li>
		<li>
	<div class="blog-card">
	<div class="photo photo4"></div>
	<ul class="details">
		<li class="tags">
			<ul>
				<li>Flurstücks- nachweise  und Flurkarten käuflich erwerben.</li>
			</ul>
		</li>
	</ul>
	<div class="description">
		<h1>Geoshop</h1>
		<h2>Version</h2>
		<p class="summary"></p>
		<a href="http://geoport-lk-mse.de/geoshop/" target="_blank" data-toggle="tooltip" data-placement="bottom">Weiter</a>
	</div>
	</div>
	</li>
		<li>
	<div class="blog-card">
	<div class="photo photo5"></div>
	<ul class="details">
		<li class="tags">
			<ul>
				<li>Wissensplattform zum Geoportal MSE</li>
			</ul>
		</li>
	</ul>
	<div class="description">
		<h1>GeoWiki</h1>
		<h2>Version</h2>
		<p class="summary" ></p>
		<a href="http://geoport-lk-mse.de/geowiki" target="_blank" data-toggle="tooltip" data-placement="bottom">Weiter</a>
	</div>
	</div>
	</li>
	</ul>
	</div>
</div>

 <div id="sonstwas">
 						<div id="myModal" class="modal fade" role="dialog">
						
						<div class="modal-dialog">
							
							<!-- Modal content-->
							<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Geodaten</h4>
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
							<div id="map" class="map" style="height:500px"></div>
							
							<!--<div class="row">
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
							</div>-->

					<script >
						proj4.defs("EPSG:25833","+proj=utm +zone=33 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
						var projection25833 = ol.proj.get("EPSG:25833");
					  
						//ORKA MV
						var orka_mv = new ol.layer.Tile({
							title:'ORKA MV',
							type: 'base',
							visible: false,
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
							visible: true,
							source: new ol.source.OSM()						
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
							source: wmsAemter,
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
						});
							
						
						var base_group = new ol.layer.Group({ 
                 			title: 'Basiskarten',
							layers: [osm,orka_mv]
						});
							
						var overlay_group = new ol.layer.Group({ 
                 			title: 'Fachdaten',
							layers: [Aemter,kreisgrenze]
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
					  
						var myView = new ol.View({
							projection: projection25833,
							extent: [318747.977431669, 5852265.44320622, 420431.006675548, 6026285.70868656],
							center: [370900, 5939000],
							resolution: 205,
							zoom: 0							
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
							projection: projection25833,							
						});

						// var projectionSelect = document.getElementById('projection');
							// projectionSelect.addEventListener('change', function(event) {
							// mousePositionControl.setProjection(ol.proj.get(event.target.value));
						// });
						
						map.on('singleclick', function(evt) {
							document.getElementById('info').innerHTML = '';
							var viewResolution = /** @type {number} */ (myView.getResolution());
							var url = wmsAemter.getGetFeatureInfoUrl(
								evt.coordinate, viewResolution, projection25833,
								{'INFO_FORMAT': 'text/html'});
							if (url) {
							document.getElementById('info').innerHTML =
								
										'<embed  width="100%" height="250px" src="' + url + '" ></embed>'
										$("#myModal").modal('show');
							}
						});


						// map.on('pointermove', function(evt) {              verursacht security error
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
						map.addControl(layerSwitcher);
					</script>			  
					</div>
					<br>
					<form class="search">
						<input class="searchTerm" placeholder="Thema suchen..." /><input class="searchButton" type="submit" />
					</form>
					  <!--<a href="#"><div class="ca3-scroll-down-link ca3-scroll-down-arrow" data-ca3_iconfont="ETmodules" data-ca3_icon=""></div></a>-->
					<br>
<div class="container">
    <div class="row" id="factBack">
	<h1  style="color:#fff;text-shadow: #000 0px 0px 3px;"> <b>LK Mecklenburgische Seenplatte</b> | in Zahlen und Fakten </h1><br><br>
      <div id="factContainer" class="col-sm-12">
	
        <div class="col-sm-6">

          <div class="col-md-6 factBox blau">
            <blockquote>
              <span class="social">
                                    <a href=""><i class="fa fa-twitter fa-2x"></i></a>
                                    <a href=""><i class="fa fa-facebook fa-2x"></i></a>
                                </span>
              <h5>Kreisschlüssel</h5>

              <h3 class="percent">13 0 71</h3>
              <p>Kreisstruktur: <span class="percentHalf">14</span><strong> Ämter</strong>,<span class="percentHalf">6</span> <strong>Amtsfreie Gemeinden</strong>,<span class="percentHalf"><? echo $count_gemeinden-6; ?></span><strong> Gemeinden</strong>,<span class="percentHalf"><? echo $count_gemarkungen; ?></span><strong> Gemarkungen</strong>. KFZ-Kennzeichen: <strong>DM, MST, MÜR, NB, AT, MC, NZ, RM, WRN, MSE.</strong></p>
            </blockquote>
          </div>

          <div class="clearfix"></div>

          <div class="col-md-6 col-md-offset-6 factBox white">
            <blockquote>
              <span class="social">
                                    <a href=""><i class="fa fa-twitter fa-2x"></i></a>
                                    <a href=""><i class="fa fa-facebook fa-2x"></i></a>
                                </span>
              <h5>Mecklenburg-Vorpommern</h5>
              <h3>Kreisstadt Neubrandenburg</h3>
              <p>Landrat <strong>Herr Heiko K&auml;rger</strong><br>
			  <a href="http://www.lk-mecklenburgische-seenplatte.de" target=blank style="font-size:0.7em;">www.lk-mecklenburgische-seenplatte.de</a></p>
            </blockquote>
          </div>


        </div>

        <div class="col-sm-6">

          <div class="col-md-12 factBox white">
            <blockquote>
              <span class="social">
                                    <a href=""><i class="fa fa-twitter fa-2x"></i></a>
                                    <a href=""><i class="fa fa-facebook fa-2x"></i></a>
                                </span>
              <h5>Zensus <? echo $stand; ?></h5>
              <h3><? echo $count_einwohner;?> Einwohner</h3>
              <p>leben im Landkreis <strong>Mecklenburgische Seenplatte</strong>.
			  <br>
			  <br>
			  <div class="container">
  <div class="row">
    <div class="col-md-2 col-lg-2"></div>
     <div class="col-md-8 col-lg-8">
       
<div class="barWrapper">
 <span class="progressText"><B>Männer</B></span>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="<? echo $mann_quote; ?>" aria-valuemin="0" aria-valuemax="100" >   
        <span class="text"><? echo $mann; ?></span>  <span  class="popOver" data-toggle="tooltip" data-placement="top" title="<? echo $mann_quote; ?>%"> </span>  
</div>
 
</div>

<div class="barWrapper">
 <span class="progressText"><B>Frauen</B></span>
<div class="progress ">
  <div class="progress-bar" role="progressbar" aria-valuenow="<? echo $frau_quote; ?>" aria-valuemin="10" aria-valuemax="100" style="">
     <span class="text"><? echo $frau; ?></span><span  class="popOver" data-toggle="tooltip" data-placement="top" title="<? echo $frau_quote; ?>%"> </span>
  </div>
  
</div>
</div>

</div>
     <div class="col-md-2 col-lg-2"></div>
    </div>
</div>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
<script >$(function () { 
  $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
});  

 
  $(".progress-bar").each(function(){
    each_bar_width = $(this).attr('aria-valuenow');
    $(this).width(each_bar_width + '%');
  });
       

</script>
Dies entspricht einer <strong>Bevölkerungsdichte</strong> von <span class="percentHalf"><?php echo floor($count_einwohner/$buchflaeche); ?> Einw. pro km²</span>
			  </p>
            </blockquote>
          </div>

          <div class="col-md-6 col-md-offset-6 factBox tan">
            <blockquote>
              <span class="social">
                                    <a href=""><i class="fa fa-twitter fa-2x"></i></a>
                                    <a href=""><i class="fa fa-facebook fa-2x"></i></a>
                                </span>
              <h5>amtliche Fläche</h5>
              <h3><? echo $buchflaeche; ?> km²</h3>
              <p>Hierbei beträgt die <strong>geodätische</strong> Fläche<span class="percentHalf"><? echo $geoflaeche ?> km²</span>, mit einer N-S Ausdehnung von <strong><? echo $hoch2 ?> km</strong> und einer O-W Ausdehnung von <strong><? echo $rechts2 ?> km</strong>. Die Grenzlänge umfasst <strong><? echo $umfang6 ?> km</strong>. Der Mittelpunkt (Polygonschwerpunkt) befindet sich in <h4><? echo $coord_string_lon;?> ö.L.&nbsp;;&nbsp;<? echo $coord_string_lat;?> n.B.</h4></p>
            </blockquote>
          </div>


        </div>


      </div>
      <!--#factContainer-->
    </div>
    <!--.row-->
  </div>
  <!--.container-->
					
</section>

<section id="version">		
<div>
	<? include('footer.php'); ?>
<div>
</section>
  </body>
</html>