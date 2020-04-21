<?php
include ("../../../../includes/connect_geobasis.php");

//globale Varibalen
$schul_id=$_GET["schul_id"];
$schema="education";
$tabelle="schulentwicklungsplanung";
$stichtage=['2019-09-06','2018-09-14','2017-09-29','2016-09-30','2015-09-30','2014-09-23','2013-09-10','2012-09-12','2011-09-09'];
$aktuelles_datum=$stichtage[0];

if (strlen($schul_id) < 1)
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
						<h2 class="text-center"><br></br>
							statistische Auswertung über Schulen
						</h2><br></br>							
					</div>
				</div><!--Ende Grid Überschrift-->
				
				<!--Grid Auswahlliste-->
				<div class="row">
					<div class="col-md-12">
						<div class="col-xs-5"><!--Breite Auswahlliste-->					
							<form action="Schulauswahl2.php" method="get" name="schul_id">
								<h4><strong>Schulauswahl:</strong></h4>
								<select class="form-control select select-primary" data-toggle="select" name="schul_id" onchange="document.schul_id.submit();">
									<option>Bitte Schule auswählen</option>
									<?php
										$query="SELECT DISTINCT a.schul_id, a.ortsteil, a.bezeichnung FROM $schema.$tabelle as a ORDER BY a.ortsteil";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result)){
											echo "<option value=\"$r[schul_id]\">".$r[ortsteil]." ".$r[bezeichnung]." (".$r[schul_id]." )</option>\n";
										}
									?>
								</select>
							</form><br></br>
							<button class="btn btn-default" type="button" onClick="window.location='../../index.html'"><span class="glyphicon glyphicon-home"></span>  Startseite</button>
							<button class="btn btn-default" type="button" onClick="window.location='Schulen_Schulart.html'"><span class="glyphicon glyphicon-arrow-left"></span>  zurück</button>
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