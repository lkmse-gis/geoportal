<?
	include ("../includes/portal_functions.php");
	include ("../includes/connect_geobasis.php");

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
  </head>
  <body>		
		<div class="row">
				<div class="col-md-7">
					<div id="map" class="map"></div>
					<div class="row">
						<form>
							<div class="col-md-5">	
								<label>Projektion: </label>
								<select id="projection" class="form-control select select-primary">
									<option value="EPSG:4326">"WGS84" (EPSG:4326)</option>
									<option value="EPSG:5650">"ETRS89 / mit UTM zone 33N" (EPSG:5650)</option>
									<option value="EPSG:25833">"ETRS89 / ohne UTM zone 33N" (EPSG:25833)</option>
									<option value="EPSG:3857">"WGS84 Web Mercator" (EPSG:3857)</option>
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
					<script>
					  var mousePositionControl = new ol.control.MousePosition({
						coordinateFormat: ol.coordinate.createStringXY(5),
						projection: 'EPSG:4326',					
						// comment the following two lines to have the mouse position
						// be placed within the map.
						className: 'custom-mouse-position',
						target: document.getElementById('mouse-position'),
						undefinedHTML: '&nbsp;'
					  });

					  var map = new ol.Map({
						controls: ol.control.defaults({
						  attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
							collapsible: false
						  })
						}).extend([mousePositionControl]),
						layers: [
						  new ol.layer.Tile({
							source: new ol.source.OSM()
						  })
						],
						target: 'map',
						view: new ol.View({
						  center: [1455000, 7085000],
						  zoom: 9
						})
					  });

					  var projectionSelect = document.getElementById('projection');
					  projectionSelect.addEventListener('change', function(event) {
						mousePositionControl.setProjection(ol.proj.get(event.target.value));
					  });				  		  
					</script>			  
				</div>
				<div class="col-md-5">			
					<table class="table table-hover table-condensed">
						<thead>
							<tr colspan="2">
								<th>
									Zahlen und Fakten
								</th>						
							</tr>
						</thead>
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
									14&nbsp;&nbsp;&nbsp;&nbsp;Ämter<br>
									6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amtsfreie Gemeinden<br>
									<? echo $count_gemeinden-6; ?> Gemeinden<br>
									<? echo $count_gemarkungen; ?> Gemarkungen
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
								<td>Nord-Süd Ausdehnung</td>
								<td><? echo $hoch2 ?> km</td>
							</tr>
							<tr>
								<td>Ost-West Ausdehnung</td>
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
  </body>
</html>