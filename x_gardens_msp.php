<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="offene_gaerten_2015";
$titel2="offene_gaerten";
$datei="gardens_msp.php";
$tabelle="tourism.open_gardens";
$layerid="131390";
$kuerzel="garten";
$bild01="images/open_gardens_2015.jpg";

$gemarkung_id=$_GET["gemarkung"];
$garten_id=$_GET["garten"];

$log=write_log($db_link,$layerid);

if ($garten_id < 1 AND $gemarkung_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle WHERE aktiv = 'ja'";	  
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
						<tr>
													
							<td align="center" colspan=2 valign="top" height=30 ><br>
								<h3>offene Gärten 2015<br>
								(13. und 14. Juni 2015)</h3>
								Zu diesem Thema befinden sich<br>
								<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
							</td>
							<td rowspan=8 width=30>
							<td border=0 valign=top rowspan=7 colspan=3>
								<br>
								<div style="margin:1px" id="map"></div>
							</td>
						</tr>
						<tr>
							<td align="center" height=50 colspan=2>
								In den hier aufgelisteten Orten können Gärten besucht werden:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2 style="font-family:Arial; font-size: 8pt; font-weight: bold">								
								<form action="gardens_msp.php" method="get" name="gemarkung">
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM public.show_gemarkungen as a, public.gemarkung as b, tourism.open_gardens as c WHERE ST_WITHIN(st_transform(c.the_geom, 2398),b.the_geom) AND c.aktiv ='ja' AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[gemkgschl]\">$r[gemarkung]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
						<tr>
					             <td valign=bottom align="center" colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema offene Gärten</a>
						         </td>
					            </tr>
					            <tr><td align="center" colspan=2>letzte Aktualisierung: <b><i><? echo get_aktualitaet($dbname,$layerid); ?></td>
								</tr>
                                <tr>
									<td valign=bottom align=center colspan=2>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die webbasierte Karte?<br>(OpenLayers)</a>																
									</td>
								</tr>
								<tr><td align="center" height=120><img src="<? echo $bild01 ?>" height=150></td>
									<td valign=bottom align=right>
										<!-- Tabelle für Legende -->											
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													
													<td width=100 align=right><small>offene Gärten </td>
													<td align=right><img src="images/gar_pkt.gif" width=20></td>
												</tr>
												
												<tr>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
								</tr>							
								<tr>
										<td colspan=2 height=35></td>				
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
				<? include ("includes/news.php"); ?>
			</div>
			<div id="footer">			
		  </div>
		</div>
		</body>
		</html>
<?	}

if ($gemarkung_id > 0)
   { 	  
	  $query="SELECT a.* FROM tourism.open_gardens as a, public.gemarkung as b WHERE ST_WITHIN (st_transform(a.the_geom,2398), b.the_geom) AND a.aktiv = 'ja' AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id';";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $garten[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemarkungsname_kurz as name FROM public.gemarkung as a WHERE CAST(a.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname = $r[name];
	  $zentrum = $r[center];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rcenter = $zentrum4[0];
	  $hcenter = $zentrum4[1];
	  $boxstring = $r[box];
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
			<? include ("includes/block_2_gemkg.php"); ?>
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
										<td align="center"  width=250 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?> offene Gärten 2015 in 
											<form action="gardens_msp.php" method="get" name="gemarkung">								
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM public.show_gemarkungen as a, public.gemarkung as b, tourism.open_gardens as c WHERE ST_WITHIN(st_transform(c.the_geom,2398),b.the_geom) AND c.aktiv='ja' AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($gemarkung_id == $r[gemkgschl]) echo " selected"; echo " value=\"$r[gemkgschl]\">$r[gemarkung]
													</option>\n";
										}
									?>
								</select>								
							</form>
							<a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)</a>
							</td>
										<td width=30 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="5" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									
									<tr>
						<td align="center" height=120><img src="<? echo $bild01 ?>" height=150></td>									
					</tr>
					<tr>
										<td align=center bgcolor=<? echo $header_farbe ;?>>
											<a href="gardens_msp.php"><? echo $link_farbe ;?>offene Gärten 2015<br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
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
													<td width=100 align=right><small>offene Gärten </td>
													<td align=right><img src="images/gar_pkt.gif" width=20></td>
												</tr>
												
												<tr>
													<td align=right><small>Gemarkungsgrenze: </td>
													<td align=right><img src="images/gemarkungsgrenze.png" width=20></td>													
												</tr>																						
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>									
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?gemarkung=<? echo $gemarkung_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
											<td height=30 width=200><a name=\"liste\"></a>&nbsp;<b>Aussteller:</b></td>											
											<td height=30 width=200>&nbsp;<b>Adresse</b></td>				
											<td height=30 width=200>&nbsp;<b>Beschreibung</b></td>
															";
										?>							
									</tr>																
									<?php for($v=0;$v<$z;$v++)
										{ 
											
											echo "<tr bgcolor=",get_farbe($v),">";																								
											echo "<td>&nbsp;<a href=\"gardens_msp.php?garten=",$garten[$v][gid],"\">",$garten[$v][beschriftung]," | ",$garten[$v][name_gaertner],"</a></td>";
											echo "<td>&nbsp;",$garten[$v][plz_gaertner]," ",$garten[$v][ort_gaertner],"<br>&nbsp;",$garten[$v][strasse_gaertner],"</td>
											<td>",$garten[$v][beschreibung],"</td>
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
<?  }

if ($garten_id > 0)
   {   
	  $query="SELECT a.gemarkungsname_kurz,a.geographicidentifier FROM public.gemarkung as a, tourism.open_gardens as b WHERE ST_WITHIN(st_transform(b.the_geom,2398),a.the_geom) AND b.gid='$garten_id';";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname=$r[gemarkungsname_kurz];
	  $gemkg_schl=$r[geographicidentifier];
	  
	  $query="SELECT astext(st_transform(the_geom,2398)) as koordinaten, astext(the_geom) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, astext(st_transform(the_geom, 4326)) as geo, gid, name_gaertner,strasse_gaertner,plz_gaertner,ort_gaertner,oeffnungszeiten,beschreibung,beschriftung,kaffe_kuchen,behindertengerecht,hunde,pflanzenverkauf,fuehrungen,weitere_gartentermine FROM tourism.open_gardens WHERE gid='$garten_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $name = $r[name];
	  $bildname = $r[bild];
	  $bildname1 = explode("&",$bildname);
	  $bildname2 = $bildname1[0];
	  $bildname3 = explode("/",$bildname2);
	  $bild="pictures/".$bildname3[3]."/".$bildname3[4];
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
		<title>Geoport_gaertneral Landkreis Mecklenburgische Seenplatte</title>
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
											<? echo $font_farbe ;?><? echo $r[name_gaertner]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="5"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									
									<tr>
						<td align="center"  height=120><img src="<? echo $bild01 ?>" height=150></td>									
					</tr>
									<tr>
										
										<td colspan=2  align=center height="30" bgcolor=<? echo $header_farbe ?>>
											<a href="gardens_msp.php"><? echo $link_farbe ;?>offene Gärten 2015<br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr>
										
										<td colspan=2 align=center height="30" bgcolor=<? echo $header_farbe ?>>
											<a href="gardens_msp.php?gemarkung=<? echo $gemkg_schl; ?>"><? echo $link_farbe ;?>offene Gärten 2015<br>in  <? echo $gemarkungsname; echo $link_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td colspan=2></td></tr>
									
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													
													<td width=100 align=right><small>offene Gärten </td>
													<td align=right><img src="images/gar_pkt.gif" width=20></td>
												</tr>
												
																																		
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>	
									<tr>
										<td colspan=3></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?<? echo $kuerzel;?>=<? echo $garten_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
                                 </table>
								 
							 <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
								<?
								$spaltenanzahl=2;
								?>
									<tr height="35">
										<td colspan=<? echo $spaltenanzahl ?> width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<font size="+1"><? echo $font_farbe ;?><? echo $r[beschriftung]," | ",$r[name_gaertner];?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Postleitzahl/Ort:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[plz_gaertner]," ",$r[ort_gaertner] ;?></b></td>
									</tr>
									<tr>
										<td>Straße:</td>
										<td width="300"><b><? echo $r[strasse_gaertner] ;?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Öffnungszeiten<br>offene Gärten 2015</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[oeffnungszeiten];?></b></td>
									</tr>
									<tr>
										<td>Beschreibung</td>
										<td><b><?echo $r[beschreibung]?></b></td>
									</tr>
									
								</table>
								
							</td>									
							<td valign=top align=center width="350">
							<? include("includes/geo_point.php"); ?>	
							</td>
						  </tr>
						  
						</table>
						</td>
					  </tr>

					<td bgcolor=<? echo $element_farbe ?>><b>
					<?
						if ($r[kaffe_kuchen] == 'ja') echo "<img src=\"images/garten01.jpg\" width=19> Kaffe & Kuchen ";
						if ($r[behindertengerecht] == 'ja') echo "<img src=\"images/garten02.jpg\" width=19> Behindertengerecht ";
						if ($r[hunde] == 'nein') echo "<img src=\"images/garten03.jpg\" width=19> Keine Hunde ";
						if ($r[pflanzenverkauf] == 'ja') echo "<img src=\"images/garten04.jpg\" width=19> Pflanzenverkauf ";
						if ($r[fuehrungen] == 'ja') echo "<img src=\"images/garten05.jpg\" width=19> Führungen ";
						if ($r[weitere_gartentermine] == 'ja') echo "<img src=\"images/garten06.jpg\" width=19> weitere Gartentermine ";
					?>
					</b></td>
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
             <? include ("includes/news.php") ?>
			</div>
			<div id="footer">
			</div>
		</div>
		</body>
		</html>
<?  }