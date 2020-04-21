<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
// neue Variablen der Name ist eindeutig
$layername_mapfile="Containerstellplaetze";
$titel="Wertstoffcontainerstellplätze";
$titel_plural="Wertstoffcontainerstellplätzen";
$titel_legende="Containerstellplatz";
$scriptname="container.php";
//$layername="Containerstellplaetze";
//$ueberschrift="Wertstoffcontainerstellplätze";
$titel2="Wertstoffcontainerstellplatz";
//Layer Name für die externen Programm Blöcke
$titel="Wertstoffcontainerstellplätze";
$datei="container.php";
$schema="supply_and_disposal";
$tabelle="container";
$kuerzel="container";
$get_themenname="container";
$layerid="80620";
$leg_bild="gruener_punkt.gif";
$gemeinde_id=$_GET["gemeinde"];
$themen_id=$_GET["$kuerzel"];

$log=write_log($db_link,$layerid);


// Ebene 1
if ($themen_id < 1 AND $gemeinde_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";	  
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
								Gemeinde ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
									<option>Bitte auswählen</option>
									<?php
								$query="SELECT DISTINCT b.gem_schl,b.gemeinde FROM gemeinden b, $schema.$tabelle as a WHERE st_intersects(st_transform(a.the_geom,2398),b.the_geom) ORDER BY gemeinde";
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

// Ebene 2 
if ($gemeinde_id > 0)
   { 	  
	 $query="SELECT a.id,a.strasse,b.gemeinde,b.gem_schl,c.geographicidentifier,d.ortsteil,a.anzahl,a.papier_1_1,a.papier_3_2,a.weissglas_3_2,a.buntglas_3_2,a.gruen,a.braun,a.bef_kosten,a.einz_kost,a.kost_begruen,a.kost_rep,a.gesamt_kosten,a.befestigung,a.einzaeunung,a.begruenung,a.reparatur,a.comment,a.bild,a.bild_date,a.oeffentlich,a.the_geom FROM gemeinden b,gemarkung c,$schema.$tabelle as a Left Join Management.ot_lt_rka d ON ST_WITHIN (a.the_geom,d.the_geom) WHERE d.typ != 'Gemeinde' and d.typ != 'Stadtlage' and b.gem_schl='$gemeinde_id' AND ST_WITHIN (st_transform(a.the_geom,2398),b.the_geom) AND ST_WITHIN(st_transform(a.the_geom,2398),c.the_geom) ORDER BY gemeinde"; 
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $container[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT DISTINCT amt,amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
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
//      echo '| ',$lon,' | ',$lat,'| ';
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
											<? echo $font_farbe ;?><? echo $ueberschrift ;?> in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
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
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php											
														$query="SELECT DISTINCT b.gem_schl,b.gemeinde FROM gemeinden b, $schema.$tabelle as a WHERE st_intersects(st_transform(a.the_geom,2398),b.the_geom) ORDER BY gemeinde";
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
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $ueberschrift ;?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
									<? include ("includes/block_2_legende.php"); ?>								
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
									<? head_trefferliste($count,7,$header_farbe);
									?>		<!-- Header für Trefferliste wird geladen -->											
												<tr>
													<td align=center height=30><b>Bild:</b></td>
													<td align=center height=30><b>Bild Datum:</b></td>
													<td align=center height=30><b> Link zum Stellplatz:</b></td>
													<td height=30>&nbsp &nbsp<b> Ort/ Ortsteil:</b></td>
												    <td height=30>&nbsp &nbsp<b> Straße:</b></td>
																										
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{   $container_id=$container[$v][id];
														$bildname = $container[$v][bild];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[5]."/".$bildname3[6];
														$ord_temp=explode(".",$bild);
														$bild2=$ord_temp[0];
														$bild_thumb=$bild2."_thumb.jpg";
														
														echo "<tr bgcolor=",get_farbe($v),">";
															$bild_temp="Kein Bild verfügbar!";
														
															if(strlen($bildname) < 1 OR $container[$v][oeffentlich] == 'nein') 
															{
																echo "<td align=center > $bild_temp </td>";
															} 
															else 
															{
																echo "<td align='center'><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild_thumb height='30'></a></td>";
															}											
															echo "<td align='center'>",$container[$v][bild_date],"</a></td>",
																"<td align='center' height='30'><a href=\"$datei?container=", $container[$v][id],"\"><b><u>",$container[$v][id],"</u></b></a></td>",
																"<td>","&nbsp &nbsp",$container[$v][ortsteil],"</td>",
																"<td>","&nbsp &nbsp",$container[$v][strasse],"</td></tr>";
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
// Ebene 3 
if ($themen_id > 0)
   {   

	  $query="SELECT b.gemeinde,b.gem_schl,c.gen as amt,c.gid as amt_id FROM gemeinden b,fd_amtsbereiche c,$schema.$tabelle as a  WHERE  ST_WITHIN (st_transform(a.the_geom,2398),b.the_geom) AND ST_WITHIN(st_transform(a.the_geom,2398),c.the_geom) AND a.id=$themen_id"; 
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);

	  $amtname=$r[amt];
	  $amt=$r[amt_id];
	  $gem_id=$r[gem_schl];
	  $gemeindename=$r[gemeinde];
	  

	  $query="SELECT astext(the_geom) as utm, astext(st_transform(the_geom,2398)) as gk4283,astext(st_transform(the_geom, 4326)) as geo,astext(st_transform(the_geom, 31468)) as rd83 FROM $schema.$tabelle as a  WHERE id='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	
	  
	  $utm = $r[utm];
	  $geo=$r[geo];
	  $rd83=$r[rd83];
	  $s4283=$r[gk4283];
	  $lon=get_utmcoordinates_lon($utm);
	  $lat=get_utmcoordinates_lat($utm);
	  
	  
	  $query="SELECT a.oid,a.id,a.lfd_nr,a.ort,a.strasse,b.gemeinde,c.geographicidentifier,d.ortsteil,a.anzahl,a.papier_1_1,a.papier_3_2,a.weissglas_3_2,a.buntglas_3_2,a.gruen,a.braun,a.bef_kosten,a.einz_kost,a.kost_begruen,a.kost_rep,a.gesamt_kosten,a.befestigung,a.einzaeunung,a.begruenung,a.reparatur,a.comment,a.bild,a.bild_date,a.oeffentlich,a.the_geom FROM gemeinden b,gemarkung c,$schema.$tabelle a Left Join Management.ot_lt_rka d ON st_intersects (a.the_geom,d.the_geom) WHERE st_intersects (st_transform(a.the_geom,2398),b.the_geom) and st_intersects(st_transform(a.the_geom,2398),c.the_geom) AND a.id=$themen_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
			
	  
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
			<? include ("includes/block_3_1_point.php"); ?>
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
											<? echo $font_farbe ;?>Containerstellplatz <? echo $r[gemarkung] ;?><? echo $font_farbe_end ;?>
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
										<td align="center" height="35" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Stadt:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php
// erweitert
														$query="SELECT DISTINCT b.gemeinde,b.gem_schl FROM gemeinden b,$schema.$tabelle as a  WHERE st_intersects (st_transform(a.the_geom,2398),b.the_geom) ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);
														$bildname=$r[bild];
														$oeffentlich=$r[oeffentlich];
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
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>zu allen Containerstellplätzen<br><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gem_id; ?>"><? echo $font_farbe ;?>zurück zur Gemeinde: <br><? echo $gemeindename ?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<? include ("includes/block_3_legende.php"); ?>
									<? include ("includes/block_3_uk.php"); ?>	
                                 </table>
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>											
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1">Containerstellplatz <? echo $r[gemarkung] ;?><? echo $font_farbe_end ;?></td>													
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Stellplatz:</td>
											<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $r[id] ;?></b></td>
											<?			
														
														$bildname = $r[bild];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[5]."/".$bildname3[6];
											?>			
						<?					
														
												if(strlen($bildname) < 1 OR $r[oeffentlich] == 'nein')										
													{
														echo "<td valign=center align=right rowspan=10 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b> kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";
													} 
												else 
													{
														echo "<td valign=top align=right rowspan=10 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
													}
											?>
										</tr>
										<tr>
											<td>Stellplatznummer:</td>
											<td><b><? echo $id ?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Anzahl der Container: </td><td bgcolor=<? echo $element_farbe ?>><b><? echo $r[anzahl] ?></b></td>																									
										</tr>										
										<tr>
											<td>Papier 1100 L:</td><td><b><? echo $r[papier_1_1] ?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Papier 3200 L:</td><td bgcolor=<? echo $element_farbe ?>><b><? echo $r[papier_3_2] ?></b></td>																									
										</tr>										
										<tr>
											<td>weiß Glas 3200L:</td><td><b><? echo $r[weissglas_3_2] ?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Kombicontainer Glas:</td><td bgcolor=<? echo $element_farbe ?>><b><? echo $r[buntglas_3_2] ?></b></td>																									
										</tr>										
										<tr>
											<td>grün Glas:</td><td><b><? echo $r[gruen] ?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>braun Glas:</td><td bgcolor=<?echo $element_farbe ?>><b><? echo $r[braun] ?></b></td>																									
										</tr>
									</table>
							</td>									
							<td valign=top align=center width="250">
							<? include("includes/geo_point_25833.php"); ?>	
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

