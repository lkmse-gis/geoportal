<!DOCTYPE html>
<html>
  <head>
	<? include('head.php'); ?>
	
  </head>
<body>


<!--
<nav class="navbar navbar-expand-lg navbar-light">
  <a class="navbar-brand" href="index.php"><img src="bilder/Logo2.jpg" style="float:right;max-width:300px" ></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse collapse justify-content-center" id="navbarNav">
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown">Geodaten <span class="sr-only">(current)</span></a>
		 <div class="dropdown-menu">
		 <div class="row">
			<a class="dropdown-item" href="#">Link 1</a>
			<a class="dropdown-item" href="#">Dienste</a>
			<a class="dropdown-item" href="#">Link 3</a>
		</div>
				 <div class="row">
			<a class="dropdown-item" href="#">Link 1</a>
			<a class="dropdown-item" href="#">Dienste</a>
			<a class="dropdown-item" href="#">Link 3</a>
		</div>
      </div>
      </li>
	  <li class="nav-item active" >
        <a class="nav-link"  href="themen.php">kvwmap</a>
      </li>
	        <li class="nav-item">
        <a class="nav-link" href="themen.php">Bürgerportal</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="index.php#landkreis">Der Landkreis</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="themen.php">Themenübersicht</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="#">Links</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link " href="#">Kontakt</a>
      </li>
    </ul>
	</div>
</nav>-->

<?php include('navbar.php'); ?>

<main>
	<div class="suche">
	</div>
	<div id="demo" class="carousel slide" data-ride="carousel">
	
		<ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
			<li data-target="#demo" data-slide-to="1"></li>
			<li data-target="#demo" data-slide-to="2"></li>
		</ul>
		<div class="carousel-inner" style="background-color:#006085;">
			<div class="carousel-item active" style="background-image: url(bilder/feld.jpg);">
			<div class="carousel-caption" >
				<h2 class="display-4" style="background-color:#006085;width:280px;margin-left:-50px;">Geoportal  <font style="font-size:12px;vertical-align:super;"><b>2.0</b></font></h2>
				<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22w;">Der Landkreis in Zahlen und Fakten</p>
			</div>   
			</div>
			<div class="carousel-item" style="background-image: url(bilder/waren.jpg);">
			<div class="carousel-caption">
				<h2 class="display-4" style="background-color:#006085;width:380px;margin-left:-50px;">Bodenrichwerte</h2>
				<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22w;">Aktuelle Richtwerte und Marktberichte</p>
			</div>   
			</div>
			<div class="carousel-item" style="background-image: url(bilder/hochsitz.jpg);">
			<div class="carousel-caption">
				<h2 class="display-4" style="background-color:#006085;width:310px;margin-left:-50px;">Jagdkataster</h2>
				<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22w;">Verwaltung der Jagdbezirke</p>
			</div>   
			</div>
		</div>
		
		<a class="carousel-control-prev" href="#demo" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</a>
		<a class="carousel-control-next" href="#demo" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		</a>
	</div>
	<!--
	<div class="kopf1"></div>
	<div class="kopf"></div>
	-->
	<div class="suche">
	</div>
	


<div class="col-l-12" >	
	<ul class="teaser-list">
   
    <li class="teaser">
			<a href="#">
			<div>
				<h1>
					<i style="color:#fff;opacity:1;font-size:1.5em;" class="material-icons" aria-hidden="true">euro_symbol</i>
				</h1>
			</div>
			<div>
				<h3>Bodenrichtwerte</h3>
				<hr>
				<p>WebGIS-Framework zur Erfassung, Verarbeitung, Analyse und Präsentation von raumbezogenen Informationen</p>
			</div>
		</a>

		<li class="teaser">
		<a href="https://geoport-lk-mse.de/mp/portale/start/" target="_blank">
			<div>
				<h1>
					<i style="color:#fff;opacity:1;font-size:1.5em;" aria-hidden="true" class="material-icons">map</i>
				</h1>
			</div>
			<div>
				<h3>Kartenportal</h3>
				<hr>
				<p>Das Kartenportal stellt, für einzelne Ämter abgestimmte, Geodaten zur Verfügung.<br><br></p>
			</div>
		</a>
	</li>
   
	<li class="teaser">
		<a href="#">
			<div>
				<h1>
					<i style="color:#fff;opacity:1;font-size:1.5em;" class="material-icons" aria-hidden="true">school</i>
				</h1>
			</div>
			<div>
				<h3>Geowiki</h3>
				<hr>
				<p>WebGIS-Framework zur Erfassung, Verarbeitung, Analyse und Präsentation von raumbezogenen Informationen</p>
			</div>
		</a>
	</li>
	

	
</ul>


</div>


<div class="jumbotron text-center" style="margin-bottom:0;border-radius:0px;background-color:white;color:#333;" id='landkreis'>
<!--<img src="bilder/lk4.png" style="width:250px;position:absolute;z-index:1;margin-top:-50px;">-->
<div style="font-size:2.5em;z-index:15;letter-spacing: 0.1em;">Der <b>Landkreis</b></div><br><div style="font-size:1.5em;z-index:15;letter-spacing: 0.15em;margin-top:-40px;padding-bottom:20px;">in <b>Zahlen</b> und <b>Fakten</b></div>
<div class="list_tag ">
  <div class="item_tag "><a href="#"><small>Bundesland:</small> <b>Mecklenburg-Vorpommern</b></a></div>
  <div class="item_tag "><a href="#"><small>Kreisstadt:</small> <b>Neubrandenburg</b></a></div>
  <div class="item_tag "><a href="#"><small>Einwohner:</small> <b>259851</b> <small>(Zensus: 30.06.2018)</small></a></div>
  <div class="item_tag "><a href="#"><b>127480 Männer</b> <small>(Quote: 49.06%)</small></a></div>
  <div class="item_tag "><a href="#"><b>132371 Frauen</b> <small>(Quote: 50.94%)</small></a></div>
  <div class="item_tag "><a href="#"><small>Bevölkerungsdichte:</small> <b>47 Einw. pro km²</b></a></div>
  <div class="item_tag "><a href="#"><small>KFZ-Kennzeichen:</small> <b>DM, MST, MÜR, NB, AT, MC, NZ, RM, WRN, MSE</b></a></div>
  <div class="item_tag "><a href="#"><small>Kreisschlüssel:</small> <b>13 0 71</b></a></div>
  <div class="item_tag "><a href="#"><b>14</b> Ämter</a></div>
  <div class="item_tag "><a href="#"><b>6</b> Amtsfreie Gemeinden</a></div>
  <div class="item_tag "><a href="#"><b>142</b> Gemeinden</a></div>
  <div class="item_tag "><a href="#"><b>613</b> Gemarkungen</a></div>
  <div class="item_tag "><a href="#"><small>amtliche Fläche:</small> <b>5470.73 km²</b></a></div>
  <div class="item_tag "><a href="#"><small>Landrat:</small> <b>Herr Heiko Kärger</b></a></div>
  <div class="item_tag "><a href="http://www.lk-mecklenburgische-seenplatte.de" target="_blank"><b>www.lk-mecklenburgische-seenplatte.de</b></a></div>
</div>
</div>



    <div class="card card-only d-block text-center" style="background-color:white;color:#333;">
        <div class="row no-gutters">
            <div class="col-sm-6">
                <div class="card-block card-only-padding px-2">
                    <h4 class="card-title"><div style="font-size:2.5em;z-index:15;letter-spacing: 0.1em;"><b>Geodätische</b> Daten</div></h4>
                    <div class="list_tag ">
						<div class="item_tag "><a href="#"><small>geodätische Fläche:</small> <b>5493.47 km²</b></a></div>
						<div class="item_tag "><a href="#"><small>Nord-Süd Ausdehnung:</small> <b>94 km</b>   </a></div>
						<div class="item_tag "><a href="#"><small>Ost-West Ausdehnung:</small> <b>101 km</b></a></div>
						<div class="item_tag "><a href="#"><small>Grenzlänge:</small> <b>532 km</b></a></div>
						<div class="item_tag "><a href="#"><small>Mittelpunkt (Polygonschwerpunkt):</small> <b>13° 0' 7''<br>53° 32' 35''</b> </a></div>
					</div>  
                </div>
            </div>
			<div class="col-sm-6" style="background-color:white;">
			<br>
			<br>
                <h1>
					<!--<i style="color:#006085;opacity:1;font-size:15em;" class="material-icons" aria-hidden="true">explore</i>-->
					<img src="bilder/lk4.png" class="img-fluid">
				</h1>
			<br>
            </div>
        </div>

	</div>

	<br>
<!--	
	    <div class="card card-only d-block">
        <div class="row no-gutters">
					<div class="col-md-6">
                <img src="bilder/waren.jpg" class="img-fluid" alt="">
            </div>
            <div class="col-md-6">
                <div class="card-block card-only-padding px-2">
                    <h4 class="card-title">BODENRICHTWERTE</h4>
					<hr>
                    <p class="card-text">Text</p>
                    <a href="#" class="btn btn-primary">BUTTON</a>
                </div>
            </div>
        </div>

	</div> -->
	
</div>

</main>

<div  style="margin-bottom:-50px;;background-color:#323131;padding:0px;">
  <div class="responsiveContainer">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d986.1033003360451!2d13.257651644416988!3d53.5195020069204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47abc37e84f50891%3A0x39f5c3c722220da6!2sLandkreis%20Mecklenburgische%20Seenplatte%20(Landratsamt%20Neubrandenburg)!5e1!3m2!1sde!2sde!4v1580456785516!5m2!1sde!2sde" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div>
</div>

<section id="version">		
	<div>
		<? include('footer.php'); ?>
	</div>
</section>
</body>
</html> 
