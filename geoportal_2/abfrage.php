<!DOCTYPE html>
<html>
<head>

	<? include('../../head.php'); ?>
	
</head>
<body>
<header >
		<link href="../../css/geoportal2.css" rel="stylesheet">
		<link href="../../css/css_tabs.css" rel="stylesheet">
		
		<?php include('../../navbar.php'); ?>
		
		
</header>
<div class="kopf"></div>
<?php

	include ("../../include/connect_geobasis_geoportal2.php");


	
	$ebene=$_GET['ebene'];
	$speicher = unserialize(rawurldecode($_GET['speicher']));
	$aktuelleseite = $_SERVER['PHP_SELF'];


//////////////////////////////////////////////////// Ebene 1

if ($ebene == 1)


	{ 	
		
		$auswahl=$_GET['auswahl'];
		$speicher[2] = array( $thema => $aktuelleseite); 
		
			foreach ($speicher as $key => $value) {

				foreach ($value as $key1 => $value1) {

					$titel[$key] = $key1;
					$url[$key] = $value1;

				}
			}

	

		$query="SELECT COUNT(*) AS anzahl FROM $schema.$sicht";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
		
		$zentrum2="370900, 5939000";
		$resolution=240;
	
		$gemeinden="false";
		$orka="false";
		$osm="true";
		$dop20="false";

		?>
		<html>
		<head>

		</head>
		<body >
		<div class="brot">
		<ul id="breadcrumbs-one">
		<li><a href="<? echo $url[0] ?>"><? echo $titel[0] ?></a> </li>
		<li><a href="<? echo $url[1] ?>?speicher=<?php unset($speicher[$thema]); $serialized = rawurlencode(serialize($speicher)); echo $serialized; ?>&ebene=0&auswahl=<? echo $auswahl; ?>"><? echo $titel[1] ?></a> </li>
		<li><a href="#" class="current"><? echo $thema ?> </a></li>
		</ul>
		</div>

	<section>
			<table class="table">
			<tr><td>
				
					<div class="panel panel-primary">


						<!--<div class="panel-heading">
							<h3 class="panel-title">
								Karte
							</h3>
						</div>-->
						<div class="blue block">
						<div class="panel-body panel-body-map" >
											  
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
							
							<div id="map" class="map" ></div>
						
							</div>
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
									<div class="col-md-7">
										<label>Maus-Position: </label>
										<span class="form-control select select-primary">
											<div id="mouse-position"></div>
										</span>
									</div>
									<? include "karte.php"; ?> 
								</form>					
							</div>
						</div>
					</div>

					
					
				
				</td>
				</tr>
				<tr>
				<td>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <? echo 'Zu diesem Thema befinden sich <b>'.$count.'</b> Datensätze in der Datenbank.'; ?>
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body " >
		<h4>Gemeinden / Orte / Stadtteile</h4>
      <?php
										$query="SELECT DISTINCT  b.ortsteil as ortslage,b.typ as ort_typ,b.gid as ort_id,b.gem_name,b.gemschl  FROM $schema.$sicht  as a, management.ot_lt_rka as b WHERE ST_WITHIN(st_transform(a.wkb_geometry,25833), b.the_geom) ORDER BY gem_name,ort_typ,ortsteil";
										$result = $dbqueryp($connectp,$query);
										$z=0;
										while($r = $fetcharrayp($result))
											{
												
												$serialized = rawurlencode(serialize($speicher));
												echo "<div style='background-color:#eee; margin:5px;padding:10px; color:black;position:relativ;width:180px;height:70px;float: left;'><a href='$themendatei?speicher=$serialized&ebene=2&gemeinde=$r[ortslage]&ortslage_id=$r[ort_id]'";if ($r[ort_typ] == 'Gemeinde') echo "class=bld ";echo "><h5>$r[ortslage]</h5></a></div>";
											}
											
									// echo'<pre>';
									// print_r( $speicher);
									// echo'</pre>';
										
									?>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Metadaten
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
			<? include('metadaten.php'); ?>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingThree">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Legende
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">
          <p style="color:black;">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
          on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
          raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
        </div>
      </div>
    </div>
  </div>
	
				
				
				</td>
				</tr>
				</table>
				<br><br>

			</section>
		
		
		</body>
		</html>
	<? }

	
//////////////////////////////////////////////////// Ebene 2	
	
if ($ebene == 2 )

	{ 	
	$gemeinde=$_GET['gemeinde'];

	$ortslage_id=$_GET['ortslage_id'];

	$speicher[3] = array( $gemeinde => $aktuelleseite); 
	

		
	foreach ($speicher as $key => $value) {

	 foreach ($value as $key1 => $value1) {

		$titel[$key] = $key1;
		$url[$key] = $value1;

	 }
   }
   
   	$geom="SELECT box(st_transform(a.the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(a.the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.ortsteil,a.gem_name,a.typ as ort_typ FROM management.ot_lt_rka as a WHERE a.gid='$ortslage_id'";
	$result_geom = $dbqueryp($connectp,$geom);
	$g = $fetcharrayp($result_geom);
	$zentrum = $g[etrscenter];
	$klammer = array("POINT(",")");
	$zentrum2 = str_replace($klammer,"",$zentrum);
	$zentrum2 = str_replace(' ',",",$zentrum2);
	$resolution=30;

	
	$gemeinden="true";
	$orka="true";
	$osm="false";
	$dop20="false";

		?>
		<html>
		<head>
		</head>
		<body>
		<div class="brot">
		<ul id="breadcrumbs-one">
		<li><a href="<? echo $url[0] ?>"><? echo $titel[0] ?></a> </li>
		<li><a href="<? echo $url[1] ?>?speicher=<?php $serialized = rawurlencode(serialize($speicher)); echo $serialized; ?>&ebene=0&gemeinde_id=0&auswahl=<? echo $auswahl; ?>"><? echo $titel[1] ?></a> </li>
		<li><a href="<? echo $url[2]; ?>?speicher=<?php $serialized = rawurlencode(serialize($speicher)); echo $serialized; ?>&ebene=1&ortslage_id=0&auswahl=<? echo $auswahl; ?>"><? echo $thema ?></a> </li>
		<li><a href="#" class="current"><? echo $gemeinde ?> </a></li>
		</ul>
		</div>
		<section>
		
				
				
			<table class="table">
			<tr><td>
				
					<div class="panel panel-primary">


						<!--<div class="panel-heading">
							<h3 class="panel-title">
								Karte
							</h3>
						</div>-->
						<div class="blue block">
						<div class="panel-body panel-body-map" >
											  
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
							
							<div id="map" class="map" ></div>
						
							</div>
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
									<div class="col-md-7">
										<label>Maus-Position: </label>
										<span class="form-control select select-primary">
											<div id="mouse-position"></div>
										</span>
									</div>
									<? include "karte.php"; ?> 
								</form>					
							</div>
						</div>
					</div>

					
					
				
				</td>
				</tr>
				<tr>
				<td>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
			<?
								
								$query="SELECT a.* FROM $schema.$sicht as a, management.ot_lt_rka as b WHERE ST_intersects(a.wkb_geometry,b.the_geom) AND b.gid='$ortslage_id'";
								$result = $dbqueryp($connectp,$query);
								$z=0;
								while($r = $fetcharrayp($result))
								{
									$z++;
									$count=$z;	
									
								}  ?>
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <? echo 'Zu diesem Thema befinden sich <b>'.$count.'</b> Datensätze in der Datenbank.'; ?>
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body ">
	<br>
		<?	$query="SELECT DISTINCT  a.*,b.ortsteil as ortslage,b.typ as ort_typ,b.gid as ort_id,b.gem_name,b.gemschl  FROM $schema.$sicht  as a, management.ot_lt_rka as b WHERE ST_WITHIN(st_transform(a.wkb_geometry,25833), b.the_geom) and b.gid='$ortslage_id' ORDER BY gem_name,typ,ortsteil";
							$result = $dbqueryp($connectp,$query);
							$z=0;
							while($r = $fetcharrayp($result))
								{
									$ergebnis[$z]=$r;
			
									
									$serialized = rawurlencode(serialize($speicher));
									echo "<div style='background-color: #eee; padding:10px; color:black;'><a href='$themendatei?speicher=$serialized&ortslage_id=$ortslage_id&themen_id=$r[gid]&ebene=3&erg=$r[bezeichnung]'><h4>$r[bezeichnung]</h4></a>$r[geoportal_anschrift]<br>Telefon: $r[tel]<br><br></div><br>";
									$z++;
									$count=$z;	
									
								} 
								// echo'<pre>';
								// print_r( $ergebnis);
								// echo'</pre>';
								
								?>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Metadaten
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
			<? include('metadaten.php'); ?>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingThree">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Legende
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">
          <p style="color:black;">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
          on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
          raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
        </div>
      </div>
    </div>
  </div>
	
				
				
				</td>
				</tr>
				</table>
			</section>
		</body>
		</html>
	<? }
	
	
	
//////////////////////////////////////////////////// Ebene 3
	
if ($ebene == 3)

	{ 	
	$link=$_GET[link];
	$themen_id=$_GET['themen_id'];
	$ortslage_id=$_GET['ortslage_id'];
	$erg=$_GET['erg'];
	
	
	
	if($link == true)
	{
		$thema=$_GET[thema];
		$speicher[2] = array( $thema => $aktuelleseite); 
		
		$query="SELECT a.* FROM $schema.$sicht as a, management.ot_lt_rka as b WHERE ST_intersects(a.wkb_geometry,b.the_geom) AND b.gid='$ortslage_id'";
		$result = $dbqueryp($connectp,$query);
										
		while($r = $fetcharrayp($result))
			{
				$gemeinde=$r[gemeinde];								

			}

		$speicher[3] = array( $gemeinde => $aktuelleseite); 
	}
	

	$geom="select st_astext(st_centroid(b.wkb_geometry)) as zentrum from $schema.$sicht as a left join address_registry.adresstabelle as b on (a.adressschluessel=b.adressschluessel) where a.gid=$themen_id";
	$result_geom = $dbqueryp($connectp,$geom);
	$g = $fetcharrayp($result_geom);
	$zentrum = $g[zentrum];
	$klammer = array("POINT(",")");
	$zentrum2 = str_replace($klammer,"",$zentrum);
	$zentrum2 = str_replace(' ',",",$zentrum2);
	$resolution=0.2;
	
	
	$gemeinden="true";
	$orka="false";
	$osm="false";
	$dop20="true";


	foreach ($speicher as $key => $value) {

	 foreach ($value as $key1 => $value1) {

		$titel[$key] = $key1;
		$url[$key] = $value1;

	 }
   }

	$query="SELECT $queryselect FROM $schema.$sicht WHERE gid=$themen_id";
	$result = $dbqueryp($connectp,$query);
	$z=0;
	while($r = $fetcharrayp($result))
		{
		$ergebnis[$z]=$r;
			
		$z++;
		$count=$z;	
									
		} ;
				
   $gemeinde=titel[1];
		?>
		<html>
		<head>
		</head>
		<body>
		<div class="brot">
		<ul id="breadcrumbs-one">
		<li><a href="<? echo $url[0] ?>"><? echo $titel[0] ?></a> </li>
		<li><a href="<? echo $url[1] ?>?speicher=<?php  $serialized = rawurlencode(serialize($speicher)); echo $serialized; ?>&ebene=0&auswahl=<? echo $auswahl; ?>"><? echo $titel[1] ?></a> </li>
		<li><a href="<? echo $url[2] ?>?speicher=<?php  $serialized = rawurlencode(serialize($speicher)); echo $serialized; ?>&ebene=1&auswahl=<? echo $auswahl; ?>&ortslage_id=<? echo $ortslage_id; ?>&gemeinde=<? echo $titel[3]; ?>"><? echo $titel[2]  ?></a> </li>
		<li><a href="<? echo $url[3] ?>?speicher=<?php  $serialized = rawurlencode(serialize($speicher)); echo $serialized; ?>&ebene=2&auswahl=<? echo $auswahl; ?>&ortslage_id=<? echo $ortslage_id; ?>&gemeinde=<? echo $titel[3]; ?>"><? echo $titel[3]  ?></a> </li>
		<li><a href="#" class="current"><? echo $erg ?> </a></li>
		</ul>
		</div>
		</div>
		<section>

					
					
				
<table class="table">
			<tr><td>
				
					<div class="panel panel-primary">


						<!--<div class="panel-heading">
							<h3 class="panel-title">
								Karte
							</h3>
						</div>-->
						<div class="blue block">
						<div class="panel-body panel-body-map" >
											  
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
							
							<div id="map" class="map" ></div>
						
							</div>
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
									<div class="col-md-7">
										<label>Maus-Position: </label>
										<span class="form-control select select-primary">
											<div id="mouse-position"></div>
										</span>
									</div>
									<? include "karte.php"; ?> 
								</form>					
							</div>
						</div>
					</div>

					
					
				
				</td>
				</tr>
				<tr>
				<td>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<? echo $erg; ?>
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
		<br>
		<!--<center><img src="http://placehold.it/200x200" alt="" /></center>-->
						<br>
						<table class="table table-hover responsive-table">
							<tbody>
							<? 
						
							$i=0;
							foreach ($ergebnis as $key => $value) 
								foreach ($value as $key1 => $value1) {
									{
							
										/*$titel[$key] = $key1;*/
										$attribut[$key] = $value1;
									echo"
										<tr >
											<th>$beschriftung[$i]</th>
											";
											if($beschriftung[$i] == 'Internet')
											{
												echo "<td><a href='$attribut[$key]' target='_blank'>$attribut[$key]</a></td>";
											}
											elseif($beschriftung[$i] == 'E-Mail')
											{
												echo "<td><a href=mailto:$attribut[$key]'>$attribut[$key]</a></td>";
											}
											else{
												echo "<td>$attribut[$key]</td>";
											}
											echo"
										</tr>";
										$i++;
							}
								}
								
							?>
							</tbody>
						</table>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		Geodätisches
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
          on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
          raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingThree">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Legende
          <i class="pull-right fa fa-plus"></i>
        </a>
      </h4>
      </div>
      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
          on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
          raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
        </div>
      </div>
    </div>
  </div>
				
				
				</td>
				</tr>
				</table>
				</section>
		</body>
		</html>
	<? } ?>
	<section id="version">
	<? include('footer.php'); ?>
	</section>
	</body>
	</html>

