<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect_i_procedure_mse.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");


$gemarkung_id=$_GET["gemarkung"];
$layerid=30000;

$log=write_i_log($db_link,$layerid);
$layer_legende_1='msp_outline_gemkg';

if ($gemarkung_id > 0)
   { 

	  $query="SELECT b.gemeinde,b.gem_schl FROM kataster.gemarkung as a, gemeinden as b WHERE a.geographicidentifier='$gemarkung_id' AND a.gemeinde=b.gem_schl";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename=$r[0];
	  $gemeinde=$r[1];
	  
	  $query="SELECT b.amt, b.amt_id, c.gid as vsitzid FROM kataster.gemarkung as a, gemeinden as b, kataster.amtsbereiche_standorte as c WHERE a.geographicidentifier='$gemarkung_id' AND a.gemeinde= b.gem_schl AND b.amt_id=CAST(c.amt_id as character varying)";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $vsitzid = $r["vsitzid"];
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT b.name, b.gid FROM kataster.gemarkung as a, government.regionen as b WHERE ST_CONTAINS(ST_BUFFER(b.the_geom,20),a.geom_25833) AND a.geographicidentifier='$gemarkung_id' ORDER by b.name";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $region[$k]=$r;
		   $k++;
		   $count=$k;
		}  
		
	  $query="SELECT b.plz, b.gid FROM kataster.gemarkung as a, osm.plz as b WHERE ST_INTERSECTS(ST_BUFFER(b.geom,-10),a.geom_25833) AND a.geographicidentifier='$gemarkung_id' ORDER by b.plz";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $plz[$z]=$r;
		   $z++;		   
		   $count=$z;
		}
   
	  $query="SELECT  box(the_geom) as box, box(st_buffer(geom_25833,1000)) as etrsbox, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_centroid(st_transform(the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, st_astext(st_centroid(st_transform(the_geom, 4326))) as geo, st_perimeter(the_geom) as umfang, gemarkungsname_kurz as name from kataster.gemarkung WHERE geographicidentifier='$gemarkung_id'";

	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname = $r["name"];
	  $area=$r["area"];
	  $flaeche = $r["area"]/10000;
	  $flaeche2 = explode(".",$flaeche);
	  $flaeche3 = $flaeche2[0];
	  $zentrum = $r["center"];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rd83 = $r["rd83"];
	  $utm = $r["utm"];
	  $geo = $r["geo"];
	  $umfang = $r["umfang"];
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];
	  $rcenter = $zentrum4[0];
	  $rcenter1 = explode(".",$rcenter);
	  $rcenter2 = $rcenter1[0];
	  $hcenter = $zentrum4[1];
	  $hcenter1 = explode(".",$hcenter);
	  $hcenter2 = $hcenter1[0];
	  $boxstring_etrs = $r["etrsbox"];
	  $boxstring = $r["box"];
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
        <?$gemarkung_karte= new karte;
        echo $gemarkung_karte->zeigeKarteBox($boxstring_etrs,'580','450','orka','1','1','','1','0',$beschriftung_karte,$gemarkung_id); ?>			 
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
									<td height="40" align="center" valign=center  bgcolor=<? echo $header_farbe ;?> colspan="2">
										<? echo $font_farbe ;?>Gemarkung: <? echo $gemarkungsname ?><? echo $font_farbe_end ;?>									
									</td>
										<td width=30 rowspan=13></td>
										<td border=0 valign=top align=right rowspan=12 colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<b>(Amt: <? echo $amtname ?>)</b>
										</td>									
									</tr>
									<tr>
										<td align="center" valign="center" colspan=2 height=20>		
										<form action="gemarkungen_msp.php" method="get" name="gemarkung">
											Ortschaft (Gemeinde):<br>
											<select name="gemarkung" onchange="document.gemarkung.submit();"  style="font-family:Arial; font-size: 8pt; font-weight: bold">
												<?php
												 $query="SELECT * FROM show_gemarkungen_13071 ORDER BY gemarkung";
												 $result = $dbqueryp($connectp,$query);

												  while($r = $fetcharrayp($result))
												   {
												   echo "<option";if ($gemarkung_id == $r["gemkgschl"]) echo " selected"; echo ' value="',$r["gemkgschl"],'">',$r["gemarkung"];
																
													echo "</option>\n";
												   }
												?>
											</select>
										</form>
									</td>
								</tr>
								<tr height="30" bgcolor=<? echo $element_farbe ;?>>									
									<td align=center colspan="2"><a href="gemarkungen_msp.php">zu allen Gemarkungen</a></td>
								</tr>	
								<tr height="30" bgcolor=<? echo $element_farbe ;?>>
									<td align=center colspan="2"><? echo "<a href=\"vsitz_msp.php?vsitz=",$vsitzid,"\">zur Amtsverwaltung</a></td>";?>
								</tr>
								<tr>
									<td colspan="2" align="center" height=30 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Informationen zu der Gemarkung<? echo $font_farbe_end ;?></td>
								</tr>
								
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td height=30>Amt:</td>
									<td><a href="aemter_msp.php?amt=<? echo $amt; ?>"><b><? echo $amtname ?></b></a></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td>Gemeinde:</td>
									<td><a href="gemeinden_msp.php?gemeinde=<?php echo $gemeinde; ?>"><b><? echo $gemeindename ?></b></a></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td>Gemarkungsnr.:</td>
									<td><b><? echo $gemarkung_id ?></b></td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td height=30>Postleitzahl:</td>
									<td>
										<?php
											for($l=0;$l<$z;$l++)												
												{echo "<a href=\"plz_msp.php?plz=",$plz[$l][1],"\"><b>",$plz[$l][0],"</b></a> ";}																							
										?>
									</td>
								</tr>
								<tr bgcolor=<? echo $element_farbe ;?>>
									<td>Bodenrichtwertzonen</td>
									<td><a href="borisf.php?gemarkung=<? echo $gemarkung_id; ?>&str_schl=x">Wohn-/Bau-/Gewerbe-/Sanierungsflächen</a><br><br><a href="borisagr.php?gemarkung=<? echo $gemarkung_id; ?>">Acker-/Grünland-/Forstflächen</a></td>
									
								</tr>
								<tr>
	           			<!-- Tabelle für Legende -->
						<td valign=bottom align=left colspan=2>
							<table class="table_legende" >
								<B>Kartenlegende :</B>
								<?php
								 $legende_geo= new legende_geo;
								 echo $legende_geo->zeigeLegende('msp_outline_gemkg',$gemarkung_id,'','','');
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
											<a href="metadaten/metadaten.php?Layer_ID=30000" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="gemarkungen_msp.php?gemarkung=<? echo $gemarkung_id ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
									<tr>										
										<td colspan=12>
											<table border=0 width="100%">
												<tr height="35">
													<td align=center colspan=12 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?><font size="+1">Geodätisches...<? echo $font_farbe_end ;?></td>
												</tr>
												<tr>
													<td align=center colspan=8 bgcolor=<? echo $header_farbe ;?>><font color=white><i>Zentrum Position</i></font></td>
													<td rowspan=2 colspan=4 align=center bgcolor=<? echo $header_farbe ?>><font color=white><i>Flächenangaben:</i></font></td>
												</tr>
												<tr>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>WGS84<br>(geografisch)</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>UTM<br>ETRS89 6&deg; Zone-33<br>GRS80</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>Gauß-Krüger<br>S42/83 3&deg; 4-Streifen<br>Krassowski</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>Gauß-Krüger<br>RD/83 3&deg; 4-Streifen<br>Bessel</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;östl. L.:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_long($geo);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lon($utm);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo $rcenter2 ;?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_rd83coordinates_lon($rd83);?></b></td>
													<td>&nbsp;&nbsp;Fläche:</td>
													<td><b>&nbsp;
														<? 
														   if ($area > 10000) 
																{$area=$area/10000;
																	$area1 = explode(".",$area);
																	$area2 = $area1[0];
																	echo $area2." ha"; 
																} 
															else 
																{
																	echo $area." m²";
																}
														?></b>
													</td>
													<td>&nbsp;&nbsp;Grenzlänge:</td>
													<td><b>&nbsp;&nbsp;<? echo $umfang3 ;?> m<b></td>													
												</tr>
												<tr>
													<td>&nbsp;&nbsp;nördl. Br.:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_lat($geo);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lat($utm);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo $hcenter2 ;?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_rd83coordinates_lat($rd83) ;?></b></td>
													<td>&nbsp;&nbsp;Nord-Süd<br>&nbsp;&nbsp;Ausdehnung:</td>													
													<td><b>&nbsp;&nbsp;<? echo round($hoch_range,2) ?> m</b></td>
													<td>&nbsp;&nbsp;Ost-West<br>&nbsp;&nbsp;Ausdehnung:</td>
													<td><b>&nbsp;&nbsp;<? echo round($rechts_range,2) ?> m</b></td>												
												</tr>												
											</table>
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
							<script type="text/javascript" language="JavaScript1.2" src="menu_mse_geoportal.js"></script>
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

else
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM kataster.gemarkung WHERE gemeinde LIKE '13071%'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
	?>
		<?php
		$lon=4567406;
		$lat=5938983;
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
		<? include ("includes/meta_popup.php"); 
       $gemarkung_karte= new karte;
        echo $gemarkung_karte->zeigeKarteBox($box_mse_gesamt,'680','450','orka','1','0','0','0','0',$beschriftung_karte,'msp_outline_gemkg');	
        ?>		
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
						<td align="center" valign="top" width=300 height=140 colspan=2>
							<br>
							<h3>Ortschaften (Gemarkungen)*</h3>
							Zu diesem Thema befinden sich<br>
							<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
						</td>
						<td rowspan=8 width=30></td>
						<td border=0 align=center rowspan=7 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Ortschaft ausw&auml;hlen:<br>
							<small>Die Angabe in Klammern ist die jeweils zugehörige Gemeinde.
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 8pt; font-weight: bold">   
							<form action="gemarkungen_msp.php" method="get" name="gemarkung">								
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM show_gemarkungen_13071  ORDER BY gemarkung";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($gemarkung_id == $r["gemkgschl"]) echo " selected"; echo ' value="',$r["gemkgschl"],'">',$r["gemarkung"],'
													</option>\n';
										}
									?>
								</select>								
							</form>
						</td>									
					</tr>
					<? include ("includes/meta_i_aktualitaet.php"); ?>
                     			<!-- Tabelle für Legende -->
						<td valign=bottom align=left >
							<table class="table_legende" >
								<B>Kartenlegende :</B>
								<?php
								 $legende_geo= new legende_geo;
								 echo $legende_geo->zeigeLegende($layer_legende_1,'','','','');
								?>
							</table> 
						</td>
			<!-- ENDE Tabelle für Legende --> 

					<? include ("includes/block_1_1_uk.php"); ?>
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
		  </div>				</div>
			</body>
		</html>
<?	} ?>
