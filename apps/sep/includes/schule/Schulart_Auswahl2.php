<?php

include ("../../../../includes/connect_geobasis.php");

//globale Varibalen
$schul_id=$_GET["schul_id"];
$gid[]=$_GET["gid"];
$schema="education";
$tabelle="schulentwicklungsplanung";
$stichtage=['2019-09-06','2018-09-14','2017-09-29','2016-09-30','2015-09-30','2014-09-23','2013-09-10','2012-09-12','2011-09-09'];
$aktuelles_datum=$stichtage[0];
$schema="education";
$tabelle="schulentwicklungsplanung";
$data=array();


	$query="SELECT DISTINCT a.bezeichnung, a.ortsteil FROM $schema.$tabelle as a WHERE a.schul_id = '$schul_id'";
	$result = $dbqueryp($connectp,$query);

	while($r = $fetcharrayp($result)){
		$data=[$r[bezeichnung],$r[ortsteil]];
	}


if (strlen($schul_id) > 0)
    {
		include("schule/sep_2019.php");
		include("schule/sep_2018.php");
		include("schule/sep_2017.php");
		include("schule/sep_2016.php");
		include("schule/sep_2015.php");
		include("schule/sep_2014.php");
		include("schule/sep_2013.php");
		include("schule/sep_2012.php");
		include("schule/sep_2011.php");		
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
				
				
				<!-- **************** Export Bibliotheken ****************** -->
				
				<script type="text/javascript" src="../../export_libs/js/jquery-3.1.1.js"></script>
				<script type="text/javascript" src="../../export_libs/js/FileSaver.min.js"></script>
				  
				<!-- für Allgemeine Exportfunktionen -->
				<script type="text/javascript" src="../../export_libs/js/tableExport.js"></script>
				  
				<!-- für XLSX -->
				<script type="text/javascript" src="../../export_libs/js/xlsx.core.min.js"></script>
				  
				<!-- für PDF -->  
				<script type="text/javascript" src="../../export_libs/js/jspdf.min.js"></script>
				<script type="text/javascript" src="../../export_libs/js/jspdf.plugin.autotable.js"></script>
				  
				<!-- für PNG --> 
				<script type="text/javascript" src="../../export_libs/js/html2canvas.min.js"></script>
				<script type="text/javascript" src="../../export_libs/js/html2canvas.js"></script>
				<script type="text/javascript" src="../../export_libs/js/html2canvas.svg.js"></script>
								
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
					<!--Grid Menüleiste-->
					<div class="row">
						<div class="col-md-12">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<h4><strong>Die ausgewählte Schule ist &nbsp;&nbsp;</strong><i><?echo "$data[0] in $data[1]"?></i>&nbsp;&nbsp;</h4>
							<!--Menüleiste-->
							<nav class="navbar navbar-default" role="navigation">
								<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
									<ul class="nav navbar-nav">
										<!--Menü-Button Startseite-->
										<a class="navbar-brand" href="#" onClick="window.location='../../index.html'"><span class="glyphicon glyphicon-home"></span>  Startseite</a>
										<!--Menü-Button zurück-->
										<a class="navbar-brand" href="#" onClick="window.location='Schulart_Auswahl.php'"><span class="glyphicon glyphicon-arrow-left"></span>  zurück</a>
										<!--Menü-Button Diagramme-->
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span>  Diagramme<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<li>
													<a href="#A01" onclick="javascript:klappe('A01');">Entwicklung Schülerzahlen</a>
												</li>
												<li>
													<a href="#A02" onclick="javascript:klappe('A02');">Entwicklung Aussiedler</a>
												</li>
												<li>
													<a href="#A03" onclick="javascript:klappe('A03');">Entwicklung Asylbewerber</a>
												</li>
												<li>
													<a href="#A04" onclick="javascript:klappe('A04');">Entwicklung Flüchtlinge</a>
												</li>
												<li>
													<a href="#A05" onclick="javascript:klappe('A05');">Entwicklung Migranten gesamt</a>
												</li>	
											</ul>
										</li>
										<!--Menü-Button 2019-09-06-->
										<li class="dropdown active">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">2019-09-06<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
													<ul class="dropdown-menu">
														<li>
															<a href="#A91" onclick="javascript:klappe('A91');">Schuldaten</a>
														</li>
														<li>
															<a href="#A92" onclick="javascript:klappe('A92');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
														</li>
														<li>
															<a href="#A93" onclick="javascript:klappe('A93');">Schülerzahlen gruppiert nach Klassenstufen</a>
														</li>
														<li>
															<a href="#A94" onclick="javascript:klappe('A94');">Schülerzahlen gruppiert nach Gemeinden</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B91" onclick="javascript:klappe('B91');">Schüleranteil nach Nationalität</a></li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
													<ul class="dropdown-menu">
														<li><a href="#K91" onclick="javascript:klappe('K91');">Standort</a></li>
														<li><a href="#K92" onclick="javascript:klappe('K92');">Einzugsbereich 2018-09-14</a></li>
														<li><a href="#K93" onclick="javascript:klappe('K93');">Einzugsbereich mit Sterndiagramm</a></li>
													</ul>
												</li>	
											</ul>
										</li>
										<!--Menü-Button 2018-09-14-->
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">2018-09-14<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
													<ul class="dropdown-menu">
														<li>
															<a href="#A81" onclick="javascript:klappe('A81');">Schuldaten</a>
														</li>
														<li>
															<a href="#A82" onclick="javascript:klappe('A82');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
														</li>
														<li>
															<a href="#A83" onclick="javascript:klappe('A83');">Schülerzahlen gruppiert nach Klassenstufen</a>
														</li>
														<li>
															<a href="#A84" onclick="javascript:klappe('A84');">Schülerzahlen gruppiert nach Gemeinden</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B81" onclick="javascript:klappe('B81');">Schüleranteil nach Nationalität</a></li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
													<ul class="dropdown-menu">
														<li><a href="#K81" onclick="javascript:klappe('K81');">Standort</a></li>
														<li><a href="#K82" onclick="javascript:klappe('K82');">Einzugsbereich 2018-09-14</a></li>
														<li><a href="#K83" onclick="javascript:klappe('K83');">Einzugsbereich mit Sterndiagramm</a></li>
													</ul>
												</li>	
											</ul>
										</li>
										<!--Menü-Button 2017-09-29-->
										<li class="dropdown active">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">2017-09-29<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
													<ul class="dropdown-menu">
														<li>
															<a href="#A71" onclick="javascript:klappe('A71');">Schuldaten</a>
														</li>
														<li>
															<a href="#A72" onclick="javascript:klappe('A72');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
														</li>
														<li>
															<a href="#A73" onclick="javascript:klappe('A73');">Schülerzahlen gruppiert nach Klassenstufen</a>
														</li>
														<li>
															<a href="#A74" onclick="javascript:klappe('A74');">Schülerzahlen gruppiert nach Gemeinden</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B71" onclick="javascript:klappe('B71');">Schüleranteil nach Nationalität</a></li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
													<ul class="dropdown-menu">
														<li><a href="#K71" onclick="javascript:klappe('K71');">Standort</a></li>
														<li><a href="#K72" onclick="javascript:klappe('K72');">Einzugsbereich 2017-09-29</a></li>
														<li><a href="#K73" onclick="javascript:klappe('K73');">Einzugsbereich mit Sterndiagramm</a></li>
													</ul>
												</li>	
											</ul>
										</li>
										<!--Menü-Button 2016-09-30-->
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">2016-09-30<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
													<ul class="dropdown-menu">
														<li>
															<a href="#A61" onclick="javascript:klappe('A61');">Schuldaten</a>
														</li>
														<li>
															<a href="#A62" onclick="javascript:klappe('A62');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
														</li>
														<li>
															<a href="#A63" onclick="javascript:klappe('A63');">Schülerzahlen gruppiert nach Klassenstufen</a>
														</li>
														<li>
															<a href="#A64" onclick="javascript:klappe('A64');">Schülerzahlen gruppiert nach Gemeinden</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B61" onclick="javascript:klappe('B61');">Schüleranteil nach Nationalität</a></li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
													<ul class="dropdown-menu">
														<li><a href="#K61" onclick="javascript:klappe('K61');">Standort</a></li>
														<li><a href="#K62" onclick="javascript:klappe('K62');">Einzugsbereich 2016-09-30</a></li>
														<li><a href="#K63" onclick="javascript:klappe('K63');">Einzugsbereich mit Sterndiagramm</a></li>
													</ul>
												</li>	
											</ul>
										</li>
										<!--Menü-Button 2015-09-30-->
										<li class="dropdown active">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">2015-09-30<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
													<ul class="dropdown-menu">
														<li>
															<a href="#A51" onclick="javascript:klappe('A51');">Schuldaten</a>
														</li>
														<li>
															<a href="#A52" onclick="javascript:klappe('A52');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
														</li>
														<li>
															<a href="#A53" onclick="javascript:klappe('A53');">Schülerzahlen gruppiert nach Klassenstufen</a>
														</li>
														<li>
															<a href="#A54" onclick="javascript:klappe('A54');">Schülerzahlen gruppiert nach Gemeinden</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B51" onclick="javascript:klappe('B51');">Schüleranteil nach Nationalität</a></li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
													<ul class="dropdown-menu">
														<li><a href="#K51" onclick="javascript:klappe('K51');">Standort</a></li>
														<li><a href="#K52" onclick="javascript:klappe('K52');">Einzugsbereich 2015-09-30</a></li>
													</ul>
												</li>	
											</ul>
										</li>
										<!--Menü-Button 2014-09-23-->
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">2014-09-23<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
													<ul class="dropdown-menu">
														<li>
															<a href="#A41" onclick="javascript:klappe('A41');">Schuldaten</a>
														</li>
														<li>
															<a href="#A42" onclick="javascript:klappe('A42');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
														</li>
														<li>
															<a href="#A43" onclick="javascript:klappe('A43');">Schülerzahlen gruppiert nach Klassenstufen</a>
														</li>
														<li>
															<a href="#A44" onclick="javascript:klappe('A44');">Schülerzahlen gruppiert nach Gemeinden</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B41" onclick="javascript:klappe('B41');">Schüleranteil nach Nationalität</a></li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
													<ul class="dropdown-menu">
														<li><a href="#K41" onclick="javascript:klappe('K41');">Standort</a></li>
														<li><a href="#K42" onclick="javascript:klappe('K42');">Einzugsbereich 2014-09-23</a></li>
													</ul>
												</li>	
											</ul>
										</li>																				
										<!--Menü-Button Historie-->
										<li class="dropdown active">
											 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Historie<strong class="caret"></strong></a>
											<ul class="dropdown-menu">
												<!--Menü-Button 2013-09-10-->
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown">2013-09-10</a>
													<ul class="dropdown-menu">
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
															<ul class="dropdown-menu">
																<li>
																	<a href="#A31" onclick="javascript:klappe('A31');">Schuldaten</a>
																</li>
																<li>
																	<a href="#A31" onclick="javascript:klappe('A32');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
																</li>
																<li>
																	<a href="#A31" onclick="javascript:klappe('A33');">Schülerzahlen gruppiert nach Klassenstufen</a>
																</li>
																<li>
																	<a href="#A31" onclick="javascript:klappe('A34');">Schülerzahlen gruppiert nach Gemeinden</a>
																</li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
															<ul class="dropdown-menu">
																<li><a href="#B31" onclick="javascript:klappe('B31');">Schüleranteil nach Nationalität</a></li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
															<ul class="dropdown-menu">
																<li><a href="#K31" onclick="javascript:klappe('K31');">Standort</a></li>
																<li><a href="#K32" onclick="javascript:klappe('K32');">Einzugsbereich 2013-09-10</a></li>
															</ul>
														</li>	
													</ul>
												</li>
												<!--Menü-Button 2012-09-12-->
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown">2012-09-12</a>
													<ul class="dropdown-menu">
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
															<ul class="dropdown-menu">
																<li>
																	<a href="#A21" onclick="javascript:klappe('A21');">Schuldaten</a>
																</li>
																<li>
																	<a href="#A22" onclick="javascript:klappe('A22');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
																</li>
																<li>
																	<a href="#A23" onclick="javascript:klappe('A23');">Schülerzahlen gruppiert nach Klassenstufen</a>
																</li>
																<li>
																	<a href="#A24" onclick="javascript:klappe('A24');">Schülerzahlen gruppiert nach Gemeinden</a>
																</li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
															<ul class="dropdown-menu">
																<li><a href="#B21" onclick="javascript:klappe('B21');">Schüleranteil nach Nationalität</a></li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
															<ul class="dropdown-menu">
																<li><a href="#K21" onclick="javascript:klappe('K21');">Standort</a></li>
																<li><a href="#K22" onclick="javascript:klappe('K22');">Einzugsbereich 2012-09-12</a></li>
															</ul>
														</li>	
													</ul>
												</li>
												<!--Untermenü 2011-09-09-->
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown">2011-09-09</a>
													<ul class="dropdown-menu">
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Statistiken</a>
															<ul class="dropdown-menu">
																<li>
																	<a href="#A11" onclick="javascript:klappe('A11');">Schuldaten</a>
																</li>
																<li>
																	<a href="#A12" onclick="javascript:klappe('A12');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</a>
																</li>
																<li>
																	<a href="#A13" onclick="javascript:klappe('A13');">Schülerzahlen gruppiert nach Klassenstufen</a>
																</li>
																<li>
																	<a href="#A14" onclick="javascript:klappe('A14');">Schülerzahlen gruppiert nach Gemeinden</a>
																</li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
															<ul class="dropdown-menu">
																<li><a href="#B11" onclick="javascript:klappe('B11');">Schüleranteil nach Nationalität</a></li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-picture"></span> Karte</a>
															<ul class="dropdown-menu">
																<li><a href="#K11" onclick="javascript:klappe('K11');">Standort</a></li>
																<li><a href="#K12" onclick="javascript:klappe('K12');">Einzugsbereich 2011-09-09</a></li>
															</ul>
														</li>
													</ul>
												</li><!--Ende Untermenü 2011-09-09-->	
											</ul>
										</li><!--Ende Menü-Button Historie-->
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a class="navbar-brand" href="#" onClick="history.go(0)" VALUE="Refresh">alle Abfragen schließen  <span class="glyphicon glyphicon-remove"></span></a>
										</li>										
									</ul>
								</div>				
							</nav>
						</div>
					</div><!--Ende Grid Menüleiste-->	
					
					<!--Grid Ausgabe-->
					<div class="row" charset="utf-8">	
						<div class="col-md-12"><br></br>
							<!--Ausgabe Menü-Button Diagramme-->
							<div style="display: none" id="A01">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A01'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/diagramme_neu.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="A02">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A02'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/diagramme_Aussiedler.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="A03">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A03'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/diagramme_Asylbewerber.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="A04">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A04'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/diagramme_Fluechtlinge.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="A05">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A05'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/diagramme_Migranten.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2019-09-06-->
							<div style="display: none" id="A91">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A91'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2019_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A92">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A92'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2019_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A93">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A93'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2019_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A94">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A94'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2019_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2019-09-06-->
							<div style="display: none" id="B91"><h1 class="text-center">Schüleranteil nach Nationalität 2019-09-06</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B91'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r18.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2019-09-06-->
							<div style="display: none" id="K91">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K91'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2019.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K92">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K92'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2019.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K93">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K93'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_mit_sterndiagramm_2019.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2018-09-14-->
							<div style="display: none" id="A81">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A81'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2018_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A82">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A82'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2018_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A83">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A83'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2018_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A84">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A84'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2018_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2018-09-14-->
							<div style="display: none" id="B81"><h1 class="text-center">Schüleranteil nach Nationalität 2018-09-14</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B81'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r18.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2018-09-14-->
							<div style="display: none" id="K81">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K81'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2018.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K82">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K82'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2018.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K83">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K83'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_mit_sterndiagramm_2018.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2017-09-29-->
							<div style="display: none" id="A71">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A71'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2017_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A72">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A72'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2017_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A73">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A73'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2017_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A74">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A74'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2017_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2017-09-29-->
							<div style="display: none" id="B71"><h1 class="text-center">Schüleranteil nach Nationalität 2017-09-29</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B71'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r17.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2017-09-29-->
							<div style="display: none" id="K71">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K71'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2017.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K72">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K72'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2017.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K73">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K73'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_mit_sterndiagramm_2017.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2016-09-30-->
							<div style="display: none" id="A61">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A61'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2016_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A62">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A62'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2016_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A63">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A63'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2016_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A64">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A64'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2016_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2016-09-30-->
							<div style="display: none" id="B61"><h1 class="text-center">Schüleranteil nach Nationalität 2016-09-30</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B61'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r16.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2016-09-30-->
							<div style="display: none" id="K61">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K61'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2016.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K62">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K62'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2016.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K63">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K63'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_mit_sterndiagramm_2016.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2015-09-30-->
							<div style="display: none" id="A51">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A51'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2015_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A52">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A52'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2015_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A53">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A53'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2015_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A54">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A54'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2015_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2015-09-30-->
							<div style="display: none" id="B51"><h1 class="text-center">Schüleranteil nach Nationalität 2015-09-30</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B51'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r15.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2015-09-30-->
							<div style="display: none" id="K51">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K51'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2015.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K52">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K52'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2015.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2014-09-23-->
							<div style="display: none" id="A41">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A41'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2014_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A42">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A42'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2014_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A43">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A43'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2014_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A44">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A44'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2014_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2014-09-23-->
							<div style="display: none" id="B41"><h1 class="text-center">Schüleranteil nach Nationalität 2014-09-23</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B41'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r14.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2014-09-23-->
							<div style="display: none" id="K41">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K41'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2014.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K42">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K42'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2014.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2013-09-10-->
							<div style="display: none" id="A31">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A31'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2013_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A32">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A32'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2013_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A33">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A33'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2013_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A34">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A34'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2013_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2013-09-10-->
							<div style="display: none" id="B31"><h1 class="text-center">Schüleranteil nach Nationalität 2013-09-10</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B31'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r13.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2013-09-10-->
							<div style="display: none" id="K31">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K31'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2013.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K32">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K32'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2013.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2012-09-12-->
							<div style="display: none" id="A21">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A21'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2012_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A22">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A22'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2012_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A23">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A23'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2012_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A24">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A24'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2012_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2012-09-12-->
							<div style="display: none" id="B21"><h1 class="text-center">Schüleranteil nach Nationalität 2012-09-12</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B21'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r12.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2012-09-12-->
							<div style="display: none" id="K21">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K21'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2012.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K22">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K22'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2012.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2011-09-09-->
							<div style="display: none" id="A11">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A11'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2011_s1.php");?><br></br>						
							</div>
							<div style="display: none" id="A12">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A12'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2011_s2.php");?><br></br>						
							</div>
							<div style="display: none" id="A13">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A13'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2011_s3.php");?><br></br>						
							</div>
							<div style="display: none" id="A14">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A14'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/sep_block_2011_s4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2011-09-09-->
							<div style="display: none" id="B11"><h1 class="text-center">Schüleranteil nach Nationalität 2011-09-09</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B11'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("schule/diagramme_r11.php");?><br></br>					   
							</div>
							<!--Karte Ausgabe Menü-Button 2011-09-09-->
							<div style="display: none" id="K11">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K11'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/standortkarte_2011.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="K12">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('K12'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("schule/karte_einzugsbereich_2011.php"); ?><br></br>					   
							</div>
						</div>
					</div><!--Ende Grid Ausgabe-->						
				</div><!--Ende Grid Container-->
					
				<script src="../../js/bootstrap.min.js"></script>
				<script src="../../js/scripts.js"></script>
				
			</body>
		</html>
<?	}