<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="Schulen";
$titel2="Schule";
$datei="schulen_msp.php";
$tabelle="fd_v_schulen";
$kuerzel="schule";
$layerid="100000";

$log=write_log($db_link,$layerid);

$gemeinde_id=$_GET["gemeinde"];
$schule_id=$_GET["$kuerzel"];
$themen_id=$schule_id;

if ($themen_id < 1 AND $gemeinde_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle WHERE hist = 'nein' AND im_lk = 'ja'";	  
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
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_1.php"); ?>
		</script>
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		
		</head>
		<body onload="load();init()">
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
							<td align="center" height=50 colspan=2>
								Gemeinde ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $tabelle as a, gemeinden as b WHERE a.hist = 'nein' AND (ST_WITHIN(a.the_geom, b.the_geom)) ORDER BY gemeinde";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[gem_schl]\">$r[gemeinde]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
							<? include ("includes/meta_aktualitaet.php"); ?>
						<tr>
							<td valign=bottom align=right>
								<!-- Tabelle für Legende -->											
								<table border="1" rules="none" width=140 valign=bottom align=right>					
									<tr>
										<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
									</tr>
									<tr>
										<td width=100 align=right><small>Berufsschule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>berufsschule.png" width=20></td>
										<td width=100 align=right><small>Förderschule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>foerderschule.png" width=20></td>
									</tr>
									<tr>
										<td width=100 align=right><small>Grundschule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>grundschule.png" width=20></td>
										<td width=100 align=right><small>Grundschule (Privat): </td>
										<td align=right><img src="<? echo $bildpfad ; ?>grundschule_p.png" width=20></td>	
									</tr>
									<tr>
										<td width=100 align=right><small>Gymnasium: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>gymnasium.png" width=20></td>
										<td width=100 align=right><small>Gymnasium (Privat): </td>
										<td align=right><img src="<? echo $bildpfad ; ?>gymnasium_p.png" width=20></td>
									</tr>
									<tr>
										<td width=100 align=right><small>Integrierte Gesamtschule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>igs.png" width=20></td>
										<td width=100 align=right><small>Kooperative Gesamtschule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>kgs.png" width=20></td>												
									</tr>
									<tr>
										<td width=100 align=right><small>Regionale Schule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>regionalschule.png" width=20></td>
										<td width=100 align=right><small>Musikschule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>musikschule.png" width=20></td>													
									</tr>
									<tr>
										<td width=100 align=right><small>Kreisvolkshochschule: </td>
										<td align=right><img src="<? echo $bildpfad ; ?>kvhs.png" width=20></td>
										<td align=right><small>Kreisgrenze: </td>
										<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
									</tr>																						
								</table> <!-- Ende der Tabelle für die Legende -->
							</td>
						</tr>
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

if ($gemeinde_id > 0)
   { 	  
	  $query="SELECT a.gid, a.name, a.strasse, a.zusatz, a.plz,a.ort, a.bezeichnung, a.schulleite, a.telefon, a.fax, a.internet, a.email, a.bild, a.oeffentlich FROM $tabelle as a, gemeinden as b WHERE ST_WITHIN (a.the_geom, b.the_geom) AND b.gem_schl='$gemeinde_id' ORDER BY a.name";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $schule[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemeinde as name FROM gemeinden as a WHERE a.gem_schl='$gemeinde_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r[name];
	  $zentrum = $r[etrscenter];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rcenter = $zentrum4[0];
	  $hcenter = $zentrum4[1];
	  $boxstring = $r[etrsbox];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $rechts = $koordinaten[2]+($rechts_range/2);
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	  $hoch = $koordinaten[3]+($hoch_range/2);
	  $range = $hoch_range;
	  if ($rechts_range > $hoch_range) $range=$rechts_range;
    

        $lon=$rechts;
		$lat=$hoch;
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
		<? include ("includes/bilder_popup.php"); ?>
		<? include ("includes/block_2_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />		
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_2.php"); ?>
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 1px;}
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
										<td height="40" align="center" valign=top width=250 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel;?> in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>(Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>)</b>
										</td>
									</tr>
									<tr>
										<td align="center" height="40">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $tabelle as a, gemeinden as b WHERE ST_WITHIN(a.the_geom, b.the_geom) ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
															{
																echo "<option";if ($gemeinde_id == $r[gem_schl]) echo " selected"; echo " value=\"$r[gem_schl]\">$r[gemeinde]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Berufsschulex: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>berufsschule.png" width=20></td>
													<td width=100 align=right><small>Förderschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>foerderschule.png" width=20></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Grundschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>grundschule.png" width=20></td>
													<td width=100 align=right><small>Grundschule (Privat): </td>
													<td align=right><img src="<? echo $bildpfad ; ?>grundschule_p.png" width=20></td>	
												</tr>
												<tr>
													<td width=100 align=right><small>Gymnasium: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>gymnasium.png" width=20></td>
													<td width=100 align=right><small>Gymnasium (Privat): </td>
													<td align=right><img src="<? echo $bildpfad ; ?>gymnasium_p.png" width=20></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Integrierte Gesamtschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>igs.png" width=20></td>
													<td width=100 align=right><small>Kooperative Gesamtschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>kgs.png" width=20></td>												
												</tr>
												<tr>
													<td width=100 align=right><small>Regionale Schule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>regionalschule.png" width=20></td>
													<td width=100 align=right><small>Musikschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>musikschule.png" width=20></td>													
												</tr>
												<tr>
													<td width=100 align=right><small>Kreisvolkshochschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>kvhs.png" width=20></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>									
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gemeinde_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
								</table> <!-- Ende innere Tablle oberer Block -->
							</td>
						</tr>
					</table>	<!-- Ende äußere Tablle oberer Block -->
					<!-- Beginn grosse Tabelle unterer Block -->
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
							    <!-- Beginn Sachdatentabelle -->
								<table border=0 width="100%" valign=top>
									<? head_trefferliste($count,5,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
										<? if ($count>0) echo "
											<td height=30></td>
											<td height=30><a name=\"liste\"></a>&nbsp;<b>Name:</b></td>											
											<td height=30>&nbsp;<b>Schultyp:</b></td>				
											<td height=30>&nbsp;<b>Postleitzahl/Ort:</b></td>
											<td height=30>&nbsp;<b>Straße:</b></td>
											";
										?>							
									</tr>																
									<?php for($v=0;$v<$z;$v++)
										{ 
											$bild=get_bild_name($schule[$v][bild]);
											#$bildname1 = explode("&",$bildname);
											#$bildname2 = $bildname1[0];
											#$bildname3 = explode("/",$bildname2);
											#$bild="pictures/".$bildname3[3]."/".$bildname3[4];
											echo "<tr bgcolor=",get_farbe($v),">";															
												if(strlen($bild) < 1 OR $schule[$v][oeffentlich] == 'nein')
													{
														echo "<td>".$bild."</td>";	
													} 
												else 
													{
														echo "<td align='center'><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild height='30'></a></td>";
													}
											echo "<td>&nbsp;<a href=\"schulen_msp.php?schule=",$schule[$v][gid],"\">",$schule[$v][name],"</a></td>";
												if ($schule[$v][zusatz] == "")
													echo
														"<td height=30>&nbsp;",$schule[$v][bezeichnung],"</td>";
												else
													echo
														"<td>&nbsp;",$schule[$v][bezeichnung]."<br>&nbsp;".$schule[$v][zusatz],"</td>";													
											echo "
											<td>&nbsp;",$schule[$v][plz]," ",$schule[$v][ort], "</td>
											<td>&nbsp;",$schule[$v][strasse],"</td>														
											</tr>";
										}
									?>																																				
								</table>
							</td>
						</tr>
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
<?  }

if ($themen_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid as schulid FROM gemeinden as a, $tabelle as b WHERE ST_WITHIN(b.the_geom,a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[amt];
	  $amt=$r[amt_id];
	  $gem_id=$r[gemeindeid];
	  $gemeindename=$r[gemeinde];
	  
	  $query="SELECT astext(the_geom) as koordinaten, astext(st_transform(the_geom, 25833)) as utm,  st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, astext(st_transform(the_geom, 4326)) as geo, gid, name, strasse, plz,ort, bezeichnung, schulleite, telefon, fax, internet, email, bild, oeffentlich, zusatz FROM $tabelle WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $name = $r[name];
	  $bild = get_bild_name($r[bild]);
	  $id = $r[gid];
	  $koord = $r[koordinaten];
	  $koord2 = trim($koord,"POINT(");
	  $koord3 = trim($koord2,")");
	  $koord4 = explode(" ",$koord3);
	  $rd83 = $r[rd83];
	  $utm = $r[utm];
	  $geo = $r[geo];
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
										<td height="40" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r[name]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <? echo $amtname; ?></b>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $tabelle as a, gemeinden as b WHERE ST_WITHIN(a.the_geom, b.the_geom) ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($e = $fetcharrayp($result))
															{
																echo "<option";if ($gem_id == $e[gem_schl]) echo " selected"; echo " value=\"$e[gem_schl]\">$e[gemeinde]</option>\n";
															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gem_id; ?>"><? echo $font_farbe ;?>alle <? echo $titel;?><br><? echo $gemeindename ?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Berufsschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>berufsschule.png" width=20></td>
													<td width=100 align=right><small>Förderschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>foerderschule.png" width=20></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Grundschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>grundschule.png" width=20></td>
													<td width=100 align=right><small>Grundschule (Privat): </td>
													<td align=right><img src="<? echo $bildpfad ; ?>grundschule_p.png" width=20></td>	
												</tr>
												<tr>
													<td width=100 align=right><small>Gymnasium: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>gymnasium.png" width=20></td>
													<td width=100 align=right><small>Gymnasium (Privat): </td>
													<td align=right><img src="<? echo $bildpfad ; ?>gymnasium_p.png" width=20></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Integrierte Gesamtschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>igs.png" width=20></td>
													<td width=100 align=right><small>Kooperative Gesamtschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>kgs.png" width=20></td>												
												</tr>
												<tr>
													<td width=100 align=right><small>Regionale Schule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>regionalschule.png" width=20></td>
													<td width=100 align=right><small>Musikschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>musikschule.png" width=20></td>													
												</tr>
												<tr>
													<td width=100 align=right><small>Kreisvolkshochschule: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>kvhs.png" width=20></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
												</tr>																						
											</table>
										</td>
									</tr>
									<tr>
										<td colspan=3></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?<? echo $kuerzel;?>=<? echo $themen_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
                                 </table>
								 
							 <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<font size="+1"><? echo $font_farbe ;?><? echo $r[name] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Postleitzahl/Ort:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[plz]," ",$r[ort] ;?></b></td>
										<?											
											#$bildname1 = explode("&",$bildname);
											#$bildname2 = $bildname1[0];
											#$bildname3 = explode("/",$bildname2);
											#$bild="pictures/".$bildname3[3]."/".$bildname3[4];											
											if(strlen($bild) < 1 OR $oeffentlich == 'nein')
												{
													echo "<td valign=center align=center rowspan=8 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar</b></font></td></tr></table></td>";	
												} 
											else 
												{
													echo "<td valign=top align=right rowspan=8 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
												}
										?>
									</tr>
									<tr>
										<td>Straße:</td>
										<td width="300"><b><? echo $r[strasse] ;?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Schultyp:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[bezeichnung]."<br>".$r[zusatz] ;?></b></td>
									</tr>
									<tr>
										<td>Schulleiter:</td>
										<td><b>
										<? 
											if ($r[schulleite] == "") echo "<font color=red>---</font>";
											else echo $r[schulleite];
										?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Telefon:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
										<? 
											if ($r[telefon] == "") echo "<font color=red>---</font>";
											else echo $r[telefon];
										?></b></td>
									</tr>	
									<tr>
										<td>FAX:</td>
										<td><b>
										<? 
											if ($r[fax] == "") echo "<font color=red>---</font>";
											else echo $r[fax];
										?></b>
										</td>												
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Internet:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
										<? 
											if ($r[internet] == "") echo "<font color=red>keine Internetpräsenz</font>";
											else echo "<a href='http://$r[internet]' target='blank'>$r[internet]</a>";
										?></b>
										</td>												
									</tr>
									<tr>
										<td>E-Mail:</td>
										<td><b>
											<? 
												if ($r[email] == "") echo "<font color=red>keine E-Mail Adresse vorhanden</font>";
												else echo "<a href='mailto:$r[email]'>$r[email]</a>";
											?></b>
										</td>												
									</tr>
								</table>
							</td>									
							<td valign=top align=center width="350">
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
<?  }