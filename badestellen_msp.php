<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="Badestellen";
$titel2="Badestelle";
$datei="badestellen_msp.php";
$tabelle="tourism.badestellen";
$kuerzel="badestelle";
$layerid="131300";
$leg_bild="swim.gif";

$gemarkung_id=$_GET["gemarkung"];
$badestellen_id=$_GET["$kuerzel"];
$themen_id=$badestellen_id;

$log=write_log($db_link,$layerid);

if ($themen_id < 1 AND $gemarkung_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle";	  
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
								Ort ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="gemarkung" onchange="document.<? echo $kuerzel;?>.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,$tabelle as c WHERE ST_WITHIN(st_transform(c.the_geom,2398),b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
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


if ($gemarkung_id > 0)
   { 	  
	  $query="SELECT a.* FROM $tabelle as a, gemarkung as b WHERE ST_WITHIN (st_transform(a.the_geom,2398), b.the_geom) AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $badestelle[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, gemarkung as b WHERE ST_WITHIN (ST_BUFFER(b.the_geom,-10), a.the_geom) AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT box(st_transform(a.the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(a.the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemarkungsname_kurz as name FROM gemarkung as a WHERE CAST(a.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname = $r[name];
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
										<td height="40" align="center" valign=top width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel;?> in <? echo $gemarkungsname ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="8"></td>
										<td border=0 valign=top align=left rowspan="7" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a></b>
										</td>
									</tr>
									<tr>
										<td align="center" height=30 colspan=2>
											Ort ausw&auml;hlen:
										</td>
									</tr>
									<tr>
										<td align="center" height="40">
											<form action="<? echo $datei;?>" method="get" name="gemarkung">								
												<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
													<option>Bitte auswählen</option>
													<?php
													 $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,$tabelle as c WHERE ST_WITHIN(st_transform(c.the_geom,2398),b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
													 $result = $dbqueryp($connectp,$query);

													  while($r = $fetcharrayp($result))
													   {
													   echo "<option";if ($gemarkung_id == $r[gemkgschl]) echo " selected"; echo " value=\"$r[gemkgschl]\">$r[gemarkung]
																	</option>\n";
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
									<? include ("includes/block_2_legende_gemkg.php"); ?>								
									<? include ("includes/block_2_uk_gemkg.php"); ?>
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
									<!-- Überschrift für Sachdaten -->
													<? if ($count>0) echo "
															<td align=center height=30></td>
															<td align=center height=30><a name=\"liste\"></a><b>Name:</b></td>													
															<td align=center height=30><b>Einstufung:</b></td>
															<td align=center height=30><b>Nummer:</b></td>
															<td align=center height=30><b>Beschreibung:</b></td>
														";
													?>
												</tr>
												<?php for($v=0;$v<$z;$v++)
													{ 
														$bildname = $badestelle[$v][bild];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[5]."/".$bildname3[6];
														echo "<tr bgcolor=",get_farbe($v),">";															
														if(strlen($bildname) < 1 OR $badestelle[$v][oeffentlich] == 'nein')
															{
																echo "<td></td>";	
															} 
														else 
															{
																echo "<td align='center'><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild height='30'></a></td>";
															}
														echo "
														<td align='center'><a href=\"$datei?$kuerzel=",$badestelle[$v][gid],"\">",$badestelle[$v][badegewaesser],"</a></td>","<td align='center'>",$badestelle[$v][einstufung],"</td>",													
														"<td align='center'>",$badestelle[$v][eu_nr],"</td>",
														"<td align='center'>",$badestelle[$v][beschreibung],"</td>",																												
														"</tr>";
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
	  $query="SELECT a.gemarkungsname_kurz, a.geographicidentifier as gemarkungid, b.gid FROM gemarkung as a, $tabelle as b WHERE ST_WITHIN(st_transform(b.the_geom,2398), a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkung_id=$r[gemarkungid];
	  $gemarkungname=$r[gemarkungsname_kurz];

	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, $tabelle as b WHERE ST_WITHIN(st_transform(b.the_geom,2398), a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT astext(st_transform(the_geom,2398)) as koordinaten, astext(st_transform(the_geom, 25833)) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, astext(st_transform(the_geom, 4326)) as geo, gid, eu_meldung, badegewaesser, eu_nr, gaststaette, kiosk, bade__aufs, toiletten, duschen, umkleiden, parken_mit, parken_ohne, strandkorb, campingpla, grillplatz, spielplatz, rudern, tretboot, surfen, fkk_strand, hundestrand, eintritt_kostenpflichtig, naturschutzgebiet, behindertengerecht, beschreibung, bild,einstufung FROM $tabelle WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname=$r[bild];
	  $oeffentlich=$r[oeffentlich];
	  $koord = $r[koordinaten];
	  $koord2 = trim($koord,"POINT(");
	  $koord3 = trim($koord2,")");
	  $koord4 = explode(" ",$koord3);
	  $rd83 = $r[rd83];
	  $utm = $r[utm];
	  $geo=$r[geo];
	  $utm2 = trim($utm,"POINT(");
	  $utm3 = trim($utm2,")");
	  $utm4 = explode(" ",$utm3);
	  $utm5 = explode(".",$utm4[0]);
	  $utm_lon = $utm5[0];
	  $utm6 = explode(".",$utm4[1]);
	  $utm_lat = $utm6[0];
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
		<? include ("includes/bilder_popup.php"); ?>
		<? include ("includes/block_3_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript" language="Javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyles_url; ?> type="text/css" />
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
											<? echo $font_farbe ;?><? echo $r[badegewaesser]; ?><br><br>Einstufung: <? echo $r[einstufung]; echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a></b>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="gemarkung">
												Ort:&nbsp;
												<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
													<option>Bitte auswählen</option>
													<?php
													 $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, gemarkung as b,$tabelle as c WHERE ST_WITHIN(st_transform(c.the_geom,2398),b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
													 $result = $dbqueryp($connectp,$query);

													  while($e = $fetcharrayp($result))
													   {
													   echo "<option";if ($gemarkung_id == $e[gemkgschl]) echo " selected"; echo " value=\"$e[gemkgschl]\">$e[gemarkung]
																	</option>\n";
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
											<a href="<? echo $datei;?>?gemarkung=<? echo $gemarkung_id; ?>"><? echo $font_farbe ;?>alle <? echo $titel;?><br><? echo $gemarkungname ?><? echo $font_farbe_end ;?></a>
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
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r[badegewaess]; ?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Nummer:</td>
										<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $r[eu_nr] ;?></b></td>
										<?											
											$bildname1 = explode("&",$bildname);
											$bildname2 = $bildname1[0];
											$bildname3 = explode("/",$bildname2);
											$bild="pictures/".$bildname3[5]."/".$bildname3[6];											
											if(strlen($bildname) < 1)
												{
													echo "<td valign=center align=center rowspan=5 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar</b></font></td></tr></table></td>";	
												} 
											else 
												{
													echo "<td valign=top align=right rowspan=5 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
												}
										?>
									</tr>
									<tr height="30">
										<td>Einstufung:</td>
										<td><b><? echo $r[einstufung];?></b></td>																									
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Beschreibung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[beschreibung] ;?></b></td>									
									</tr>
									<tr height="30">
										<td>Ausstattung:</td>
										<td><b><? 
												if ($r[gaststaette] == 'X' OR $r[gaststaette] == 'x')
													echo "Gaststätte<br>";
												else if (strlen($r[gaststaette]) > 1) 
													echo "Gaststätte (".$r[gaststaette].")<br>";													
												if ($r[kiosk] == 'X' OR $r[kiosk] == 'x') 
													echo "Kiosk<br>";
												else if (strlen($r[kiosk]) > 1) 
													echo "Kiosk (".$r[kiosk].")<br>";
												if ($r[bade_aufs] == 'X' OR $r[bade_aufs] == 'x') 
													echo "Badeaufsicht<br>";
												else if (strlen($r[bade_aufs]) > 1) 
													echo "Badeaufsicht (".$r[bade_aufs].")<br>";
												if ($r[toiletten] == 'X' OR $r[toiletten] == 'x') 
													echo "Toiletten<br>";
												else if (strlen($r[toiletten]) > 1) 
													echo "Toiletten (".$r[toiletten].")<br>";
												if ($r[duschen] == 'X' OR $r[duschen] == 'x') 
													echo "Duschen<br>";
												else if (strlen($r[duschen]) > 1) 
													echo "Duschen (".$r[duschen].")<br>";
												if ($r[umkleiden] == 'X' OR $r[umkleiden] == 'x') 
													echo "Umkleiden<br>";
												else if (strlen($r[umkleiden]) > 1) 
													echo "Umkleiden (".$r[umkleiden].")<br>";
												if ($r[parken_mit] == 'X' OR $r[parken_mit] == 'x') 
													echo "kostenpflichtige Parkplätze<br>";
												else if (strlen($r[parken_mit]) > 1) 
													echo "kostenpflichtige Parkplätze (".$r[parken_mit].")<br>";
												if ($r[parken_ohn] == 'X' OR $r[parken_ohn] == 'x') 
													echo "kostenfreie Parkplätze<br>";
												else if (strlen($r[parken_ohne]) > 1) 
													echo "kostenfreie Parkplätze (".$r[parken_ohne].")<br>";
												if ($r[strandkorb] == 'X' OR $r[strandkorb] == 'x') 
													echo "Strandkorbverleih<br>";
												else if (strlen($r[strandkorb]) > 1) 
													echo "Strandkorbverleih (".$r[strandkorb].")<br>";
												if ($r[campingpla] == 'X' OR $r[campingpla] == 'x') 
													echo "Campingplatz<br>";
												else if (strlen($r[campingpla]) > 1) 
													echo "Campingplatz (".$r[campingpla].")<br>";
												if ($r[grillplatz] == 'X' OR $r[grillplatz] == 'x') 
													echo "Grillplatz<br>";
												else if (strlen($r[grillplatz]) > 1) 
													echo "Grillplatz (".$r[grillplatz].")<br>";
												if ($r[spielplatz] == 'X' OR $r[spielplatz] == 'x') 
													echo "Spielplatz<br>";
												else if (strlen($r[spielplatz]) > 1) 
													echo "Spielplatz (".$r[spielplatz].")<br>";
												if ($r[rudern] == 'X' OR $r[rudern] == 'x') 
													echo "Ruderbootverleih<br>";
												else if (strlen($r[rudern]) > 1) 
													echo "Ruderbootverleih (".$r[rudern].")<br>";
												if ($r[tretboot] == 'X' OR $r[tretboot] == 'x') 
													echo "Tretbootverleih<br>";
												else if (strlen($r[tretboot]) > 1) 
													echo "Tretbootverleih (".$r[tretboot].")<br>";
												if ($r[surfen] == 'X' OR $r[surfen] == 'x') 
													echo "Windsurfen<br>";
												else if (strlen($r[surfen]) > 1) 
													echo "Windsurfen (".$r[surfen].")<br>";
												if ($r[fkk_strand] == 'X' OR $r[fkk_strand] == 'x') 
													echo "FKK-Strand<br>";
												else if (strlen($r[fkk_strand]) > 1) 
													echo "FKK-Strand (".$r[fkk_strand].")<br>";
												if ($r[hundestran] == 'X' OR $r[hundestran] == 'x') 
													echo "Hundestrand<br>";
												else if (strlen($r[hundestrand]) > 1) 
													echo "Hundestrand (".$r[hundestrand].")<br>";
												if ($r[eintritt_k] == 'X' OR $r[eintritt_k] == 'x') 
													echo "Besuch der Badestelle ist kostenpflichtig<br>";
												else if (strlen($r[eintritt_kostenpflichtig]) > 1) 
													echo "Besuch der Badestelle ist kostenpflichtig (".$r[eintritt_kostenpflichtig].")<br>";
												if ($r[naturschutzgebiet] == 'X' OR $r[naturschutzgebiet] == 'x') 
													echo "liegt im Naturschutzgebiet<br>";
												else if (strlen($r[naturschutzgebiet]) > 1) 
													echo "liegt im Naturschutzgebiet (".$r[naturschut].")<br>";
												if ($r[behindertengerecht] == 'X' OR $r[behindertengerecht] == 'x') 
													echo "Behinderten gerecht<br>";
												else if (strlen($r[behindertengerecht]) > 1) 
													echo "Behinderten gerecht (".$r[behindertengerecht].")<br>";												
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

