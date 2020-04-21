<?php


$themendatei='apo_test.php';//name der Themendatei
$thema='Apo Test';//Themenname für Anzeige im Geoportal
$tabelle='geoportal_apotheken';//Tabellenname in der Datenbank	
$schema='geoportal';//Schema in der Datenbank
$themaWMS='https://geoport-lk-mse.de/webservices/mse_all';//Link des WMS Dienstes
$layer='Apotheken';// Layer in der WMS Datei
$layerid='110020';// LayerID wird für Metadatenanzeige benötigt

$queryselect='ih';// Attribute welche ausgegeben werden sollen
include('abfrage.php');// Attribute welche ausgegeben werden sollen
?>