<?php
// Bearbeiter: Andreas Thurm/ Uwe Popp
// Datum: 2017-04-12
//
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
//           ("includes/karte_seb.php")
require_once ("classes/legende_geo.class.php");

//globale Varibalen
$v_stichtag='2016-09-30';

$v_schultyp_name='Schule mit dem Förderschwerpunkt Lernen';
$schullayer_karte='schulen_2016_fl';

$layername_mapfile="seb_fl_2016";
$layername_mapfile_umringe="seb_fl_gr";
$titel="Schuleinzugsbereiche Förderschwerpunkt Lernen";
$titel_legende="Schuleinzugsbereich";

// education.schuleinzugsbereiche
$v_schultyp='fl';
$tabelle="schuleinzugsbereiche";
$schema="education";

//education.schulen_2016
$v_schularten='Fö';
//$v_schularten='FöL/FöSp/FöK/FöV/FöKr';

// Legenden - Layer - msp.map
$breite1="90";
$breite2="100";
$layer="seb_fl_2016";
$layer2="seb_fl_gr";
$layer3="Ortsteile_lt_rka";
$layer4="schulen_2016_fl";
$layer99="";

// geoportal.geoportal_schulen_2016
$get_themenname="bereich";
$layerid="101420";
$ortsteil_id=$_GET["ortsteil"];
$ortsteil_notiz=$_GET["ot"];
$anzahl_bereiche=$_GET["cb"];
$themen_id=$_GET["$get_themenname"];
$log=write_i_log($db_link,$layerid);

// Ebene 1
if (!isset($ortsteil_id) AND !isset($themen_id))
    { 
        $query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle WHERE schultyp='$v_schultyp' AND stichtag='$v_stichtag'";
        $result = $dbqueryp($connectp,$query);
        $r = $fetcharrayp($result);
        $count = $r["anzahl"];
		$box=$box_mse_gesamt;
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
            <? include ("includes/karte_seb.php"); ?>
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
                                Ortsteil ausw&auml;hlen:
                            </td>
                        </tr>
                        <tr>
                            <td align="center" height=40 colspan=2>                                
                                <form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="ortsteil">
                                <select name="ortsteil" onchange="document.ortsteil.submit();">
                                    <option>Bitte auswählen</option>
                                   <?php
                                        $query="SELECT gid, substr((ortsteil || ' (' || gem_name || ')'),1,36) as v_ortsteil FROM management.ot_lt_rka ORDER BY v_ortsteil";
                                        $result = $dbqueryp($connectp,$query);

                                        while($r = $fetcharrayp($result))
                                            {
                                                echo "<option value=\"$r[gid]\">$r[v_ortsteil]</option>\n";
                                            }
                                    ?>
                                </select>
                                </form>
                            </td>
                        </tr>                            
                        <? include ("includes/meta_i_aktualitaet.php"); ?>
                        <tr>
									<!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
											<B>Kartenlegende :</B>
												<?php
													$legende_geo= new legende_geo;
													echo $legende_geo->zeigeLegende2th($breite1,$breite2,$layer,$layer2,$layer99,$layer4,$layer99,$layer99)
												?>
										</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
                        </tr>
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
<?    } 

//  --  Ebene 2 --
if ($ortsteil_id > 0)
    {           
        $query="SELECT a.gid,a.bereich,a.schul_id,b.ortsteil,b.gemschl,b.gem_name ,b.gemkg, b.gemkg_schl FROM $schema.$tabelle as a, management.ot_lt_rka as b WHERE ST_INTERSECTS(b.the_geom,a.the_geom) AND b.gid='$ortsteil_id' AND a.schultyp='$v_schultyp' AND a.stichtag='2016-09-30'";
        $result=$dbqueryp($connectp,$query);
        $count=0;
        
       while($r=$fetcharrayp($result))
         {
           $seb[$count]["v_gid"]=$r["gid"];
           $seb[$count]["bereich"]=$r["bereich"];
           $seb[$count]["ortsteil"]=$r["ortsteil"];
           $seb[$count]["schul_id"]=$r["schul_id"];
           $seb[$count]["gemschl"]=$r["gemschl"];
           $seb[$count]["gem_name"]=$r["gem_name"];
           $seb[$count]["gemkg"]=$r["gemkg"];
           $seb[$count]["gemkg_schl"]=$r["gemkg_schl"];   
           $count++;
          }
      
      $v_ortsteil = $seb[0]["gemkg"];
      $v_gem_name = $seb[0]["gem_name"];
      $v_gemkg = $seb[0]["gemkg"];
      $v_gemkg_schl = $seb[0]["gemkg_schl"];
       
       
    if ($count > 1)
        {
//            var_dump($seb);    
    
      $query="SELECT box(a.the_geom) as etrsbox, st_astext(st_centroid(a.the_geom)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center ,ortsteil , gemschl, gem_name, gemkg, gemkg_schl FROM management.ot_lt_rka a WHERE gid='$ortsteil_id'";
      $result = $dbqueryp($connectp,$query);
      
      $r = $fetcharrayp($result);
      $v_ortsteil = $r["ortsteil"];
      $v_gem_name = $r["gem_name"];
      $v_gemkg = $r["gemkg"];
      $v_gemkg_schl = $r["gemkg_schl"];

      $box=$r["box"];
      
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
// neu            
            <? include ("includes/karte_seb.php"); ?>
//
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
                                            <? echo $font_farbe ;?><BR><? echo $titel ;?><br><br>für: <h2><? echo $v_ortsteil ;?>(<? echo $v_gem_name ;?>)</h2><br>(<? echo $count," Treffer)",$font_farbe_end ;?>
                                        </td>
                                        <td width=10 rowspan="7">
                                        </td>
                                        <td border=0 valign=top align=left rowspan="6" colspan=3>
                                            <div style="margin:1px" id="map"></div>
                                        </td>
                                    </tr>
                                    <tr> </tr>
                                    <tr>
                                        <td align="center" height="40" valign=center ;>
                                        </td>                                        
                                    </tr>
                                    <tr bgcolor=<? echo $header_farbe; ?>>
                                        <td align=center>
                                            <a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>alle Schuleinzugsbereiche<? echo $font_farbe_end ;?></a>
                                        </td>    
                                    </tr>
                                    <tr>
                                        <td  height=10></td>
                                    </tr>
                                    <tr>
                                      <!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
											<B>Kartenlegende :</B>
												<?php
													$legende_geo= new legende_geo;
													echo $legende_geo->zeigeLegende2th($breite1,$breite2,$layer,$layer2,$layer3,$layer4,$layer99,$layer99)
												?>
										</table> 
										</td>
									<!-- ENDE Tabelle für Legende -->
                                    </tr>                                
                                    <? include ("includes/block_2_uk_seb.php"); ?>    
                                </table> <!-- Ende innere Tablle oberer Block -->
                            </td>
                        </tr>
                    </table>    <!-- Ende äußere Tabelle oberer Block -->
                    <!-- Beginn grosse Tabelle unterer Block -->
                    <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
                        <tr>
                            <td>
                                <!-- Beginn Sachdatentabelle -->
                                <table border=0 width="100%" valign=top>
                                    <? head_trefferliste($count,2,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->
                                    <tr bgcolor=<? echo $element_farbe ?>>
                                         <td align=center height=30><H4><b>Bereich:</b></td>
                                         <td align=center height=30><H4><b>Ortsteil:</b></td>
                                    </tr>
                                     
                                    <?php for ($i=0;$i<$count;$i++)
                                        {
                                        echo '<tr bgcolor=',get_farbe($i+1),'>
                                          <td align=center height=30><a href="',$_SERVER["PHP_SELF"],'?',$get_themenname,'=',$seb[$i]["v_gid"],'&ot=',$ortsteil_id,'&cb=',$count,'">',$seb[$i]["bereich"],'</a></td>
                                          <td align=center>',$seb[$i]["ortsteil"],'</td>
                                        </tr>';
                                        
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
		<? 
        }
    else
        {
            $v_gid = $seb[0]["v_gid"];
            echo "<head> <meta http-equiv=\"refresh\" content=\"0; URL=",$_SERVER["PHP_SELF"],"?bereich=$v_gid&ot=$ortsteil_id&cb=1\">
            </head>";
        }
}

// Ebene 3
if ($themen_id > 0)
   { 
$query="SELECT astext(b.wkb_geometry) as utm, astext(st_transform(b.wkb_geometry,2398)) as gk4283,astext(st_transform(b.wkb_geometry, 4326)) as geo,astext(st_transform(b.wkb_geometry, 31468)) as  rd83, b.oid, b.gid, b.gml_id, b.stichtag, b.schul_id, b.kvwmap_anschrift, b.bezeichnung, b.ortsteil, b.schularten, b.gkz, b.tel, b.fax, b.mail, b.internet, b.profile, b.schulleiter, b.schultraeger, b.adressschluessel AS fa_adressschluessel, b.klassifizierung_schulen, b.schultyp, b.isced_level, b.bild, b.geoportal_anschrift, b.kreis_name, b.kreisschluessel, b.gem_schl, b.gemeinde_name, a.bereich, b.wkb_geometry FROM $schema.$tabelle as a, geoportal.geoportal_schulen_aktuell as b WHERE ST_WITHIN(b.wkb_geometry,a.the_geom) AND a.gid = '$themen_id' AND schularten LIKE '%FöL%'";

    $result = $dbqueryp($connectp,$query);
    $r = $fetcharrayp($result);
 // var_dump($r);     
 
    $bildname=$r["bild"];
    $oeffentlich=$r["oeffentlich"];
    $ortsteil = $r["ortsteil"];
    $gem_schl = $r["gem_schl"];
    $v_ortsteil = $r["ortsteil"];
    $v_bereich = $r["bereich"];
    $v_bezeichnung = $r["bezeichnung"];
    $v_gem_name = $r["gemeinde_name"];
    $v_gemkg = $r["gemkg"];

    $s4283 = $r["gk4283"];
    $geo=$r["geo"];
    $rd83=$r["rd83"];
    $utm=$r["utm"];
 
 
 
    $count3 = 0;
    $result = $dbqueryp($connectp,$query);
    while($r=$fetcharrayp($result))
    {
       $seb[$count3]["gid"]=$r["gid"];
       $seb[$count3]["anschrift"]=$r["geoportal_anschrift"];
       $seb[$count3]["bezeichnung"]=$r["bezeichnung"];
       $seb[$count3]["schultraeger"]=$r["schultraeger"];
       $seb[$count3]["tel"]=$r["tel"];
       $seb[$count3]["fax"]=$r["fax"];
       $seb[$count3]["mail"]=$r["mail"];
       $seb[$count3]["schulleiter"]=$r["schulleiter"];
       
       $count3++;
    }          
     
     $query="SELECT box(the_geom) as etrsbox, st_astext(st_centroid(the_geom)) as etrscenter, box(the_geom) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, gid, bereich FROM $schema.$tabelle WHERE gid='$themen_id'";
      $result = $dbqueryp($connectp,$query);
      $r = $fetcharrayp($result);

      $box=$r["box"];

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
        <? include ("includes/karte_seb.php"); ?>
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
                                            <? echo $font_farbe,"<BR>",$titel;
											if ($ortsteil_notiz != '') echo "<br>für ",get_ortsteil_name($ortsteil_notiz,$connectp,$dbqueryp,$fetcharrayp);
											echo "<h2>",$v_bereich,  $font_farbe_end,"</h2>" ;?>
                                        </td>
                                        <td width=10 rowspan="6"></td>
                                        <td border=0 valign=top align=left rowspan="5" colspan=3>
                                            <div style="margin:1px" id="map"></div>
                                        </td>
                                    </tr>                                
                                    <tr bgcolor=<? echo $header_farbe; ?>>
                                        <td align=center><br> 
                                            <a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>zu allen Schuleinzugsbereichen<? echo $font_farbe_end ;?></a>
                                        </td>
                                    </tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
									<?
									if ($ortsteil_notiz != '')
									   echo '<td align=center><br> 
                                            <a href="',$_SERVER["PHP_SELF"],'?ortsteil=',$ortsteil_notiz,'">',$font_farbe,'zu allen Schuleinzugsbereichen(',$anzahl_bereiche,') für ', get_ortsteil_name($ortsteil_notiz,$connectp,$dbqueryp,$fetcharrayp),$font_farbe_end,'</a>
                                        </td>';
									?>
                                    </tr>
                                    
                                    <tr>
                                       <td  height=8> </td>
                                    </tr>
                                    <tr>
                                    <!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
											<B>Kartenlegende :</B>
												<?php
													$legende_geo= new legende_geo;
													echo $legende_geo->zeigeLegende2th($breite1,$breite2,$layer,$layer2,$layer99,$layer4,$layer99,$layer99)
												?>
										</table> 
										</td>
									<!-- ENDE Tabelle für Legende -->
                                    </tr>                                
                                    <? include ("includes/block_3_uk_seb.php"); ?>    
                                </table> <!-- Ende innere Tablle oberer Block -->
                            </td>
                        </tr>
                    </table>    <!-- Ende äußere Tabelle oberer Block -->
                    <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
                        <tr>
                            <td border=0 valign=top>
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=6 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><?php echo $count3; ?> Schulstandorte im Schuleinzugsbereich: <? echo $v_bereich; echo $font_farbe_end ;?></td>
									</tr>
									<tr height="35" bgcolor=<? echo $element_farbe ?>>
										<td><H4><b>Bezeichnung:</td>
										<td><H4><b>Schulträger:</td>
										<td><H4><b>Anschrift:</td>
										<td><H4><b>Schulleiter:</td>
										<td><H4><b>Telefon:</td>
										<td><H4><b>E-Mail:</td>
									</tr>
									<?php for ($i=0;$i<$count3;$i++)
									{
									echo "<tr bgcolor=",get_farbe($i+1),">
										<td height='30'><a href=\"schulen.php?schule=",$seb[$i]["gid"],"\">",$seb[$i]["bezeichnung"],"</a></td>","
										<td>",$seb[$i]["schultraeger"],"</td>
										<td>",$seb[$i]["anschrift"],"</td>
										<td>",$seb[$i]["schulleiter"],"</td>
										<td>",$seb[$i]["tel"],"</td>
										<td>",$seb[$i]["mail"],"</td>
									</tr>";
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
<? } ?>