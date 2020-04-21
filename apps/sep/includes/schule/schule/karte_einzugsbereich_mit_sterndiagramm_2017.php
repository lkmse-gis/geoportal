		<?php
			$schul_id=$_GET["schul_id"];
			
			# Sterndiagramm					
			$query="SELECT  st_box(st_buffer(st_convexhull(st_union(a.sterndiagramm_geom_25833, b.geom_25833)),1000)) as bounding_box, b.bereich, b.schultyp, b.stichtag, b.gid
					FROM education.schulen_sterndiagramm_ab_2016 as a, public.fd_seb as b
					WHERE a.schul_id = '$schul_id'
					AND '$schul_id' = ANY(b.schul_id)
					AND b.stichtag = '2016-09-30'";
					$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
							
							$schuleinzugsbereich=$r[bereich];
							$schultyp=$r[schultyp];
							$stichtagx=$r[stichtag];
							$layerb = $r[gid];
							$boxk = $r[bounding_box];				
							$klammer = array("(",")");
							$box2 = str_replace($klammer,"",$boxk);
							$array = explode(",",$box2);
							$a0 = $array[0];
							$a1 = $array[1];
							$a2 = $array[2];
							$a3 = $array[3];

							$x=$a0 - $a2;
							$y=$a1 - $a3;

							if ($x>$y) 
								{
									$diff=$x-$y;
									$hoch_neu=$a1+$diff;
									$bbox=$a2.",".$a3.",".$a0.",".$hoch_neu;
								}
							else 
								{
									$diff=$y-$x;
									$rechts_neu=$a0+$diff;
									$bbox=$a2.",".$a3.",".$rechts_neu.",".$a1;
								};
			
			$query="SELECT c.verortet, (coalesce(b.innerhalb_a,0)+coalesce(d.innerhalb_b,0)) as innerhalb
					FROM education.schulen_sterndiagramm_ab_2016 as a
					LEFT JOIN (
							SELECT COUNT(DISTINCT b.schueler_id) as innerhalb_a, b.schul_id
							FROM address_registry.adresstabelle as a, education.schulentwicklungsplanung as b
							WHERE a.gem_schl = b.schueler_gkz::integer
							AND b.stichtag = '2016-09-30'
							AND b.schul_id = '$schul_id'
							GROUP BY b.schul_id) as b on a.schul_id = b.schul_id
					LEFT JOIN (
							SELECT COUNT(DISTINCT b.schueler_id) as innerhalb_b, b.schul_id
							FROM address_registry.adresstabelle as a, education.schulentwicklungsplanung as b
							WHERE a.postleitzahl = b.schueler_plz
							AND b.stichtag = '2016-09-30'
							AND schul_id = '$schul_id'
							AND b.schueler_gkz IS NULL
							GROUP BY b.schul_id) as d on a.schul_id = d.schul_id
					LEFT JOIN (
							SELECT COUNT(schueler_adressschluessel) as verortet, schul_id
							FROM education.schueler_nach_schule
							WHERE schueler_adressschluessel IS NOT NULL
							AND stichtag = '2016-09-30'
							AND schul_id = '$schul_id'
							GROUP BY schul_id) as c on a.schul_id = c.schul_id
					WHERE a.schul_id = '$schul_id'";
					$result = $dbqueryp($connectp,$query);
					$r = $fetcharrayp($result);
					$verortet=$r[verortet];
					$innerhalb=$r[innerhalb];				
						
?>
<table class="bordered">
	
		<tr>
			<td style="text-align:center;" colspan=20>Schuljahr 2016/17 mit Schuleinzugsbereich und Sterndiagramm</td>														
		</tr>
		<tr>
			<td style="text-align:center;">Schuleinzugsbereich</td>
			<td style="text-align:center;">Schultyp</td>
			<td style="text-align:center;">Stichtag</td>
			<td style="text-align:center;">Schülergesamtzahl</td>
			<td style="text-align:center;">verortet</td>
			<td style="text-align:center;">nicht verortet</td>
			<td style="text-align:center;">Wohnen innerhalb des Landkreises</td>
			<td style="text-align:center;">Wohnen außerhalb des Landkreises</td>
		</tr>
	
		<tr>
			<?php 										
				echo "<td style=\"text-align:center;\">",$schuleinzugsbereich,"</td>",
				"<td style=\"text-align:center;\">",$schultyp,"</td>",
				"<td style=\"text-align:center;\">",$stichtagx,"</td>",
				"<td style=\"text-align:center;\">",$schuelerzahlen_2016[1],"</td>",
				"<td style=\"text-align:center;\">",$verortet,"</td>",
				"<td style=\"text-align:center;\">",($schuelerzahlen_2016[1]-$verortet),"</td>",
				"<td style=\"text-align:center;\">",$innerhalb,"</td>",
				"<td style=\"text-align:center;\">",($schuelerzahlen_2016[1]-$innerhalb),"</td></tr>";
		?>
		<tr><td colspan=20 style="text-align:center;"><?php echo (($schuelerzahlen_2016[1]-$verortet)-($schuelerzahlen_2016[1]-$innerhalb)) ?> Schüler können auf Grund fehlerhafter Adressangaben nicht verortet werden! Das heißt, mit den Schülern, die außerhalb des Landkreises wohnen, werden <?php echo ($schuelerzahlen_2016[1]-$verortet) ?> nicht im Sterndiagramm angezeigt!</td></tr>
	
</table>
<table>
	<tr>
		<td align='center'>
			<?php echo "<img  class=\"img-thumbnail\" align='center' width='750' height='750' src=\"http://www.geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/wms/protected/seb.map&seb.map&REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=ORKA,$schul_id,$layerb&BBOX=$bbox&SRS=EPSG:25833&FORMAT=image/png&WIDTH=750&HEIGHT=750\">"; ?>
		</td>
	</tr>
</table>	
