<?php

include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');
	

$datum = getdate(time());
$year=$datum[year];
$month=$datum[mon];
$day=$datum[mday];
$hour=$datum[hours];
$minute=$datum[minutes];
$second=$datum[seconds];
if (strlen($month) == 1) $month='0'.$month;
if (strlen($day) == 1) $day='0'.$day;
if (strlen($hour) == 1) $hour='0'.$hour;
if (strlen($minute) == 1) $minute='0'.$minute;
if (strlen($second) == 1) $second='0'.$second;
$heute=$day.'.'.$month.'.'.$year;
$wf_gid=$_GET["wf_gid"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterst?? CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link href="css/style_css.php" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
	</head>
<body link=blue vlink=purple>
<img src="../../images/geoportal_logo.png" width=1200 ><h2> Info zum Gewerbestandort Neubrandenburg</h2>

<BR>

</head>

<div class=WordSection1>

<p class=MsoNormal><span>Hier werden Sie weitergeleitet zum Portal der Stadt Neubrandenburg für weitere Informationen!<P><B>Link: </B></span><span style='font-family:"Arial","sans-serif"'>
<a href="https://neubrandenburg.de/Wirtschaft-Entwicklung/Investieren-in-Neubrandenburg/Gewerbestandorte" >Investieren in Neubrandenburg - Gewerbestandorte</a></span>
</p>

<p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

</div>

</body>

</html>



