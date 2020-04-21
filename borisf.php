<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legenden.class.php");

//Variablen
$titel="Bodenrichtwerte Bauland";
$headline="Bodenrichtwerte<br>Wohn-, Bau-, Gewerbe-, Sanierungsflächen";
$titel2="Bodenrichtwertzone";

$beschriftung_karte="Bodenrichtwerte";
$tabelle="bw_zonen";
$kuerzel="borisf";
$leg_bild="borisf.png";




$gemarkung_id=$_GET["gemarkung"];
$str_schl=$_GET["str_schl"];
$borisf_id=$_GET["$kuerzel"];
$stichtag=$_GET["stichtag"];
$themen_id=$borisf_id;

if (!isset($stichtag))
    {
	  $query="SELECT stichtag,layer_id_bau from bodenrichtwerte.bw_stichtage ORDER BY stichtag DESC LIMIT 1";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $stichtag = $r["stichtag"];
	  $layerid = $r["layer_id_bau"];
	  
	}
	else
	{
	  $query="SELECT stichtag,layer_id_bau from bodenrichtwerte.bw_stichtage WHERE stichtag ='$stichtag'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $layerid = $r["layer_id_bau"];
	  
	}
$log=write_i_log($db_link,$layerid);	
$layer_name="Bodenrichtwerte_Bauland_".$stichtag; 

if ($themen_id < 1 AND $gemarkung_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM bodenrichtwerte.bw_zonen WHERE (zonentyp != 'Ackerland' AND zonentyp != 'Grünland' AND zonentyp != 'forstwirtschaftliche Flächen') AND stichtag='$stichtag'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
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
		<?
             $brwkarte= new karte;
             echo $brwkarte->zeigeKarteBox($box_mse_gesamt,'680','450','orka','1','0','0','0','0',$beschriftung_karte,$layer_name);			 
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
		         <td width="30%" align="center" valign="top" height=30 colspan=2>
				 <?php  echo get_i_mp_link($db_link,$layerid); ?>
			     <h3><?php echo $headline; ?>*</h3>
				Zu diesem Thema befinden sich<br>
				<b><?php echo $count; ?></b> Datens&auml;tze in der Datenbank.
		        </td>
		        <td rowspan=7 width=30></td>
		        <td width="75%" border=0 valign=top rowspan=7 colspan=3>
			    <br>
			    <div style="margin:1px" id="map"></div>
		        </td>
	            </tr>
				<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 12pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
							Stichtag:
							<input type=hidden name="str_schl" value="x">
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
						<td align="center" height=30 colspan=2><br>
						<br><br>
							Gemarkung ausw&auml;hlen:<br>
							<small>Die Angabe in Klammern ist die jeweils zugehörige Gemeinde.
						</td>
				</tr>
				<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 10pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
							<input type=hidden name="str_schl" value="x">
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
					             <td valign=bottom align=center colspan=2>
					    *) <a href="<? echo $metadatenpfad.$layerid;?>" target="_blank" onclick="return hilfe_popup(this.href)">Info zum Thema <? echo $titel; ?></a>
						         </td>
					</tr>
					
					<tr>
									<td valign=bottom align=center>
										<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die webbasierte Karte?<br>(OpenLayers)</a>																
									</td>
					</tr>
                    						<!-- Tabelle für Legende -->
											<?php
											  $brw_legende=new legende;
											  echo $brw_legende->brw_bauland();
											?>
											<!-- Ende der Tabelle für die Legende -->
												
					<tr>
										<td colspan=3 height=35></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>   
											<a href="<? echo $metadatenpfad.$layerid;?>" target="_blank" onclick="return hilfe_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $_SERVER["PHP_SELF"],"?stichtag=",$stichtag;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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


if ($gemarkung_id > 0 AND $str_schl =='x')
   {
         
	  $query="SELECT a.oertliche_bezeichnung, a.bodenrichtwertnummer, a.bodenrichtwert, a.brwu, a.brwb, a.beitragszustand, a.zonentyp,a.stichtag FROM bodenrichtwerte.bw_zonen as a, gemarkung as b WHERE b.geographicidentifier='$gemarkung_id' AND st_intersects(st_transform(a.the_geom,2398),b.the_geom) AND a.stichtag='$stichtag' AND (a.zonentyp != 'Grünland' AND a.zonentyp != 'Ackerland'  AND a.zonentyp != 'forstwirtschaftliche Flächen') ORDER BY a.bodenrichtwertnummer";
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
	  
	  
	  $query="SELECT b.gemeinde,b.gem_schl, b.amt, b.amt_id FROM gemarkung as a, gemeinden as b WHERE a.geographicidentifier='$gemarkung_id' AND CAST(a.gemeinde AS INTEGER)=CAST(b.gem_schl AS INTEGER)";
	  $result = $dbqueryp($connectp,$query);
	  $y = $fetcharrayp($result);
	  $gemeindename=$y[0];
	  $gemeinde=$y[1];
	  $amtname=$y[2];
	  $amt=$y[3];
	  
	  $query="SELECT box(the_geom) as box, box(st_transform(the_geom,25833)) as etrsbox, area(the_geom) as area,  gemarkungsname_lang as name from gemarkung WHERE geographicidentifier='$gemarkung_id'";

	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  
	  $boxstring = $r["etrsbox"];
	  
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
		<?php
				
              $brw_karte= new karte;
              echo $brw_karte->zeigeKarteBox($boxstring,'680','450','orka','0','0','0','1','0',$beschriftung_karte,$layer_name);
             ?>
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
											<? echo $font_farbe ;?>Bodenrichtwertzonen in <? echo $gemarkungsname; ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 valign=top align=center rowspan="7" colspan=5>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 12pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
							Stichtag:
							<input type=hidden name="str_schl" value="x">
							<input type=hidden name="gemarkung" value="<? echo $gemarkung_id ?>">
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
						<td align="center" height=60  style="font-family:Arial; font-size: 8pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gemarkung">
							<input type=hidden name=str_schl value="x">
							<input type=hidden name=stichtag value="<? echo $stichtag ?>">
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
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
						<td align="center" height=60  style="font-family:Arial; font-size: 8pt; font-weight: bold">   
								
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="strasse">
							<input type=hidden name=gemarkung value=<? echo $gemarkung_id; ?>>
							<input type=hidden name=stichtag value=<? echo $stichtag; ?>>
								<select name="str_schl" onchange="document.strasse.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Straße auswählen</option>
									<?php
									 $query="SELECT a.strassenname,a.schluesselgesamt as str_schl FROM kataster.lk_lb_flst_strassen as a, gemarkung as b WHERE st_intersects(a.wkb_geometry,st_transform(b.the_geom,25833)) AND CAST(b.geographicidentifier AS INTEGER)=$gemarkung_id AND a.schluesselgesamt LIKE '$gemeinde%' ORDER BY strassenname";
									 
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[str_schl]\">$r[strassenname]
													</option>\n";
										}
									?>
								</select>								
							</form>
							
						</td>									
					</tr>
					<tr>
					 <td align=center bgcolor=<? echo $header_farbe ;?>>
					 <a href="<? echo $_SERVER["PHP_SELF"],"?stichtag=",$stichtag;?>"><? echo $link_farbe ;?>Bodenrichtwertzonen<br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
					 </td>										
					</tr>
					<!-- Tabelle für Legende -->
					<?php
					  $brw_legende=new legende;
					  echo $brw_legende->brw_bauland();
					?>
					<!-- Ende der Tabelle für die Legende -->
					<tr>
		              <td colspan=2></td>                                       										
		              <td><small>
			          <? echo $cr ?>| &nbsp;<a href=\"includes/kartehilfe.php\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\">Hilfe zur Kartennutzung</a>
		              </td>	
		              <td>
			          <a href="metadaten/metadaten.php?Layer_ID=<?php echo $layerid ?>" target=\"_blank\" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
		              </td>
		              <td align=right>
			          <a href="<?php echo $_SERVER["PHP_SELF"] ?>?str_schl=x&gemarkung=<?php echo $gemarkung_id ?>&stichtag=<? echo $stichtag ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
		              </td>
	               </tr>
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
													<td align=center><b>örtliche Bezeichnung</td>
													<td align=center><b>Bodenrichtwert</td>
													<td align=center><b>Zonentyp</td>
													<td align=center><b>Stichtag</td>
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{
													
													echo "<tr bgcolor=",get_farbe($v),">",
														"<td align='center'><a href=\"",$_SERVER["PHP_SELF"],"?borisf=",$borisf[$v]["bodenrichtwertnummer"],"&stichtag=",$stichtag,"&gemarkung=",$gemarkung_id,"\">",$borisf[$v]["bodenrichtwertnummer"],"</a></td>",
														"<td align='left'>",$borisf[$v]["oertliche_bezeichnung"],"</td>";
														if (empty($borisf[$v]["bodenrichtwert"]) AND empty($borisf[$v]["brwu"])) 
															{
																echo "<td align='center'>",$borisf[$v]["brwb"]," €/m²</td>"; 
															} 
														elseif (empty($borisf[$v]["bodenrichtwert"]) AND empty($borisf[$v]["brwb"]))
															{
																echo "<td align='center'>",$borisf[$v]["brwu"]," €/m²</td>";
															}
														else
															{
																echo "<td align='center'>",$borisf[$v]["bodenrichtwert"]," €/m²</td>";
														}
														echo "<td align='center'>",$borisf[$v]["zonentyp"],"</td>","<td align='center'>",$borisf[$v]["stichtag"],"</td>",
														"</tr>";
													}
												?>																																					
											</table>
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

if ($gemarkung_id > 0 AND $str_schl != 'x' AND $themen_id < 1)
   { 	  
   $gem=substr($str_schl,0,8);
   $str=substr($str_schl,8,5);
   
	  $query="SELECT a.oertliche_bezeichnung, a.bodenrichtwertnummer, a.bodenrichtwert, a.brwu, a.brwb, a.beitragszustand, a.zonentyp,a.stichtag FROM bodenrichtwerte.bw_zonen as a, kataster.lk_lb_flst_strassen as b WHERE st_intersects(a.the_geom,b.wkb_geometry) AND a.stichtag='$stichtag' AND (a.zonentyp != 'Grünland' AND a.zonentyp != 'Ackerland' AND zonentyp != 'forstwirtschaftliche Flächen') AND b.schluesselgesamt='$str_schl' ORDER BY a.bodenrichtwertnummer";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($x = $fetcharrayp($result))
	    {
	       $borisf[$z]=$x;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT a.gemarkungsname_kurz,b.gemeinde,b.gem_schl,b.amt,b.amt_id FROM gemarkung as a, gemeinden as b WHERE a.gemeinde=b.gem_schl AND a.geographicidentifier = '$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $y = $fetcharrayp($result);
	  $gemarkungsname=$y[0];
	  $gemeindename=$y[1];
	  $gemeinde=$y[2];
	  $amtname=$y[3];
	  $amt=$y[4];
	  
	    
	  
	  $query="SELECT strassenname,box(wkb_geometry) as etrsbox, st_astext(st_centroid(wkb_geometry)) as etrscenter, box(st_transform(wkb_geometry,2398)) as box, area(wkb_geometry) as area, st_astext(st_centroid(st_transform(wkb_geometry,2398))) as center from kataster.lk_lb_flst_strassen WHERE schluesselgesamt='$str_schl'";
      
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $street=$r["strassenname"];
	  
	  $boxstring = $r["etrsbox"];
	  
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
		<?php
		      $brw_karte= new karte;
              echo $brw_karte->zeigeKarteBox($boxstring,'680','450','orka','0','0','0','1','0',$beschriftung_karte,$layer_name);
        ?>
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
											<? echo $font_farbe ;?>Bodenrichtwertonen in <? echo $gemarkungsname; ?><br>
											Straße: <? echo $street; ?><? echo $font_farbe_end ;?><br>
											<a href="#liste"><? echo $font_farbe ;?>(
											<? if ($count >=1) echo $count;
											   else echo "kein ";?> Treffer)
											   <? echo $font_farbe_end ;?></a>
										</td>
										<td width=30></td>
										<td border=0 valign=top align=center rowspan="7" colspan=5>
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
							Stichtag:
							<input type=hidden name="str_schl" value="x">
							<input type=hidden name="gemarkung" value="<? echo $gemarkung_id ?>">
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
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gemarkung">
							<input type=hidden name="str_schl" value="x">
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Ort auswählen</option>
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
						<td align="center" height=60  style="font-family:Arial; font-size: 8pt; font-weight: bold"> 
						<? echo "ausgewählt: ",$street; ?>
						<br><br>
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="strasse">
							<input type=hidden name="gemarkung" value="<? echo $gemarkung_id; ?>">
								<select name="str_schl" onchange="document.strasse.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>andere Straße auswählen</option>
									<?php
									 $query="SELECT a.strassenname,a.schluesselgesamt as str_schl FROM kataster.lk_lb_flst_strassen as a, gemarkung as b WHERE st_intersects(a.wkb_geometry,st_transform(b.the_geom,25833)) AND CAST(b.geographicidentifier AS INTEGER)=$gemarkung_id AND a.schluesselgesamt LIKE '$gemeinde%' ORDER BY strassenname";
									 
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option value=$r[str_schl]>$r[strassenname]
													</option>\n";
										}
									?>
								</select>								
							</form>
						</td>									
					</tr>
					
					<tr>
					<td align=center bgcolor=<? echo $header_farbe ;?>>
					<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $link_farbe ;?>Bodenrichtwertzonen<br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
					</td>										
					</tr>
					<!-- Tabelle für Legende -->
					<?php
					  $brw_legende=new legende;
					  echo $brw_legende->brw_bauland();
					?>
					<!-- Ende der Tabelle für die Legende -->
					<tr>
		              <td colspan=2></td>                                       										
		              <td><small>
			          <? echo $cr ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
		              </td>	
		              <td>
			          <a href="metadaten/metadaten.php?Layer_ID=<?php echo $layerid ?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title=\"Metadaten\" border=0></a>
		              </td>
		              <td align=right>
			          <a href="<?php echo $_SERVER["PHP_SELF"] ?>?str_schl=<?php echo $str_schl ?>&gemarkung=<?php echo $gemarkung_id ?>&stichtag=<?php echo $stichtag ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
		              </td>
	               </tr>
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
													<td align=center><b>örtliche Bezeichnung</td>
													<td align=center><b>Bodenrichtwert</td>
													<td align=center><b>Zonentyp</td>
													<td align=center><b>Stichtag</td>
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{
													
													echo "<tr bgcolor=",get_farbe($v),">",
														"<td align='center'><a href=\"",$_SERVER["PHP_SELF"],"?borisf=",$borisf[$v]["bodenrichtwertnummer"],"&stichtag=$stichtag","&gemarkung=",$gemarkung_id,"\">",$borisf[$v]["bodenrichtwertnummer"],"</a></td>",
														"<td align='left'>",$borisf[$v]["oertliche_bezeichnung"],"</td>";
														if (empty($borisf[$v]["bodenrichtwert"]) AND empty($borisf[$v]["brwu"])) 
															{
																echo "<td align='center'>",$borisf[$v]["brwb"]," €/m²</td>"; 
															} 
														elseif (empty($borisf[$v]["bodenrichtwert"]) AND empty($borisf[$v]["brwb"]))
															{
																echo "<td align='center'>",$borisf[$v]["brwu"]," €/m²</td>";
															}
														else
															{
																echo "<td align='center'>",$borisf[$v]["bodenrichtwert"]," €/m²</td>";
														}
														echo "<td align='center'>",$borisf[$v]["zonentyp"],"</td>",
														     "<td align='center'>",$borisf[$v]["stichtag"],"</td>",
														"</tr>";														
													}
												?>																																					
											</table>
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




 if ($themen_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid FROM gemeinden as a, bodenrichtwerte.bw_zonen as b WHERE ST_WITHIN(st_transform(b.the_geom, 2398),a.the_geom) AND b.bodenrichtwertnummer='$themen_id' AND b.stichtag='$stichtag'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r["amt"];
	  $amt=$r["amt_id"];
	  $gem_id=$r["gemeindeid"];
	  $gemeindename=$r["gemeinde"];
	  
	  $query="SELECT box(the_geom) as box, * FROM bodenrichtwerte.bw_zonen WHERE bodenrichtwertnummer='$themen_id' AND stichtag='$stichtag'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $x = $fetcharrayp($result);
	  
	  $boxstring = $x["box"];
	  $geometrie=$x["the_geom"];
		
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
		<?php
		      $brw_karte= new karte;
              echo $brw_karte->zeigeKarteBox($boxstring,'680','450','orka','0','0','0','1','0',$beschriftung_karte,$layer_name);
        ?>
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
											<? echo $font_farbe ;?>Bodenrichtwertzone<br><? echo $x["bodenrichtwertnummer"]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=30></td>
										<td border=0 valign=top align=center rowspan="7" colspan=5>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>									
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe ?>>
											Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>
										<br>
											Gemeinde: <a href="gemeinden_msp.php?gemeinde=<? echo $gem_id; ?>"><? echo $gemeindename ?></a>
										<br>
											Gemarkung: <a href="gemarkungen_msp.php?gemarkung=<? echo $x["gemarkung"] ?>"><? echo get_gemarkung_name($x["gemarkung"],$connectp,$dbqueryp,$fetcharrayp) ?></a>
										</td>
									</tr>
						<tr>
						<td align="center" height=60 colspan=2 style="font-family:Arial; font-size: 12pt; font-weight: bold">   
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
							Stichtag:
							<input type=hidden name="borisf" value="<? echo $themen_id ?>">
							<input type=hidden name="gemarkung" value="<? echo $gemarkung_id ?>">
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
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gemarkung">
							<input type=hidden name=str_schl value="x">
								<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
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
					<a href="<? echo $_SERVER["PHP_SELF"],"?stichtag=",$stichtag ;?>"><? echo $link_farbe ;?>Bodenrichtwertzonen<br>gesamter Landkreis<? echo $link_farbe_end ;?></a>
					</td>
					</tr>
					<tr>
					 <td align=center bgcolor=<? echo $header_farbe ?>>
					  <a href="<? echo $_SERVER["PHP_SELF"] ;?>?gemarkung=<? echo $x["gemarkung"]; ?>&stichtag=<? echo $stichtag; ?>&str_schl=x"><? echo $link_farbe ;?>Bodenrichtwertzonen<br>in  <? echo get_gemarkung_name($x["gemarkung"],$connectp,$dbqueryp,$fetcharrayp); echo $link_farbe_end ;?></a>
					</td>
					</tr>
					<!-- Tabelle für Legende -->
					<?php
					  $brw_legende=new legende;
					  echo $brw_legende->brw_bauland();
					?>
					<!-- Ende der Tabelle für die Legende -->
					<tr>
		              <td colspan=2></td>                                       										
		              <td><small>
			          <? echo $cr ?>| &nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
		              </td>	
		              <td>
			          <a href="metadaten/metadaten.php?Layer_ID=<?php echo $layerid ?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title=\"Metadaten\" border=0></a>
		              </td>
		              <td align=right>
			          <a href="<?php echo $_SERVER["PHP_SELF"] ?>?borisf=<?php echo $themen_id ?>&stichtag=<?php echo $stichtag ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
		              </td>
	               </tr>
					</table>									
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr>
										<td width="100%" colspan=2 bgcolor=<? echo $header_farbe ?>><font size="+1"><? echo $font_farbe ;?>&nbsp;&nbsp;Bodenrichtwertzone <? echo $x["bodenrichtwertnummer"];?><? echo $font_farbe_end ;?></td>
										</td>
									</tr>									 			 
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Bodenrichtwertnummer:</td>
										<td width="100%" ><b><? echo $x["bodenrichtwertnummer"] ; ?></b></td>
									</tr>
									<tr>
										<td>Gemeinde:</td>
										<td><b><? echo get_gemeinde_name($x["gemeinde"],$connectp,$dbqueryp,$fetcharrayp) ; ?></b></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Gemarkung:</td>
										<td><b><? echo get_gemarkung_name($x["gemarkung"],$connectp,$dbqueryp,$fetcharrayp); ; ?></b></td>
									</tr>
									<tr>
										<td>Ortsteil:</td>
										<td><b><? echo $x["ortsteilname"] ; ?></b></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>örtl. Bezeichnung</td>
										<td><b><? echo $x["oertliche_bezeichnung"] ?></b></td>
									</tr>
									<tr>
										<?
										if ($x["verfahrensgrund_zusatz"] == 'SB') 
										{
											echo "<td>Sanierungsbeeinflusster<br>Bodenrichtwert</td>
											<td><b>",$x["brwb"]," €/m²</b></td>";
										}
										elseif ($x["verfahrensgrund_zusatz"] == 'SU') 
										{
											echo "<td>Sanierungsunbeeinflusster<br>Bodenrichtwert</td>
											<td><b>",$x["brwu"]," €/m²</b></td>";
										}
										elseif ($x["verfahrensgrund"] == 'Entw' AND $x["brwu"] > 0 ) 
										{
											echo "<td>entwicklungsunbeeinflusster<br>Bodenrichtwert</td>
											<td><b>",$x["brwu"]," €/m²</b></td>";
										}
										elseif ($x["verfahrensgrund"] == 'Entw' AND $x["brwb"] > 0 ) 
										{
											echo "<td>entwicklungsbeeinflusster<br>Bodenrichtwert</td>
											<td><b>",$x["brwb"]," €/m²</b></td>";
										}
										else
										{
											echo "<td>Bodenrichtwert</td>
											<td><b>",$x["bodenrichtwert"]," €/m²</b></td>";
										}
										?>
									</tr>
									<tr  bgcolor=<? echo $element_farbe ?>>
										<td>Zonentyp:</td>
										<td><b><? if ($x["verfahrensgrund"] == 'Entw') echo "Entwicklungsbereich";
 										        else echo $x["zonentyp"]; ?> </b></td>
									</tr>
									<tr>
										<td>Beitragszustand:</td>
										<td><b>
										<? 
										if ($x["beitragszustand"] == '1')	echo "eb-/kb-frei";
										if ($x["beitragszustand"] == '3')	echo "eb-/kb- u. abgabenpflichtig nach KAG";
										if ($x["beitragszustand"] == '2')	echo "eb-/kb-frei u. abgabenpflichtig nach KAG";
										?> </b></td>
									</tr>					
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Fläche des Richtwertgrundstücks in m²:</td>
										<td><b><? echo $x["flaeche"] ?> </b></td>
									</tr>
									<tr>
										<td>Stichtag:</td>
										<td><b><? echo $x["stichtag"] ?> </b></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Nutzungsart:</td>
										<td><b>
										<? $query="SELECT nutzungsart FROM bodenrichtwerte.bw_nutzungsart WHERE nakey = '$x[nutzungsart]'";
										
										$result = $dbqueryp($connectp,$query);
										$na = $fetcharrayp($result);
										echo $na[0] ?> </b></td>
									</tr>
									<tr>
										<td>Bauweise:</td>
										<td><b><? $query="SELECT bwtext FROM bodenrichtwerte.bw_bauweise WHERE bwkey = '$x[bauweise]'";										
										$result = $dbqueryp($connectp,$query);
										$na = $fetcharrayp($result);
										echo $na[0] ?> </b></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Geschosszahl:</td>
										<td><b><? echo $x["geschosszahl"] ?> </b></td>
									</tr>
									<tr>
										<td>Grundflächenzahl:</td>
										<td><b><? echo $x["grundflaechenzahl"] ?> </b></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Geschossflächenzahl:</td>
										<td><b><? echo $x["geschossflaechenzahl"] ?> </b></td>
									</tr>
									<tr>
										<td>Baumassenzahl:</td>
										<td><b><? echo $x["baumassenzahl"] ?> </b></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Tiefe in m:</td>
										<td><b><? echo $x["tiefe"] ?> </b></td>
									</tr>
									<tr>
										<td>Breite in m:</td>
										<td><b><? echo $x["breite"] ?> </b></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td>Verfahrensgrund:</td>
										<td><b><? echo $x["verfahrensgrund"] ?> </b></td>
									</tr>
									<tr>
										<td>Verfahrensgrundzusatz:</td>
										<td><b><? echo $x["verfahrensgrund_zusatz"] ?> </b></td>
									</tr>
								</table>
							</td>										
									<td valign=top align=right width="350">
									<? echo geo_flaeche($geometrie,$connectp,$dbqueryp,$fetcharrayp) ?>
							</td>
						</tr>
						</table>
						</td></tr>
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



