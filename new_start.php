<?
	include ("includes/portal_functions.php");
	include ("includes/connect_geobasis.php");

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
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	

    <title>Geoportal LK MSE</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">
	
	<? include ("ajax.php"); ?>
	<? include ("includes/zeit.php"); ?>

    <link href="bootstrap_conf/css/bootstrap.min.css" rel="stylesheet">
	<link href="bootstrap_conf/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="bootstrap_conf/css/style.css" rel="stylesheet">	
	<link rel="stylesheet" href="geoportal_2/ol3-layerswitcher-master/src/ol3-layerswitcher.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
	<link rel="stylesheet" href="https://openlayers.org/en/v3.20.1/css/ol.css" type="text/css">   
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v3.20.1/build/ol.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.14/proj4.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>	

  </head>
  <body>
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<br>
				<div class="jumbotron well">
					<h3>
						Geoportal Landkreis Mecklenburgische Seenplatte
					</h3>			
				</div>
			</div>
		</div>
			
		<div class="row">
			<div class="col-md-5">		
				<nav class="navbar navbar-default" role="navigation">
					<div class="navbar-header">					 
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
						</button><a class="navbar-brand" href="new_start.php" data-toggle="tooltip" data-placement="bottom" title="Startseite"><em class="glyphicon glyphicon-home"></em></a>
					</div>
					
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">							
							<li class="active">
								<a href="javascript:ajaxpage('geoportal_2/information.php', 'content')" data-toggle="tooltip" data-placement="bottom" title="informieren Sie sich"><em class="fa fa-comments-o"></em> Information</a>
							</li>
							<li>
								<a href="javascript:ajaxpage('geoportal_2/auskunft.php', 'content')" data-toggle="tooltip" data-placement="bottom" title="Wer ist mein Ansprechpartner im Landkreis?"><em class="fa fa-user-circle"></em> Auskunft</a>
							</li>
							<li class="active">
								<a href="javascript:ajaxpage('geoportal_2/wo_finde_ich_was.php', 'content')" data-toggle="tooltip" data-placement="bottom" title="Wo finde ich Geodaten?"><em class="fa fa-map-signs"></em> Wo finde ich was?</a>
							</li>
							<li>
								<a href="#" data-toggle="tooltip" data-placement="bottom" title="Eine Übersicht gefällig?"><em class="glyphicon glyphicon-menu-hamburger"></em> Themen</a>
							</li>
							<li class="active">
								<a href="#" data-toggle="tooltip" data-placement="bottom" title="Was haben die anderen Kreise?"><em class="glyphicon glyphicon-menu-hamburger"></em> Geoportale</a>
							</li>
						</ul>					
					</div>					
				</nav>			
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-5">
				<nav class="navbar navbar-default" role="navigation">
					<div class="navbar-header">					 
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
							 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
						</button><span class="navbar-brand" href="#" data-toggle="tooltip" data-placement="bottom" title="Anwendungen"><em class="fa fa-desktop"></em></span>
					</div>
					
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">							
						<ul class="nav navbar-nav navbar-right">							
							<li class="divider"></li>							
							<li class="active">
								<a href="https://geoport-lk-mse.de/kvwmap" target="_blank" data-toggle="tooltip" data-placement="bottom" title="startet das WebGis kvwmap - Anmeldedaten notwendig"><em class="glyphicon glyphicon-eye-close"></em> kvwmap</a>
							</li>
							<li>
								<a href="https://geoport-lk-mse.de/kvwmap/index.php?gast=50" target="_blank" data-toggle="tooltip" data-placement="bottom" title="startet die freie Version von kvwmap"><em class="glyphicon glyphicon-eye-open"></em> Bürgerportal</a>
							</li>
							<li class="active">
								<a href="http://geoport-lk-mse.de/mp/portale/start" target="_blank" data-toggle="tooltip" data-placement="bottom" title="startet das mobile Kartenportal"><em class="glyphicon glyphicon-phone"></em> Kartenportal</a>
							</li>
							<li>
								<a href="http://geoport-lk-mse.de/geoshop/" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Hier können Sie Flurkarten und Flurstücksnachweise käuflich erwerben."><em class="glyphicon glyphicon-shopping-cart"></em> Geoshop</a>
							</li>
							<li class="active">
								<a href="http://geoport-lk-mse.de/geowiki" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Wissensplattform zum Geoportal MSE"><em class="glyphicon glyphicon-education"></em> Geowiki</a>
							</li>						
						</ul>
					</div>				
				</nav>			
			</div>
		</div>			
		
		<div id="content">
			<div class="row">
				<div class="col-md-7">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								virtuelle Karte
							</h3>
						</div>
						<div class="panel-body">
							<div id="map" class="map"></div>
						</div>
						<div class="panel-footer">
							<div class="row">
								<form>
									<div class="col-md-5">	
										<label>Projektion: </label>
										<select id="projection" class="form-control select select-primary">
											<option value="EPSG:4326">"WGS84" (EPSG:4326)</option>									
											<option value="projection25833">"ETRS89 ohne führende UTM Zone" (EPSG:25833)</option>									
										</select>
									</div>						
									<div class="col-md-6">
										<label>Maus-Position: </label>
										<span class="form-control select select-primary">
											<div id="mouse-position"></div>
										</span>
									</div>
									<div class="col-md-1">
										<br><a class="btn btn-primary btn-default" href="https://geoport-lk-mse.de/geoportal/new_start.php" title="Refresh"><em class="glyphicon glyphicon-refresh"></em></a>
									</div>
								</form>					
							</div>
						</div>
					</div>
					<!--<div class="row">
						<div class="col-md-12">	
							<div id="info" class="alert alert-success">
								&nbsp;
							</div>
						</div>				
					</div>-->
					<script src="geoportal_2/ol3-layerswitcher-master/src/ol3-layerswitcher.js"></script>
					<script>
						proj4.defs("EPSG:25833","+proj=utm +zone=33 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
						var projection25833 = ol.proj.get("EPSG:25833");
					  
						//ORKA MV
						var orka_mv = new ol.layer.Tile({												
							title: 'ORKA MV',
							type: 'base',
							visible: true,
							source: new ol.source.XYZ({
								projection: 'EPSG:3857',
								url: 'https://www.orka-mv.de/geodienste/orkamv/tiles/1.0.0/'
								+ 'orkamv/GLOBAL_WEBMERCATOR/{z}/{x}/{y}.png'
							})
						});
						
						//Open Street Map Daten
						var osm = new ol.layer.Tile({												
							title: 'OSM',
							type: 'base',
							visible: false,
							source: new ol.source.OSM()						
						});
						
						//Kreisgrenze
						var kreisgrenze = new ol.layer.Tile({	
							title: 'Kreisgrenze',
							source:	new ol.source.TileWMS({
								projection: projection25833,
								url: 'https://geoport-lk-mse.de/webservices/mse_all',
								params: {	'LAYERS': 'Kreisgrenze_msp',
											'VERSION': '1.1.0',
											'FORMAT': 'image/png',
											'TILED': true
										},
								serverType: 'mapserver',
							})
						});
						
						var base_group = new ol.layer.Group({ 
                 			title: 'Basiskarten',
							layers: [orka_mv, osm]
						});
							
						var overlay_group = new ol.layer.Group({ 
                 			title: 'Fachdaten',
							layers: [kreisgrenze]
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
									collapsible: false
								})
							}).extend([mousePositionControl]),
							layers: [base_group,overlay_group],
							target: 'map',
							view: myView						
						});

						var projectionSelect = document.getElementById('projection');
							projectionSelect.addEventListener('change', function(event) {
							mousePositionControl.setProjection(ol.proj.get(event.target.value));
						});
						
						map.on('singleclick', function(evt) {
						  document.getElementById('info').innerHTML = '';
						  var viewResolution = /** @type {number} */ (view.getResolution());
						  var url = kreisgrenze.getGetFeatureInfoUrl(
							  evt.coordinate, viewResolution, projection25833,
							  {'INFO_FORMAT': 'text/html'});
						  if (url) {
							document.getElementById('info').innerHTML =
								'<iframe seamless src="' + url + '"></iframe>';
						  }
						});

						map.on('pointermove', function(evt) {
						  if (evt.dragging) {
							return;
						  }
						  var pixel = map.getEventPixel(evt.originalEvent);
						  var hit = map.forEachLayerAtPixel(pixel, function(layer) {
							return true;
						  });
						  map.getTargetElement().style.cursor = hit ? 'pointer' : '';
						});
						
						var layerSwitcher = new ol.control.LayerSwitcher({ 
								tipLabel: 'Legende' // Optional label for button 
							});
						map.addControl(layerSwitcher);
					</script>			  
				</div>
				<div class="col-md-5">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								Zahlen und Fakten
							</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover table-condensed table-bordered">								
								<tbody>									
									<tr>
										<td>Bundesland</td>
										<td>Mecklenburg-Vorpommern</td>
									</tr>								
									<tr>
										<td>Kreisstadt</td>
										<td>Neubrandenburg</td>
									</tr>
									<tr>
										<td>Landrat</td>
										<td>Herr Heiko K&auml;rger</td>
									</tr>
									<tr>
										<td>Homepage</td>
										<td><a href="http://www.lk-mecklenburgische-seenplatte.de" target=blank>www.lk-mecklenburgische-seenplatte.de</a></td>
									</tr>
									<tr>
										<td>Einwohner</td>
										<td>
											<? echo $count_einwohner."(Zensus: ".$stand.")<br>".$mann." Männer (Quote: ".$mann_quote."%)<br>".$frau." Frauen (Quote: ".$frau_quote."%)"; ?>
										</td>
									</tr>
									<tr>
										<td>Bevölkerungsdichte</td>
										<td>
											<? echo floor($count_einwohner/$buchflaeche); ?> Einw. pro km²
										</td>
									</tr>
									<tr>
										<td>KFZ-Kennzeichen</td>
										<td>DM, MST, MÜR, NB, AT, MC, NZ, RM, WRN, MSE</td>
									</tr>
									<tr>
										<td>Kreisschlüssel</td>
										<td>13 0 71</td>
									</tr>
									<tr>
										<td>Kreisstruktur</td>
										<td>
											14 Ämter; 6 Amtsfreie Gemeinden<br>											
											<? echo $count_gemeinden-6; ?> Gemeinden; <? echo $count_gemarkungen; ?> Gemarkungen<br>											
										</td>
									</tr>
									<tr>
										<td>amtliche Fläche</td>
										<td>
											<? echo $buchflaeche; ?> km²
										</td>
									</tr>										
									<tr>
										<td>geodätische Fläche</td>
										<td><? echo $geoflaeche ?> km²</td>
									</tr>
									<tr>
										<td>N-S Ausdehnung</td>
										<td><? echo $hoch2 ?> km</td>
									</tr>
									<tr>
										<td>O-W Ausdehnung</td>
										<td><? echo $rechts2 ?> km</td>
									</tr>
									<tr>
										<td>Grenzlänge</td>
										<td><? echo $umfang6 ?> km</td>
									</tr>
									<tr>
										<td>Mittelpunkt (Polygonschwerpunkt)</td>
										<td><? echo $coord_string_lon;?> ö.L.&nbsp;;&nbsp;<? echo $coord_string_lat;?> n.B.</td>
									</tr>
								</tbody>
							</table>
						</div>						
					</div>								
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-default" role="navigation">	
					<div class="navbar-header">					 
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3">
							 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
						</button><span class="navbar-brand" href="#">Nutzung/Kontakt</span>
					</div>
					
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">						
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="javascript:ajaxpage('geoportal_2/kontakt.php', 'content')" data-toggle="tooltip" data-placement="top" title="Wer hilf Ihnen hier bei was?"><em class="glyphicon glyphicon-user"></em> Kontakt</a>
							</li>							
							<li class="active">
								<a href="javascript:ajaxpage('geoportal_2/impressum.php', 'content')" data-toggle="tooltip" data-placement="top" title="Wer ist für was verantwortlich?"><em class="fa fa-file-text-o"></em> Impressum</a>
							</li>							
							<li>
								<a href="http://geoport-lk-mse.de/geoportal/lizenzen/AfGVK_AGNB_2016_MSE.pdf" data-toggle="tooltip" data-placement="top" title="PDF mit den Nutzungsbedingungen"><em class="fa fa-file-pdf-o"></em> Nutzungsbedingungen</a>
							</li>							
							<li class="active">
								<a href="http://www.lk-mecklenburgische-seenplatte.de" target="_blank" data-toggle="tooltip" data-placement="top" title="zum Landkreis MSE"><em class="fa fa-copyright"></em> Landkreis Mecklenburgische Seenplatte</a>
							</li>
						</ul>
					</div>					
				</nav>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
	</script>
	<script src="bootstrap_conf/js/jquery.min.js"></script>
    <!--<script src="bootstrap_conf/js/scripts.js"></script>-->
	<script src="bootstrap_conf/js/bootstrap.min.js"></script>
  </body>
</html>