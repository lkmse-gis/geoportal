<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");

//globale Varibalen
$layername_mapfile="Gerichte";
$titel="Gerichte";
$titel_legende="Gericht";
$scriptname="gerichte.php";
$tabelle="geoportal_gerichte";
$schema="geoportal";
$get_themenname="gericht";
$layerid="150500";
$leg_bild="gericht.gif";
$gemeinde_id=$_GET["gemeinde"];
$themen_id=$_GET["$get_themenname"];

$log=write_log($db_link,$layerid);

if ($themen_id < 1)
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
								<? echo $titel2; ?> ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
								<select name="<? echo $get_themenname;?>" onchange="document.<? echo $get_themenname;?>.submit();">
									<option>Bitte ausw&auml;hlen</option>
									<?php
										$query="SELECT a.bezeichnung, a.gid FROM $schema.$tabelle as a ORDER BY a.bezeichnung";
										$result = $dbqueryp($connectp,$query);										
										while($r = $fetcharrayp($result))											
											{												
												echo "<option value=\"$r[gid]\"  title=\"$r[bezeichnung]\">$r[bezeichnung]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
						<? include ("includes/meta_aktualitaet.php"); ?>
						<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Amtsgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>amtsgericht.gif" width=30></td>
													<td align=right><small>Arbeitsgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>arbeitsgericht.gif" width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Landgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>landgericht.gif" width=30></td>
													<td align=right><small>Landessozialgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>landessozialgericht.gif" width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Sozialgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sozialgericht.gif" width=30></td>
													<td align=right><small>Staatsanwaltschaft: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>staatsanwaltschaft.gif" width=30></td>
												</tr>
												<tr>
													<td colspan=2></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>
												</tr>																						
											</table>
										</td>
									</tr>
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

if ($themen_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid FROM gemeinden as a, $schema.$tabelle as b WHERE ST_WITHIN(st_transform(b.wkb_geometry,2398), a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[amt];
	  $amt=$r[amt_id];
	  $gem_id=$r[gemeindeid];
	  $gemeindename=$r[gemeinde];
	  
	  $query="SELECT astext(wkb_geometry) as utm, astext(st_transform(wkb_geometry,2398)) as gk4283,astext(st_transform(wkb_geometry, 4326)) as geo,astext(st_transform(wkb_geometry, 31468)) as rd83, gid, geoportal_anschrift, bezeichnung, urheber, tel, fax, mail, homepage, art, richter, ebene, plz2, ort2, strasse2, tel2, fax2, mail2, ebene2, plz3, ort3, strasse3, tel3, fax3, mail3, ebene2, bild, oeffentlich FROM $schema.$tabelle WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname=$r[bild];
	  $oeffentlich=$r[oeffentlich];
	  $adresse=$r[geoportal_anschrift];
	  $adresse1 = explode(";",$adresse);
	  $anschrift = $adresse1[0]."<br>".$adresse1[1]."<br>".$adresse1[2];
	 
	  $s4283 = $r[gk4283];
	  $geo=$r[geo];
	  $rd83=$r[rd83];
	  $utm=$r[utm];
	  $lon = get_utmcoordinates_lon($utm);
	  $lat=get_utmcoordinates_lat($utm);
	  
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
											<? echo $font_farbe ;?><? echo $r[bezeichnung]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="6"></td>
										<td border=0 valign=top align=left rowspan="5" colspan=3>
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
											<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
												Stadt:&nbsp;
												<select name="<? echo $get_themenname;?>" onchange="document.<? echo $get_themenname;?>.submit();">
													<?php
														$query="SELECT a.bezeichnung, a.gid FROM $schema.$tabelle as a ORDER BY a.bezeichnung";
														$result = $dbqueryp($connectp,$query);
													
														while($e = $fetcharrayp($result))
															{
																echo "<option";if ($themen_id == $e[gid]) echo " selected"; echo " value=\"$e[gid]\"  title=\"$e[bezeichnung]\">$e[bezeichnung]</option>\n";															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center colspan=2>
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>alle <? echo $titel; ?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width=140 valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Amtsgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>amtsgericht.gif" width=30></td>
													<td align=right><small>Arbeitsgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>arbeitsgericht.gif" width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Landgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>landgericht.gif" width=30></td>
													<td align=right><small>Landessozialgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>landessozialgericht.gif" width=30></td>
												</tr>
												<tr>
													<td width=100 align=right><small>Sozialgericht: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>sozialgericht.gif" width=30></td>
													<td align=right><small>Staatsanwaltschaft: </td>
													<td align=right><img src="<? echo $bildpfad ; ?>staatsanwaltschaft.gif" width=30></td>
												</tr>
												<tr>
													<td colspan=2></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=30></td>
												</tr>																						
											</table>
										</td>
									</tr>
									<? include ("includes/block_3_1_uk.php"); ?>	
                                 </table>
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>											
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r[bezeichnung] ;?><? echo $font_farbe_end ;?></td>													
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Anschrift:</td>
											<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $anschrift ;?></b></td>												
											<?												
												$bildname1 = explode("&",$bildname);
												$bildname2 = $bildname1[0];
												$bildname3 = explode("/",$bildname2);
												$bild="pictures/".$bildname3[5]."/".$bildname3[6];											
												if(strlen($bildname) < 1 OR $oeffentlich == 'nein')
													{
														echo "<td valign=center align=right rowspan=7 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";	
													} 
												else 
													{
														echo "<td valign=top align=right rowspan=7 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
													}
											?>
										</tr>
										<tr>
											<td>Telefon:</td>
											<td><b>
											<? 
												if ($r[tel] == "") echo "<font color=red>keine Telefonnummer vorhanden</font>";
												else echo $r[tel];
											?></b></td>
										</tr>	
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>FAX:</td>
											<td bgcolor=<? echo $element_farbe ?>><b>
											<? 
												if ($r[fax] == "") echo "<font color=red>keine Faxnummer vorhanden</font>";
												else echo $r[fax];
											?></b>
											</td>												
										</tr>									
										<tr>
											<td>E-Mail:</td>
											<td><b>
												<? 
													if ($r[mail] == "") echo "<font color=red>keine E-Mail Adresse vorhanden</font>";
													else echo "<a href='mailto:$r[mail]'>$r[mail]</a>";
												?></b>
											</td>												
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Homepage:</td>
											<td bgcolor=<? echo $element_farbe ?>><b>
												<? 
													if ($r[homepage] == "") echo "<font color=red>keine Homepage vorhanden</font>";
													else echo "<a href='$r[homepage]' target=_blank>$r[homepage]</a>";
												?></b>
											</td>												
										</tr>
										<tr>
											<td>Leitung:</td>
											<td><b>
												<? 
													if ($r[richter] == "") echo "<font color=red>kein Name vorhanden</font>";
													else echo $r[richter];
												?></b>
											</td>												
										</tr>
										<?
											if (empty($r[ebene]) and empty($r[ebene2]))
											{
												echo "<tr><td colspan=2><font color=red>das Gericht ist die h&ouml;hste Instanz im Land</font></td></tr>";											
											}
											elseif (empty($r[ebene2]))
											{
												echo "<tr bgcolor=$element_farbe><td>nächste Instanz<br>(Land):</td><td><b>".$r[ebene]."<br>".$r[plz2]." ".$r[ort2]."<br>".$r[strasse2]."<br>Tel: ".$r[tel2]."<br>Fax: ".$r[fax2]."<br>E-Mail: <a href='mailto:$r[mail2]'>$r[mail2]</a></td></tr>
													<tr><td colspan=2><font color=red>das Gericht unter dem Punkt nächste Instanz ist die h&ouml;hste Instanz im Land</font></td></tr>";
											}
											else
												{
													echo "<tr bgcolor=$element_farbe><td>nächste Instanz:</td><td><b>".$r[ebene]."<br>".$r[plz2]." ".$r[ort2]."<br>".$r[strasse2]."<br>Tel: ".$r[tel2]."<br>Fax: ".$r[fax2]."<br>E-Mail: <a href='mailto:$r[mail2]'>$r[mail2]</a></td></tr>
														<tr><td>höhste Instanz<br>(Land):</td><td><b>".$r[ebene2]."<br>".$r[plz3]." ".$r[ort3]."<br>".$r[strasse3]."<br>Tel: ".$r[tel3]."<br>Fax: ".$r[fax3]."<br>E-Mail: <a href='mailto:$r[mail3]'>$r[mail3]</a>"  ;
														;
												}	
										?>																		
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