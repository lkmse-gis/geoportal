<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Strassenmeistereibereiche";
$layer_legende_2="Kreisgrenze_msp";

$layer="Strassenmeistereibereiche";
$label_auswahl="Strassenmeistereibereich";
$beschriftung_karte="Strassenmeistereibereiche";

//globale Varibalen
$titel="Strassenmeistereibereiche";

$datei="sbmb_msp.php";
$tabelle="construction.sm_bereiche";
$kuerzel="sbmb";
$layerid="70200";

$sbmb_id=$_GET["$kuerzel"];

$log=write_i_log($db_link,$layerid);

if ($sbmb_id < 1)
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
										<h3>Stra&szlig;enmeistereibereiche*</h3>
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
										<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
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


if ($sbmb_id > 0)
   {   
	  
	  //Straßenbauamtsbereich ermitteln	
	  $query="SELECT a.gid, a.name, a.plz, a.ort, a.strasse FROM construction.sba_bereich as a, $tabelle as b WHERE ST_INTERSECTS(ST_BUFFER(b.the_geom,-5),a.the_geom) AND b.gid='$sbmb_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $s=0;
	  while($r = $fetcharrayp($result))
	    {
	       $sbab[$s]=$r;
		   $s++;
		   $count=$s;
		}
	
	  //Straßenmeisterei ermitteln	
	  $query="SELECT a.gid, a.name, a.plz, a.ort, a.strasse FROM construction.sm_standorte as a, $tabelle as b WHERE ST_INTERSECTS(b.the_geom,a.the_geom) AND b.gid='$sbmb_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  
	  $r = $fetcharrayp($result);
	  $sm_id=$r["gid"];
      $sm_name=$r["name"];	  
		
	  $query="SELECT a.name, a.gid FROM construction.sm_bereiche as a, $tabelle as b WHERE ST_WITHIN(a.the_geom,b.the_geom) AND b.gid='$sbmb_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $sbmbname=$r["name"];
	  $sbmbid=$r["gid"];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox,st_transform(the_geom,25833) as geom_25833, gid, name, strasse, plz, ort FROM $tabelle WHERE gid='$sbmb_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);	 
	  $sbmbname=$r["name"];
	  $sbmbid=$r["gid"];
  	  $etrsbox=$r["etrsbox"];
	  $geom_25833=$r["geom_25833"];

	 
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
											<? echo $font_farbe ;?><? echo $r["name"]; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b><? echo $r["plz"]," ",$r["ort"],"<br>",$r["strasse"] ;?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2"><? echo $label_auswahl;?>:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT name, gid FROM $tabelle ORDER BY name";
														$result = $dbqueryp($connectp,$query);														
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($sbmb_id == $e["gid"]) echo " selected"; echo ' value="',$e["gid"],'" title="',$e["name"],'">',$e["name"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Stra&szlig;enmeistereibereiche<? echo $font_farbe_end ;?></a>
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
										<td colspan=2  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r["name"] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Zum Sitz der zust&auml;ndigen<br>Stra&szlig;enmeisterei:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo "<a href=\"sbm_msp.php?sbm=",$sm_id,"\">",$sm_name,"</a></b>" ;?></td>													
									</tr>
									<tr height="30">
										<td>Adresse<br>Stra&szlig;enmeisterei:</td>
										<td><b><? echo $r['plz']," ",$r['ort'],"<br>",$r['strasse'] ;?></b></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top>Stra&szlig;enmeisterei geh&ouml;rt<br>zum Stra&szlig;enbauamtsbereich:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
											<?php 
												for($x=0;$x<$s;$x++)
													{ echo "<a href=\"sbab_msp.php?sbab=",$sbab[$x][0],"\">",$sbab[$x][1],"</a><br>",$sbab[$x][2]," ",$sbab[$x][3],"<br>",$sbab[$x][4],"<br>";}
											?></b>
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

