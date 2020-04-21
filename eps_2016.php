<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$layername_mapfile="EPS_2016";
$titel="Befallsgebiete des Eichenprozessionsspinners (2016)";
$titel_plural="Befallsgebieten des Eichenprozessionsspinners (2016)";
$titel_legende="Befallsgebiet";
$scriptname="eps_2016.php";
$tabelle="befall_eps";
$schema="health";
$get_themenname="eps_area";
$layerid="110110";
$leg_bild="eps_rot.png";
$gemeinde_id=$_GET["gemeinde"];
$themen_id=$_GET["$get_themenname"];

$log=write_log($db_link,$layerid);

if ($themen_id < 1 AND $gemeinde_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle WHERE  jahr='2016'";	  
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
			<? include ("includes/block_1_1.php"); ?>
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
								betroffene Gemeinde ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
								<select name="gemeinde" onchange="document.<? echo $get_themenname;?>.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_intersects(st_transform(a.the_geom,2398), b.the_geom) AND a.jahr='2016' ORDER BY gemeinde";
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
						<?
						echo "<tr>
				              <td valign=bottom align=right>
					          <!-- Tabelle für Legende -->											
					          <table border=\"1\" rules=\"none\" width=140 valign=bottom align=right>					
						           <tr>
							       <td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
						           </tr>
						           <tr>
							       <td width=100 align=right><small>$titel_legende: </td>
							       <td align=right><img src=\"",$bildpfad.$leg_bild,"\" width=20></td>
							       <td align=right><small>Kreisgrenze: </td>
							       <td align=right><img src=\"images/gemeindegrenze_2.png\" width=30></td>
								   </tr>
								   <tr>
								   <td colspan=3><small> Befallsgebiet mit Nummer:</td>
								   
								   <td  bgcolor=#FF0000></td>
								   </tr>
								  																						
					           </table> <!-- Ende der Tabelle für die Legende -->
				              </td>
			                  </tr>";
                              ?>
						
						
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
	  $query="SELECT a.* FROM $schema.$tabelle as a, gemeinden as b WHERE ST_intersects(st_transform(a.the_geom,2398), b.the_geom) AND b.gem_schl='$gemeinde_id' AND a.jahr='2016' ORDER BY a.gid";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $eps[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(st_transform(a.the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(a.the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemeinde as name FROM gemeinden as a WHERE a.gem_schl='$gemeinde_id'";
	  
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
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />		
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_2_1.php"); ?>
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
										<td height="40" align="center" valign=top width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel ;?> in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="7"></td>
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
											<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $get_themenname;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_intersects(st_transform(a.the_geom,2398), b.the_geom) AND a.jahr='2016' ORDER BY gemeinde";
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
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>alle <? echo $titel ;?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
									<?
						      echo "<tr>
				              <td valign=bottom align=right>
					          <!-- Tabelle für Legende -->											
					          <table border=\"1\" rules=\"none\" width=140 valign=bottom align=right>					
						           <tr>
							       <td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
						           </tr>
						           <tr>
							       <td width=100 align=right><small>$titel_legende: </td>
							       <td align=right><img src=\"",$bildpfad.$leg_bild,"\" width=20></td>
							       <td align=right><small>Kreisgrenze: </td>
							       <td align=right><img src=\"images/gemeindegrenze_2.png\" width=30></td>
								   </tr>
								   <tr>
								   <td colspan=3><small> Befallsgebiet mit Nummer:</td>
								   
								   <td  bgcolor=#FF0000></td>
								   </tr>
								  																						
					           </table> <!-- Ende der Tabelle für die Legende -->
				              </td>
			                  </tr>";
                              ?>								
									<? include ("includes/block_2_uk_gem.php"); ?>	
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
									<? head_trefferliste($count,2,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
													
													<td align=center height=30><a name="Liste"></a><b>ID Befallsgebiet</b></td>
													<td align=center height=30><b>eingeleitete Maßnahmen</b></td>
																									
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{   echo "<tr ";
													    if ($v % 2 == 0) echo "bgcolor=$element_farbe";
														echo ">";
													    $beobachtung=$eps[$v][beobachtung];
														$warnschilder=$eps[$v][warnschilder];
														$entfernung_nester=$eps[$v][entfernung_nester];
														$chemische_bekaempfung=$eps[$v][chemische_bekaempfung];
														echo
														"<td align='center'><a href=$scriptname?$get_themenname=",$eps[$v][gid],">",$eps[$v][gid],"</a></td>",
														"<td align='center'>";
														if ($beobachtung == t) echo "Beobachtung<br>";
														if ($warnschilder == t) echo "Aufstellen von Warnschildern<br>";
														if ($entfernung_nester == t) echo "mechanische Entfernung der Nester<br>";
														if ($chemische_bekaempfung == t) echo "chemische Bekaempfung aus der Luft<br>";
														
														if ($beobachtung != t AND $warnschilder != t AND $entfernung_nester != t AND $chemische_bekaempfung != t) echo "noch keine Maßnahmen eingeleitet";
														echo "</td></tr>";
													}
												?>																																				
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							
						</tr>
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

 if ($themen_id > 0)
   {   
      $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid,b.grad_des_befalls FROM gemeinden as a, $schema.$tabelle as b WHERE ST_intersects(st_transform(b.the_geom,2398), a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[amt];
	  $amt=$r[amt_id];
	  $gem_id=$r[gemeindeid];
	  $gemeindename=$r[gemeinde];  
   
   
      $query="SELECT box(a.the_geom) as etrsbox, st_astext(st_centroid(a.the_geom)) as utm,astext(st_transform(st_centroid(a.the_geom),4326)) as geo, astext(st_transform(st_centroid(a.the_geom),2398)) as s4283, astext(st_transform(st_centroid(a.the_geom),31468)) as rd83,st_perimeter(a.the_geom) as umfang, area(the_geom) as flaeche,a.gid,a.grad_des_befalls,a.beobachtung,a.warnschilder,a.entfernung_nester,a.chemische_bekaempfung,a.datum_massnahme FROM $schema.$tabelle as a WHERE a.gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $objekt_id=$r[gid];
	  $grad_des_befalls=$r[grad_des_befalls];
	  $utm=$r[utm];
	  $s4283=$r[s4283];
	  $rd83=$r[rd83];
	  $geo=$r[geo];
	  $umfang=$r[umfang];
	  $area=$r[flaeche];
	  $zentrum = $r[utm];
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
   
   
	  
	  
	  
	  echo $lon," ",$lat," ",$rechts_range," ",$hoch_range;
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
		<? include ("includes/block_3_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_3_1_area.php"); ?>
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
										<td height="40" align="center" valign=center width=270 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Befallsgebiet: <? echo $objekt_id; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="7"></td>
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
										<td align="center" height="40">
											<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $get_themenname;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_intersects(st_transform(a.the_geom,2398), b.the_geom) AND a.jahr='2016' ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($gr = $fetcharrayp($result))
															{
																echo "<option";if ($gem_id == $gr[gem_schl]) echo " selected"; echo " value=\"$gr[gem_schl]\">$gr[gemeinde]</option>\n";
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center colspan=2>
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>zu allen <? echo $titel_plural;?><br><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $scriptname;?>?gemeinde=<? echo $gem_id; ?>"><? echo $font_farbe ;?>zu allen <? echo $titel_plural;?><br>in <? echo $gemeindename ?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<?
						      echo "<tr>
				              <td valign=bottom align=right>
					          <!-- Tabelle für Legende -->											
					          <table border=\"1\" rules=\"none\" width=140 valign=bottom align=right>					
						           <tr>
							       <td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
						           </tr>
						           <tr>
							       <td width=100 align=right><small>$titel_legende: </td>
							       <td align=right><img src=\"",$bildpfad.$leg_bild,"\" width=20></td>
							       <td align=right><small>Kreisgrenze: </td>
							       <td align=right><img src=\"images/gemeindegrenze_2.png\" width=30></td>
								   </tr>
								   <tr>
								   <td colspan=3><small> Befallsgebiet mit Nummer:</td>
								   
								   <td  bgcolor=#FF0000></td>
								   </tr>
								  																						
					           </table> <!-- Ende der Tabelle für die Legende -->
				              </td>
			                  </tr>";
                              ?>					
									<? include ("includes/block_3_1_uk.php"); ?>	
                                 </table>
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>											
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1">Befall durch den Eichenprozessionsspinner<? echo $font_farbe_end ;?></td>													
										</tr>
										<tr>
											<td width="50%" bgcolor=<? echo $element_farbe ?>>Gebietsnummer:</td>
											<td width="50%" bgcolor=<? echo $element_farbe ?>><b><? echo $objekt_id ;?></b></td>												
										</tr>	
										<tr>
											<td>eingeleitete Maßnahmen:</td>
											<td><b><ol><? if ($r[beobachtung] == t) echo "<li>Beobachtung</li>";
														if ($r[warnschilder] == t) echo "<li>Aufstellen von Warnschildern</li>";
														if ($r[entfernung_nester] == t) echo "<li>mechanische Entfernung der Nester</li>";
														if ($r[chemische_bekaempfung] == t) echo "<li>chemische Bekaempfung aus der Luft</li>";
														if (($r[beobachtung] == t OR $r[warnschilder] == t OR $r[entfernung_nester] == t OR $r[chemische_bekaempfung] == t) AND ($r[datum_massnahme] != '')) echo "<small>(Die Maßnahme(n) wurde durchgeführt am: $r[datum_massnahme])";
														if ($r[beobachtung] != t AND $r[warnschilder] != t AND $r[entfernung_nester] != t AND $r[chemische_bekaempfung] != t) echo "noch keine Maßnahmen eingeleitet";?></b></ol></td>																									
										</tr>
										
										<tr>
											<td width="50%" bgcolor=<? echo $element_farbe ?>>Fläche des Gebietes in m²:</td>
											<td width="50%" bgcolor=<? echo $element_farbe ?>><b><? echo round($area,0) ;?></b></td>												
										</tr>
																					
									</table>
							</td>									
							<td valign=top align=center width="250">
							<? include("includes/geo_flaeche_25833.php"); ?>	
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

