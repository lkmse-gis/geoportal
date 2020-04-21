<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen
$titel="KUNST offen 2018";
$titel3="Kunst offen:";
$zeitraum="19. - 21.Mai";
$titel2="Veranstaltungsorte";
$datei="kunstoffen.php";
$tabelle="fd_kunst";
$layerid="131380";		// ja
$layerid2="131381";		// nein

// Legenden - Layer in - msp.map - eintragen - 1 spaltig - Themen 
$layer="KUNST offen 2018";
$layer2="Kreisgrenze_msp";
$layer3="aemter_msp_outline";
$layer4="msp_outline_gem";
$layer5="msp_outline_gemkg";
$layer6="Postleitzahlbereiche";
$layer99="";

$kuerzel="artist";
$themen_id=$_GET["$kuerzel"];
$bild01="images/kunstoffen2018.jpg";

$gemeinde_id=$_GET["gemeinde"];
$gemarkung_id=$_GET["gemarkung"];

$log=write_log($db_link,$layerid);

// Ebene 1
if ($themen_id < 1 AND $gemarkung_id < 1)
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
						<tr>
													
							<td align="center" colspan=2 valign="top" height=30 ><br>
								<h3><? echo $titel ;?><br>( <? echo $zeitraum ;?> )</h3>
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
								In den hier aufgelisteten Orten finden Events statt:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2 style="font-family:Arial; font-size: 8pt; font-weight: bold">								
								<form action="<? $datei ?>" method="get" name="gemarkung">
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte ausw&auml;hlen</option>
									<?php
$query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,fd_kunst as c WHERE ST_WITHIN(c.the_geom,b.the_geom) AND c.aktiv ='ja' AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
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
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema <? echo $titel3 ?></a>
						         </td>
					            </tr>
					            <tr><td align="center" colspan=2>letzte Aktualisierung: <b><i><? echo get_aktualitaet($dbname,$layerid); ?></td>
								</tr>
                                <tr>
									<td valign=bottom align=center colspan=2>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die webbasierte Karte?<br>(OpenLayers)</a>																
									</td>
								</tr>
								<tr>
								<td align="center" height=120><img src="<? echo $bild01 ?>" height=150></td>
								<!-- Tabelle für Legende -->
                                        <td valign=bottom align=right>
                                            <table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                                            <B>Kartenlegende :</B>
                                                <?php
                                                    $legende_geo= new legende_geo;
                                                    echo $legende_geo->zeigeLegende($layer,$layer2,$layer99,$layer99,$layer99,$layer99)
                                                ?>
                                        </table> 
                                        </td>
                                <!-- ENDE Tabelle für Legende --> 
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
if ($gemarkung_id > 0)
   { 	  
	  $query="SELECT a.* FROM fd_kunst as a, gemarkung as b WHERE ST_WITHIN (a.the_geom, b.the_geom) AND a.aktiv='ja' AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id';";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $artist[$z]=$r;
		   $z++;
		   $count=$z;	
		}

      $query="SELECT box(st_transform(a.the_geom,25833)) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemarkungsname_kurz as name FROM gemarkung as a WHERE CAST(a.geographicidentifier AS INTEGER)='$gemarkung_id'";
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
		
//  echo '| ',$lon,' | ',$lat,'| ';

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
											<? echo $font_farbe ;?><? echo $titel;?> in 
								<form action="<? $datei ?>" method="get" name="gemarkung">								
									<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
										<option>Bitte ausw&auml;hlen</option>
									<?php
  $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,fd_kunst as c WHERE ST_WITHIN(c.the_geom,b.the_geom) AND c.aktiv='ja' AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
 									
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
							<td width=30 rowspan="7">
							</td>
							<td border=0 valign=top align=left rowspan="5" colspan=3>
								<div style="margin:1px" id="map"></div>
							</td>
							</tr>
							<tr>
								<td align="center" height=120><img src="<? echo $bild01 ?>" height=150></td>									
							</tr>
							<tr>
								<td align=center bgcolor=<? echo $header_farbe ;?>>
									<a href="<? echo $datei;?>"><? echo $link_farbe ;$titel?><br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
								</td>
							</tr>
							<tr>
								<td  height=10></td>
							</tr>
							<tr>										
															<!-- Tabelle für Legende -->
                                        <td valign=bottom align=right>
                                            <table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                                            <B>Kartenlegende :</B>
                                                <?php
                                                    $legende_geo= new legende_geo;
                                                    echo $legende_geo->zeigeLegende($layer,$layer5,$layer99,$layer99,$layer99,$layer99)
                                                ?>
                                        </table> 
                                        </td>
                                <!-- ENDE Tabelle für Legende --> 
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
											<td height=30 width=10>&nbsp;<b>Fly.Nr.</b></td>																				
											<td height=30 width=200><a name=\"liste\"></a>&nbsp;<b>Künstler</b></td>											
											<td height=30 width=200>&nbsp;<b>Adresse</b></td>				

											<td height=30 width=120>&nbsp;<b>Telefon</b></td>
											";
										?>							
									</tr>																
									<?php for($v=0;$v<$z;$v++)
										{ 
											
											echo "<tr bgcolor=",get_farbe($v),">";															
											echo "<td>&nbsp;&nbsp;&nbsp;&nbsp<b><u><a href=\"$datei?$kuerzel=",$artist[$v][gid],"\">",$artist[$v][beschriftung],"</u></b></td>";
											echo "<td>&nbsp;<a href=\"$datei?$kuerzel=",$artist[$v][gid],"\">",$artist[$v][name],"<br>",$artist[$v][name2],"</a></td>
											<td>&nbsp;",$artist[$v][plz]," ",$artist[$v][ort],"<br>&nbsp;",$artist[$v][strasse],"</td>
											<td>&nbsp;",$artist[$v][tel],"</td>								
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
// Ebene 3
if ($themen_id > 0)
   {   
	  $query="SELECT a.gemarkungsname_kurz,a.geographicidentifier FROM gemarkung as a, fd_kunst as b WHERE ST_WITHIN(b.the_geom,a.the_geom) AND b.gid='$themen_id';";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname=$r[gemarkungsname_kurz];
	  $gemkg_schl=$r[geographicidentifier];
	  
	  $query="SELECT astext(the_geom) as koordinaten, astext(st_transform(the_geom, 25833)) as utm,  st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, astext(st_transform(the_geom, 4326)) as geo, gid, name,name2,strasse,plz,ort,tel,fax,homepage,mail, bild, oeffentlich,oeffnungszeiten,ausstattung,ausstellung,beschreibung,beschriftung,klassifizierung FROM fd_kunst WHERE gid='$themen_id'";
	  
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
	  $fly_nr = $r[beschriftung];
	  
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
								<table border='0'>
									<tr>
										<td width="250 "height="50" align="center" valign=center colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r[name]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width="10" rowspan="5"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=2>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
									<td align="center"  height=120><img src="<? echo $bild01 ?>" height=150></td>									
									</tr>
									<tr>
									<td colspan=2  align=center height="30" bgcolor=<? echo $header_farbe ?>>
										<a href="<? echo $datei; ?>"><? echo $link_farbe ;$titel?><br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
									</td>
									</tr>
									<tr>
										<td colspan=2 align=center height="30" bgcolor=<? echo $header_farbe ?>>
											<a href="<? $datei ?>?gemarkung=<? echo $gemkg_schl; ?>"><? echo $link_farbe ;$titel?><br>in  <? echo $gemarkungsname; echo $link_farbe_end ;?></a>
										</td>	
									</tr>
									<tr><td colspan=2></td>
									</tr>
									<tr>										
									<!-- Tabelle für Legende -->
                                        <td valign=bottom align=right>
                                            <table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                                            <B>Kartenlegende :</B>
                                                <?php
                                                    $legende_geo= new legende_geo;
                                                    echo $legende_geo->zeigeLegende($layer,$layer99,$layer99,$layer99,$layer99,$layer99)
                                                ?>
                                        </table> 
                                        </td>
									<!-- ENDE Tabelle für Legende --> 
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
											<a href="<? echo $datei;?>?<? echo $kuerzel;?>=<? echo $themen_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
					</table>
								 
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
							<table border=0 valign=top>
											<?			
														
														$bildname = $r[bild];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[5]."/".$bildname3[6];
											?>	
								<? if (file_exists($bild) AND strlen($bildname3[6]) > 1)
								  {
								     $spaltenanzahl=3;
								  }
								  else
								  {
								    $spaltenanzahl=2;
								  }
								  ?>
									<tr height="35">
										<td colspan=<? echo $spaltenanzahl ?> width="100%" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<font size="+1"><? echo $font_farbe ;?><? echo $fly_nr ?>) <? echo $r[name]," ",$r[name2] ;?><? echo $font_farbe_end ;?></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Postleitzahl/Ort: </td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[plz]," ",$r[ort] ;?></b></td>
										<?
											
											if ($spaltenanzahl == 3)
												{
												echo "<td valign=top align=right rowspan='11' width='320' ><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild></a></td>";
												} 
										?>
									</tr>
									<tr>
										<td>Straße:</td>
										<td width="100%"><b><? echo $r[strasse] ;?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Öffnungszeiten<br></td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[oeffnungszeiten];?></b></td>
									</tr>
									<tr>
										<td>Kunstrichtung</td>
										<td><b><?echo $r[klassifizierung]?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Ausstellung</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[ausstellung];?></b></td>
									</tr>
									<tr>
										<td>Beschreibung</td>
										<td><b><?echo $r[beschreibung]?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Ausstattung</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[ausstattung];?></b></td>
									</tr>
									<tr>
										<td>Telefon</td>
										<td><b><?echo $r[tel]?></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Fax</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[fax];?></b></td>
									</tr>
									<tr>
										<td>Homepage</td>
										<td><b><a href="<?echo $r[homepage]?>" target="_blank"><?echo $r[homepage]?></a></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>E-Mail</td>
										<td bgcolor=<? echo $element_farbe ?>><b><a href=mailto:=<? echo $r[mail];?>><? echo $r[mail];?></a></b></td>
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