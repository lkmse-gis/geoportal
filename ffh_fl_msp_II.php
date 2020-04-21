<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="Fauna Flora Habitat Gebiete";
$titel2="Fauna Flora Habitat Gebiet";
$datei="ffh_fl_msp_II.php";
$tabelle="sg_ffh_fl";
$schema="environment";
$kuerzel="ffh";
$layerid="32000";

$log=write_log($db_link,$layerid);

$ffh_id=$_GET["$kuerzel"];

if ($ffh_id < 1)
    { 
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r[anzahl];
	
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
			<style type="text/css">
				#map {
				width: 730px;
				height: 490px;
				border: 1px solid black;
				}
			</style>
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
							<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
									
									<td align="center" valign="top" height=30 colspan=2><br>
										<h3><? echo $titel; ?>*</h3>
										Zu diesem Thema befinden sich<br>
										<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
									</td>
									<td width=30 rowspan=8></td>
									<td border=0 valign=top align=center rowspan=7 colspan=3>
										<br>
										<div style="margin:1px" id="map"></div>
									</td>
								</tr>
								<tr>
									<td align="center"  height=60 colspan=2>
										<? echo $titel2; ?> ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=40 colspan=2>
										<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
										<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
											<?php
												$query="SELECT name, gid FROM $schema.$tabelle ORDER BY name";
												$result = $dbqueryp($connectp,$query);
												echo "<option>Bitte ausw&auml;hlen</option>\n";
												while($r = $fetcharrayp($result))
													{
														echo "<option value=\"$r[gid]\">$r[name]</option>\n";
													}
											?>
										</select>										
										</form>
									</td>									
								</tr>
                                <tr>
					             <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema <? echo $titel; ?></a>
						         </td>
					            </tr>
					            <tr><td align=center colspan=2>letzte Aktualisierung: <b><i><? echo get_aktualitaet($dbname,$layerid); ?></td>
								</tr>
								<tr>
									<td valign=bottom align=center>
										<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die webbasierte Karte?<br>(OpenLayers)</a>																
									</td>
								</tr>
                                <tr>									
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<table border="1" rules="none" width="100%" valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td align=right><small><? echo $titel2;?>: </td>
													<td align=right><img src="images/ffh.gif" width=30></td>													
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>													
												</tr>											
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>					           
								</tr>							
								<tr>
										<td colspan=2 height=35></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>   
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
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
                    <? include ("includes/news.php") ?>					
					</div>
					<div id="footer">						
					</div>
				</div>
			</body>
		</html>
<?	} 


if ($ffh_id > 0)
   {   
	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(st_transform(b.the_geom,2398),a.the_geom) AND b.gid='$ffh_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, $schema.$tabelle as b WHERE ST_INTERSECTS(st_transform(b.the_geom,2398),a.the_geom) AND b.gid='$ffh_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count=$k;
		}
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(the_geom),25833)) as etrscenter, box(the_geom) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_centroid(st_transform(the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, st_astext(st_centroid(st_transform(the_geom, 2398))) as s4283, st_astext(st_centroid(st_transform(the_geom, 4326))) as geo, st_astext(st_transform(the_geom, 2398)) as koordinaten, st_perimeter(the_geom) as umfang, gid, name, area_ha, eu_nr, ffh_art1, ffh_art2, anz_art, bedeut, eu_nr, managem, gis_code FROM $schema.$tabelle WHERE gid='$ffh_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname = $r[ziel];
	  $area=$r[area];	  
	  $zentrum = $r[etrscenter];
	  $rd83 = $r[rd83];
	  $s4283 = $r[s4283];
	  $utm = $r[utm];
	  $geo = $r[geo];
	  $umfang = $r[umfang];
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
			<style type="text/css">
			   #map {
					width: 700px;
					height: 320px;
					border: 1px solid black;
				}
			</style>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_3_flaeche.php"); ?>
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 2px;}
			td.rahmen {border: solid #000000 1px;}
		</style> 
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		<script type="text/javascript">
			function popup (url) {
				fenster = window.open(url, "Popupfenster", "width=700,height=1000,resizable=yes");
				fenster.focus();
				return false;
			}
		</script>
		
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
											<? echo $font_farbe ;?><? echo $r[name]; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>EU-Nummer: <? echo $r[eu_nr]; ?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2"><? echo $titel2;?>:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT name, gid FROM $schema.$tabelle ORDER BY name";
														$result = $dbqueryp($connectp,$query);														
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($ffh_id == $e[gid]) echo " selected"; echo " value=\"$e[gid]\" title=\"$e[name]\">$e[name]</option>\n";
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
									<tr>										
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<table border="1" rules="none" width="100%" valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td align=right><small><? echo $titel2;?>: </td>
													<td align=right><img src="images/ffh.gif" width=30></td>													
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>													
												</tr>											
											</table> <!-- Ende der Tabelle für die Legende -->
										</td>
									</tr>	
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?<? echo $kuerzel;?>=<? echo $ffh_id; ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						    <tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=2  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r[name] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">FFH Art (Klasse 1):</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[ffh_art1] ;?></b></td>													
									</tr>
									<tr height="30">
										<td>FFH Art (Klasse 2):</td>
										<td><b><? echo $r[ffh_art2] ;?></b></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Bedeutung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[bedeut] ;?></b></td>													
									</tr>
									<tr height="30">
										<td>EU-Nr:</td>
										<td><b><? echo $r[eu_nr] ;?></b></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Management:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[managem] ;?></b></td>													
									</tr>
									<tr height="30">
										<td>Fl&auml;che in ha:</td>
										<td><b><? echo $r[area_ha] ;?></b></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Artenanzahl:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[anz_art] ;?></b></td>													
									</tr>
									<tr height="30">
										<td>Anlage:</td>
										<?											
											$bildname1 = explode("&",$bildname);
											$bildname2 = $bildname1[0];
											$bildname3 = explode("/",$bildname2);
											$bild="pictures/".$bildname3[3]."/".$bildname3[4];										
											echo "<td><b><a href=$bild target='_blank' onclick='return popup(this.href);'>$r[gis_code].pdf</a></b></td>";
										?>
									</tr>									
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top><? echo $titel2;?> schneidet folgende<br>&Auml;mter des Kreises:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
											<?php 
												for($x=0;$x<$i;$x++)
												{ echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
											?></b>
										</td>													
									</tr>
									<tr>
										<td valign=top><? echo $titel2;?> schneidet folgende<br>Gemeinden des Kreises:</td>
										<td><b>
											<?php 
												for($y=0;$y<$k;$y++)
												{echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$y][0],"\">",$gemeinden[$y][1],"(".$gemeinden[$y][0].")</a><br>";}
											?></b>
										</td>
									</tr>																		
								</table>
							</td>
							<td width=30></td>
							<td valign=top align=center width="350">
								<? include ("includes/geo_flaeche.php") ?>
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
				<? include ("includes/news.php") ?>		
			</div>
			<div id="footer">			
			</div>
		</div>
		</body>
		</html>
<?  }

