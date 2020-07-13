<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Strassenbauamtsbereiche";
$layer_legende_2="Kreisgrenze_msp";

$layer="Strassenbauamtsbereiche";
$label_auswahl="Strassenbauamtsbereich";
$beschriftung_karte="Strassenbauamtsbereiche";

//globale Varibalen
$titel="Strassenbauamtsbereiche";
$kuerzel="sbab";
$datei=$_SERVER["PHP_SELF"];
$tabelle="construction.sba_bereich";

$layerid="70210";

$sbab_id=$_GET["sbab"];

$log=write_i_log($db_link,$layerid);

if ($sbab_id < 1)
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
             echo $geoportal_karte->zeigeKarteBox($box_mse_gesamt,'695','510','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
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
										<h3>Stra&szlig;enbauamtsbereiche*</h3>
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
										<? echo $label_auswahl; ?> ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=40 colspan=2>
										<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
										<select name="<? echo $kuerzel ?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
											<?php
												$query="SELECT name, gid FROM $tabelle ORDER BY name";
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


if ($sbab_id > 0)
   {   
	 
	  $query="SELECT a.name, a.gid FROM construction.sba_standorte as a, $tabelle as b WHERE ST_WITHIN(a.the_geom,b.the_geom) AND b.gid='$sbab_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $sbabname=$r["name"];
	  $sbabid=$r["gid"];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox, st_transform(the_geom,25833) as geom_25833, gid, name, strasse, plz, ort FROM $tabelle WHERE gid='$sbab_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
      $geom_25833=$r["geom_25833"];
      $etrsbox=$r["etrsbox"];	  
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
											<? echo $font_farbe ;?><? echo $r['name']; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b><? echo $r['plz']," ",$r['ort'],"<br>",$r['strasse'] ;?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2"><? echo $label_auswahl;?>:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<select name="kuerzel" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT name, gid FROM $tabelle ORDER BY name";
														$result = $dbqueryp($connectp,$query);														
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($sbab_id == $e['gid']) echo " selected"; echo ' value="',$e["gid"],'" title="',$e["name"],'">',$e["name"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Stra&szlig;enbauamtsbereiche<? echo $font_farbe_end ;?></a>
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
										<td colspan=2  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r['name'] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Zum zust&auml;ndigen Stra&szlig;enbauamt:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo "<a href=\"sba_msp.php?kuerzel=",$sbabid,"\">",$sbabname,"</a></b>" ;?></td>													
									</tr>
									<tr height="30">
										<td>Adresse vom<br>Stra&szlig;enbauamt:</td>
										<td><b><? echo $r['plz']," ",$r['ort'],"<br>",$r['strasse'] ;?></b></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top>folgende Strassenmeisterein<br>aus dem Landkreis<br>geh&ouml;ren zu diesem<br><? echo $label_auswahl;?>:</td>
										<td bgcolor=<? echo $element_farbe ?>>
											<table rules="none" border=0 width="90%">
												<tr>
													<td height=25>
														<b><i>Bereiche</b>
													</td>
													<td>
														<b><i>Standorte</b>
													</td>
												</tr>
												<?php 
												$query="SELECT a.gid, a.name FROM construction.sm_bereiche as a, $tabelle as b WHERE ST_INTERSECTS(ST_BUFFER(b.the_geom,-5),a.the_geom) AND b.gid='$sbab_id' ORDER by a.name";
												$result = $dbqueryp($connectp,$query);
												while($r = $fetcharrayp($result))
												  {
													$bereich_id=$r["gid"];
												    echo '<tr><td valign="top"><a href="sbmb_msp.php?sbmb=',$r["gid"],'">',$r["name"],'</a></td><td>';
													$subquery="SELECT a.* FROM construction.sm_standorte as a,construction.sm_bereiche as b WHERE st_within(a.the_geom,b.the_geom) AND b.gid='$bereich_id'";
													$subresult = $dbqueryp($connectp,$subquery);
													while($sub_r = $fetcharrayp($subresult))
												      {
														echo '<a href="sbm_msp.php?sbm=',$sub_r["gid"],'">',$sub_r["name"],'</a><br>';
														echo $sub_r["strasse"],'<br>',$sub_r["plz"],' ',$subr_r["ort"],'<br>Telefon: ',$sub_r["tel"],'<br>';
													   }
													echo '</td></tr>';		
												 }
												?>
													
											</table>
										</td>													
									</tr>									
																		
								</table>
							</td>
							<td width=30></td>
							<td valign=top align=center width="350">
								<? echo geo_flaeche($geom_25833,$connectp,$dbqueryp,$fetcharrayp) ?>
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

