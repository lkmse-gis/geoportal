<?php

//globale Varibalen
$reg_nr=$_GET["reg_nr"];
$stichtage=['2011-09-09','2012-09-12','2013-09-10','2014-09-23','2015-09-30','2016-09-30','2017-09-29','2018-09-14','2019-09-06'];

if (strlen($reg_nr) < 1)
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
				
				<!-- **************** Export Bibliotheken ****************** -->
				
				<script type="text/javascript" src="../../export_libs/js/jquery-3.1.1.js"></script>
				<script type="text/javascript" src="../../export_libs/js/FileSaver.min.js"></script>
				  
				<!-- für Allgemeine Exportfunktionen -->
				<script type="text/javascript" src="../../export_libs/js/tableExport.js"></script>
				  
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
				
				<!--Grid Auswahlliste-->
				<div class="row">
					<div class="col-md-12">
						<div class="col-xs-5"><!--Breite Auswahlliste-->					
							<form action="amtsb.php" method="get" name="reg_nr">
								<h4><strong>Amtsbereich auswählen:</strong></h4>
								<select class="form-control select select-primary" data-toggle="select" name="reg_nr" onchange="document.reg_nr.submit();">									
									<option>Bitte Amtsbereich auswählen</option>
									<option value="13">Neubrandenburg</option>
									<option value="5202">Demmin</option>
									<option value="5208">Dargun</option>
									<option value="5221">Demmnin-Land</option>
									<option value="5222">Treptower Tollensewinkel</option>
									<option value="5223">Malchin am Kummerower See</option>
									<option value="5224">Stavenhagen</option>
									<option value="5503">Neustrelitz</option>
									<option value="5504">Feldberger Seenlandschaft</option>
									<option value="5513">Friedland</option>
									<option value="5514">Woldegk</option>
									<option value="5516">Neustrelitz-Land</option>
									<option value="5517">Neverin</option>
									<option value="5520">Stargarder Land</option>
									<option value="5522">Mecklenburgische Kleinseenplatte</option>
									<option value="5603">Waren (Müritz)</option>
									<option value="5618">Penzliner Land</option>
									<option value="5619">Malchow</option>
									<option value="5620">Seenlandschaft Waren</option>
									<option value="5621">Röbel-Müritz</option>
								</select>
							</form><br></br>
							
							<button class="btn btn-default" type="button" onClick="window.location='../../index.html'"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;
								Startseite
							</button>
						</div>
					</div>
				</div><!--Ende Grid Auswahlliste-->
			
			</div><!--Ende Grid Container-->
				
			<script src="../../js/bootstrap.min.js"></script>
			<script src="../../js/scripts.js"></script>
			
		</body>
		</html>
<?	}

if (strlen($reg_nr) > 0)
    {
	include ("../../../../includes/connect_geobasis.php");
	include("amtsb/2019/sep_2019_k.php");
	include("amtsb/2018/sep_2018_k.php");
	include("amtsb/2017/sep_2017_k.php");
	include("amtsb/2016/sep_2016_k.php");
	include("amtsb/2015/sep_2015_k.php");
	include("amtsb/2014/sep_2014_k.php");
	include("amtsb/2013/sep_2013_k.php");
	include("amtsb/2012/sep_2012_k.php");
	include("amtsb/2011/sep_2011_k.php");
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
								<?
									if ($reg_nr == 13){ echo "statistische Auswertung des Amtsbereichs Neubrandenburg";}
									elseif ($reg_nr == 5202){ echo "statistische Auswertung des Amtsbereichs Demmin";}
									elseif ($reg_nr == 5208){ echo "statistische Auswertung des Amtsbereichs Dargun";}
									elseif ($reg_nr == 5221){ echo "statistische Auswertung des Amtsbereichs Demmin-Land";}
									elseif ($reg_nr == 5222){ echo "statistische Auswertung des Amtsbereichs Treptower Tollensewinkel";}
									elseif ($reg_nr == 5223){ echo "statistische Auswertung des Amtsbereichs Malchin am Kummerower See";}
									elseif ($reg_nr == 5224){ echo "statistische Auswertung des Amtsbereichs Stavenhagen";}
									elseif ($reg_nr == 5503){ echo "statistische Auswertung des Amtsbereichs Neustrelitz";}
									elseif ($reg_nr == 5504){ echo "statistische Auswertung des Amtsbereichs Feldberger Seenlandschaft";}
									elseif ($reg_nr == 5513){ echo "statistische Auswertung des Amtsbereichs Friedland";}
									elseif ($reg_nr == 5514){ echo "statistische Auswertung des Amtsbereichs Woldegk";}
									elseif ($reg_nr == 5516){ echo "statistische Auswertung des Amtsbereichs Neustrelitz-Land";}
									elseif ($reg_nr == 5517){ echo "statistische Auswertung des Amtsbereichs Neverin";}
									elseif ($reg_nr == 5520){ echo "statistische Auswertung des Amtsbereichs Stargarder Land";}
									elseif ($reg_nr == 5522){ echo "statistische Auswertung des Amtsbereichs Mecklenburgische Kleinseenplatte";}
									elseif ($reg_nr == 5603){ echo "statistische Auswertung des Amtsbereichs Waren (Müritz)";}
									elseif ($reg_nr == 5618){ echo "statistische Auswertung des Amtsbereichs Penzliner Land";}
									elseif ($reg_nr == 5619){ echo "statistische Auswertung des Amtsbereichs Malchow";}
									elseif ($reg_nr == 5620){ echo "statistische Auswertung des Amtsbereichs Seenlandschaft Waren";}
									elseif ($reg_nr == 5621){ echo "statistische Auswertung des Amtsbereichs Röbel-Müritz";}
								?>
							</h2>							
						</div>
					</div>
					<!--Grid Menüleiste-->
					<div class="row">
						<div class="col-md-12">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<!--Menüleiste-->
							<nav class="navbar navbar-default" role="navigation">
								<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
									<ul class="nav navbar-nav">
										<!--Menü-Button Startseite-->
										<a class="navbar-brand" href="#" onClick="window.location='../../index.html'"><span class="glyphicon glyphicon-home"></span>  Startseite</a>
										<!--Menü-Button zurück-->
										<a class="navbar-brand" href="#" onClick="window.location='amtsb.php'"><span class="glyphicon glyphicon-arrow-left"></span>  zurück</a>
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
															<a href="#A91" onclick="javascript:klappe('A91');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
														</li>
														<li>
															<a href="#A92" onclick="javascript:klappe('A92');">Schülerzahlen gruppiert nach Schularten der Schule</a>
														</li>
														<li>
															<a href="#A93" onclick="javascript:klappe('A93');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
														</li>
														<li>
															<a href="#A94" onclick="javascript:klappe('A94');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B91" onclick="javascript:klappe('B91');">Schüleranteil nach Nationalität</a></li>
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
															<a href="#A81" onclick="javascript:klappe('A81');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
														</li>
														<li>
															<a href="#A82" onclick="javascript:klappe('A82');">Schülerzahlen gruppiert nach Schularten der Schule</a>
														</li>
														<li>
															<a href="#A83" onclick="javascript:klappe('A83');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
														</li>
														<li>
															<a href="#A84" onclick="javascript:klappe('A84');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B81" onclick="javascript:klappe('B81');">Schüleranteil nach Nationalität</a></li>
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
															<a href="#A71" onclick="javascript:klappe('A71');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
														</li>
														<li>
															<a href="#A72" onclick="javascript:klappe('A72');">Schülerzahlen gruppiert nach Schularten der Schule</a>
														</li>
														<li>
															<a href="#A73" onclick="javascript:klappe('A73');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
														</li>
														<li>
															<a href="#A74" onclick="javascript:klappe('A74');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B71" onclick="javascript:klappe('B71');">Schüleranteil nach Nationalität</a></li>
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
															<a href="#A61" onclick="javascript:klappe('A61');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
														</li>
														<li>
															<a href="#A62" onclick="javascript:klappe('A62');">Schülerzahlen gruppiert nach Schularten der Schule</a>
														</li>
														<li>
															<a href="#A63" onclick="javascript:klappe('A63');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
														</li>
														<li>
															<a href="#A64" onclick="javascript:klappe('A64');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B61" onclick="javascript:klappe('B61');">Schüleranteil nach Nationalität</a></li>
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
															<a href="#A51" onclick="javascript:klappe('A51');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
														</li>
														<li>
															<a href="#A52" onclick="javascript:klappe('A52');">Schülerzahlen gruppiert nach Schularten der Schule</a>
														</li>
														<li>
															<a href="#A53" onclick="javascript:klappe('A53');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
														</li>
														<li>
															<a href="#A54" onclick="javascript:klappe('A54');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B51" onclick="javascript:klappe('B51');">Schüleranteil nach Nationalität</a></li>
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
															<a href="#A41" onclick="javascript:klappe('A41');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
														</li>
														<li>
															<a href="#A42" onclick="javascript:klappe('A42');">Schülerzahlen gruppiert nach Schularten der Schule</a>
														</li>
														<li>
															<a href="#A43" onclick="javascript:klappe('A43');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
														</li>
														<li>
															<a href="#A44" onclick="javascript:klappe('A44');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
														</li>
													</ul>
												</li>
												<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
													<ul class="dropdown-menu">
														<li><a href="#B41" onclick="javascript:klappe('B41');">Schüleranteil nach Nationalität</a></li>
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
																	<a href="#A31" onclick="javascript:klappe('A31');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
																</li>
																<li>
																	<a href="#A32" onclick="javascript:klappe('A32');">Schülerzahlen gruppiert nach Schularten der Schule</a>
																</li>
																<li>
																	<a href="#A33" onclick="javascript:klappe('A33');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
																</li>
																<li>
																	<a href="#A34" onclick="javascript:klappe('A34');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
																</li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
															<ul class="dropdown-menu">
																<li><a href="#B31" onclick="javascript:klappe('B31');">Schüleranteil nach Nationalität</a></li>
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
																	<a href="#A21" onclick="javascript:klappe('A21');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
																</li>
																<li>
																	<a href="#A22" onclick="javascript:klappe('A22');">Schülerzahlen gruppiert nach Schularten der Schule</a>
																</li>
																<li>
																	<a href="#A23" onclick="javascript:klappe('A23');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
																</li>
																<li>
																	<a href="#A24" onclick="javascript:klappe('A24');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
																</li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
															<ul class="dropdown-menu">
																<li><a href="#B21" onclick="javascript:klappe('B21');">Schüleranteil nach Nationalität</a></li>
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
																	<a href="#A11" onclick="javascript:klappe('A11');">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a>
																</li>
																<li>
																	<a href="#A12" onclick="javascript:klappe('A12');">Schülerzahlen gruppiert nach Schularten der Schule</a>
																</li>
																<li>
																	<a href="#A13" onclick="javascript:klappe('A13');">Schülerzahlen gruppiert nach Schulart der Schüler</a>
																</li>
																<li>
																	<a href="#A14" onclick="javascript:klappe('A14');">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a>
																</li>
															</ul>
														</li>
														<li class="dropdown dropdown-submenu"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span> Diagramme</a>
															<ul class="dropdown-menu">
																<li><a href="#B11" onclick="javascript:klappe('B11');">Schüleranteil nach Nationalität</a></li>
															</ul>
														</li>
													</ul>
												</li><!--Ende Untermenü 2011-09-09-->	
											</ul>
										</li><!--Ende Menü-Button Historie-->
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a class="navbar-brand" href="#" onClick="history.go(0)" VALUE="Refresh">alle Abfragen schließen  <span class="glyphicon glyphicon-remove"></a>
										</li>										
									</ul>
								</div>				
							</nav>
						</div>
					</div><!--Ende Grid Menüleiste-->
					
					<!--Grid Ausgabe-->
					<div class="row">
						<div class="col-md-12">
							<!--Ausgabe Menü-Button Diagramme-->
							<div style="display: none" id="A01">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A01'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/diagramme_k1.php");?><br></br>					   
							</div>
							<div style="display: none" id="A02">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A02'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/diagramme_Aussiedler.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="A03">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A03'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/diagramme_Asylbewerber.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="A04">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A04'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/diagramme_Fluechtlinge.php"); ?><br></br>					   
							</div>
							<div style="display: none" id="A05">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A05'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/diagramme_Migranten.php"); ?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2019-09-06-->
							<div style="display: none" id="A91">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A91'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2019/sep_block_2019_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A92">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A92'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2019/sep_block_2019_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A93">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A93'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2019/sep_block_2019_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A94">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A94'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2019/sep_block_2019_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2019-09-06-->
							<div style="display: none" id="B91"><h1 class="text-center">Schüleranteil nach Nationalität 2019-09-06</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B91'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2019/diagramme_r19.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2018-09-14-->
							<div style="display: none" id="A81">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A81'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2018/sep_block_2018_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A82">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A82'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2018/sep_block_2018_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A83">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A83'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2018/sep_block_2018_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A84">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A84'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2018/sep_block_2018_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2018-09-14-->
							<div style="display: none" id="B81"><h1 class="text-center">Schüleranteil nach Nationalität 2018-09-14</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B81'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2018/diagramme_r18.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2017-09-29-->
							<div style="display: none" id="A71">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A71'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2017/sep_block_2017_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A72">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A72'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2017/sep_block_2017_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A73">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A73'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2017/sep_block_2017_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A74">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A74'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2017/sep_block_2017_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2017-09-29-->
							<div style="display: none" id="B71"><h1 class="text-center">Schüleranteil nach Nationalität 2017-09-29</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B71'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2017/diagramme_r17.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2016-09-30-->
							<div style="display: none" id="A61">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A61'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2016/sep_block_2016_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A62">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A62'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2016/sep_block_2016_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A63">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A63'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2016/sep_block_2016_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A64">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A64'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2016/sep_block_2016_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2016-09-30-->
							<div style="display: none" id="B61"><h1 class="text-center">Schüleranteil nach Nationalität 2016-09-30</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B61'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2016/diagramme_r16.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2015-09-30-->
							<div style="display: none" id="A51">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A51'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2015/sep_block_2015_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A52">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A52'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2015/sep_block_2015_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A53">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A53'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2015/sep_block_2015_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A54">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A54'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2015/sep_block_2015_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2015-09-30-->
							<div style="display: none" id="B51"><h1 class="text-center">Schüleranteil nach Nationalität 2015-09-30</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B51'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2015/diagramme_r15.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2014-09-23-->
							<div style="display: none" id="A41">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A41'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2014/sep_block_2014_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A42">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A42'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2014/sep_block_2014_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A43">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A43'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2014/sep_block_2014_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A44">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A44'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2014/sep_block_2014_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2014-09-23-->
							<div style="display: none" id="B41"><h1 class="text-center">Schüleranteil nach Nationalität 2014-09-23</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B41'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2014/diagramme_r14.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2013-09-10-->
							<div style="display: none" id="A31">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A31'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2013/sep_block_2013_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A32">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A32'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2013/sep_block_2013_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A33">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A33'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2013/sep_block_2013_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A34">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A34'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2013/sep_block_2013_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2013-09-10-->
							<div style="display: none" id="B31"><h1 class="text-center">Schüleranteil nach Nationalität 2013-09-10</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B31'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2013/diagramme_r13.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2012-09-12-->
							<div style="display: none" id="A21">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A21'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2012/sep_block_2012_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A22">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A22'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2012/sep_block_2012_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A23">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A23'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2012/sep_block_2012_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A24">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A24'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2012/sep_block_2012_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2012-09-12-->
							<div style="display: none" id="B21"><h1 class="text-center">Schüleranteil nach Nationalität 2012-09-12</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B21'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2012/diagramme_r12.php");?><br></br>					   
							</div>
							<!--Statistik Ausgabe Menü-Button 2011-09-09-->
							<div style="display: none" id="A11">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A11'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2011/sep_block_2011_k1.php");?><br></br>						
							</div>
							<div style="display: none" id="A12">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A12'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2011/sep_block_2011_k2.php");?><br></br>						
							</div>
							<div style="display: none" id="A13">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A13'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2011/sep_block_2011_k3.php");?><br></br>						
							</div>
							<div style="display: none" id="A14">
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('A14'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
								<? include("amtsb/2011/sep_block_2011_k4.php");?><br></br>						
							</div>
							<!--Diagramme Ausgabe Menü-Button 2011-09-09-->
							<div style="display: none" id="B11"><h1 class="text-center">Schüleranteil nach Nationalität 2011-09-09</h1>
								<button style="float:right; color:black;" type="button" class="btn btn-xs btn-link" onclick="javascript:klappe('B11'); return false">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							   <? include("amtsb/2011/diagramme_r11.php");?><br></br>					   
							</div>
						</div>
					</div><!--Ende Grid Ausgabe-->					
				</div><!--Ende Grid Container-->
				
				<script src="../../js/bootstrap.min.js"></script>
				<script src="../../js/scripts.js"></script>
			
			</body>
		</html>
<?	}