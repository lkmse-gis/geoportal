<html>
<head>
<title>Geoportal Landkreis MSE - Downloads</title>
<meta name="author" content="Norman">
<meta name="generator" content="Ulli Meybohms HTML EDITOR">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
<style type="text/css">
	td
		{
			font-size: 16px;
			font-family: verdana;
		}
			a:link{color:#000000}
			a:visited{color:#000000}
</style>
</head>

<?
  $gemeindeteile_datum=filemtime("/var/www/apps/geoportal/downloads/krea/gemeindeteile_export_utf8.csv");
  $gemeindeteile_stand=date("d.m.Y",$gemeindeteile_datum);
  $abfuhrkalender_datum=filemtime("/var/www/apps/geoportal/downloads/krea/nb_krea_export_utf8.csv");
  $abfuhrkalender_stand=date("d.m.Y",$abfuhrkalender_datum);
?>

<body>
	<div align="center">
	<img src="geologo.jpg" width=100%>
	<table border=0>		
	<tr>				
	 <td align=center style="background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #000000;
						font-size: 34px;
						text-shadow: 1px 1px 1px #393939;"><b>Downloads</b>
				</td>
			</tr>
			</table>
			<br>
			<br>
			<br>
			
		<table border=0>
			<tr>
				<td colspan=3><b>Abfuhrkalender (CSV-Dateien)</b><br>Stand: <? echo $abfuhrkalender_stand; ?></td>
				<td width=50></td>
				<td colspan=2><b>Gemeindeteile mit Straßen (CSV-Datei)</b><br>Stand: <? echo $gemeindeteile_stand; ?></td>
			</tr>
			<tr height=10>
			  <td colspan=3><hr></td>
			  <td></td>
			  <td colspan=2><hr></td>
			</tr>
			<tr height=20>
			    <td width=250></td>
				<td width=100 align=center>ISO 8859-1</td>
			    <td width=100 align=center>UTF-8</td>
				<td width=50></td>
				<td width=100 align=center>ISO 8859-1</td>
			    <td width=100 align=center>UTF-8</td>
			<tr>
			    <td>Orte</td>
				<td align=center><a href="krea/orte_krea_export_ansi.csv"><img src="download.png" width=20></a></td>
				<td align=center><a href="krea/orte_krea_export_utf8.csv"><img src="download.png" width=20></a></td>
				<td></td>
				<td align=center><a href="krea/gemeindeteile_export_ansi.csv"><img src="download.png" width=20></a></td>
				<td align=center><a href="krea/gemeindeteile_export_utf8.csv"><img src="download.png" width=20></a></td>

			</tr>
			<tr>
			    <td>Städte (außer NB)</td>
				<td align=center><a href="krea/staedte_krea_export_ansi.csv"><img src="download.png" width=20></a></td>
				<td align=center><a href="krea/staedte_krea_export_utf8.csv"><img src="download.png" width=20></a></td>
			</tr>
			<tr>
			    <td>Neubrandenburg</td>
				<td align=center><a href="krea/nb_krea_export_ansi.csv"><img src="download.png" width=20></a></td>
				<td align=center><a href="krea/nb_krea_export_utf8.csv"><img src="download.png" width=20></a></td>
			</tr>
			<tr height=50>
				<td colspan=3></td>
				<td width=50></td>
				<td colspan=2></td>
			</tr>
			<tr>
				<td colspan=3><b>Adressverzeichnisse (CSV-Dateien)</b><br>Stand: <? echo $abfuhrkalender_stand; ?></td>
				<td width=50></td>
				<td colspan=2></td>
			</tr>
			<tr height=10>
			  <td colspan=3><hr></td>
			</tr>
			<tr height=20>
				<td width=250></td>
				<td width=100 align=center>ISO 8859-1</td>
			    <td width=100 align=center>UTF-8</td>
			<tr>
			<tr>
				<td>KEV</td>
				<td align=center><a href="51_0_jugendamt/strassenverzeichnis_kev_ansi.csv"><img src="download.png" width=20></a></td>
				<td align=center><a href="51_0_jugendamt/strassenverzeichnis_kev_utf8.csv"><img src="download.png" width=20></a></td>
			</tr>
			
		</table>
	</div>
</body>
</html>
