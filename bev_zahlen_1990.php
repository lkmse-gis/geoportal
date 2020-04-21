<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$titel="Bevoelkerungszahlen_1990";
$titel2="Bevoelkerungszahlen_1990";
$datei="bev_zahlen_1990.php";
$tabelle="population.g_bevoelkerung";
$kuerzel="bevzahlen_1990";
$layerid="85300";

$log=write_log($db_link,$layerid);

$gemeinde_id=$_GET["$kuerzel"];

if ($gemeinde_id < 1)
    { 
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle WHERE stichtag='31.12.1990'";	  
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
		<? include ("includes/block_1_css_map.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
		<script type="text/javascript" language="Javascript">
			<? include ("includes/block_1_bevoelkerung.php"); ?>
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
										<h3>Bev&ouml;lkerungszahlen*</h3>Stichtag: 31.12.1990<br><br>
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
										Gemeinde ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=40 colspan=2>
										<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
										<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
											<?php
												$query="SELECT gemeinde, gem_schl FROM $tabelle WHERE stichtag='31.12.1990' ORDER BY gemeinde";
												$result = $dbqueryp($connectp,$query);
												echo "<option>-- Bitte ausw&auml;hlen --</option>\n";
												while($r = $fetcharrayp($result))
													{
														echo "<option value=\"$r[gem_schl]\">$r[gemeinde]</option>\n";
													}
											?>
										</select>										
										</form>
									</td>									
								</tr>
                                <tr>
					             <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema <? echo $titel; ?></a>
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
													<td align=right><small>bis 200<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_1.gif" width=30></td>													
													<td align=right><small>1001 - 5000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_3.gif" width=30></td>													
												</tr>
												<tr>
													<td align=right><small>201 - 500<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_2.gif" width=30></td>																										
													<td align=right><small>5001 - 10000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_5.gif" width=30></td>													
												</tr>
												<tr>
													<td align=right><small>501 - 1000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_4.gif" width=30></td>																										
													<td align=right><small>über 10000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_6.gif" width=30></td>													
												</tr>
												<tr>
													<td></td>
													<td></td>
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
                    <? include ("includes/news.php") ?>					
					</div>
					<div id="footer">						
					</div>
				</div>
			</body>
		</html>
<?	} 


if ($gemeinde_id > 0)
   {   
	  $query="SELECT name, amts_sf FROM fd_amtsbereiche as a, $tabelle as b WHERE b.stichtag='31.12.1990' AND ST_INTERSECTS(a.the_geom,st_buffer(b.the_geom,-10)) AND b.gem_schl='$gemeinde_id' ORDER by b.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.1995' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_1995 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2009' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2009 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2010' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2010 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2011' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2011 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2012' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2012 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2013' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2013 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2014' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2014 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2015' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2015 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2016' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2016 = $fetcharrayp($result);
	  
	  $query="SELECT gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote FROM population.g_bevoelkerung WHERE stichtag='31.12.2017' AND gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r_2017 = $fetcharrayp($result);
	  
	  $query="SELECT flaeche, gem_schl, gemeinde, gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote, box(st_transform(the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(the_geom),25833)) as etrscenter,box(the_geom) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_centroid(st_transform(the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, st_astext(st_centroid(st_transform(the_geom, 4326))) as geo, st_astext(st_transform(the_geom, 2398)) as koordinaten, st_perimeter(the_geom) as umfang  FROM $tabelle WHERE stichtag='31.12.1990' AND gem_schl='$gemeinde_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname = $r[ziel];
	  $gemeindename = $r[gemeinde];
	  $area=$r[area];	  
	  $zentrum = $r[etrscenter];
	  $zentrum2 = trim($zentrum,"POINT(");
	  $zentrum3 = trim($zentrum2,")");
	  $zentrum4 = explode(" ",$zentrum3);
	  $rd83 = $r[rd83];
	  $s4283 = $r[center];
	  $utm = $r[utm];
	  $geo = $r[geo];
	  $umfang = $r[umfang];
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];
	  $rcenter = $zentrum4[0];
	  $rcenter1 = explode(".",$rcenter);
	  $rcenter2 = $rcenter1[0];
	  $hcenter = $zentrum4[1];
	  $hcenter1 = explode(".",$hcenter);
	  $hcenter2 = $hcenter1[0];
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
			<? include ("includes/block_2_bevoelkerung.php"); ?>
		</script>
		<script language="javascript">
			function klappe (Id){
			  if (document.getElementById) {
				var mydiv = document.getElementById(Id);
				mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
			  }
			}
		</script>
		<style type="text/css">
			td.rand {border: solid #000000 2px;}
			td.rahmen {border: solid #000000 1px;}
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
											<? echo $font_farbe ;?><? echo $r[gemeinde]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <? echo "<a href=\"aemter_msp.php?amt=",$amt,"\">",$amtname,"</a> ";?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">Gemeinde ausw&auml;hlen:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT gemeinde, gem_schl FROM $tabelle WHERE stichtag='31.12.1990' ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);														
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($gemeinde_id == $e[gem_schl]) echo " selected"; echo " value=\"$e[gem_schl]\" title=\"$e[gemeinde]\">$e[gemeinde]</option>\n";
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Gemeinden<? echo $font_farbe_end ;?></a>
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
													<td align=right><small>bis 200<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_1.gif" width=30></td>													
													<td align=right><small>1001 - 5000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_3.gif" width=30></td>													
												</tr>
												<tr>
													<td align=right><small>201 - 500<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_2.gif" width=30></td>																										
													<td align=right><small>5001 - 10000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_5.gif" width=30></td>													
												</tr>
												<tr>
													<td align=right><small>501 - 1000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_4.gif" width=30></td>																										
													<td align=right><small>über 10000<br>Einw.: </td>
													<td align=right><img src="images/bevzahlen_6.gif" width=30></td>													
												</tr>
												<tr>
													<td></td>
													<td></td>
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
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?<? echo $kuerzel;?>=<? echo $gemeinde_id; ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						    <tr>
							<td valign=top>											
								<table border=0 cellspacing=0 valign=top>
									<tr height="35">
										<td colspan=3  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><a name="anker"><? echo $r[gemeinde]." - 31.12.1990" ;?></a><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Fl&auml;che in km&sup2;:</td>
										<td colspan=2 bgcolor=<? echo $element_farbe ?>><b><? echo $r[flaeche]." km²" ;?></b></td>													
									</tr>
									<tr height="30">
										<td>Einwohner gesamt:</td>
										<td width=40%><b><? echo $r[gesamt]." </td><td><b><a href=\"#anker\" onclick=\"klappe('eintrag_1')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_1" style="display: none">
										<? if (($r[gesamt]-$r_1995[gesamt]) < 0)
											echo "1995 - ".$r_1995[gesamt]." (&dArr; ",$r[gesamt]-$r_1995[gesamt],")<br>";
											else if (($r[gesamt]-$r_1995[gesamt]) == 0)
												echo "1995 - ".$r_1995[gesamt]." (&hArr; ",$r[gesamt]-$r_1995[gesamt],")<br>";
											else if (($r[gesamt]-$r_1995[gesamt]) > 0)
												echo "1995 - ".$r_1995[gesamt]." (&uArr; ",$r[gesamt]-$r_1995[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2009[gesamt]) < 0)
											echo "2009 - ".$r_2009[gesamt]." (&dArr; ",$r[gesamt]-$r_2009[gesamt],")<br>";
											else if (($r[gesamt]-$r_2009[gesamt]) == 0)
												echo "2009 - ".$r_2009[gesamt]." (&hArr; ",$r[gesamt]-$r_2009[gesamt],")<br>";
											else if (($r[gesamt]-$r_2009[gesamt]) > 0)
												echo "2009 - ".$r_2009[gesamt]." (&uArr; ",$r[gesamt]-$r_2009[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2010[gesamt]) < 0)
											echo "2010 - ".$r_2010[gesamt]." (&dArr; ",$r[gesamt]-$r_2010[gesamt],")<br>";
											else if (($r[gesamt]-$r_2010[gesamt]) == 0)
												echo "2010 - ".$r_2010[gesamt]." (&hArr; ",$r[gesamt]-$r_2010[gesamt],")<br>";
											else if (($r[gesamt]-$r_2010[gesamt]) > 0)
												echo "2010 - ".$r_2010[gesamt]." (&uArr; ",$r[gesamt]-$r_2010[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2011[gesamt]) < 0)
											echo "2011 - ".$r_2011[gesamt]." (&dArr; ",$r[gesamt]-$r_2011[gesamt],")<br>";
											else if (($r[gesamt]-$r_2011[gesamt]) == 0)
												echo "2011 - ".$r_2011[gesamt]." (&hArr; ",$r[gesamt]-$r_2011[gesamt],")<br>";
											else if (($r[gesamt]-$r_2011[gesamt]) > 0)
												echo "2011 - ".$r_2011[gesamt]." (&uArr; ",$r[gesamt]-$r_2011[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2012[gesamt]) < 0)
											echo "2012 - ".$r_2012[gesamt]." (&dArr; ",$r[gesamt]-$r_2012[gesamt],")<br>";
											else if (($r[gesamt]-$r_2012[gesamt]) == 0)
												echo "2012 - ".$r_2012[gesamt]." (&hArr; ",$r[gesamt]-$r_2012[gesamt],")<br>";
											else if (($r[gesamt]-$r_2012[gesamt]) > 0)
												echo "2012 - ".$r_2012[gesamt]." (&uArr; ",$r[gesamt]-$r_2012[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2013[gesamt]) < 0)
											echo "2013 - ".$r_2013[gesamt]." (&dArr; ",$r[gesamt]-$r_2013[gesamt],")<br>";
											else if (($r[gesamt]-$r_2013[gesamt]) == 0)
												echo "2013 - ".$r_2013[gesamt]." (&hArr; ",$r[gesamt]-$r_2013[gesamt],")<br>";
											else if (($r[gesamt]-$r_2013[gesamt]) > 0)
												echo "2013 - ".$r_2013[gesamt]." (&uArr; ",$r[gesamt]-$r_2013[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2014[gesamt]) < 0)
											echo "2014 - ".$r_2014[gesamt]." (&dArr; ",$r[gesamt]-$r_2014[gesamt],")<br>";
											else if (($r[gesamt]-$r_2014[gesamt]) == 0)
												echo "2014 - ".$r_2014[gesamt]." (&hArr; ",$r[gesamt]-$r_2014[gesamt],")<br>";
											else if (($r[gesamt]-$r_2014[gesamt]) > 0)
												echo "2014 - ".$r_2014[gesamt]." (&uArr; ",$r[gesamt]-$r_2014[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2015[gesamt]) < 0)
											echo "2015 - ".$r_2015[gesamt]." (&dArr; ",$r[gesamt]-$r_2015[gesamt],")<br>";
											else if (($r[gesamt]-$r_2015[gesamt]) == 0)
												echo "2015 - ".$r_2015[gesamt]." (&hArr; ",$r[gesamt]-$r_2015[gesamt],")<br>";
											else if (($r[gesamt]-$r_2015[gesamt]) > 0)
												echo "2015 - ".$r_2015[gesamt]." (&uArr; ",$r[gesamt]-$r_2015[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2016[gesamt]) < 0)
											echo "2016 - ".$r_2016[gesamt]." (&dArr; ",$r[gesamt]-$r_2016[gesamt],")<br>";
											else if (($r[gesamt]-$r_2016[gesamt]) == 0)
												echo "2016 - ".$r_2016[gesamt]." (&hArr; ",$r[gesamt]-$r_2016[gesamt],")<br>";
											else if (($r[gesamt]-$r_2016[gesamt]) > 0)
												echo "2016 - ".$r_2016[gesamt]." (&uArr; ",$r[gesamt]-$r_2016[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2017[gesamt]) < 0)
											echo "2017 - ".$r_2017[gesamt]." (&dArr; ",$r[gesamt]-$r_2017[gesamt],")<br>";
											else if (($r[gesamt]-$r_2017[gesamt]) == 0)
												echo "2017 - ".$r_2017[gesamt]." (&hArr; ",$r[gesamt]-$r_2017[gesamt],")<br>";
											else if (($r[gesamt]-$r_2017[gesamt]) > 0)
												echo "2017 - ".$r_2017[gesamt]." (&uArr; ",$r[gesamt]-$r_2017[gesamt],")<br>";
										?>
										</b></td></div>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Einwohner/km&sup2;:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[km2]." Einw/km&sup2; </td><td bgcolor=$element_farbe><b><a href=\"#anker\" onclick=\"klappe('eintrag_2')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>																		
										<div id="eintrag_2" style="display: none">
										<? if (($r[km2]-$r_1995[km2]) < 0)
											echo "1995 - ".$r_1995[km2]." (&dArr; ",$r[km2]-$r_1995[km2],")<br>";
											else if (($r[km2]-$r_1995[km2]) == 0)
												echo "1995 - ".$r_1995[km2]." (&hArr; ",$r[km2]-$r_1995[km2],")<br>";
											else if (($r[km2]-$r_1995[km2]) > 0)
												echo "1995 - ".$r_1995[km2]." (&uArr;",$r[km2]-$r_1995[km2],")<br>";
										?>
										<? if (($r[km2]-$r_2009[km2]) < 0)
											echo "2009 - ".$r_2009[km2]." (&dArr; ",$r[km2]-$r_2009[km2],")<br>";
											else if (($r[km2]-$r_2009[km2]) == 0)
												echo "2009 - ".$r_2009[km2]." (&hArr; ",$r[km2]-$r_2009[km2],")<br>";
											else if (($r[km2]-$r_2009[km2]) > 0)
												echo "2009 - ".$r_2009[km2]." (&uArr; ",$r[km2]-$r_2009[km2],")<br>";
										?>
										<? if (($r[km2]-$r_2010[km2]) < 0)
											echo "2010 - ".$r_2010[km2]." (&dArr; ",$r[km2]-$r_2010[km2],")<br>";
											else if (($r[km2]-$r_2010[km2]) == 0)
												echo "2010 - ".$r_2010[km2]." (&hArr; ",$r[km2]-$r_2010[km2],")<br>";
											else if (($r[km2]-$r_2010[km2]) > 0)
												echo "2010 - ".$r_2010[km2]." (&uArr;",$r[km2]-$r_2010[km2],")<br>";
										?>
										<? if (($r[km2]-$r_2011[km2]) < 0)
											echo "2011 - ".$r_2011[km2]." (&dArr; ",$r[km2]-$r_2011[km2],")<br>";
											else if (($r[km2]-$r_2011[km2]) == 0)
												echo "2011 - ".$r_2011[km2]." (&hArr; ",$r[km2]-$r_2011[km2],")<br>";
											else if (($r[km2]-$r_2011[km2]) > 0)
												echo "2011 - ".$r_2011[km2]." (&uArr; ",$r[km2]-$r_2011[km2],")<br>";
										?>
										<? if (($r[km2]-$r_2012[km2]) < 0)
											echo "2012 - ".$r_2012[km2]." (&dArr; ",$r[km2]-$r_2012[km2],")<br>";
											else if (($r[km2]-$r_2012[km2]) == 0)
												echo "2012 - ".$r_2012[km2]." (&hArr; ",$r[km2]-$r_2012[km2],")<br>";
											else if (($r[km2]-$r_2012[km2]) > 0)
												echo "2012 - ".$r_2012[km2]." (&uArr; ",$r[km2]-$r_2012[km2],")<br>";
										?>
										<? if (($r[gesamt]-$r_2013[gesamt]) < 0)
											echo "2013 - ".$r_2013[gesamt]." (&dArr; ",$r[gesamt]-$r_2013[gesamt],")<br>";
											else if (($r[gesamt]-$r_2013[gesamt]) == 0)
												echo "2013 - ".$r_2013[gesamt]." (&hArr; ",$r[gesamt]-$r_2013[gesamt],")<br>";
											else if (($r[gesamt]-$r_2013[gesamt]) > 0)
												echo "2013 - ".$r_2013[gesamt]." (&uArr; ",$r[gesamt]-$r_2013[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2014[gesamt]) < 0)
											echo "2014 - ".$r_2014[gesamt]." (&dArr; ",$r[gesamt]-$r_2014[gesamt],")<br>";
											else if (($r[gesamt]-$r_2014[gesamt]) == 0)
												echo "2014 - ".$r_2014[gesamt]." (&hArr; ",$r[gesamt]-$r_2014[gesamt],")<br>";
											else if (($r[gesamt]-$r_2014[gesamt]) > 0)
												echo "2014 - ".$r_2014[gesamt]." (&uArr; ",$r[gesamt]-$r_2014[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2015[gesamt]) < 0)
											echo "2015 - ".$r_2015[gesamt]." (&dArr; ",$r[gesamt]-$r_2015[gesamt],")<br>";
											else if (($r[gesamt]-$r_2015[gesamt]) == 0)
												echo "2015 - ".$r_2015[gesamt]." (&hArr; ",$r[gesamt]-$r_2015[gesamt],")<br>";
											else if (($r[gesamt]-$r_2015[gesamt]) > 0)
												echo "2015 - ".$r_2015[gesamt]." (&uArr; ",$r[gesamt]-$r_2015[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2016[gesamt]) < 0)
											echo "2016 - ".$r_2016[gesamt]." (&dArr; ",$r[gesamt]-$r_2016[gesamt],")<br>";
											else if (($r[gesamt]-$r_2016[gesamt]) == 0)
												echo "2016 - ".$r_2016[gesamt]." (&hArr; ",$r[gesamt]-$r_2016[gesamt],")<br>";
											else if (($r[gesamt]-$r_2016[gesamt]) > 0)
												echo "2016 - ".$r_2016[gesamt]." (&uArr; ",$r[gesamt]-$r_2016[gesamt],")<br>";
										?>
										<? if (($r[gesamt]-$r_2017[gesamt]) < 0)
											echo "2017 - ".$r_2017[gesamt]." (&dArr; ",$r[gesamt]-$r_2017[gesamt],")<br>";
											else if (($r[gesamt]-$r_2017[gesamt]) == 0)
												echo "2017 - ".$r_2017[gesamt]." (&hArr; ",$r[gesamt]-$r_2017[gesamt],")<br>";
											else if (($r[gesamt]-$r_2017[gesamt]) > 0)
												echo "2017 - ".$r_2017[gesamt]." (&uArr; ",$r[gesamt]-$r_2017[gesamt],")<br>";
										?>
										</b></td></div>
									</tr>
									<tr height="30">
										<td>M&auml;nner:</td>
										<td><b><? echo $r[mann]." </td><td><b><a href=\"#anker\" onclick=\"klappe('eintrag_3')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_3" style="display: none">
										<? if (($r[mann]-$r_1995[mann]) < 0)
											echo "1995 - ".$r_1995[mann]." (&dArr; ",$r[mann]-$r_1995[mann],")<br>";
											else if (($r[mann]-$r_1995[mann]) == 0)
												echo "1995 - ".$r_1995[mann]." (&hArr; ",$r[mann]-$r_1995[mann],")<br>";
											else if (($r[mann]-$r_1995[mann]) > 0)
												echo "1995 - ".$r_1995[mann]." (&uArr;",$r[mann]-$r_1995[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2009[mann]) < 0)
											echo "2009 - ".$r_2009[mann]." (&dArr; ",$r[mann]-$r_2009[mann],")<br>";
											else if (($r[mann]-$r_2009[mann]) == 0)
												echo "2009 - ".$r_2009[mann]." (&hArr; ",$r[mann]-$r_2009[mann],")<br>";
											else if (($r[mann]-$r_2009[mann]) > 0)
												echo "2009 - ".$r_2009[mann]." (&uArr; ",$r[mann]-$r_2009[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2010[mann]) < 0)
											echo "2010 - ".$r_2010[mann]." (&dArr; ",$r[mann]-$r_2010[mann],")<br>";
											else if (($r[mann]-$r_2010[mann]) == 0)
												echo "2010 - ".$r_2010[mann]." (&hArr; ",$r[mann]-$r_2010[mann],")<br>";
											else if (($r[mann]-$r_2010[mann]) > 0)
												echo "2010 - ".$r_2010[mann]." (&uArr;",$r[mann]-$r_2010[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2011[mann]) < 0)
											echo "2011 - ".$r_2011[mann]." (&dArr; ",$r[mann]-$r_2011[mann],")<br>";
											else if (($r[mann]-$r_2011[mann]) == 0)
												echo "2011 - ".$r_2011[mann]." (&hArr; ",$r[mann]-$r_2011[mann],")<br>";
											else if (($r[mann]-$r_2011[mann]) > 0)
												echo "2011 - ".$r_2011[mann]." (&uArr; ",$r[mann]-$r_2011[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2012[mann]) < 0)
											echo "2012 - ".$r_2012[mann]." (&dArr; ",$r[mann]-$r_2012[mann],")<br>";
											else if (($r[mann]-$r_2012[mann]) == 0)
												echo "2012 - ".$r_2012[mann]." (&hArr; ",$r[mann]-$r_2012[mann],")<br>";
											else if (($r[mann]-$r_2012[mann]) > 0)
												echo "2012 - ".$r_2012[mann]." (&uArr; ",$r[mann]-$r_2012[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2013[mann]) < 0)
											echo "2013 - ".$r_2013[mann]." (&dArr; ",$r[mann]-$r_2013[mann],")<br>";
											else if (($r[mann]-$r_2013[mann]) == 0)
												echo "2013 - ".$r_2013[mann]." (&hArr; ",$r[mann]-$r_2013[mann],")<br>";
											else if (($r[mann]-$r_2013[mann]) > 0)
												echo "2013 - ".$r_2013[mann]." (&uArr; ",$r[mann]-$r_2013[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2014[mann]) < 0)
											echo "2014 - ".$r_2014[mann]." (&dArr; ",$r[mann]-$r_2014[mann],")<br>";
											else if (($r[mann]-$r_2014[mann]) == 0)
												echo "2014 - ".$r_2014[mann]." (&hArr; ",$r[mann]-$r_2014[mann],")<br>";
											else if (($r[mann]-$r_2014[mann]) > 0)
												echo "2014 - ".$r_2014[mann]." (&uArr; ",$r[mann]-$r_2014[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2015[mann]) < 0)
											echo "2015 - ".$r_2015[mann]." (&dArr; ",$r[mann]-$r_2015[mann],")<br>";
											else if (($r[mann]-$r_2015[mann]) == 0)
												echo "2015 - ".$r_2015[mann]." (&hArr; ",$r[mann]-$r_2015[mann],")<br>";
											else if (($r[mann]-$r_2015[mann]) > 0)
												echo "2015 - ".$r_2015[mann]." (&uArr; ",$r[mann]-$r_2015[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2016[mann]) < 0)
											echo "2016 - ".$r_2016[mann]." (&dArr; ",$r[mann]-$r_2016[mann],")<br>";
											else if (($r[mann]-$r_2016[mann]) == 0)
												echo "2016 - ".$r_2016[mann]." (&hArr; ",$r[mann]-$r_2016[mann],")<br>";
											else if (($r[mann]-$r_2016[mann]) > 0)
												echo "2016 - ".$r_2016[mann]." (&uArr; ",$r[mann]-$r_2016[mann],")<br>";
										?>
										<? if (($r[mann]-$r_2017[mann]) < 0)
											echo "2017 - ".$r_2017[mann]." (&dArr; ",$r[mann]-$r_2017[mann],")<br>";
											else if (($r[mann]-$r_2017[mann]) == 0)
												echo "2017 - ".$r_2017[mann]." (&hArr; ",$r[mann]-$r_2017[mann],")<br>";
											else if (($r[mann]-$r_2017[mann]) > 0)
												echo "2017 - ".$r_2017[mann]." (&uArr; ",$r[mann]-$r_2017[mann],")<br>";
										?>
										</b></td></div>														
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">M&auml;nneranteil in Prozent:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[mann_quote]."% </td><td bgcolor=$element_farbe><b><a href=\"#anker\" onclick=\"klappe('eintrag_4')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_4" style="display: none">
										<? if (($r[mann_quote]-$r_1995[mann_quote]) < 0)
											echo "1995 - ".$r_1995[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_1995[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_1995[mann_quote]) == 0)
												echo "1995 - ".$r_1995[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_1995[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_1995[mann_quote]) > 0)
												echo "1995 - ".$r_1995[mann_quote]."% (&uArr;",$r[mann_quote]-$r_1995[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2009[mann_quote]) < 0)
											echo "2009 - ".$r_2009[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2009[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2009[mann_quote]) == 0)
												echo "2009 - ".$r_2009[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2009[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2009[mann_quote]) > 0)
												echo "2009 - ".$r_2009[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2009[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2010[mann_quote]) < 0)
											echo "2010 - ".$r_2010[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2010[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2010[mann_quote]) == 0)
												echo "2010 - ".$r_2010[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2010[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2010[mann_quote]) > 0)
												echo "2010 - ".$r_2010[mann_quote]."% (&uArr;",$r[mann_quote]-$r_2010[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2011[mann_quote]) < 0)
											echo "2011 - ".$r_2011[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2011[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2011[mann_quote]) == 0)
												echo "2011 - ".$r_2011[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2011[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2011[mann_quote]) > 0)
												echo "2011 - ".$r_2011[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2011[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2012[mann_quote]) < 0)
											echo "2012 - ".$r_2012[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2012[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2012[mann_quote]) == 0)
												echo "2012 - ".$r_2012[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2012[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2012[mann_quote]) > 0)
												echo "2012 - ".$r_2012[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2012[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2013[mann_quote]) < 0)
											echo "2013 - ".$r_2013[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2013[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2013[mann_quote]) == 0)
												echo "2013 - ".$r_2013[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2013[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2013[mann_quote]) > 0)
												echo "2013 - ".$r_2013[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2013[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2014[mann_quote]) < 0)
											echo "2014 - ".$r_2014[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2014[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2014[mann_quote]) == 0)
												echo "2014 - ".$r_2014[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2014[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2014[mann_quote]) > 0)
												echo "2014 - ".$r_2014[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2014[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2015[mann_quote]) < 0)
											echo "2015 - ".$r_2015[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2015[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2015[mann_quote]) == 0)
												echo "2015 - ".$r_2015[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2015[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2015[mann_quote]) > 0)
												echo "2015 - ".$r_2015[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2015[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2016[mann_quote]) < 0)
											echo "2016 - ".$r_2016[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2016[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2016[mann_quote]) == 0)
												echo "2016 - ".$r_2016[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2016[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2016[mann_quote]) > 0)
												echo "2016 - ".$r_2016[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2016[mann_quote],"%)<br>";
										?>
										<? if (($r[mann_quote]-$r_2017[mann_quote]) < 0)
											echo "2017 - ".$r_2017[mann_quote]."% (&dArr; ",$r[mann_quote]-$r_2017[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2017[mann_quote]) == 0)
												echo "2017 - ".$r_2017[mann_quote]."% (&hArr; ",$r[mann_quote]-$r_2017[mann_quote],"%)<br>";
											else if (($r[mann_quote]-$r_2017[mann_quote]) > 0)
												echo "2017 - ".$r_2017[mann_quote]."% (&uArr; ",$r[mann_quote]-$r_2017[mann_quote],"%)<br>";
										?>
										</b></td></div>													
									</tr>
									<tr height="30">
										<td>Frauen:</td>
										<td><b><? echo $r[frau]." </td><td><b><a href=\"#anker\" onclick=\"klappe('eintrag_5')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_5" style="display: none">
										<? if (($r[frau]-$r_1995[frau]) < 0)
											echo "1995 - ".$r_1995[frau]." (&dArr; ",$r[frau]-$r_1995[frau],")<br>";
											else if (($r[frau]-$r_1995[frau]) == 0)
												echo "1995 - ".$r_1995[frau]." (&hArr; ",$r[frau]-$r_1995[frau],")<br>";
											else if (($r[frau]-$r_1995[frau]) > 0)
												echo "1995 - ".$r_1995[frau]." (&uArr; ",$r[frau]-$r_1995[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2009[frau]) < 0)
											echo "2009 - ".$r_2009[frau]." (&dArr; ",$r[frau]-$r_2009[frau],")<br>";
											else if (($r[frau]-$r_2009[frau]) == 0)
												echo "2009 - ".$r_2009[frau]." (&hArr; ",$r[frau]-$r_2009[frau],")<br>";
											else if (($r[frau]-$r_2009[frau]) > 0)
												echo "2009 - ".$r_2009[frau]." (&uArr; ",$r[frau]-$r_2009[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2010[frau]) < 0)
											echo "2010 - ".$r_2010[frau]." (&dArr; ",$r[frau]-$r_2010[frau],")<br>";
											else if (($r[frau]-$r_2010[frau]) == 0)
												echo "2010 - ".$r_2010[frau]." (&hArr; ",$r[frau]-$r_2010[frau],")<br>";
											else if (($r[frau]-$r_2010[frau]) > 0)
												echo "2010 - ".$r_2010[frau]." (&uArr; ",$r[frau]-$r_2010[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2011[frau]) < 0)
											echo "2011 - ".$r_2011[frau]." (&dArr; ",$r[frau]-$r_2011[frau],")<br>";
											else if (($r[frau]-$r_2011[frau]) == 0)
												echo "2011 - ".$r_2011[frau]." (&hArr; ",$r[frau]-$r_2011[frau],")<br>";
											else if (($r[frau]-$r_2011[frau]) > 0)
												echo "2011 - ".$r_2011[frau]." (&uArr; ",$r[frau]-$r_2011[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2012[frau]) < 0)
											echo "2012 - ".$r_2012[frau]." (&dArr; ",$r[frau]-$r_2012[frau],")<br>";
											else if (($r[frau]-$r_2012[frau]) == 0)
												echo "2012 - ".$r_2012[frau]." (&hArr; ",$r[frau]-$r_2012[frau],")<br>";
											else if (($r[frau]-$r_2012[frau]) > 0)
												echo "2012 - ".$r_2012[frau]." (&uArr; ",$r[frau]-$r_2012[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2013[frau]) < 0)
											echo "2013 - ".$r_2013[frau]." (&dArr; ",$r[frau]-$r_2013[frau],")<br>";
											else if (($r[frau]-$r_2013[frau]) == 0)
												echo "2013 - ".$r_2013[frau]." (&hArr; ",$r[frau]-$r_2013[frau],")<br>";
											else if (($r[frau]-$r_2013[frau]) > 0)
												echo "2013 - ".$r_2013[frau]." (&uArr; ",$r[frau]-$r_2013[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2014[frau]) < 0)
											echo "2014 - ".$r_2014[frau]." (&dArr; ",$r[frau]-$r_2014[frau],")<br>";
											else if (($r[frau]-$r_2014[frau]) == 0)
												echo "2014 - ".$r_2014[frau]." (&hArr; ",$r[frau]-$r_2014[frau],")<br>";
											else if (($r[frau]-$r_2014[frau]) > 0)
												echo "2014 - ".$r_2014[frau]." (&uArr; ",$r[frau]-$r_2014[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2015[frau]) < 0)
											echo "2015 - ".$r_2015[frau]." (&dArr; ",$r[frau]-$r_2015[frau],")<br>";
											else if (($r[frau]-$r_2015[frau]) == 0)
												echo "2015 - ".$r_2015[frau]." (&hArr; ",$r[frau]-$r_2015[frau],")<br>";
											else if (($r[frau]-$r_2015[frau]) > 0)
												echo "2015 - ".$r_2015[frau]." (&uArr; ",$r[frau]-$r_2015[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2016[frau]) < 0)
											echo "2016 - ".$r_2016[frau]." (&dArr; ",$r[frau]-$r_2016[frau],")<br>";
											else if (($r[frau]-$r_2016[frau]) == 0)
												echo "2016 - ".$r_2016[frau]." (&hArr; ",$r[frau]-$r_2016[frau],")<br>";
											else if (($r[frau]-$r_2016[frau]) > 0)
												echo "2016 - ".$r_2016[frau]." (&uArr; ",$r[frau]-$r_2016[frau],")<br>";
										?>
										<? if (($r[frau]-$r_2017[frau]) < 0)
											echo "2017 - ".$r_2017[frau]." (&dArr; ",$r[frau]-$r_2017[frau],")<br>";
											else if (($r[frau]-$r_2017[frau]) == 0)
												echo "2017 - ".$r_2017[frau]." (&hArr; ",$r[frau]-$r_2017[frau],")<br>";
											else if (($r[frau]-$r_2017[frau]) > 0)
												echo "2017 - ".$r_2017[frau]." (&uArr; ",$r[frau]-$r_2017[frau],")<br>";
										?>
										</b></td></div>												
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Frauenanteil in Prozent:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[frau_quote]."% </td><td bgcolor=$element_farbe><b><a href=\"#anker\" onclick=\"klappe('eintrag_6')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_6" style="display: none">
										<? if (($r[frau_quote]-$r_1995[frau_quote]) < 0)
											echo "1995 - ".$r_1995[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_1995[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_1995[frau_quote]) == 0)
												echo "1995 - ".$r_1995[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_1995[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_1995[frau_quote]) > 0)
												echo "1995 - ".$r_1995[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_1995[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2009[frau_quote]) < 0)
											echo "2009 - ".$r_2009[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2009[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2009[frau_quote]) == 0)
												echo "2009 - ".$r_2009[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2009[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2009[frau_quote]) > 0)
												echo "2009 - ".$r_2009[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2009[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2010[frau_quote]) < 0)
											echo "2010 - ".$r_2010[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2010[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2010[frau_quote]) == 0)
												echo "2010 - ".$r_2010[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2010[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2010[frau_quote]) > 0)
												echo "2010 - ".$r_2010[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2010[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2011[frau_quote]) < 0)
											echo "2011 - ".$r_2011[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2011[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2011[frau_quote]) == 0)
												echo "2011 - ".$r_2011[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2011[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2011[frau_quote]) > 0)
												echo "2011 - ".$r_2011[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2011[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2012[frau_quote]) < 0)
											echo "2012 - ".$r_2012[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2012[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2012[frau_quote]) == 0)
												echo "2012 - ".$r_2012[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2012[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2012[frau_quote]) > 0)
												echo "2012 - ".$r_2012[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2012[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2013[frau_quote]) < 0)
											echo "2013 - ".$r_2013[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2013[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2013[frau_quote]) == 0)
												echo "2013 - ".$r_2013[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2013[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2013[frau_quote]) > 0)
												echo "2013 - ".$r_2013[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2013[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2014[frau_quote]) < 0)
											echo "2014 - ".$r_2014[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2014[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2014[frau_quote]) == 0)
												echo "2014 - ".$r_2014[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2014[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2014[frau_quote]) > 0)
												echo "2014 - ".$r_2014[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2014[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2015[frau_quote]) < 0)
											echo "2015 - ".$r_2015[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2015[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2015[frau_quote]) == 0)
												echo "2015 - ".$r_2015[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2015[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2015[frau_quote]) > 0)
												echo "2015 - ".$r_2015[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2015[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2016[frau_quote]) < 0)
											echo "2016 - ".$r_2016[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2016[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2016[frau_quote]) == 0)
												echo "2016 - ".$r_2016[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2016[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2016[frau_quote]) > 0)
												echo "2016 - ".$r_2016[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2016[frau_quote],"%)<br>";
										?>
										<? if (($r[frau_quote]-$r_2017[frau_quote]) < 0)
											echo "2017 - ".$r_2017[frau_quote]."% (&dArr; ",$r[frau_quote]-$r_2017[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2017[frau_quote]) == 0)
												echo "2017 - ".$r_2017[frau_quote]."% (&hArr; ",$r[frau_quote]-$r_2017[frau_quote],"%)<br>";
											else if (($r[frau_quote]-$r_2017[frau_quote]) > 0)
												echo "2017 - ".$r_2017[frau_quote]."% (&uArr; ",$r[frau_quote]-$r_2017[frau_quote],"%)<br>";
										?>
										</b></td></div>
									</tr>
									<tr height="30">
										<td>weitere/andere zahlenjahre:</td>
										<td colspan=2>
											<b><? echo "<a href=\"bev_zahlen_2017.php?bevzahlen_2017=",$r[gem_schl],"\">2017</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2016.php?bevzahlen_2016=",$r[gem_schl],"\">2016</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2015.php?bevzahlen_2015=",$r[gem_schl],"\">2015</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2014.php?bevzahlen_2014=",$r[gem_schl],"\">2014</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2013.php?bevzahlen_2013=",$r[gem_schl],"\">2013</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2012.php?bevzahlen_2012=",$r[gem_schl],"\">2012</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2011.php?bevzahlen_2011=",$r[gem_schl],"\">2011</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2010.php?bevzahlen_2010=",$r[gem_schl],"\">2010</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_2009.php?bevzahlen_2009=",$r[gem_schl],"\">2009</a>, ";?></b>
											<b><? echo "<a href=\"bev_zahlen_1995.php?bevzahlen_1995=",$r[gem_schl],"\">1995</a>";?></b>
										</td>								
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">zur Gemeinde (Kataster):</td>
										<td colspan=2 bgcolor=<? echo $element_farbe ?>><b><? echo "<a href=\"gemeinden_msp.php?gemeinde=",$r[gem_schl],"\">",$r[gemeinde],"</a> ";?></b></td>													
									</tr>
								</table>
							</td>
							<td valign=top align=center width="350">
								<? include("includes/geo_flaeche.php"); ?>	
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

