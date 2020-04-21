<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
//include ("includes/connect.php");
include ("includes/connect_i_mse.php");
require_once("classes/legenden.class.php");
require_once("classes/karte.class.php");

$layerid=121690;

$log=write_i_log($db_link,$layerid);

$vorgang_id=$_GET["vorgang_id"];
$sa=$_GET["sa"];


if (strlen($vorgang_id) > 0)
   { 	  
	  $query="SELECT * FROM veterinary.crisis_area WHERE vorgang_id='$vorgang_id'";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gebiet[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT area(the_geom) as flaeche,typ,dokument_verordnung,dokument_karte,art FROM veterinary.crisis_area WHERE vorgang_id='$vorgang_id' ORDER BY flaeche DESC LIMIT 1";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $target_type=$r["typ"];
	  if (strlen($r["dokument_verordnung"]) >0) $verfuegung_link="http://geoport-lk-mse.de/geoportal/pictures/veterinary/".substr($r["dokument_verordnung"],32,30);
	  if (strlen($r["dokument_karte"]) >0) $karte_link="http://geoport-lk-mse.de/geoportal/pictures/veterinary/".substr($r["dokument_karte"],32,30);
	  $sa=$r["art"];
	  
	  
	  
	  
	  $query="SELECT a.gemeinde FROM gemeinden as a,veterinary.crisis_area as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.the_geom,-10)) AND b.vorgang_id='$vorgang_id' AND b.typ = 'Sperrgebiet'";
	  $result = $dbqueryp($connectp,$query);
	  $gs=0;
	  while($r = $fetcharrayp($result))
	    {
	       $sp_gemeinde[$gs]=$r;
		   $gs++;
		   $countgs=$gs;	
		}
		
	  $query="SELECT a.gemeinde FROM gemeinden as a,veterinary.crisis_area as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.the_geom,-10)) AND b.vorgang_id='$vorgang_id' AND b.typ = 'Beobachtungsgebiet'";
	  $result = $dbqueryp($connectp,$query);
	  $gb=0;
	  while($r = $fetcharrayp($result))
	    {
	       $beo_gemeinde[$gb]=$r;
		   $gb++;
		   $countgb=$gb;	
		}
		
	  $query="SELECT a.gemeinde FROM gemeinden as a,veterinary.crisis_area as b WHERE st_intersects(st_transform(a.the_geom,25833),st_buffer(b.the_geom,-10)) AND b.vorgang_id='$vorgang_id' AND b.typ = 'Schutzzone'";
	  $result = $dbqueryp($connectp,$query);
	  $gsz=0;
	  while($r = $fetcharrayp($result))
	    {
	       $sz_gemeinde[$gsz]=$r;
		   $gsz++;
		   $countgsz=$gsz;	
		}
	  
	  $Kuerzel="crisis_area";
	  $titel="TSN-Meldungen";
	  $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area,  a.vorgang,a.beginnt FROM veterinary.crisis_area as a WHERE a.vorgang_id='$vorgang_id' AND a.typ = '$target_type'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  
	  $box = $r["box"];
	  
	  

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
		
			
			<?
			$tsn_karte= new karte;
			echo $tsn_karte->zeigeKarteBox($box,'680','450','dtk','1','0','1','0','0','Tierseuchenmeldung',$sa);			 
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
										<td height="40" align="center" valign=top width=250 bgcolor=<? echo $header_farbe; ?>>
										
											<? echo $font_farbe ;?>Tierseuchenmeldung<br><h3><? echo $r["vorgang"],"<br>(",$r["beginnt"],")";?> <? echo $font_farbe_end ;?></h3><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="8"></td>
										<td border=0 valign=top align=left rowspan="8" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="crisis_area.php"><? echo $font_farbe ;?>alle Meldungen ansehen<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr><td align=center>
									<?php echo get_i_mp_link($db_link,$layerid);?>
									</td></tr>
                                               <? if ($gebiet[0]["typ"] != "Allgemeinverfügung") {

                                                                  	  echo "<tr bgcolor=#FF0000>
									  <td><b><u>Gemeinden im Sperrgebiet:</u></b><br>"; 
									     if ($gs > 0) 
										   {
										     for($v=0;$v<$gs;$v++)
										        echo $sp_gemeinde[$v][0],", ";
										   }
										   else echo "Kein Sperrgebiet angelegt.";
										   
									  echo "</td>
									</tr>
									<tr bgcolor=#fff928>
									  <td><b><u>Gemeinden in der Schutzzone:</u></b><br>";
									 
									     if ($gsz > 0) 
										   {
										     for($v=0;$v<$gsz;$v++)
										        echo $sz_gemeinde[$v][0],", ";
										   }
										   else echo "Keine Schutzzone angelegt.";
										   
									  echo "</td>
									</tr>
									<tr bgcolor=#00FF00>
									<td><b><u>Gemeinden im Beobachtungsgebiet:</u></b><br>";
									
									     if ($gb > 0) 
										   {
										     for($v=0;$v<$gb;$v++)
										        echo $beo_gemeinde[$v][0],", ";
										   }
										   else echo "Kein Beobachtungsgebiet angelegt.";
										   
									  echo "</td>
									</tr>
                                                                        "; }

									else echo "<tr><td align=center>Bitte beachten!</td></tr>
                                                                                   <tr><td align=center>Diese Allgemeinverfügung gilt für alle Gemeinden</td></tr>
                                                                                   <tr><td align=center>des Landkreises<br>Mecklenburgische Seenplatte</td></tr>";
                                                                        ?>
									<tr><td  height=10><? if ($count == 1) echo "<b>zum Download verfügbare Dokumente:</b>"; ?><br>
									    <? if (strlen($verfuegung_link) > 0 AND $count==1) echo "<a href=$verfuegung_link target=_blank>Verfügung herunterladen</a><br>";
										   else if ($count == 1) echo "Keine Verfügung vorhanden.<br>";
										   if (strlen($karte_link) > 0 AND $count==1)  echo "<a href=$karte_link target=_blank>Detailkarte herunterladen</a><br>";
										   else if ($count == 1)  echo "Keine Detailkarte vorhanden.<br>";
										   ?>
										   </td></tr>
									<tr>										
										<td valign=bottom align=right>
										<?php
										$legende_tsn=new legende;
										$legende_tsn->tsn($sa);
										?>
										</td>
									</tr>									
									<tr>
										<td colspan=2></td>                                       										
										<td><small>
											 <? echo $cr; ?>| &nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
										</td>	
										<td>
											<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
										</td>
										<td align=right>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gemeinde_id;?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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
											<td height=30></td>
											<td height=30><a name=\"liste\"></a>&nbsp;<b>Vorgang:</b></td>											
											<td height=30>&nbsp;<b>Gebiet:</b></td>				
											<td height=30>&nbsp;<b>Massnahmen:</b></td>
											<td height=30>&nbsp;<b>Datum:</b></td>
											";
										?>							
									</tr>																
									<?php for($v=0;$v<$z;$v++)
										{ 
											$bildname = $gebiet[$v]["dokument_verordnung"];
											$bildname1 = explode("&",$bildname);
											$bildname2 = $bildname1[0];
											$bildname3 = explode("/",$bildname2);
											$bild="pictures/".$bildname3[5]."/".$bildname3[6];
											$kartename = $gebiet[$v]["dokument_karte"];
											$kartename1 = explode("&",$kartename);
											$kartename2 = $kartename1[0];
											$kartename3 = explode("/",$kartename2);
											$karte="pictures/".$kartename3[5]."/".$kartename3[6];
											echo "<tr bgcolor=",get_farbe($v),">															
													<td>"; 
											if (strlen($bildname) > 0) echo "<a href=$bild target=_blank>Verfügung ansehen</a>";
											if (strlen($kartename) > 0) echo "<br><a href=$karte target=_blank>Detailkarte ansehen</a>";
											echo "</td>";	
												
											echo "<td>",$gebiet[$v]["vorgang"],"</td>";													
											echo "<td>",$gebiet[$v]["typ"],"</td>													
											<td>&nbsp;",$gebiet[$v]["massnahmen"],"</td>
											<td>&nbsp;",$gebiet[$v]["beginnt"],"</td>														
											</tr>";
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





if (strlen($sa) > 0  AND strlen($vorgang_id) == 0)
    { 
	
		$query="SELECT COUNT(DISTINCT vorgang_id) AS anzahl FROM veterinary.crisis_area WHERE endet>=now() AND art='$sa'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
		
		$query="SELECT bezeichnung FROM veterinary.seuchenarten WHERE kuerzel='$sa'";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$seuchenart = $r["bezeichnung"];
		
	
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
			$tsn_karte= new karte;
			echo $tsn_karte->zeigeKarteBox($box_mse_gesamt,'680','490','orka','1','0','1','0','0','Tierseuchenmeldung',$sa);			 
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
						<td align="center" valign="top" width=300 height=60 colspan=2>
						
							<h3>Aktuelle<br>Tierseuchenmeldungen* Landkreis<br>Mecklenburgische Seenplatte</h3>
							Aktuell befinden sich<br>
							<b><? echo $count; ?></b> Meldungen zur Seuchenart<br><br><b><? echo $seuchenart; ?></b><br><br>in der Datenbank.
						</td>
						<td rowspan=6 width=30></td>
						<td border=0 align=center rowspan=7 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Meldung ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="crisis_area.php" method="get" name="vorgang">
							    <input type=hidden value='<? echo $sa; ?>' name=sa>
								<select name="vorgang_id" onchange="document.vorgang.submit();">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT DISTINCT vorgang_id,vorgang FROM veterinary.crisis_area WHERE endet>=now() AND art='$sa' ORDER BY vorgang_id ";
									 $result = $dbqueryp($connectp,$query);
									 
									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[vorgang_id]\">$r[vorgang]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
					<tr>
					   <td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>><a href="crisis_area.php"><? echo $font_farbe ;?>alle Meldungen ansehen<? echo $font_farbe_end ;?></a></td>
					</tr>
					<tr>
					    <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Tierseuchenmeldungen</a>
						</td>
					</tr>
					<tr><td align=center colspan=2>letzte Aktualisierung: <b><i>laufend</i></b></td></tr>
					
					<tr>
									<td valign=bottom align=center>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die<br>webbasierte Karte?<br>(OpenLayers)</a>																
									</td>	
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<?php
										     $legende_tsn=new legende;
										     $legende_tsn->tsn($sa);
										    ?>
										</td>
									</tr>
								<tr>
									<td height=35 colspan=3></td>									
									<td>
										 <small><? echo $cr; ?>|&nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
									</td>	
									<td>
										<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
									</td>
									<td align=right>
										<a href="crisis_area.php?sa=<? echo $sa; ?>"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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

if (strlen($sa) == 0)
    { 
	
		$query="SELECT COUNT(DISTINCT vorgang_id) AS anzahl FROM veterinary.crisis_area WHERE endet>=now()";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
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
			$tsn_karte= new karte;
			echo $tsn_karte->zeigeKarteBox($box_mse_gesamt,'680','490','orka','1','0','0','0','0','Tierseuchenmeldung','AIV,AFB,ASP');			 
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
						<td align="center" valign="top" width=300 height=60 colspan=2>
						<?php echo get_i_mp_link($db_link,$layerid);?>
							<h3>Aktuelle<br>Tierseuchenmeldungen* Landkreis<br>Mecklenburgische Seenplatte<br>
							<br><b>Gesamtansicht</b><br><br>- alle Seuchenarten -</h3>
							Aktuell befinden sich<br>
							<b><? echo $count; ?></b> Meldungen in der Datenbank.
						</td>
						<td rowspan=5 width=30></td>
						<td border=0 align=center rowspan=6 colspan=3>
							<br>
							<div style="margin:1px" id="map"></div>
						</td>
					</tr>
					<tr>
						<td align="center" height=30 colspan=2>
							Seuchenart auswählen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="crisis_area.php" method="get" name="vorgang">
								<select name="sa" onchange="document.vorgang.submit();">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT kuerzel,bezeichnung FROM veterinary.seuchenarten ORDER BY bezeichnung ";
									 $result = $dbqueryp($connectp,$query);
									 
									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[kuerzel]\">$r[bezeichnung]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
					<tr>
					    <td valign=bottom align=center colspan=2>
					    *) <a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)">Info zum Thema Tierseuchenmeldungen</a>
						</td>
					</tr>
					<tr><td align=center colspan=2>letzte Aktualisierung: <b><i>laufend</i></b></td></tr>
					
					<tr>
									<td valign=bottom align=center>
										<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Wie nutze ich die<br>webbasierte Karte?<br>(OpenLayers)</a>																
									</td>	
										<td valign=bottom align=right>
											<!-- Tabelle für Legende -->
											<?php
										     $legende_tsn=new legende;
										     $legende_tsn->tsn('all');
										     ?>
										</td>
									</tr>
								<tr>
									<td height=35 colspan=3></td>									
									<td>
										 <small><? echo $cr; ?>|&nbsp;<a href="includes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>
									</td>	
									<td>
										<a href="metadaten/metadaten.php?Layer_ID=<? echo $layerid?>" target="_blank" onclick="return meta_popup(this.href)"><img src="images/info_button.gif" title="Metadaten" border=0></a>
									</td>
									<td align=right>
										<a href="crisis_area.php"><img src="images/reload.png" title="Kartenausschnitt neu laden"></a>
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


?>
