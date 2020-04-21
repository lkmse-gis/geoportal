<?php
$dbp="geobasis_mse2";
$userp="gisadmin";
$hostp="pgsql-server";
$passwordp="361xpKT_4";



    $conn = pg_connect ("dbname=$dbp user=$userp host=$hostp password=$passwordp")
    or die ("<div align=\"center\">Keine Verbindung zur PgSQL-DB m&ouml;glich oder die Datenbank \"<b>".$db."</b>\" existiert nicht!<br><br>Wenden Sie sich an den Administrator.</div>");

    $dbqueryp = "pg_query";
    $fetcharrayp = "pg_fetch_assoc";
    $connectp = $conn;

$ip=getenv('REMOTE_ADDR');
$ip_array=explode(".",$ip);




?>
