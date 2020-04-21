<?php
	

	
	$themendatei='kliniken.php';
	global $themandatei;
	
	$thema="Kliniken";
	$tabelle="geoportal_kliniken";
	$schema="geoportal";
	$themaWMS="https://geoport-lk-mse.de/webservices/mse_all";
	$layer="Kliniken";
	$layerid="110030";
	$get_themenname="kliniken";
	
	$queryselect='geoportal_anschrift,typ,tel,fax,internet';
	
	$beschriftung[0]='Anschrift';
	$beschriftung[1]='Typ';
	$beschriftung[2]='Telefon';
	$beschriftung[3]='Fax';
	$beschriftung[4]='Internet';
	
	include("abfrage.php") ;
	
	


	
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

</body>
</html>