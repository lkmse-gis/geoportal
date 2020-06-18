<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Naturschutzgebiete";
$layer_legende_2="Kreisgrenze_msp";
$layer="Naturschutzgebiete";
$label_auswahl="Naturschutzgebiet";

//globale Varibalen
$datei=$_SERVER["PHP_SELF"];
$beschriftung_karte="Naturschutzgebiete";
$titel="Naturschutzgebiete";


$tabelle="sg_naturschutzgebiete";
$schema="environment";

$kuerzel="nsg";
$layerid="32010";

$log=write_i_log($db_link,$layerid);

$nsg_id=$_GET["$kuerzel"];


if ($nsg_id < 1)
    { 
        $query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";      
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
             echo $geoportal_karte->zeigeKarteBox($box_mse_gesamt,'750','510','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
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
                                        <? echo $label_auswahl; ?> ausw&auml;hlen:
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
      
      $query="SELECT box(st_transform(the_geom,25833)) as etrsbox, st_transform(the_geom,25833) as geom_25833,  gid, name, area_ha, ausweis_mv, gis_code, lage,rechtsgr FROM $schema.$tabelle WHERE gid='$nsg_id'";
      
      $result = $dbqueryp($connectp,$query);
      $r = $fetcharrayp($result);     
	  $geom_25833 = $r["geom_25833"];
      $etrsbox = $r["etrsbox"];
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
                                            <? echo $font_farbe ;?><? echo $r["name"]; ?><? echo $font_farbe_End ;?>
                                        </td>
                                        <td width=30 rowspan=7></td>
                                        <td border=0 align=center rowspan="6" colspan=3>
                                            <div style="margin:1px" id="map"></div>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
                                            <b>GIS-Code: <? echo $r["gis_code"]; ?></b><br>                                            
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
                                                        $query="SELECT name, gid FROM $schema.$tabelle ORDER BY gid";
                                                        $result = $dbqueryp($connectp,$query);                                                        
                                                        while($e = $fetcharrayp($result))
                                                        {
                                                         echo "<option";if ($nsg_id == $e["gid"]) echo " selected"; echo ' value="',$e["gid"],'" title="',$e["name"],'">',$e["name"],'</option>\n';
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
							   
					           <? include ("includes/block_1_1_uk.php"); ?>				</table>
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
                                        <td bgcolor=<? echo $element_farbe ?> width="30%">Ausweisung:</td>
                                        <td bgcolor=<? echo $element_farbe ?>><b><? echo $r["ausweis_mv"] ;?></b></td>                                                    
                                    </tr>
                                    <tr height="30">
                                        <td>Fl&auml;che in ha:</td>
                                        <td><b><? echo $r["area_ha"] ;?></b></td>                                                    
                                    </tr>
                                    <tr height="30">
                                        <td bgcolor=<? echo $element_farbe ?> width="30%">Rechtsgrundlage:</td>
                                        <td bgcolor=<? echo $element_farbe ?>><b><? echo $r["rechtsgr"] ;?></b></td>                                                    
                                    </tr>
                                    <tr height="30">
                                        <td>Lagebeschreibung:</td>
                                        <td><b><? echo $r["lage"] ;?></b></td>                                                    
                                    </tr>
                                    <tr>
                                        <td bgcolor=<? echo $element_farbe ?> valign=top><? echo $label_auswahl;?> schneidet folgende<br>&Auml;mter des Kreises:</td>
                                        <td bgcolor=<? echo $element_farbe ?>><b>
                                            <?php 
                                                for($x=0;$x<$i;$x++)
                                                { echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
                                            ?></b>
                                        </td>                                                    
                                    </tr>
                                    <tr>
                                        <td valign=top><? echo $label_auswahl;?> schneidet folgende<br>Gemeinden des Kreises:</td>
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
                                <? echo geo_flaeche($geom_25833,$connectp,$dbqueryp,$fetcharrayp) ?>
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

