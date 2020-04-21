<!DOCTYPE html>
<html>
<head>

	
	<? include('../../head.php'); ?>
	<link href="../../css/geoportal2.css" rel="stylesheet">
	
	
</head>
<body>
<header >

		<?php include('../../navbar.php'); ?>
		
</header>
<div class="kopf"></div>
<?php

	include ("../../include/connect_geobasis_geoportal2.php");
	//include ("../../../../includes/connect.php");
	//include ("../../../includes/portal_functions.php");

	
	$ebene=$_GET['ebene'];
	
	$speicher = unserialize(rawurldecode($_GET['speicher']));
	$aktuelleseite = $_SERVER['PHP_SELF'];
	

if ($ebene==0)
	{
		$auswahl=$_GET['auswahl'];
		
		
		$speicher[] = array( $auswahl => $aktuelleseite); 
			foreach ($speicher as $key => $value) {

				foreach ($value as $key1 => $value1) {

					$titel[$key] = $key1;
					$url[$key] = $value1;

				}
			}

		?>
		<html>
		<head>

		</head>
		<body >
		<div class="brot">
		<ul id="breadcrumbs-one">
		<li><a href="<? echo $url[0] ?>"><? echo $titel[0] ?></a> </li>
		<li><a href="#" class="current"><? echo $titel[1] ?> </a></li>
		</ul>
		</div>
		<section>
		<!--<div class="row">
			<div class="col-md-3">
				<div class="jumbotron well">
					<p><a href="apotheken.php?<? $serialized = rawurlencode(serialize($speicher)); ?>speicher=<? echo $serialized; ?>&ebene=1"> Apotheken</a></p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="jumbotron well">
					<p>	Eichenprozessionsspinner</p>					
				</div>
			</div>
			<div class="col-md-3">
				<div class="jumbotron well">
					<p><a href="kliniken.php?<? $serialized = rawurlencode(serialize($speicher)); ?>speicher=<? echo $serialized; ?>&ebene=1"> Kliniken</a></p>
				</div>
			</div>
		</div>-->
		
			 <div class="container">
        <div class="row">
			<div class="kacheln">
            <div class="col-sm-6 col-md-4"><p><a href="apotheken.php?<? $serialized = rawurlencode(serialize($speicher)); ?>speicher=<? echo $serialized; ?>&ebene=1"> Apotheken</a></p></div>
            <div class="col-sm-6 col-md-4 text-muted"><p>Eichenprozessionsspinner</p></div>
            <div class="col-sm-6 col-md-4"><p><a href="kliniken.php?<? $serialized = rawurlencode(serialize($speicher)); ?>speicher=<? echo $serialized; ?>&ebene=1"> Kliniken</a></p></div>
            <div class="clearfix visible-md-block"></div>
			<div class="col-sm-6 col-md-4"><p><a href="zert_gesundheitskurse.php?<? $serialized = rawurlencode(serialize($speicher)); ?>speicher=<? echo $serialized; ?>&ebene=1">Gesundheitskurse</a></p></div>
            <div class="col-sm-6 col-md-4 text-muted"><p>...</p></div>
            <div class="col-sm-6 col-md-4 text-muted"><p>...</p></div>
            <div class="clearfix visible-md-block"></div>
			</div>
        </div>
    </div>
		</section>
		
		</body>
		</html>
		<?
	}
	?>
	</body>
	</html>