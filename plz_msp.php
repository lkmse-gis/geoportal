<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Postleitzahlbereiche";


$layerid=31100;
$plz_id=$_GET["plz"];
$layer='Postleitzahlbereiche';
$beschriftung_karte='PLZ-Bereiche';

$log=write_i_log($db_link,$layerid);

if ($plz_id < 1)
    { 
		$query="SELECT COUNT(*) AS anzahl FROM osm.plz";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
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
		<? include ("includes/meta_popup.php"); 
        $plz_karte= new karte;
        echo $plz_karte->zeigeKarteBox($box_mse_gesamt,'740','450','orka','0','0','0','0','0',$beschriftung_karte,$layer);			 
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
									
									<td align="center" valign="top" height=30 colspan=2><br>
										<h3>Postleitzahlbereiche*</h3>
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
									<td align="center"  height=30 colspan=2>
										Postleitzahlbereich ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=60 colspan=2>
										<form action="plz_msp.php" method="get" name="plz">
										<select name="plz" onchange="document.plz.submit();">
											<option>Bitte auswählen</option>
											<?php
												$query="SELECT plz, gid FROM osm.plz ORDER BY plz";
												$result = $dbqueryp($connectp,$query);

												while($r = $fetcharrayp($result))
													{
														echo "<option value=\"$r[gid]\">$r[plz]</option>\n";
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
								 echo $legende_geo->zeigeLegende($layer_legende,'','','','');
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
		  </div>
		</div>
			</body>
		</html>
<?	} 


if ($plz_id > 0)
   {   
	  $query="SELECT a.name, a.amts_sf FROM kataster.amtsbereiche a, osm.plz as b WHERE ST_INTERSECTS(b.geom,st_buffer(a.geom_25833,-500)) AND b.gid='$plz_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, osm.plz as b WHERE ST_INTERSECTS(b.geom,st_buffer(a.geom_25833,-500)) AND b.gid='$plz_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count=$k;
		}
	  
	  $query="SELECT box(st_transform(geom,2398)) as box, box(geom) as etrsbox,area(geom) as area, st_astext(st_centroid(geom)) as center, st_astext(st_centroid(geom)) as utm, st_astext(st_centroid(st_transform(geom, 4326))) as geo, st_astext(st_centroid(st_transform(geom, 31468))) as rd83,st_astext(st_centroid(st_transform(geom, 2398))) as s4283, st_astext(st_transform(geom, 2398)) as koordinaten, st_perimeter(geom) as umfang, gid, plz FROM osm.plz WHERE gid='$plz_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);	 
	  $area=$r["area"];	  
	  $zentrum = $r["center"];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $utm = $r["utm"];
	  $geo = $r["geo"];
	  $s4283 = $r["s4283"];
	  $rd83 = $r["rd83"];
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
		<? include ("includes/meta_popup.php"); 
        $plz_karte= new karte;
        echo $plz_karte->zeigeKarteBox($boxstring_etrs,'680','450','orka','0','0','0','0','0',$beschriftung_karte,$layer);			 
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
							<td valign=top>
								<table border=0>
									<tr>
										<td height="40" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Postleitzahlbereich <? echo $r["plz"]; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b><? echo $r["plz"]; ?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">Postleitzahlbereich:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="plz_msp.php" method="get" name="plz">												
												<select name="plz" onchange="document.plz.submit();">
													<?php														
															$query="SELECT plz, gid FROM osm.plz ORDER BY plz";
															$result = $dbqueryp($connectp,$query);

															while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($plz_id == $e["gid"]) echo " selected"; echo ' value="',$e["gid"],'">',$e["plz"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="plz_msp.php"><? echo $font_farbe ;?>alle Postleitzahlbereiche<? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
									<tr>										
 			                        <!-- Tabelle für Legende -->
						               <td valign=bottom align=left >
							            <table class="table_legende" >
								          <B>Kartenlegende :</B>
								<?php
								 $legende_geo= new legende_geo;
								 echo $legende_geo->zeigeLegende($layer_legende,'','','','');
								?>
							</table> 
						</td>
			<!-- ENDE Tabelle für Legende --> 
									</tr>	
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=5050" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="plz_msp.php?plz=<? echo $plz_id; ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1">Postleitzahlbereich <? echo $r["plz"] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> height=30>Postleitzahlbereich:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["plz"] ;?></b></td>													
									</tr>
									<tr>
										<td valign=top height=30>enthaltene Amtsbereiche:</td>
										<td><b>
											<?php 
												for($x=0;$x<$i;$x++)
												{ echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
											?></b>
										</td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30>enthaltene Gemeinden:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
											<?php 
												for($y=0;$y<$k;$y++)
												{echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$y][0],"\">",$gemeinden[$y][1],"(".$gemeinden[$y][0].")</a><br>";}
											?></b>
										</td>
									</tr>									
								</table>
							</td>
							<td width=30></td>
							<td valign=top align=center width="250">
								<? include ("includes/geo_flaeche.php") ?>
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

