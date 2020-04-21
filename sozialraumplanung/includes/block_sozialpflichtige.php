<?php
	echo "
	 <td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=11 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege17')\" title=\"aufklappen/zuklappen\"><b>Sozialpflichtige</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege17\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2></td>	
									<td>Einwohner</td>
									<td>Sozialpflichtige</td>
									<td>davon männlich</td>
									<td>Auszubildende</td>
									<td>davon männlich</td>
								</tr>
								<tr>
									<td rowspan=10 align=center width='5%'>2011</td>
									<td>Anzahl</td>
									<td rowspan=2>$gesamt</td>
									<td>$gesamt_sozialpflichtige</td>
									<td>$gesamt_sozialpflichtige_m</td>
									<td>$gesamt_azubis</td>
									<td>$gesamt_azubis_m</td>									
								</tr>								
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td>".round((($gesamt_sozialpflichtige/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_sozialpflichtige_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_azubis/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_azubis_m/$gesamt)*100),2)." %</td>
								</tr>
							</table>
							</div>
						</td>";
?>	