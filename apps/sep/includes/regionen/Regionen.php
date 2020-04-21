<?php

//globale Varibalen
$reg_nr=$_GET["reg_nr"];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Schulentwicklungsplanung</title>

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
	<link href="../../css/font-awesome.min.css" rel="stylesheet">
	<link href="../../css/bootstrap-theme.min.css" rel="stylesheet">

  </head>
  <body>

   <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<div class="jumbotron well" top="100">
				<h1 class="text-center">
					Schulentwicklungsplanung
				</h1>
			</div>	
			<h2 class="text-center"><br></br>
				Wählen Sie eine Region aus!
			</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-primary btn-lg btn-block active"  onClick="window.location='reg.php?reg_nr=1'">
				<h1><span class="glyphicon glyphicon-th-large">
					Demmin
				</h1></span>
			</button>
		</div>
		<div class="col-md-6">
			<br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-primary btn-lg btn-block active"  onClick="window.location='reg.php?reg_nr=2'">
				<h1><span class="glyphicon glyphicon-th-large">
					Mecklenburg-Strelitz
				</h1></span>
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-primary btn-lg btn-block active"  onClick="window.location='reg.php?reg_nr=3'">
				<h1><span class="glyphicon glyphicon-th-large">
					Müritz
				</h1></span>
			</button>
		</div>
		<div class="col-md-6">
			<br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-primary btn-lg btn-block active" onClick="window.location='reg.php?reg_nr=4'">
				<h1><span class="glyphicon glyphicon-th-large">
					Neubrandenburg
				</h1></span>
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<br></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<button class="btn btn-default" type="button" onClick="window.location='../../index.html'"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;  zurück</button>
		</div>
	</div>
   </div>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/scripts.js"></script>
  </body>
</html>