<?php
	echo "
	 <td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=8 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege12')\" title=\"aufklappen/zuklappen\"><b>Bevölkerung Jugend</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege12\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2></td>			
									<td>0-u3</td>
									<td>3-u7</td>
									<td>3-u6,5</td>
									<td>6,5-u11</td>
									<td>6-u6,5</td>
									<td>6,5-u7</td>
									<td>7-u11</td>
									<td>7-u15</td>
									<td>15-u18</td>
									<td>18-u20</td>
									<td>20-u25</td>									
								</tr>
								<tr>
									<td rowspan=8 align=center width='5%'>2011</td>
									<td bgcolor='#A9E2F3'>männlich</td>
									<td bgcolor='#A9E2F3'>$gesamt_0_2_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_3_6_m</td>
									<td bgcolor='#A9E2F3'>",ceil($gesamt_3_6_m-($m[6]/2)),"</td>
									<td bgcolor='#A9E2F3'>",floor($gesamt_7_10_m+($m[6]/2)),"</td>
									<td bgcolor='#A9E2F3'>",ceil($m[6]/2),"</td>
									<td bgcolor='#A9E2F3'>",floor($m[6]/2),"</td>
									<td bgcolor='#A9E2F3'>$gesamt_7_10_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_7_14_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_15_17_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_18_19_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_20_24_m</td>									
								</tr>
								<tr>
									<td>männlich %</td>
									<td>",round((($gesamt_0_2_m/$gesamt_0_2)*100),2),"</td>
									<td>",round((($gesamt_3_6_m/$gesamt_3_6)*100),2),"</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>",round((($gesamt_7_14_m/$gesamt_7_14)*100),2),"</td>
									<td>",round((($gesamt_15_17_m/$gesamt_15_17)*100),2),"</td>
									<td>",round((($gesamt_18_19_m/$gesamt_18_19)*100),2),"</td>
									<td>",round((($gesamt_20_24_m/$gesamt_20_24)*100),2),"</td>									
								</tr>
								<tr>
									<td>männlich % an Gesamtbevölkerung</td>
									<td>",round((($gesamt_0_2_m/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_3_6_m/$gesamt)*100),2),"</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>",round((($gesamt_7_14_m/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_15_17_m/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_18_19_m/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_20_24_m/$gesamt)*100),2),"</td>	
								</tr>
								<tr bgcolor='#F6CECE'>
									<td>weiblich</td>
									<td>$gesamt_0_2_w</td>
									<td>$gesamt_3_6_w</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>$gesamt_7_14_w</td>
									<td>$gesamt_15_17_w</td>
									<td>$gesamt_18_19_w</td>
									<td>$gesamt_20_24_w</td>	
								</tr>
								<tr>
									<td>weiblich %</td>
									<td>",round((($gesamt_0_2_w/$gesamt_0_2)*100),2),"</td>
									<td>",round((($gesamt_3_6_w/$gesamt_3_6)*100),2),"</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>",round((($gesamt_7_14_w/$gesamt_7_14)*100),2),"</td>
									<td>",round((($gesamt_15_17_w/$gesamt_15_17)*100),2),"</td>
									<td>",round((($gesamt_18_19_w/$gesamt_18_19)*100),2),"</td>
									<td>",round((($gesamt_20_24_w/$gesamt_20_24)*100),2),"</td>
								</tr>
								<tr>
									<td>weiblich % an Gesamtbevölkerung</td>
									<td>",round((($gesamt_0_2_w/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_3_6_w/$gesamt)*100),2),"</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>",round((($gesamt_7_14_w/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_15_17_w/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_18_19_w/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_20_24_w/$gesamt)*100),2),"</td>	
								</tr>
								<tr bgcolor='#F3E2A9'>
									<td>gesamt</td>
									<td>$gesamt_0_2</td>
									<td>$gesamt_3_6</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>$gesamt_7_14</td>
									<td>$gesamt_15_17</td>
									<td>$gesamt_18_19</td>
									<td>$gesamt_20_24</td>	
								</tr>
								<tr>
									<td>gesamt % an Gesamtbevölkerung</td>
									<td>",round((($gesamt_0_2/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_3_6/$gesamt)*100),2),"</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>",round((($gesamt_7_14/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_15_17/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_18_19/$gesamt)*100),2),"</td>
									<td>",round((($gesamt_20_2/$gesamt)*100),2),"</td>									
								</tr>
							</table>
							</div>
						</td>";
?>	