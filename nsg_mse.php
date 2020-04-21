<?php
include ("includes/connect_geobasis.php");
include ("includes/connect.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen
$datei="nsg_mse.php";
$beschriftung_karte="Naturschutzgebiete";
$layer_name="Naturschutzgebiete";

$titel="Naturschutzgebiete";
$titel2="Naturschutzgebiet";

// Legenden - Layer - msp.map
$layer_name2="";
$breite1="90";
$breite2="120";
$layer="Kreisgrenze_msp";
$layer2="aemter_msp_outline";
$layer3="Ortsteile_lt_rka";
$layer4="Naturschutzgebiete";
$layer99="";

$tabelle="sg_naturschutzgebiete";
$schema="environment";

$kuerzel="nsg";
$layerid="32010";

$log=write_log($db_link,$layerid);

$nsg_id=$_GET["$kuerzel"];


if ($nsg_id < 1)
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
           $geotopkarte= new karte;
           echo $geotopkarte->zeigeKarteBox($box_mse_gesamt,'730','490','orka','1','1','0','0','0',$beschriftung_karte,$layer_name);
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
                                    <td align="center"  height=30 colspan=2>
                                        <? echo $titel2; ?> ausw&auml;hlen:
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" height="60" colspan="2">
                                        <form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
                                        <select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">

                                            <?php
                                                $query="SELECT name, gid FROM $schema.$tabelle ORDER BY name";
                                                $result = $dbqueryp($connectp,$query);
                                                echo "<option>Bitte ausw&auml;hlen</option>\n";
                                                while($r = $fetcharrayp($result))
                                                    {
                                                        echo "<option value=\"$r[gid]\"  title=\"$r[name]\">$r[name]</option>\n";
                                                    }
                                            ?>
                                        </select>
                                        </form>
                                    </td>
                                </tr>                                
                                <? include ("includes/meta_aktualitaet.php"); ?>
                                     
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
                            	
                          <? include ("includes/block_1_uk.php"); ?> 
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
<?    } 


if ($nsg_id > 0)
   {   
      $query="SELECT a.name, a.amts_sf FROM kataster.amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.the_geom,a.geom_25833) AND b.gid='$nsg_id' ORDER by a.name";
      $result = $dbqueryp($connectp,$query);
      $i=0;
      while($r = $fetcharrayp($result))
        {
           $aemter[$i]=$r;
           $i++;
           $count=$i;
        }

      $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.the_geom,a.geom_25833) AND b.gid='$nsg_id' ORDER by a.gemeinde";
      $result = $dbqueryp($connectp,$query);
      $k=0;
      while($r = $fetcharrayp($result))
        {
           $gemeinden[$k]=$r;
           $k++;
           $count=$k;
        }
      
      $query="SELECT box(st_transform(the_geom,25833)) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, st_astext(st_centroid(st_transform(the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(the_geom, 31468))) as rd83, st_astext(st_centroid(st_transform(the_geom, 4326))) as geo, st_astext( st_centroid(st_transform(the_geom, 2398))) as koordinaten, st_perimeter(the_geom) as umfang, gid, name, area_ha, ausweis_mv, gis_code, lage FROM $schema.$tabelle WHERE gid='$nsg_id'";
      
      $result = $dbqueryp($connectp,$query);
      $r = $fetcharrayp($result);     
      $area=$r[area];
	  $s4283 = $r[koordinaten];
      $rd83 = $r[rd83];
      $utm = $r[utm];
      $geo = $r[geo];
	  $umfang = $r[umfang];
      $boxstring = $r[box];
      $klammern=array("(",")");
      $boxstring = str_replace($klammern,"",$boxstring);
      $koordinaten = explode(",",$boxstring);
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
      $rechts_range = $koordinaten[0]-$koordinaten[2];
  
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
        <?php
			$geotopkarte= new karte;
            echo $geotopkarte->zeigeKarteBox($boxstring,'730','490','orka','0','0','1','0','0',$beschriftung_karte,$layer_name);
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
                                            <form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
                                                <select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
                                                    <?php
                                                        $query="SELECT name, gid FROM $schema.$tabelle ORDER BY gid";
                                                        $result = $dbqueryp($connectp,$query);                                                        
                                                        while($e = $fetcharrayp($result))
                                                        {
                                                         echo "<option";if ($nsg_id == $e[gid]) echo " selected"; echo " value=\"$e[gid]\" title=\"$e[name]\">$e[name]</option>\n";
                                                        }
                                                    ?>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>                                        
                                        <td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
                                            <a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
                                        </td>                                        
                                    </tr>                                    
                                    <tr>                                        
                                     <!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
											<B>Kartenlegende :</B>
												<?php
													$legende_geo= new legende_geo;
													echo $legende_geo->zeigeLegende2th($breite1,$breite2,$layer,$layer99,$layer99,$layer4,$layer99,$layer99)
												?>
										</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
                                    </tr>    
									<? include ("includes/block_1_uk.php"); ?>
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
                                    <tr height="30">
                                        <td bgcolor=<? echo $element_farbe ?> width="30%">Zust&auml;ndigkeit:</td>
                                        <td bgcolor=<? echo $element_farbe ?>><b><? echo $r[zustaendig] ;?></b></td>                                                    
                                    </tr>
                                    <tr height="30">
                                        <td>Lagebeschreibung:</td>
                                        <td><b><? echo $r[lage] ;?></b></td>                                                    
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
                            
                            <td valign=top align=center width="350">
                                <? include ("includes/geo_flaeche.php") ?>
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

