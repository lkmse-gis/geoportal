<?php
include ("../../../../includes/connect_geobasis.php");
include("../kreis/2019/sep_2019_k.php");
include("../kreis/2018/sep_2018_k.php");
include("../kreis/2017/sep_2017_k.php");
include("../kreis/2016/sep_2016_k.php");
include("../kreis/2015/sep_2015_k.php");
include("../kreis/2014/sep_2014_k.php");
include("../kreis/2013/sep_2013_k.php");
include("../kreis/2012/sep_2012_k.php");
include("../kreis/2011/sep_2011_k.php");

//globale Varibalen
$schul_id=$_GET["schul_id"];
$schema="education";
$tabelle="schulentwicklungsplanung";
$stichtage=['2019-09-06','2018-09-14','2017-09-29','2016-09-30','2015-09-30','2014-09-23','2013-09-10','2012-09-12','2011-09-09'];
$aktuelles_datum=$stichtage[0];
$schulart=NULL;
$schultyp=NULL;
$schultyp=$_GET["schultyp"];

if (strlen($schultyp) < 1 AND strlen($schulart) < 1)
    {
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">

				<title>Schulentwicklungsplanung</title>

				<link href="../../css/bootstrap.min.css" rel="stylesheet">
				<link href="../../css/style.css" rel="stylesheet">	
				<link href="../../css/font-awesome.min.css" rel="stylesheet">
				<link href="../../css/bootstrap-theme.min.css" rel="stylesheet">
				
				<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
				
				<script type="text/javascript" src="../../js/jquery-3.1.0.min.js"></script> <!--js Bibliothek laden noch bevor etwas ausgeführt wird-->
				
				<script language="javascript">
					function klappe (Id){
					  if (document.getElementById) {
						var mydiv = document.getElementById(Id);
						mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
					  }
					}
				</script>				
			</head>
		<body>
			<!--Grid Container-->
			<div class="container-fluid">
				<!--Grid Überschrift-->
				<div class="row">
					<div class="col-md-12">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<div class="jumbotron well" top="100">
							<h1 class="text-center">
								Schulentwicklungsplanung
							</h1>
						</div>							
					</div>
				</div><!--Ende Grid Überschrift-->
				
				<!--Grid Auswahlliste-->
				<div class="row">
					<div class="col-md-12">
						<div class="col-xs-5"><!--Breite Auswahlliste-->					
							<form action="Schulart_Auswahl.php" method="get" name="schultyp">
								<h4><strong>Schulart auswählen:</strong></h4>
								<select class="form-control select select-primary" data-toggle="select" name="schultyp" onchange="document.schultyp.submit();">									
									<option>Bitte Schulart auswählen</option>
									<option value="Agy">Agy</option>
									<option value="FöG">FöG</option>
									<option value="FöK">FöK</option>
									<option value="FöKr">FöKr</option>
									<option value="FöL">FöL</option>
									<option value="FöSp">FöSp</option>
									<option value="FöV">FöV</option>
									<option value="GS">GS</option>
									<option value="Gy">Gy</option>
									<option value="IGS">IGS</option>
									<option value="OS">OS</option>
									<option value="RegS">RegS</option>
								</select>
							</form><br></br>							
							<button class="btn btn-default" type="button" onClick="window.location='../../index.html'"><span class="glyphicon glyphicon-home"></span>  Startseite</button>
							<button class="btn btn-default" type="button" onClick="window.location='Schulen_Schulart.html'"><span class="glyphicon glyphicon-arrow-left"></span>  zurück</button><br></br><br></br>
						</div>
						<!--Legende-->
						<div class="col-xs-12"><!--Breite Legende-->
							<h2 align="left" style="font-family: 'Times New Roman'">
								<strong>Legende</strong><br>
								<hr class="col-xs-6"></br>
							</h2>
							<h4>Agy - Abendgymnasium<h4>
							<h4>FöG - Schule mit Förderschwerpunkt geistige Entwicklung<h4>
							<h4>FöK - Schule mit Förderschwerpunkt körperlich, motorische Entwicklung<h4>
							<h4>FöKr - Schule mit Förderschwerpunkt Kranke<h4>
							<h4>FöL - Schule mit Förderschwerpunkt Lernen<h4>
							<h4>FöSp - Schule mit Förderschwerpunkt Sprache<h4>
							<h4>FöV - Schule mit Förderschwerpunkt Verhalten (emotionale und soziale Entwicklung = ESE)<h4>
							<h4>GS - Grundschule<h4>
							<h4>Gy - Gymnasium<h4>
							<h4>IGS - Integrierte Gesamtschule<h4>
							<h4>OS - Orientierungsstufe<h4>
							<h4>RegS - Regionale Schule<h4>
						</div>
					</div>
				</div><!--Ende Grid Auswahlliste-->
			
			</div><!--Ende Grid Container-->
				
			<script src="../../js/jquery.min.js"></script>
			<script src="../../js/bootstrap.min.js"></script>
			<script src="../../js/scripts.js"></script>
			
		</body>
		</html>
<?	}

if (strlen($schultyp) > 0)
    {
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">

				<title>Schulentwicklungsplanung</title>

				<link href="../../css/bootstrap.min.css" rel="stylesheet">
				<link href="../../css/style.css" rel="stylesheet">	
				<link href="../../css/font-awesome.min.css" rel="stylesheet">
				<link href="../../css/bootstrap-theme.min.css" rel="stylesheet">
				
				<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
				
				<script type="text/javascript" src="../../js/jquery-3.1.0.min.js"></script> <!--js Bibliothek laden noch bevor etwas ausgeführt wird-->
				
				<script language="javascript">
					function klappe (Id){
					  if (document.getElementById) {
						var mydiv = document.getElementById(Id);
						mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
					  }
					}
				</script>				
			</head>
		<body>
			<!--Grid Container-->
			<div class="container-fluid">
				<!--Grid Überschrift-->
				<div class="row">
					<div class="col-md-12">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<div class="jumbotron well" top="100">
							<h1 class="text-center">
								Schulentwicklungsplanung
							</h1>
						</div>							
					</div>
				</div><!--Ende Grid Überschrift-->
				
				<!--Grid Auswahlliste-->
				<div class="row">
					<div class="col-md-12">
						<div class="col-xs-5"><!--Breite Auswahlliste-->					
							<form action="Schulart_Auswahl2.php" method="get" name="schul_id">
								<h4><strong>Schulart ist &nbsp;&nbsp;</strong><i><?echo "$schultyp"?>,</i>&nbsp;&nbsp;<strong> wählen Sie eine Schule aus!</strong></h4>
								<select class="form-control select select-primary" data-toggle="select" name="schul_id" onchange="document.schul_id.submit();">
									<option>Bitte Schule auswählen</option>
									<?php
										$query="SELECT DISTINCT a.bezeichnung, a.schul_id, a.ortsteil FROM $schema.$tabelle as a WHERE a.schularten LIKE '%$schultyp%' ORDER BY a.bezeichnung ASC";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result)){
											echo "<option value=\"$r[schul_id]\">".$r[bezeichnung]." ".$r[ortsteil]."</option>\n";
										}
									?>
								</select>
							</form><br></br>
							<button class="btn btn-default" type="button" onClick="window.location='../../index.html'"><span class="glyphicon glyphicon-home"></span>  Startseite</button>
							<button class="btn btn-default" type="button" onClick="window.location='Schulart_Auswahl.php'"><span class="glyphicon glyphicon-arrow-left"></span>  zurück</button>
						</div>
					</div>
				</div><!--Ende Grid Auswahlliste-->
			
			</div><!--Ende Grid Container-->
				
			<script src="../../js/jquery.min.js"></script>
			<script src="../../js/bootstrap.min.js"></script>
			<script src="../../js/scripts.js"></script>
			
		</body>
		</html>
<?	}