<?php
include ("includes/portal_functions.php");

$ip=getenv('REMOTE_ADDR');
$ip_array=explode(".",$ip);

$ip=getenv('REMOTE_ADDR');
$ip_array=explode(".",$ip);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
<style type="text/css">
 #map {width:450px;height: 355px;border: 1px solid black;}
</style>
<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
</head>
<body onload="init();load();">
<div id="container">
  <div id="header">
    <?php
		head_portal();
	?>
  </div>
  <div id="wrapper">
    <div id="content">
		<br>
		<table width="80%" border="0" cellpadding="0" align="center" cellspacing="0">
			<tr>
				<td colspan=3 align=center bgcolor=<? echo $header_farbe ;?>>
					<h2><? echo $font_farbe ;?>kvwmap - Das WEB-GIS der Kreisverwaltung<? echo $font_farbe_end ;?></h2>
				</td>
			</tr>
			<tr>
				<td colspan=3 align=center height=70>
					<b>Kvwmap</b> ist ein WEB-GIS(Geografisches Informationssystem) welches auf Basis von Open-Source-Software entwickelt wurde. Kernstück dieser Applikation ist der UMN-Mapserver. Die Datenhaltung erfolgt in MYSQL- und PostgreSQL-Datenbanken.
					Entwickelt wurde dieses System hauptsächlich am Steinbeis TFZ für Geoinformatik an der Universität Rostock. Die Pflege und Weiterentwicklung des Systems erfolgt durch die Firma GDI-Service Rostock.<br>
				</td>
			</tr>
			<tr>
				<td width="100%">
					<table align=center border=0>
						<tr>
							<td valign=center>
								<table>
									<tr>
										<td width=200 align=center height=40>
											<a href="https://geoport-lk-mse.de/kvwmap"
											 target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;"><img src="buttons/kvwmap_button.gif" border=0></a>
										</td>
									</tr>
									<tr>
										<td width=200 align=center><small>
												Diese Version ist nur <b>registrierten Nutzern</b> zugänglich. Hier benötigt man ein Benutzernamen sowie ein Passwort.<br>								
										</td>
									</tr>
								</table>
							</td>
							<td width=300 align=center valign=center>
								<table>
									<tr>
										<td height=8></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $header_farbe ;?> align=center valign=center>
											<font color=white>Eine Kurzanleitung zur Benutzung des WEB-GIS <b>"kvwmap"</b> finden Sie
											<a href="pdf/Schulung.pdf" target="_blank"><font color=white><b>hier</b></font></a>.
										</td>
									</tr>
									<tr><td height=10></td></tr>
									
								</table>
							</td>
							<td valign=top>
							<table>
							<tr><td align=center height=40>
							<a href="buergerportal.php"				
							 target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;"><img src="buttons/buergerportal_button.gif" border=0></a>
							</td>
						    </tr>
						    <tr>
							<td width=200 valign=top align=center><small>
								Dies ist eine <b>kostenfreie</b> Version für den Bürger. Es werden keine Anmeldedaten benötigt.
							</td>
						    </tr>
							</table>
							</td>
						</tr>
					</table>
				</td>				
			</tr>
			<tr>
			<td colspan=3><img src="buttons/kvwmap_gross.png"></td>
			</tr>
			
		</table>
		
	
	
	</div>
  </div>
  <div id="navigation">
    <table border="0" align="left">
		<tr>
			<td>
				<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js"></script>
			</td>
		</tr>
	</table>
  </div>
  <div id="extra">
	<? include ("includes/news.php"); ?>
  </div>
  <div id="footer">	
  </div>
</div>
</body>
</html>
