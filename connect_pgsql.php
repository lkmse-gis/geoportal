<?php
$dbp="kvwmap_alk";
$userp="kvwmap";
$hostp="localhost";
$passwordp="kvwmap";



    $conn = pg_connect ("dbname=$dbp user=$userp host=$hostp password=$passwdp")
    or die ("<div align=\"center\">Keine Verbindung zur PgSQL-DB m?glich oder die Datenbank \"<b>".$db."</b>\" existiert nicht!<br><br>Wenden Sie sich an den Administrator.</div>");

    $dbqueryp = "pg_query";
    $fetcharrayp = "pg_fetch_array";
    $connectp = $conn;

$ip=getenv('REMOTE_ADDR');
$ip_array=explode(".",$ip);

if (($ip_array[0]=='192' AND $ip_array[1]=='168') OR ($ip_array[0]=='128' AND $ip_array[1]=='1'))
   {
    define('URL','http://geoport.landkreis-mueritz.de/');
   }
   else
   {
    define('URL','http://geoport.landkreis-mueritz.de:10000/');
   }


?>
