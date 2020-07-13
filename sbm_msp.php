<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Strassenmeisterei";
$layer_legende_2="Kreisgrenze_msp";
$layer="Strassenmeisterei";
$label_auswahl="Strassenmeisterei";
$beschriftung_karte="Strassenmeisterei";

//globale Varibalen
$titel="Strassenmeisterei";

$datei=$_SERVER["PHP_SELF"];
$tabelle="construction.sm_standorte";
$kuerzel="sbm";
$layerid="70400";


$sbm_id=$_GET["$kuerzel"];

$log=write_i_log($db_link,$layerid);

if ($sbm_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle";	  
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
             $geoportal_karte= new karte;
             echo $geoportal_karte->zeigeKarteBox($box_mse_gesamt,'730','510','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
            ?>		
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
								<? echo $label_auswahl; ?> ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
									<option>Bitte ausw&auml;hlen</option>
									<?php
										$query="SELECT name, gid FROM $tabelle ORDER BY name";
										$result = $dbqueryp($connectp,$query);										
										while($r = $fetcharrayp($result))											
											{												
												echo "<option value=\"$r[gid]\"  title=\"$r[name]\">$r[name]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
						<!-- es folgt die Einbindung eines Snippets mit der Verknüpfung zu den Metadaten -->
								
                                <? include ("includes/meta_i_aktualitaet.php"); ?> 
								
								<!-- Zeile für die Legende -->
								
								<tr>									
 			                       <td valign=bottom align=left >
							       <table class="table_legende" >
								    <B>Kartenlegende :</B>
								    <?php
								     $legende_geo= new legende_geo;
								     echo $legende_geo->zeigeLegende($layer_legende,$layer_legende_2,'','','');
								     ?>
							       </table> 
						          </td>
    		                   	</tr>

							   <!-- Einbindung des Snippets für die Zeile unter der Karte -->
							   
					           <? include ("includes/block_1_1_uk.php"); ?>			</table>
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

if ($sbm_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid as sbmid FROM gemeinden as a, $tabelle as b WHERE ST_WITHIN(b.the_geom,a.the_geom) AND b.gid='$sbm_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r["amt"];
	  $amt=$r["amt_id"];
	  $gem_id=$r["gemeindeid"];
	  $gemeindename=$r["gemeinde"];
	  
	  //Straßenmeistereibereich ermitteln	
	  $query="SELECT a.gid, a.name FROM construction.sm_bereiche as a, $tabelle as b WHERE ST_INTERSECTS(b.the_geom,a.the_geom) AND b.gid='$sbm_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $sbmbname=$r["name"];
	  $sbmbid=$r["gid"];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox,st_transform(the_geom,25833) as geom_25833, gid, name, strasse, plz, ort, tel, fax, email, bild, oeffentlich FROM $tabelle WHERE gid='$sbm_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $name = $r["name"];
	  $bildname = $r["bild"];
	  $bildname2 = trim($bildname,"/data/Bilder/");
	  $bildname3 = explode(".",$bildname2);
	  $bildname4 = $bildname3[0];
	  $id = $r["gid"];
	  $etrsbox = $r["etrsbox"];
	  $geom_25833 = $r["geom_25833"];
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
             $geoportal_karte= new karte;
             echo $geoportal_karte->zeigeKarteBox($etrsbox,'700','520','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
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
											<? echo $font_farbe ;?><? echo $r["name"]; ?><? echo $font_farbe_end ;?>
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
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<? echo $label_auswahl;?>:&nbsp;
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT a.name, a.gid FROM $tabelle as a ORDER BY a.name";
														$result = $dbqueryp($connectp,$query);
													
														while($e = $fetcharrayp($result))
															{
																echo "<option";if ($sbm_id == $e["gid"]) echo " selected"; echo ' value="',$e["gid"],'"  title="',$e["name"],'">',$e["name"],'</option>\n';															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>										
										<td align=center colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Stra&szlig;enmeisterein<? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
								<!-- Zeile für die Legende -->
								
								   <tr>									
 			                       <td valign=bottom align=left >
							       <table class="table_legende" >
								    <B>Kartenlegende :</B>
								    <?php
								     $legende_geo= new legende_geo;
								     echo $legende_geo->zeigeLegende($layer_legende,$layer_legende_2,$layer_legende_3,'','');
								     ?>
							       </table> 
						          </td>
    		                   	</tr>
							   <!-- Einbindung des Snippets für die Zeile unter der Karte -->
							   
					           <? include ("includes/block_1_1_uk.php"); ?>		</table>
							</td>
						</tr>
						</table>
								 
							 <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<font size="+1"><? echo $font_farbe ;?><? echo $r["name"] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Postleitzahl:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["plz"] ;?></b></td>
										<?
											$bildname="bilder/schulen/$bildname4.jpg";
											if (file_exists($bildname)) {
												echo "<td valign=top align=right rowspan=8 width=420><a href='bilder/schulen/$bildname4.jpg' target='_blank' onclick='return popup(this.href);'><img height='235' src='bilder//schulen/$bildname4.jpg'></a></td>";
												} else {
												echo "<td valign=center align=right rowspan=8 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";
												}
										?>
									</tr>
									<tr height="25">
										<td>Ort:</td>
										<td><b><? echo $r["ort"] ;?></b></td>
									</tr>
									<tr height="25">
										<td bgcolor=<? echo $element_farbe ?>>Straße:</td>
										<td bgcolor=<? echo $element_farbe ?> width="300"><b><? echo $r["strasse"] ;?></b></td>
									</tr>									
									<tr  height="25">
										<td>Telefon:</td>
										<td><b>
										<? 
											if ($r["tel"] == "") echo "<font color=red>keine Telefonnummer verfügbar</font>";
											else echo $r["tel"];
										?></b></td>
									</tr>	
									<tr height="25">
										<td bgcolor=<? echo $element_farbe ?>>FAX:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
										<? 
											if ($r["fax"] == "") echo "<font color=red>keine Faxnummer verfügbar</font>";
											else echo $r["fax"];
										?></b>
										</td>												
									</tr>									
									<tr>
										<td>E-Mail:</td>
										<td><b>
											<? 
												if ($r["mail"] == "") echo "<font color=red>keine E-Mail Adresse verfügbar</font>";
												else echo '<a href="mailto:',$r["mail"],'>',$r["mail"],'</a>';
											?></b>
										</td>												
									</tr>									<tr>
										<td bgcolor=<? echo $element_farbe ?>>Zum Zust&auml;ndigkeitsbereich:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
										<? 
											echo "<a href=\"sbmb_msp.php?sbmb=",$sbmbid,"\">",$sbmbname,"</a><br>";
										?></b>
										</td>												
									</tr>
								</table>
							</td>									
							<td valign=top align=center width="350">
							<? echo geo_punkt($geom_25833,$connectp,$dbqueryp,$fetcharrayp) ?>		
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