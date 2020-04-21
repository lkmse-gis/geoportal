<?php
	

	
	$themendatei='zert_gesundheitskurse.php';
	$thema="Zertifizierte Gesundheitskurse";
	$tabelle="geoportal_zert_gesundheitskurse";
	$schema="geoportal";
	$themaWMS="https://geoport-lk-mse.de/webservices/zert_gesundheitskurse";
	$layer="Zertifizierte_Gesundheitskurse";
	$layerid="110650";
	$get_themenname="Zertifizierte_Gesundheitskurse";
	
	$queryselect='geoportal_anschrift,anbieter,beschreibung,tel,fax,internet';
	
	$beschriftung[0]='Anschrift';
	$beschriftung[1]='Inhaber';
	$beschriftung[2]='Telefon';
	$beschriftung[3]='Fax';
	$beschriftung[4]='Internet';
	$beschriftung[5]='E-Mail';

	

	
	include("abfrage.php") ;
	



	
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

</body>
</html>