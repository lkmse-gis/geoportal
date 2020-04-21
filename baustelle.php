
<?
	include ("includes/portal_functions.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>	
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
			<? include ("ajax.php"); ?>
			<? include ("includes/zeit.php"); ?>
			<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
	<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
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
		<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
			<!--<tr>
				<td colspan=2>
					<h2><u>Willkommen</u></h2>
				</td>
			</tr>-->
			<tr>
				<td width="100%">
					<table border=0 align=center>
						<tr height=50>
							<td valign=middle align=center>
								
							</td>
						</tr>
						<tr>
							<td valign=middle align=center>
								Diese Seite befindet sich im Aufbau oder wird umstrukturiert.
							</td>
						</tr>
						<tr height=20>
							<td valign=middle align=center>
								
							</td>
						</tr>
						<tr>							
							<td valign=middle align=center>
								<img src="images/baustelle.png" width=300>																		
							</td>
						</tr>
						<tr height=50>
							<td valign=middle align=center>
								
							</td>
						</tr>
					</table>
				</td>				
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
	<?
		include("includes/news.php");
	?>
</div>
  <div id="footer">    
  </div>
</div>
</body>
</html>