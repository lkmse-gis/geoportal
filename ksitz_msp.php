<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="Kreisverwaltungen";
$titel2="Kreisverwaltung";
$datei="ksitz_msp.php";
$tabelle="fd_amtssitze_msp";
$kuerzel="kreisverwaltung";
$layerid="30600";
$leg_bild="kreissitz.gif";

$ksitz_id=$_GET["$kuerzel"];
$themen_id=$ksitz_id;

$log=write_log($db_link,$layerid);


if ($themen_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM fd_amtssitze_msp WHERE art='Regionalverwaltung'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
	
	?>
		<?php
		$lon=368607;
		$lat=5937811;
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		<? include ("includes/block_1_css_map.php"); ?>			
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_1.php"); ?>
		</script>
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
							<table width="100%" border=0 cellpadding="0" align="center" cellspacing="0">
								<? include ("includes/count_map.php"); ?>
								<tr>
									<td align="center" height=30 colspan=2>
										Kreisverwaltung ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=60 colspan=2> 								
										<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
										<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
										<option>Bitte auswählen</option>
											<?php
												$query="SELECT gid, name FROM fd_amtssitze_msp WHERE art='Regionalverwaltung' ORDER BY name";
												$result = $dbqueryp($connectp,$query);

												while($r = $fetcharrayp($result))
													{
														echo "<option value=\"$r[gid]\">$r[name]</option>\n";
													}
											?>
										</select>
										</form>
									</td>
								</tr>
								<? include ("includes/meta_aktualitaet.php"); ?>
						<? include ("includes/block_1_legende.php"); ?>
						<? include ("includes/block_1_uk.php"); ?>							
					</table>
				</div>
			</div>
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
				<? include ("includes/news.php"); ?>
			</div>
			<div id="footer">			
		  </div>
		</div>
		</body>
		</html>
<?	}

if ($themen_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid as ksitzid FROM gemeinden as a, fd_amtssitze_msp as b WHERE ST_WITHIN(b.the_geom,a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[amt];
	  $amt=$r[amt_id];
	  $gem_id=$r[gemeindeid];
	  $gemeindename=$r[gemeinde];
	  
	  $query="SELECT astext(the_geom) as koordinaten, astext(st_transform(the_geom, 25833)) as utm, astext(st_transform(the_geom, 4326)) as geo, astext(st_transform(the_geom, 31468)) as rd83, gid, name, plz, ort, strasse, tel, internet, email, fax, bild, oeffentlich, urheber FROM fd_amtssitze_msp WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname=$r[bild];
	  $oeffentlich=$r[oeffentlich];
	  $name = $r[name];
	  $id = $r[gid];
	  $koord = $r[koordinaten];
	  $koord2 = trim($koord,"POINT(");
	  $koord3 = trim($koord2,")");
	  $koord4 = explode(" ",$koord3);
	  $utm = $r[utm];
	  $geo = $r[geo];
	  $rd83=$r[rd83];
	  $lon = $koord4[0];
	  $lon1 = explode(".",$koord4[0]);
	  $lon2 = $lon1[0];
	  $lat = $koord4[1];
	  $lat1 = explode(".",$koord4[1]);
	  $lat2 = $lat1[0];
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		<? include ("includes/block_3_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
		<? include ("includes/block_3.php"); ?>
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 2px;}
			td.rahmen {border: solid #000000 1px;}
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
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>
								<table border=0>
									<tr>
										<td height="40" align="center" valign=center width=270 bgcolor=<? echo $header_farbe ;?> colspan=2>
											<? echo $font_farbe ;?>Verwaltungsstandort<br><? echo $r[name] ?><? echo $font_farbe_end ;?>
										</td>
										<td width=30 rowspan=6></td>
										<td border=0 valign=top align=center rowspan="5" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<b>(Regionalstandort: <? echo $r[name] ?>)</b>
										</td>
									</tr>								
									<tr>
										<td align="center" height="25" colspan=2>
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<? echo $titel2;?>:&nbsp;
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT gid, name FROM fd_amtssitze_msp WHERE art='Regionalverwaltung' ORDER BY name";
														$result = $dbqueryp($connectp,$query);
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($themen_id == $e[gid]) echo " selected"; echo " value=\"$e[gid]\">$e[name]</option>\n";
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center bgcolor=<? echo $header_farbe ;?> colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?> <br>des Landkreises<br>Mecklenburgische Seenplatte<? echo $font_farbe_end ;?></a>
										</td>										
									</tr>
									<? include ("includes/block_3_legende.php"); ?>
									<? include ("includes/block_3_uk.php"); ?>	
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<b><font size="+1"><? echo $font_farbe ;?>Regionalstandort <? echo $r[name] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Postleitzahl/Ort:</td>
										<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $r[plz]," ",$r[ort] ;?></b></td>	
										<?											
											$bildname1 = explode("&",$bildname);
											$bildname2 = $bildname1[0];
											$bildname3 = explode("/",$bildname2);
											$bild="pictures/".$bildname3[3]."/".$bildname3[4];											
											if(strlen($bildname) < 1 OR $oeffentlich == 'nein')
												{
													echo "<td valign=center align=right rowspan=8 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar</b></font></td></tr></table></td>";	
												} 
											else 
												{
													echo "<td valign=top align=right rowspan=8 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
												}
										?>
									<tr>
									<tr>
													<td>Strasse:</td>
													<td><b><? echo $r[strasse] ;?></b></td>																									
												</tr>
												<tr>
													<td bgcolor=<? echo $element_farbe ?>>Telefon:</td>
													<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[tel] ;?></b></td>																									
												</tr>
												<tr>
													<td>Faxnummer:</td>
													<td><b><? echo $r[fax] ;?></b></td>																									
												</tr>
												<tr>
													<td bgcolor=<? echo $element_farbe ?>>E-Mail:</td>
													<td bgcolor=<? echo $element_farbe ?>><b><a href="mailto:<? echo $r[email] ;?>" target=blank><? echo $r[email] ;?></a></b></td>																									
												</tr>
												<tr>
													<td>Homepage:</td>
													<td><b><a href="<? echo $r[internet] ;?>" target=blank>zur Homepage</a></b></td>																									
												</tr>
												<tr>
													<td bgcolor=<? echo $element_farbe ?>>Urheber (Bild):</td>
													<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[urheber] ;?></b></td>																									
												</tr>
											</table>
							</td>									
							<td valign=top align=center width="250">
							<? include("includes/geo_point.php"); ?>	
							</td>
						</tr>
						</table>
						</td></tr>
					</table>
				</div>
			</div>
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
             <? include ("includes/news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  } ?>