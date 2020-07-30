<?php
// Bearbeiter: Andreas Thurm/ Uwe Popp
// Datum: 2017-05-12
//
// ------- Legende ---------
// 1 ( Thema )
// 2 ( Standard | Thema )
// 3 ( Thema | Thema ) mit Breite der Boxen
//
  class legende_geo
   {
	private $kreis_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=Kreisgrenze_msp&VERSION=1.1.1&FORMAT=image/png"';
	private $aemter_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=aemter_msp_outline&VERSION=1.1.1&FORMAT=image/png"';
	private $gemeinden_gr_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=msp_outline_gem&VERSION=1.1.1&FORMAT=image/png"';
	private $gemeinden_mv_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=gemeinden_mv&VERSION=1.1.1&FORMAT=image/png"';
	private $gemeinden_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=gemeinden_msp&VERSION=1.1.1&FORMAT=image/png"';
	private $gemarkung_gr_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=msp_outline_gemkg&VERSION=1.1.1&FORMAT=image/png"';
	private $Ortsteile_lt_rka_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=Ortsteile_lt_rka&VERSION=1.1.1&FORMAT=image/png"';
	private $Postleitzahlbereiche_url='"http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=Postleitzahlbereiche&VERSION=1.1.1&FORMAT=image/png"';
	
// ## 1 ##  1 Spaltig (Thema)
    function zeigeLegende($layer,$layer2,$layer3,$layer4,$layer5)
    {
		?>
		<tr align=left >
			<td>
			<? if ($layer <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			<? if ($layer2 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer2?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			<? if ($layer3 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer3?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>	
			<? if ($layer4 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer4?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			<? if ($layer5 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer5?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
			</td>
		</tr><?
		return $html;
    }
	
    function zeigeLegendeDemografie($layer_demografie,$layer2,$layer3,$layer4,$layer5)
    {
		?>
		<tr align=left >
			<td>
			<? if ($layer_demografie <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_bevoelkerung_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer_demografie?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			<? if ($layer2 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer2?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			<? if ($layer3 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer3?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>	
			<? if ($layer4 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer4?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			<? if ($layer5 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer5?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
			</td>
		</tr><?
		return $html;
    }

	
// ## 2 ##  2 Spaltig (Standard | Themen)
	 function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
    {
		?>
		<tr align=left >
			<td>			
			            <? if ($kreis == '1'){
							 echo "<img src=$this->kreis_url alt='Grenze LK MSE'>" ; } ?>   
						<? if ($aemter == '1'){ 
							echo "<img src=$this->aemter_url alt='Ã„mter'>" ; } ?>
						<? if ($gemeinde_gr == '1'){ 
							echo "<img src=$this->gemeinden_gr_url alt='Gemeinde Grenzen'>" ; } ?>
						<? if ($gemeinden == '1'){
                            echo "<img src=$this->gemeinden_url alt='Gemeinden'>" ; } ?>
						<? if ($gemarkung_gr == '1'){
							echo "<img src=$this->gemarkung_gr_url alt='Gemarkungs Grenzen'>" ; } ?>
						<? if ($Ortsteile_lt_rka == '1'){
							echo "<img src=$this->Ortsteile_lt_rka_url alt='Ortsteile'>" ; } ?>       
			</td>
			<td>
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<? if ($layer2 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer2?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
			</td>
		</tr><?
		return $html;
    }  
// ## 3 ##  2 Spaltig (Themen | Themen)
	function zeigeLegende2th($breite1,$breite2,$layer,$layer2,$layer3,$layer4,$layer5,$layer6)
    {
		?>
		<tr align=left>
			<td>		
				<? if ($layer <> '')
				{ ?> 
				    <img width=<?echo $breite1?> src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>			 
				<? if ($layer2 <> '')
				{ ?> 
					<img width=<?echo $breite1?> src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer2?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
				<? if ($layer3 <> '')
				{ ?> 
					<img width=<?echo $breite1?> src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer3?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
			</td>
			<td>
				<? if ($layer4 <> '')
				{ ?> 
				<img width=<?echo $breite2?> src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer4?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
				<? if ($layer5 <> '')
				{ ?> 
				<img width=<?echo $breite2?> src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer5?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
				<? if ($layer6 <> '')
				{ ?> 
				<img width=<?echo $breite2?> src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer6?>&VERSION=1.1.1&FORMAT=image/png">
				<?} ?>
			</td>
		</tr><?
		return $html;
    }
	
// Legende für Buslinien und Haltestellen
    function zeigeLegendeBusLinien($layer,$layer2,$layer3,$layer4,$layer5)
    {
		?>
		<tr align=left >
			<td>
			<? if ($layer <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/wms/public/buslinien.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			<? if ($layer2 <> '')
				{ ?> 
				<img src="http://geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_buslinien_wms.map&SERVICE=WMS&REQUEST=GetLegendGraphic&LAYER=<?echo $layer2?>&VERSION=1.1.1&FORMAT=image/png"><br>
				<?} ?>
			</td>
		</tr><?
		return $html;
    }

   }
?>
