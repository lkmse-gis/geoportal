<?php
include ("../../includes/connect_geobasis.php");
include("includes/kreis/sep_2015_k.php");
include("includes/kreis/sep_2014_k.php");
include("includes/kreis/sep_2013_k.php");
include("includes/kreis/sep_2012_k.php");
include("includes/kreis/sep_2011_k.php");

//globale Varibalen
$schul_id=$_GET["schul_id"];
$schema="education";
$tabelle="schulentwicklungsplanung";
$stichtage=['2015-09-30','2014-09-23','2013-09-10','2012-09-12','2011-09-09'];
$aktuelles_datum=$stichtage[0];

if (strlen($schul_id) < 1)
    {
	?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<style type="text/css">
			table {
				*border-collapse: collapse; /* IE7 and lower */
				border-spacing: 0;
				font-family: arial;
				width: 100%;    
			}

			.bordered {
				border: solid #ccc 1px;
				-moz-border-radius: 6px;
				-webkit-border-radius: 6px;
				border-radius: 6px;
				-webkit-box-shadow: 0 1px 1px #ccc;
				-moz-box-shadow: 0 1px 1px #ccc;
				box-shadow: 0 1px 1px #ccc;        
			}

			.bordered tr:hover {
				background: #dce9f9;
				-o-transition: all 0.1s ease-in-out;
				-webkit-transition: all 0.1s ease-in-out;
				-moz-transition: all 0.1s ease-in-out;
				-ms-transition: all 0.1s ease-in-out;
				transition: all 0.1s ease-in-out;    
			}    
			   
			.bordered td, .bordered th {
				border-left: 1px solid #ccc;
				border-top: 1px solid #ccc;
				padding: 6px;
				text-align: left;    
			}

			.bordered td {
				font-size: 12px;
				font-weight: bold;
			}

			.bordered th {
				background-color: #dce9f9;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#ebf3fc), to(#dce9f9));
				background-image: -webkit-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:    -moz-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:     -ms-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:      -o-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:         linear-gradient(top, #ebf3fc, #dce9f9);
				-webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
				-moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
				box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
				border-top: none;
				text-shadow: 0 1px 0 rgba(255,255,255,.5);
			}

			.bordered td:first-child, .bordered th:first-child {
				border-left: none;
			}

			.bordered th:first-child {
				-moz-border-radius: 6px 0 0 0;
				-webkit-border-radius: 6px 0 0 0;
				border-radius: 6px 0 0 0;
			}

			.bordered th:last-child {
				-moz-border-radius: 0 6px 0 0;
				-webkit-border-radius: 0 6px 0 0;
				border-radius: 0 6px 0 0;
			}

			.bordered th:only-child{
				-moz-border-radius: 6px 6px 0 0;
				-webkit-border-radius: 6px 6px 0 0;
				border-radius: 6px 6px 0 0;
			}

			.bordered tr:last-child td:first-child {
				-moz-border-radius: 0 0 0 6px;
				-webkit-border-radius: 0 0 0 6px;
				border-radius: 0 0 0 6px;
			}

			.bordered tr:last-child td:last-child {
				-moz-border-radius: 0 0 6px 0;
				-webkit-border-radius: 0 0 6px 0;
				border-radius: 0 0 6px 0;
			}
			.bordered a:link { color:black; text-decoration:none; }
			.bordered a:visited { color:black; text-decoration:none; }
			.bordered a:focus { color:black; text-decoration:underline; }
			.bordered a:hover { color:black; text-decoration:underline; }
			.bordered a:active { color:black; text-decoration:none; }	
		</style>
		<script language="javascript">
			function klappe (Id){
			  if (document.getElementById) {
				var mydiv = document.getElementById(Id);
				mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
			  }
			}
		</script>		
		</head>
		<body>
			<table class="bordered">							
						<tr>
							<th colspan=2 style="text-align:center;">
								Schulentwicklungsplanung
							</th>
						</tr>
			</table>
			<table>							
				<tr height=30></tr>
				<tr>
					<td valign=top>
						Auswertung über Kreis
					</td>
				</tr>
				<tr height=10></tr>
			</table>
			<table>							
						<tr>												
							<td valign=top>
								<table border=0 width="100%">									
									<tr>
										<td valign=top>
											<? include("includes/kreis/diagramme_k.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/kreis/sep_block_2015_k.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/kreis/sep_block_2014_k.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/kreis/sep_block_2013_k.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/kreis/sep_block_2012_k.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>									
									<tr>
										<td valign=top>
											<? include("includes/kreis/sep_block_2011_k.php"); ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
			</table>
			<table>							
				<tr height=30></tr>
				<tr>
					<td valign=top>
						Auswertung über Schule
					</td>
				</tr>
				<tr height=10></tr>
			</table>
			<table class="bordered">							
						<tr>
							<th>
								Schule ausw&auml;hlen:
							</th>
						</tr>
						<tr>
							<td align="center">								
								<form action="schulentwicklungsplanung.php" method="get" name="inhalt">
								<select name="schul_id" onchange="document.inhalt.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT a.schul_id, a.bezeichnung, a.ortsteil FROM $schema.$tabelle as a ORDER BY a.bezeichnung";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[schul_id]\">".$r[bezeichnung]." ".$r[ortsteil]."</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>								
			</table>
		</body>
		</html>
<?	}

if (strlen($schul_id) > 0)
    {
		include("includes/schule/schule/sep_2015.php");
		include("includes/schule/schule/sep_2014.php");
		include("includes/schule/schule/sep_2013.php");
		include("includes/schule/schule/sep_2012.php");
		include("includes/schule/schule/sep_2011.php");			
	?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Schulentwicklungsplanung</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<style type="text/css">
			table {
				*border-collapse: collapse; /* IE7 and lower */
				border-spacing: 0;
				font-family: arial;
				width: 100%;    
			}

			.bordered {
				border: solid #ccc 1px;
				-moz-border-radius: 6px;
				-webkit-border-radius: 6px;
				border-radius: 6px;
				-webkit-box-shadow: 0 1px 1px #ccc;
				-moz-box-shadow: 0 1px 1px #ccc;
				box-shadow: 0 1px 1px #ccc;        
			}

			.bordered tr:hover {
				background: #dce9f9;
				-o-transition: all 0.1s ease-in-out;
				-webkit-transition: all 0.1s ease-in-out;
				-moz-transition: all 0.1s ease-in-out;
				-ms-transition: all 0.1s ease-in-out;
				transition: all 0.1s ease-in-out;    
			}    
			   
			.bordered td, .bordered th {
				border-left: 1px solid #ccc;
				border-top: 1px solid #ccc;
				padding: 6px;
				text-align: left;    
			}

			.bordered td {
				font-size: 12px;
				font-weight: bold;
			}

			.bordered th {
				background-color: #dce9f9;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#ebf3fc), to(#dce9f9));
				background-image: -webkit-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:    -moz-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:     -ms-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:      -o-linear-gradient(top, #ebf3fc, #dce9f9);
				background-image:         linear-gradient(top, #ebf3fc, #dce9f9);
				-webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
				-moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
				box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
				border-top: none;
				text-shadow: 0 1px 0 rgba(255,255,255,.5);
			}

			.bordered td:first-child, .bordered th:first-child {
				border-left: none;
			}

			.bordered th:first-child {
				-moz-border-radius: 6px 0 0 0;
				-webkit-border-radius: 6px 0 0 0;
				border-radius: 6px 0 0 0;
			}

			.bordered th:last-child {
				-moz-border-radius: 0 6px 0 0;
				-webkit-border-radius: 0 6px 0 0;
				border-radius: 0 6px 0 0;
			}

			.bordered th:only-child{
				-moz-border-radius: 6px 6px 0 0;
				-webkit-border-radius: 6px 6px 0 0;
				border-radius: 6px 6px 0 0;
			}

			.bordered tr:last-child td:first-child {
				-moz-border-radius: 0 0 0 6px;
				-webkit-border-radius: 0 0 0 6px;
				border-radius: 0 0 0 6px;
			}

			.bordered tr:last-child td:last-child {
				-moz-border-radius: 0 0 6px 0;
				-webkit-border-radius: 0 0 6px 0;
				border-radius: 0 0 6px 0;
			}
			.bordered a:link { color:black; text-decoration:none; }
			.bordered a:visited { color:black; text-decoration:none; }
			.bordered a:focus { color:black; text-decoration:underline; }
			.bordered a:hover { color:black; text-decoration:underline; }
			.bordered a:active { color:black; text-decoration:none; }	
		</style>
		<script language="javascript">
			function klappe (Id){
			  if (document.getElementById) {
				var mydiv = document.getElementById(Id);
				mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
			  }
			}
		</script>
		</head>
		<body>
			<table class="bordered">							
						<tr>
							<th colspan=2 style="text-align:center;">
								Schulentwicklungsplanung
							</th>
						</tr>
			</table>
			<table class="bordered">							
						<tr>
							<th>
								Schule wechseln:
							</th>
							<th style="text-align:right;">
								<a href="http://www.geoport-lk-mse.de/geoportal/apps/sep/schulentwicklungsplanung.php">Zurück</a>
							</th>
						</tr>
						<tr>
							<td colspan=2>								
								<form action="schulentwicklungsplanung.php" method="get" name="inhalt">
								<select name="schul_id" onchange="document.inhalt.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT a.schul_id, a.bezeichnung, a.ortsteil FROM $schema.$tabelle as a ORDER BY a.bezeichnung";
										$result = $dbqueryp($connectp,$query);

										while($e = $fetcharrayp($result))
											{
												echo "<option";if ($schul_id == $e[schul_id]) echo " selected"; echo " value=\"$e[schul_id]\">".$e[bezeichnung]." ".$e[ortsteil]."</option>\n";
											}
									?>
								</select>
								</form>
							</td>							
						</tr>						
			</table>
			<table>							
						<tr>												
							<td valign=top>
								<table border=0 width="100%">
									<tr height=30></tr>
									<tr>
										<td valign=top>
											<? include("includes/schule/schule/diagramme.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/schule/schule/sep_block_2015.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/schule/schule/sep_block_2014.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/schule/schule/sep_block_2013.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>
									<tr>
										<td valign=top>
											<? include("includes/schule/schule/sep_block_2012.php"); ?>
										</td>
									</tr>
									<tr height=10></tr>									
									<tr>
										<td valign=top>
											<? include("includes/schule/schule/sep_block_2011.php"); ?>
										</td>
									</tr>								
								</table>
							</td>
						</tr>						
						<tr>
							<td>								
								
							</td>
						</tr>								
			</table>
		</body>
		</html>
<?	}
