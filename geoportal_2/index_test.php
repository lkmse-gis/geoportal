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
  <a href="#">Startseite</a>
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
		<img src="bilder/Logo.png" class="logo">
		

	<div id="demo" class="carousel slide" data-ride="carousel">
	
	<ul class="carousel-indicators">
		<li data-target="#demo" data-slide-to="0" class="active"></li>
		<li data-target="#demo" data-slide-to="1"></li>
		<li data-target="#demo" data-slide-to="2"></li>
	</ul>
	<div class="carousel-inner" style="background-color:#006085;">
		<div class="carousel-item active" style="background-image: url(bilder/waren.jpg);">
		<div class="carousel-caption" >
			<h2 style="background-color:#006085;width:220px;">Geoportal  2.0</h2>
			<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22w;">Der Landkreis in Zahlen und Fakten</p>
		</div>   
		</div>
		<div class="carousel-item" style="background-image: url(bilder/plauer-see.jpg);">
		<div class="carousel-caption">
			<h2 style="background-color:#006085;width:180px;">Chicago</h2>
			<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22px;">Thank you, Chicago!</p>
		</div>   
		</div>
		<div class="carousel-item" style="background-image: url(bilder/mecklenburgische-seenplatte.jpg);">
		<div class="carousel-caption">
			<h2 style="background-color:#006085;width:180px;">New York</h2>
			<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22px;">We love the Big Apple!</p>
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
	<br>
		<div class="col-lg-12">
		<div class="card-deck">
			<div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 d-flex  p-5">
                            <h1 class="mx-auto align-self-center"><i style="color:#fff;opacity:1;font-size:1.5em;" class="material-icons" aria-hidden="true">vpn_lock</i></h1>
                        </div>
                            <div class="col-md-6 py-3">
                                <h3 class="card-title">kvwmap</h3>
                                <p class="card-text">With supporting roots below as a natural lead-in to additional content and then some more content that is here.</p>
                                <a href="#" class="btn btn-outline-success btn-block">Outline</a>
                            </div>
                        </div>

                        </div>
            </div>
			<div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 d-flex  p-5">
                            <h1 class="mx-auto align-self-center"><i style="color:#fff;opacity:1;font-size:1.5em;" class="material-icons" aria-hidden="true">public</i></h1>
                        </div>
                            <div class="col-md-6 py-3">
                                <h3 class="card-title">Bürgerportal</h3>
                                <p class="card-text">With supporting roots below as a natural lead-in to additional content and then some more content that is here.</p>
                                <a href="#" class="btn btn-outline-success btn-block">Outline</a>
                            </div>
                        </div>

                </div>
            </div>
						<div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 d-flex  p-5">
                            <h1 class="mx-auto align-self-center"><i style="color:#fff;opacity:1;font-size:1.5em;" class="material-icons" aria-hidden="true">shopping_cart</i></h1>
                        </div>
                            <div class="col-md-6 py-3">
                                <h3 class="card-title">Geoshop</h3>
                                <p class="card-text">With supporting roots below as a natural lead-in to additional content and then some more content that is here.</p>
                                <a href="#" class="btn btn-outline-success btn-block">Outline</a>
                            </div>
                        </div>

                </div>
            </div>
		</div>
		</div>
	<div class="container">
  <div class="jumbotron">
    <h1>Bootstrap Tutorial</h1>      
    <p>Bootstrap is the most popular HTML, CSS, and JS framework for developing responsive, mobile-first projects on the web.</p>
  </div>
  <p>This is some text.</p>      
  <p>This is another text.</p>      
</div>
</div>

<div class="jumbotron text-center" style="margin-bottom:0">
  <p>Footer</p>
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
