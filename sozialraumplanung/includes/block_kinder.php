<?php
	echo "
	 <td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=8 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege10')\" title=\"aufklappen/zuklappen\"><b>Kinder</b></a>
									</td>							
								</tr>
							</table>
							<div id=\"eintraege10\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
									<td colspan=3></td>
									<td>Gesamt</td>
									<td>Krippe</td>
									<td>Kindergarten</td>
									<td>Hort</td>									
									<td>Tagespflegepersonen</td>
									<td>Integrativ</td>
								</tr>
								<tr bgcolor='lightblue'>
									<td rowspan=8 align=center width='5%'>2011</td>
									<td colspan=2>Anzahl</td>
									<td>",$kinderbetreuung+$tagesmutter,"</td>
									<td>$krippen</td>
									<td>$kindergarten</td>
									<td>$horte</td>									
									<td>$tagesmutter</td>
									<td>$integrativ_anzahl</td>	
								</tr>
								<tr bgcolor='lightblue'>									
									<td colspan=2>Kapazitäten</td>
									<td>",$kinderbetreuung_zahlen_kapazitaet+$tagesmutter_zahlen_kapazitaet,"</td>"?>
									<? if ($krippen_zahlen_kapazitaet == "") echo "<td>k.A.</td>";
										else echo "<td>$krippen_zahlen_kapazitaet</td>";
									?>
									<? if ($kindergarten_zahlen_kapazitaet == "") echo "<td>k.A.</td>";
										else echo "<td>$kindergarten_zahlen_kapazitaet</td>";
									?>
									<? if ($horte_zahlen_kapazitaet == "") echo "<td>k.A.</td>";
										else echo "<td>$horte_zahlen_kapazitaet</td>";
									?>									
									<? if ($tagesmutter_zahlen_kapazitaet == "") echo "<td>k.A.</td>";
										else echo "<td>$tagesmutter_zahlen_kapazitaet</td>";
									?>
									<? if ($integrativ_plaetze == "") echo "<td>k.A.</td>";
										else echo "<td>$integrativ_plaetze</td>";
									?>
						<?	echo"</tr>
								<tr bgcolor='lightblue'>									
									<td colspan=2>Anteil zur Bevölkerungsgruppe</td>
									<td>",round(((($kinderbetreuung_zahlen_kapazitaet+$tagesmutter_zahlen_kapazitaet)/$gesamt_0_9)*100),2)," %</td>
									<td>",round((($krippen_zahlen_kapazitaet/$gesamt_0_2)*100),2)," %</td>
									<td>",round((($kindergarten_zahlen_kapazitaet/$gesamt_3_6)*100),2)," %</td>
									<td></td>
									<td>",round((($tagesmutter_zahlen_kapazitaet/$gesamt_0_2)*100),2)," %</td>
								</tr>
								<tr bgcolor='lightblue'>									
									<td colspan=2>Belegung</td>
									<td>$kinderbetreuung_zahlen</td>"?>
									<? if ($krippen_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$krippen_zahlen</td>";
									?>
									<? if ($kindergarten_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$kindergarten_zahlen</td>";
									?>
									<? if ($horte_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$horte_zahlen</td>";
									?>									
									<? if ($tagesmutter_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$tagesmutter_zahlen</td>";
									?>	
						<? echo	"</tr>
								<tr bgcolor='lightblue'>									
									<td rowspan=4>mögliche Einnahmen (Beiträge)</td>
									<td>halbtags</td>
									<td rowspan=4>",$kinderbeitraege_kk+$kinderbeitraege_kg+$kinderbeitraege_hort," €</td>									
									<td>$kinderbeitraege_kk_h €</td>
									<td>$kinderbeitraege_kg_h €</td>
									<td>$kinderbeitraege_hort_h €</td>
								</tr>
								<tr bgcolor='lightblue'>
									<td>teilzeit</td>								
									<td>$kinderbeitraege_kk_t €</td>
									<td>$kinderbeitraege_kg_t €</td>
									<td>$kinderbeitraege_hort_t €</td>
								</tr>
								<tr bgcolor='lightblue'>
									<td>ganztags</td>								
									<td>$kinderbeitraege_kk_g €</td>
									<td>$kinderbeitraege_kg_g €</td>
								</tr>
								<tr bgcolor='lightblue'>
									<td>gesamt</td>								
									<td>$kinderbeitraege_kk €</td>
									<td>$kinderbeitraege_kg €</td>
									<td>$kinderbeitraege_hort €</td>
								</tr>
								<tr>
									<td rowspan=8 align=center width='5%'>2012</td>
									<td colspan=2>Anzahl</td>
									<td>",$kinderbetreuung_2012+$tagesmutter_2012,"</td>
									<td>$krippen_2012</td>
									<td>$kindergarten_2012</td>
									<td>$horte_2012</td>																		
									<td>$tagesmutter_2012</td>
									<td>$integrativ_anzahl_2012</td>		
								</tr>
								<tr>									
									<td colspan=2>Kapazitäten</td>
									<td>",$kinderbetreuung_zahlen_kapazitaet_2012+$tagesmutter_zahlen_kapazitaet_2012,"</td>";?>
									<? if ($krippen_zahlen_kapazitaet_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$krippen_zahlen_kapazitaet_2012</td>";
									?>
									<? if ($kindergarten_zahlen_kapazitaet_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$kindergarten_zahlen_kapazitaet_2012</td>";
									?>
									<? if ($horte_zahlen_kapazitaet_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$horte_zahlen_kapazitaet_2012</td>";
									?>									
									<? if ($tagesmutter_zahlen_kapazitaet_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$tagesmutter_zahlen_kapazitaet_2012</td>";
									?>
									<? if ($integrativ_plaetze_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$integrativ_plaetze_2012</td>";
									?>
						<? echo "</tr>
								 <tr>									
									<td colspan=2>Belegung</td>
									<td>$kinderbetreuung_zahlen_2012</td>";?>
									<? if ($krippen_zahlen_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$krippen_zahlen_2012</td>";
									?>
									<? if ($kindergarten_zahlen_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$kindergarten_zahlen_2012</td>";
									?>
									<? if ($horte_zahlen_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$horte_zahlen_2012</td>";
									?>									
									<? if ($tagesmutter_zahlen_2012 == "") echo "<td>k.A.</td>";
										else echo "<td>$tagesmutter_zahlen_2012</td>";
									?>	
						<? echo "</tr>
								<tr>									
									<td rowspan=4>mögliche Einnahmen (Beiträge)</td>
									<td>halbtags</td>
									<td rowspan=4>",$kinderbeitraege_kk_2012+$kinderbeitraege_kg_2012+$kinderbeitraege_hort_2012," €</td>									
									<td>$kinderbeitraege_kk_h_2012 €</td>
									<td>$kinderbeitraege_kg_h_2012 €</td>
									<td>$kinderbeitraege_hort_h_2012 €</td>
								</tr>
								<tr>
									<td>teilzeit</td>								
									<td>$kinderbeitraege_kk_t_2012 €</td>
									<td>$kinderbeitraege_kg_t_2012 €</td>
									<td>$kinderbeitraege_hort_t_2012 €</td>
								</tr>
								<tr>
									<td>ganztags</td>								
									<td>$kinderbeitraege_kk_g_2012 €</td>
									<td>$kinderbeitraege_kg_g_2012 €</td>
								</tr>
								<tr>
									<td>gesamt</td>								
									<td>$kinderbeitraege_kk_2012 €</td>
									<td>$kinderbeitraege_kg_2012 €</td>
									<td>$kinderbeitraege_hort_2012 €</td>
								</tr>
							</table>
							</div>
						</td>";
?>	