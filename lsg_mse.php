<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legenden.class.php");


//globale Varibalen
$titel="Landschaftsschutzgebiete";
$layer_name="lsg_2016";
$beschriftung_karte="LSG";
$tabelle="sg_lsg_2016";
$schema="environment";
$kuerzel="lsg";
$layerid="32025";

$lsg_id=$_GET["$kuerzel"];

$log=write_i_log($db_link,$layerid);

if ($lsg_id < 1)
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
		<?
             $lsg_karte= new karte;
             echo $lsg_karte->zeigeKarteBox($box_mse_gesamt,'690','490','orka','1','0','0','0','0',$beschriftung_karte,$layer_name);			 
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
									    <?php
										  echo get_i_mp_link($db_link,$layerid);
										?>
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
									<td align="center"  height=50 colspan=2>
										<? echo $beschriftung_karte ?> ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=40 colspan=2>
										<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
										<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
											<?php
												$query="SELECT name, gid FROM $schema.$tabelle ORDER BY name";
												$result = $dbqueryp($connectp,$query);
												echo "<option>Bitte ausw&auml;hlen</option>\n";
												while($r = $fetcharrayp($result))
													{
														echo "<option value=\"$r[gid]\" title=\"$r[name]\">$r[name]</option>\n";
													}
											?>
										</select>										
										</form>
									</td>									
								</tr>
                                <tr>
					             <td valign=bottom align=center colspan=2>
					    *) <a href="<? echo $metadatenpfad.$layerid;?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema<br><? echo $titel; ?></a>
						         </td>
					            </tr>
					            <tr><td align=center colspan=2>letzte Aktualisierung: <b><i><? echo get_i_aktualitaet($db_link,$layerid); ?></td>
								</tr>
								<tr>
									<td valign=bottom align=center>
										<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die webbasierte Karte?<br>(OpenLayers)</a>																
									</td>
								</tr>
                                <?php
											  $lsglegende=new legende;
											  echo $lsglegende->lsg();
								?>							
								<tr>
										<td colspan=2 height=35></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>   
											<a href="<? echo $metadatenpfad.$layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
										</td>
									</tr>
							</table>
						</div>
					</div>
					<?php 
			        echo div_navigation(); 
			        echo div_extra(); 
			        echo div_footer(); 
			        ?>
				</div>
			</body>
		</html>
<?	} 


if ($lsg_id > 0)
   {   
	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(st_transform(b.geom,2398),a.the_geom) AND b.gid='$lsg_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, $schema.$tabelle as b WHERE ST_INTERSECTS(st_transform(b.geom,2398),a.the_geom) AND b.gid='$lsg_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count=$k;
		}
	  
	  $query="SELECT box(geom) as box, geom,gid, name, area_ha, ausweis_mv, gis_code FROM $schema.$tabelle WHERE gid='$lsg_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);	 
	  
	  $boxstring = $r[box];
	  $geometrie = $r[geom];
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
		<?
             $lsg_karte= new karte;
             echo $lsg_karte->zeigeKarteBox($boxstring,'700','320','orka','1','0','0','0','0',$beschriftung_karte,$layer_name);			 
        ?> 
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
											<b>GIS-Code: <? echo $r[gis_code]; ?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2"><? echo $titel2;?>:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT name, gid FROM $schema.$tabelle ORDER BY name";
														$result = $dbqueryp($connectp,$query);														
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($lsg_id == $e[gid]) echo " selected"; echo " value=\"$e[gid]\" title=\"$e[name]\">$e[name]</option>\n";
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
									<?php
											  $lsglegende=new legende;
											  echo $lsglegende->lsg();
								    ?>	
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/meta_info_small.php?id=<? echo $layerid;?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $_SERVER["PHP_SELF"];?>?<? echo $kuerzel;?>=<? echo $lsg_id; ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
										<td bgcolor=<? echo $element_farbe ?> width="30%">Ausweisung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[ausweis_mv] ;?></b></td>													
									</tr>
									<tr height="30">
										<td>Fl&auml;che in ha:</td>
										<td><b><? echo $r[area_ha] ;?></b></td>													
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
								<? echo geo_flaeche($geometrie,$connectp,$dbqueryp,$fetcharrayp) ?>
							</td>
						</tr>
					</table>				
				</div>
			</div>
			<?php 
			echo div_navigation(); 
			echo div_extra(); 
			echo div_footer(); 
			?>
		</div>
		</body>
		</html>
<?  }

