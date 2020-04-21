<?php
	

	
	$themendatei='apotheken.php';//name der Themendatei
	$thema="Apotheken";//Themenname	für Anzeige im Geoportal					
	$sicht="geoportal_apotheken";	//Tabellenname in der Datenbank																	
	$schema="geoportal"; //Schema in der Datenbank
	$themaWMS="https://geoport-lk-mse.de/webservices/mse_all"; //Link des WMS Dienstes
	$layer="Apotheken"; // Layer in der WMS Datei
	$layerid="110020"; // LayerID wird für Metadatenanzeige benötigt
	
	
	$queryselect='geoportal_anschrift,ih,tel,fax,internet,email,oeffnungszeiten'; // Attribute welche ausgegeben werden sollen
	
	//Festlegen der Auttributreihenfolge für die Ausgabe
	
	$beschriftung[0]='Anschrift';
	$beschriftung[1]='Inhaber';
	$beschriftung[2]='Telefon';
	$beschriftung[3]='Fax';
	$beschriftung[4]='Internet';
	$beschriftung[5]='E-Mail';
	$beschriftung[6]='Öffnungszeiten';
	

	//Schnittstelle automatisiertes Script
	include("../../abfrage.php") ;
	



	
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

</body>
</html>