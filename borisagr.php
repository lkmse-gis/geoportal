<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_mse.php");
include ("includes/portal_functions.php");

//globale Varibalen
$headline="Bodenrichtwerte<br>Ackerland/Grünland/Forst";
$titel="Bodenrichtwerte_AGR";
$titel2="Bodenrichtwert";
$kuerzel="borisagr";
$tabelle="bw_zonen";

#$log=write_log($db_link,$layerid);
$log=write_i_log($db_link,$layerid);

$gemarkung_id=$_GET["gemarkung"];
$themen_id=$_GET["$kuerzel"];
$stichtag=$_GET["stichtag"];


if (!isset($stichtag))
    {
	  $query="SELECT stichtag ,layer_id_agf from bodenrichtwerte.bw_stichtage WHERE aktuell";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $stichtag = $r['stichtag'];
	  $layerid = $r['layer_id_agf'];
	  
	}
	else
	{
	  $query="SELECT stichtag,layer_id_agf from bodenrichtwerte.bw_stichtage WHERE stichtag ='$stichtag'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $layerid = $r['layer_id_agf'];
	  
	}
	
$titel="Bodenrichtwerte_AGR_".$stichtag;	

if ($themen_id < 1 AND $gemarkung_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM bodenrichtwerte.bw_zonen WHERE (zonentyp='Ackerland' OR zonentyp='Grünland' OR zonentyp='forstwirtschaftliche Flächen') AND stichtag='$stichtag'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r['anzahl'];
	
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
						<? echo "
							<tr>							
							<td width=\"30%\" align=\"center\" valign=\"top\" height=30 colspan=2><br>";
							echo get_i_mp_link($db_link,$layerid); 
							echo "<h3>$headline*</h3>
							Zu diesem Thema befinden sich<br>
							<b>$count</b> Datens&auml;tze in der Datenbank.
							</td>
							<td rowspan=7 width=\"5%\">
							<td width=\"75%\" border=0 valign=top rowspan=6 colspan=3>
							<br>
							<div style=\"margin:1px\" id=\"map\"></div>
							</td>
							</tr>"; ?>
					<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 12pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
							Stichtag:
							
								<select name="stichtag" onchange="document.stichtag.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM bodenrichtwerte.bw_stichtage  ORDER BY stichtag DESC";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($stichtag == $r['stichtag']) echo " selected"; echo ' value=',$r["stichtag"],'>',$r["ausgabe"]
													,'</option>\n';
										}
									?>
								</select>								
							</form>
						</td>									
					</tr>
					<tr>
						<td align="center" height=50 colspan=2>
							Ortschaft ausw&auml;hlen:<br>
							<small>Die Angabe in Klammern ist die jeweils zugehörige Gemeinde.
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 8pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
							<input type=hidden name="stichtag" value="<? echo $stichtag ?>">
								<select name="gemarkung" onchange="document.<? echo $kuerzel;?>.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM show_gemarkungen  ORDER BY gemarkung";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($gemarkung_id == $r['gemkgschl']) echo " selected"; echo ' value=',$r["gemkgschl"],'>',$r["gemarkung"],'
													</option>\n';
										}
									?>
								</select>								
							</form>
						</td>									
					</tr>
						<tr><td align=center colspan=2>
						*) <a href="<? echo $metadatenpfad.$layerid;?>" target="_blank" onclick="return hilfe_popup(this.href)">Info zum Thema <? echo $titel; ?></a>
						</td>
					    </tr>
						<? include ("includes/block_1_legende.php"); ?>
						<?php
							echo "
								<tr>
								<td colspan=2 height=35></td>				
								<td><small>
								$cr| &nbsp;<a href=\"includes/kartehilfe.php\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\">Hilfe zur Kartennutzung</a>
								</td>	
								<td>
								<a href=\"metadaten/metadaten.php?Layer_ID=$layerid\" target=\"_blank\" onclick=\"return meta_popup(this.href)\"><img src=\"images/info_button.gif\" title=\"Metadaten\" border=0></a>
								</td>
								<td align=right>
								<a href=\"",$_SERVER["PHP_SELF"],"?stichtag=",$stichtag,"\"><img src=\"images/reload.png\" title=\"Kartenausschnitt neu laden\"></a>
								</td>
								</tr>";
						?>
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


if ($gemarkung_id > 0)
   { 	  
	  $query="SELECT ackerzahl, bodenrichtwertnummer, bodenrichtwert,  gruenlandzahl, zonentyp,stichtag FROM bodenrichtwerte.bw_zonen WHERE gemarkung='$gemarkung_id' AND stichtag='$stichtag' AND (zonentyp LIKE '%nland%' OR zonentyp = 'Ackerland' OR zonentyp LIKE 'forstwirtschaftliche%') ORDER BY bodenrichtwertnummer";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($x = $fetcharrayp($result))
	    {
	       $borisf[$z]=$x;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT gemarkungsname_kurz FROM gemarkung WHERE geographicidentifier = '$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $y = $fetcharrayp($result);
	  $gemarkungsname=$y[0];
	  
	  
	  $query="SELECT b.gemeinde,b.gem_schl FROM gemarkung as a, gemeinden as b WHERE a.geographicidentifier='$gemarkung_id' AND a.gemeinde::integer=CAST(b.gem_schl AS INTEGER)";
	  $result = $dbqueryp($connectp,$query);
	  $y = $fetcharrayp($result);
	  $gemeindename=$y[0];
	  $gemeinde=$y[1];
	  
	  $query="SELECT b.amt, b.amt_id FROM gemarkung as a,gemeinden as b WHERE a.geographicidentifier='$gemarkung_id' AND a.gemeinde::integer= CAST(b.gem_schl as INTEGER)";
	  $result = $dbqueryp($connectp,$query);
	  $a = $fetcharrayp($result);
	  $amtname=$a[0];
	  $amt=$a[1];
	  
	  $query="SELECT box(the_geom) as box, box(st_transform(the_geom,25833)) as etrsbox, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_transform(st_centroid(the_geom),25833)) as etrscenter, gemarkungsname_lang as name from gemarkung WHERE geographicidentifier='$gemarkung_id'";

	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $flaeche = $r["area"]/10000;
	  $flaeche2 = explode(".",$flaeche);
	  $flaeche3 = $flaeche2[0];
	  $zentrum = $r["etrscenter"];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rcenter = $zentrum4[0];
	  $hcenter = $zentrum4[1];
	  $boxstring = $r["etrsbox"];
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
										<td height="50" align="center" valign=center width=250  bgcolor=<? echo $header_farbe ;?>>
											<? echo $font_farbe ;?>Bodenrichtwertzonen<br> (Ackerland/Grünland/Forst)<br> in <? echo $gemarkungsname; ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30></td>
										<td border=0 valign=top align=center rowspan="6" colspan=5>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?> height=50><td>
										<table border=0 >
											<tr>
												<td>Gemeinde:</td>
												<td><a href="gemeinden_msp.php?gemeinde=<? echo $gemeinde; ?>"><? echo $gemeindename ?></a></td>
											</tr>
										   <tr>
												<td>Amt:</td>
												<td><a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a></td>
											</tr>
										</table>
									</td>
									</tr>
									<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 12pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
							<input type=hidden name="gemarkung" value="<? echo $gemarkung_id ?>">
							Stichtag:
							
								<select name="stichtag" onchange="document.stichtag.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM bodenrichtwerte.bw_stichtage  ORDER BY stichtag DESC";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($stichtag == $r['stichtag']) echo " selected"; echo ' value=',$r["stichtag"],'>',$r["ausgabe"]
													,'</option>\n';
										}
									?>
								</select>								
							</form>
						</td>									
					</tr>
									<tr>
						<td align="center" height=60  style="font-family:Arial; font-size: 8pt; font-weight: bold">   
							<b>Gemarkung:</b><br><form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
								<input type=hidden name="stichtag" value="<? echo $stichtag ?>">
								<select name="gemarkung" onchange="document.<? echo $kuerzel;?>.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM show_gemarkungen  ORDER BY gemarkung";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($gemarkung_id == $r['gemkgschl']) echo " selected"; echo ' value=',$r["gemkgschl"],'>',$r["gemarkung"],'
													</option>\n';
										}
									?>
								</select>								
							</form>
						</td>									
						</tr>
						<tr>
							<td align=center bgcolor=<? echo $header_farbe ;?>>
								<a href="<? echo $_SERVER["PHP_SELF"],"?stichtag=",$stichtag;?>"><? echo $link_farbe ;?>Bodenrichtwertzonen (A/GR/F)<br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
							</td>										
						</tr>
							<? include ("includes/block_2_legende_gemkg.php"); ?>								
							<?php
							echo "
								<tr>
								<td colspan=2 height=35></td>				
								<td><small>
								$cr| &nbsp;<a href=\"includes/kartehilfe.php\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\">Hilfe zur Kartennutzung</a>
								</td>	
								<td>
								<a href=\"metadaten/metadaten.php?Layer_ID=$layerid\" target=\"_blank\" onclick=\"return meta_popup(this.href)\"><img src=\"images/info_button.gif\" title=\"Metadaten\" border=0></a>
								</td>
								<td align=right>
								<a href=\"",$_SERVER["PHP_SELF"],"?stichtag=",$stichtag,"&gemarkung=",$gemarkung_id,"\"><img src=\"images/reload.png\" title=\"Kartenausschnitt neu laden\"></a>
								</td>
								</tr>";
						?>
							</table> <!-- Ende innere Tablle oberer Block -->
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
								<table border=0 width="100%" valign=top>
												<? head_trefferliste($count,5,$header_farbe)?>											
												<tr>
												    <td align=center height=30><b><a name="liste"></a>Bodenrichtwert-<br>nummer</td>													
													<td align=center><b>Zonentyp</td>
													<td align=center><b>Bodenrichtwert</td>
													<td align=center><b>Acker-/Grünlandzahl</td>
													<td align=center><b>Stichtag</td>
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{
													
													echo "<tr bgcolor=",get_farbe($v),">",
														"<td align='center'><a href=\"",$_SERVER["PHP_SELF"],"?$kuerzel=",$borisf[$v]["bodenrichtwertnummer"],"&stichtag=$stichtag","\">",$borisf[$v]["bodenrichtwertnummer"],"</a></td>",
														"<td align='left'>",$borisf[$v]["zonentyp"],"</td>",														
														"<td align='center'>",$borisf[$v]["bodenrichtwert"]," €/m²</td>",
														"<td align='center'>";
														if ($borisf[$v]["zonentyp"] == "Ackerland") echo $borisf[$v]["ackerzahl"];
														if ($borisf[$v]["zonentyp"] == "Grünland") echo $borisf[$v]["gruenlandzahl"];
														echo "</td><td>",$borisf[$v]["stichtag"],
														"</td></tr>";
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
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid FROM gemeinden as a, bodenrichtwerte.bw_zonen as b WHERE ST_INTERSECTS(st_buffer(st_transform(b.the_geom, 2398),-10),a.the_geom) AND b.bodenrichtwertnummer='$themen_id' AND b.stichtag='2016-12-31'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r["amt"];
	  $amt=$r["amt_id"];
	  $gem_id=$r["gemeindeid"];
	  $gemeindename=$r["gemeinde"];
	  
	  $query="SELECT gemarkungsname_kurz, geographicidentifier FROM gemarkung, bodenrichtwerte.bw_zonen WHERE bw_zonen.bodenrichtwertnummer='$themen_id' AND gemarkung.geographicidentifier::integer=bw_zonen.gemarkung";
	  $result = $dbqueryp($connectp,$query);
	  $y = $fetcharrayp($result);
	  $gemarkungsname=$y[0];
	  $gemarkung_id=$y[1];
	  
	  $query="SELECT box(the_geom) as box, box(st_transform(the_geom,25833)) as etrsbox, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_transform(st_centroid(the_geom),25833)) as etrscenter, st_perimeter(st_transform(the_geom,2398)) as umfang,st_astext(st_centroid(st_transform(the_geom, 4326))) as geo,st_astext(st_centroid(st_transform(the_geom, 25833))) as utm ,st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83 ,bodenrichtwertnummer, bodenrichtwert, stichtag, flaeche,ackerzahl, oertliche_bezeichnung, zonentyp, gruenlandzahl, ortsteilname, flaeche,gemarkung,gemeinde FROM bodenrichtwerte.bw_zonen WHERE bodenrichtwertnummer='$themen_id' AND stichtag='$stichtag'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $x = $fetcharrayp($result);
	  $geo=$x["geo"];
	  $utm=$x["utm"];
	  $rd83=$x["rd83"];
	  $area=$x["area"];
	  $flaeche = $x["area"]/10000;				//Fläche wird geteilt durch 10000 um ha zu ermitteln
	  $flaeche2 = explode(".",$flaeche);		//Fläche wird zerlegt in zwei Arrays
	  $flaeche3 = $flaeche2[0];					//Ausgabe der Fläche ohne Kommastellen
	  $zentrum = $x["etrscenter"];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $umfang = $x["umfang"];
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];
	  $rcenter = $zentrum4[0];
	  $rcenter1 = explode(".",$rcenter);
	  $rcenter2 = $rcenter1[0];
	  $hcenter = $zentrum4[1];
	  $hcenter1 = explode(".",$hcenter);
	  $hcenter2 = $hcenter1[0];
	  $boxstring = $x["etrsbox"];
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
		<? include ("includes/block_3_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />		
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_2_gemkg.php"); ?>
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
										<td height="50" align="center" valign=center width=250  bgcolor=<? echo $header_farbe ;?>>
											<? echo $font_farbe ;?>Bodenrichtwertzone<br><? echo $x["bodenrichtwertnummer"]," (",$x["zonentyp"],")"; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=30 rowspan="7"></td>
										<td border=0 valign=top align=right rowspan="7" colspan=5>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>									
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe ?>>
											(Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>)
										<br>
											(Gemeinde: <a href="gemeinden_msp.php?gemeinde=<? echo $x["gemeinde"]; ?>"><? echo get_gemeinde_name($x["gemeinde"],$connectp,$dbqueryp,$fetcharrayp) ; ?></a>)
										</td>
									</tr>
									<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 12pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
							<input type=hidden name="borisagr" value="<? echo $themen_id ?>">
							Stichtag:
							
								<select name="stichtag" onchange="document.stichtag.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM bodenrichtwerte.bw_stichtage  ORDER BY stichtag DESC";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($stichtag == $r['stichtag']) echo " selected"; echo ' value=',$r["stichtag"],'>',$r["ausgabe"]
													,'</option>\n';
										}
									?>
								</select>								
							</form>
						</td>									
					</tr>
									<tr>
										<td align="center" height=60  style="font-family:Arial; font-size: 8pt; font-weight: bold">   
											<b>Gemarkung:</b><br><form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
											<input type=hidden name="stichtag" value="<? echo $stichtag ?>">
								<select name="gemarkung" onchange="document.<? echo $kuerzel;?>.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT * FROM show_gemarkungen  ORDER BY gemarkung";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($gemarkung_id == $r['gemkgschl']) echo " selected"; echo ' value=',$r["gemkgschl"],'>',$r["gemarkung"],'
													</option>\n';
										}
									?>
								</select>								
											</form>
										</td>									
									</tr>
									<tr>										
										<td align=center bgcolor=<? echo $header_farbe ?>>
											<a href="<? echo $_SERVER["PHP_SELF"],"?stichtag=",$stichtag; ?>"><? echo $link_farbe ;?>Bodenrichtwertzonen (A/GR/F)<br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
										</td>										
									</tr>
									<tr>										
										<td align=center bgcolor=<? echo $header_farbe ?>>
											<a href="<? echo $_SERVER["PHP_SELF"],"?gemarkung=",$x['gemarkung'],"&stichtag=",$stichtag; ?>"><? echo $link_farbe ;?>Bodenrichtwertzonen (A/GR/F)<br>in  <? echo get_gemarkung_name($x['gemarkung'],$connectp,$dbqueryp,$fetcharrayp); echo $link_farbe_end ;?></a>
										</td>										
									</tr>
									<? include ("includes/block_3_legende.php"); ?>
									<?php
							echo "
								<tr>
								<td colspan=2 height=35></td>				
								<td><small>
								$cr| &nbsp;<a href=\"includes/kartehilfe.php\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\">Hilfe zur Kartennutzung</a>
								</td>	
								<td>
								<a href=\"metadaten/metadaten.php?Layer_ID=$layerid\" target=\"_blank\" onclick=\"return meta_popup(this.href)\"><img src=\"images/info_button.gif\" title=\"Metadaten\" border=0></a>
								</td>
								<td align=right>
								<a href=\"",$_SERVER["PHP_SELF"],"?stichtag=",$stichtag,"&borisagr=",$themen_id,"\"><img src=\"images/reload.png\" title=\"Kartenausschnitt neu laden\"></a>
								</td>
								</tr>";
						?>
									</table>								 
							<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
									<td valign=top>											
										<table border=0 valign=top>
											<tr height="35">
												<td width="100%" colspan=2 bgcolor=<? echo $header_farbe ?>><font size="+1"><? echo $font_farbe ;?>&nbsp;&nbsp;Bodenrichtwertzone <? echo $x['bodenrichtwertnummer']," (",$x['zonentyp'],")";?><? echo $font_farbe_end ;?></td>
											</tr>														 
											<tr height="25" bgcolor=<? echo $element_farbe ?>><td>Bodenrichtwertnummer:</td>
												<td width="100%"><b><? echo $x['bodenrichtwertnummer'] ; ?></b></td></tr>
											<tr height="25"><td>Gemeinde:</td>
												<td><b><? echo get_gemeinde_name($x['gemeinde'],$connectp,$dbqueryp,$fetcharrayp) ; ?></b></td></tr>
											<tr height="25" bgcolor=<? echo $element_farbe ?>><td>Gemarkung:</td>
												<td><b><? echo get_gemarkung_name($x['gemarkung'],$connectp,$dbqueryp,$fetcharrayp); ; ?></b></td></tr>
											  <tr height="25"><td>Ortsteil:</td>
												<td><b><? echo $x['ortsteilname'] ; ?></b></td></tr>

											 <tr height="25" bgcolor=<? echo $element_farbe ?>><td>örtl. Bezeichnung</td>
												<td><b><? echo $x['oertliche_bezeichnung'] ?></b></td></tr>
											 <tr height="25"><td>Bodenrichtwert</td>
												<td><b><? echo $x['bodenrichtwert'] ?> €/m²</b></td></tr>
											 <tr height="25" bgcolor=<? echo $element_farbe ?>><td>Zonentyp:</td>
												<td><b><? echo $x['zonentyp'] ?> </b></td></tr>
											 <tr height="25"><td>
											 <? if ($x['zonentyp'] == 'Ackerland') echo "Ackerzahl";
												if ($x['zonentyp'] == 'Grünland') echo "Gruenlandzahl";
											 ?>
											 </td>
											<td><b>
											<? if ($x['zonentyp'] == 'Ackerland') echo $x['ackerzahl']; 
											   if ($x['zonentyp'] == 'Grünland') echo $x['gruenlandzahl'];
											?>
											</td></tr>
											 <tr height="25" bgcolor=<? echo $element_farbe ?>><td>Stichtag</td>
												<td><b><? echo $x['stichtag'] ?> </b></td></tr>
										</table>
									</td>										
									<td valign=top align=right width="350">
									<? include("includes/geo_flaeche.php"); ?>	
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



