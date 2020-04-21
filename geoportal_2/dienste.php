<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="css/geoportal2_2.css" rel="stylesheet">

</head>
<body>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="index.php">Startseite</a>
  <hr class="new3">
  <a href="#">Geodaten</a>
  <hr class="new3">
   <a href="#">kvwmap | <svg width="2.3em" height="0.6em" style="fill:#75b726;">
  <g transform="translate(-267 -10)">
    <path d="M274.675 14.847v-1.305c0-1.443-1.223-2.61-2.735-2.61-1.512
             0-2.736 1.167-2.736 2.61v1.305h-.684c-.753 0-1.367.587-1.367
             1.306v3.917c0 .72.614 1.305 1.367 1.305h6.84c.758 0 1.367-.586
             1.367-1.305v-3.917c0-.72-.61-1.306-1.368-1.306h-.685zm-1.367
             0h-2.736v-1.305c0-.72.615-1.306 1.368-1.306.753 0 1.368.587
             1.368 1.306v1.305zm-.406
             5.223h-1.92l.386-1.775c-.368-.194-.625-.566-.625-1
             0-.632.54-1.142 1.197-1.142.662 0 1.197.51 1.197 1.142 0
             .434-.257.806-.625 1l.39 1.775z"/>
  </g></svg></a>
  <hr class="new3">
   <a href="#">Bürgerportal</a>
  <hr class="new3">
  <a href="#">Dienste</a>
  <hr class="new3">
  <a href="#">Themenübersicht</a>
  <hr class="new3">
  <a href="#">Links</a>
  <hr class="new3">
  <a href="#">Kontakt</a>
</div>

<div id="main">
	<span class="hamburger" onclick="openNav()">&#9776;</span>
	<a href="index.php"><img src="bilder/Logo.jpg" class="logo"></a>
		
<header class="header_standard" style="background: url(bilder/natur.jpg) no-repeat center center;background-color:grey;">
	<div class="carousel-item" >
	</div>
  			<div class="carousel-caption" >
				<h2 class="display-4" style="background-color:#006085;width:330px;margin-left:-50px;">Dienste</h2>
				<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22w;">WMS / WFS / INSPIRE</p>
			</div>  
</header>
		

	<div class="suche">
	</div>

<div class="col-md-12">	
<br>
<!--
<div class="container">
  <div id="accordion">
	<a class="card-link" data-toggle="collapse" href="#t1">
		<div class="card">
			<div class="card-header">
			Bauen
			</div>
			<div id="t1" class="collapse " data-parent="#accordion">
			<div class="card-body">
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t2">
		<div class="card">
			<div class="card-header">
			Bevölkerung
			</div>
			<div id="t2" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t3">
		<div class="card">
			<div class="card-header">
			Bodenrichtwerte
			</div>
			<div id="t3" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t4">
		<div class="card">
			<div class="card-header">
			Bildung
			</div>
			<div id="t4" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t5">
		<div class="card">
			<div class="card-header">
			Gesundheit
			</div>
			<div id="t5" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t6">
		<div class="card">
			<div class="card-header">
			Kreisstruktur
			</div>
			<div id="t6" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t7">
		<div class="card">
			<div class="card-header">
			Umwelt / Natur
			</div>
			<div id="t7" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t8">
		<div class="card">
			<div class="card-header">
			Sicherheit
			</div>
			<div id="t8" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t9">
		<div class="card">
			<div class="card-header">
			Tourismus
			</div>
			<div id="t9" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
		<a class="card-link" data-toggle="collapse" href="#t10">
		<div class="card">
			<div class="card-header">
			Verkehr
			</div>
			<div id="t10" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t11">
		<div class="card">
			<div class="card-header">
			Ver- / Entsorgung
			</div>
			<div id="t11" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t12">
		<div class="card">
			<div class="card-header">
			Wirtschaft
			</div>
			<div id="t12" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>

  </div>
</div>-->
<br>

</div>



<div class="jumbotron text-center" style="margin-bottom:0;border-radius:0px;background-color:#333;margin-top:-1px;">

  <p></p>
  <div class="responsiveContainer">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1994.731757512131!2d13.25770038487415!3d53.51939222348609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x39f5c3c722220da6!2sLandkreis+Mecklenburgische+Seenplatte+(Landratsamt+Neubrandenburg)!5e0!3m2!1sde!2sde!4v1563452255083!5m2!1sde!2sde" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<div>
© Landkreis Mecklenburgische Seenplatte 2019
</div>
</div>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginRight = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginRight= "0";
}
</script>
   
</body>
</html> 
