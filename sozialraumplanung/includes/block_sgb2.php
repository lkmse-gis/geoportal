<?php
	echo "
	 <td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=19 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege15')\" title=\"aufklappen/zuklappen\"><b>SGB II</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege15\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2 rowspan=3></td>									
									<td colspan=9 align=center>Bedarfsgemeinschaft</td>
									<td colspan=7 align=center>Personen in Bedarfsgemeinschaften</td>
								</tr>
								<tr>
									<td rowspan=2>Gesamt</td>									
									<td colspan=4 align=center>nach BG-Typ</td>
									<td colspan=4 align=center>BG mit Personen unter 18 Jahren</td>
									<td rowspan=2>Gesamt</td>
									<td colspan=7 align=center>nach Altersgruppen</td>
								</tr>
								<tr>									
									<td align='center'>Single-BG</td>
									<td align='center'>alleinerziehende BG</td>
									<td align='center'>Partner-BG ohne Kinder</td>
									<td align='center'>Partner-BG mit Kinder</td>									
									<td align='center'>Gesamt</td>
									<td align='center'>1 Kind</td>
									<td align='center'>2 Kinder</td>	
									<td align='center'>3 oder mehr Kinder</td>
									<td align='center'>unter 3 Jahre</td>
									<td align='center'>3 bis unter 7 Jahre</td>
									<td align='center'>7 bis unter 15 Jahre</td>
									<td align='center'>15 bis unter 18 Jahre</td>
									<td align='center'>18 bis unter 20 Jahre</td>	
									<td align='center'>20 bis unter 25 Jahre</td>
								</tr>
								<tr>
									<td rowspan=3 align=center width='5%'>2011</td>
									<td>Anzahl</td>
									<td>$bg_insgesamt</td>
									<td>$bg_single</td>
									<td>$bg_alleinerz</td>
									<td>$bg_paar_o</td>
									<td>$bg_paar_m</td>
									<td>$bg_ges_u18</td>
									<td>$bg_1_kinder</td>
									<td>$bg_2_kinder</td>
									<td>$bg_3_kinder</td>
									<td>$p_bg_ges</td>
									<td>$p_bg_2</td>
									<td>$p_bg_3_6</td>
									<td>$p_bg_7_14</td>
									<td>$p_bg_15_17</td>
									<td>$p_bg_18_19</td>
									<td>$p_bg_20_25</td>
								</tr>
								<tr>
									<td>Anteil</td>
									<td>".round(($bg_insgesamt/$gesamt)*100,2)."%</td>
									<td>".round(($bg_single/$gesamt)*100,2)."%</td>
									<td>".round(($bg_alleinerz/$gesamt)*100,2)."%</td>
									<td>".round(($bg_paar_o/$gesamt)*100,2)."%</td>
									<td>".round(($bg_paar_m/$gesamt)*100,2)."%</td>
									<td>".round(($bg_ges_u18/$gesamt)*100,2)."%</td>
									<td>".round(($bg_1_kinder/$gesamt)*100,2)."%</td>
									<td>".round(($bg_2_kinder/$gesamt)*100,2)."%</td>
									<td>".round(($bg_3_kinder/$gesamt)*100,2)."%</td>
									<td>".round(($p_bg_ges/$gesamt)*100,2)."%</td>
									<td>".round(($p_bg_2/$gesamt)*100,2)."%</td>
									<td>".round(($p_bg_3_6/$gesamt)*100,2)."%</td>
									<td>".round(($p_bg_7_14/$gesamt)*100,2)."%</td>
									<td>".round(($p_bg_15_17/$gesamt)*100,2)."%</td>
									<td>".round(($p_bg_18_19/$gesamt)*100,2)."%</td>
									<td>".round(($p_bg_20_25/$gesamt)*100,2)."%</td>
								</tr>
								<tr>
									<td>Anteil Gruppe</td>
									<td colspan='5'></td>									
									<td>".round(($bg_ges_u18/$gesamt_0_17)*100,2)."%</td>
									<td>".round(($bg_1_kinder/$gesamt_0_17)*100,2)."%</td>
									<td>".round(($bg_2_kinder/$gesamt_0_17)*100,2)."%</td>
									<td>".round(($bg_3_kinder/$gesamt_0_17)*100,2)."%</td>
									<td></td>
									<td>".round(($p_bg_2/$gesamt_0_2)*100,2)."%</td>
									<td>".round(($p_bg_3_6/$gesamt_3_6)*100,2)."%</td>
									<td>".round(($p_bg_7_14/$gesamt_7_14)*100,2)."%</td>
									<td>".round(($p_bg_15_17/$gesamt_15_17)*100,2)."%</td>
									<td>".round(($p_bg_18_19/$gesamt_18_19)*100,2)."%</td>
									<td>".round(($p_bg_20_25/$gesamt_20_24)*100,2)."%</td>
								</tr>
							</table>
							</div>
						</td>";
?>	