<?php
	echo "
	 <td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=11 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege13')\" title=\"aufklappen/zuklappen\"><b>Bevölkerung Indizies</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege13\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2></td>			
									<td>0-u18</td>
									<td>18-u65</td>
									<td>65-u80</td>
									<td>80-u100</td>
									<td>65-u100</td>									
									<td>Jugendindex</td>
									<td>Altenquotient</td>
									<td>Hochbetagten-Index</td>
									<td>Aging-Index</td>
								</tr>
								<tr>
									<td rowspan=9 align=center width='5%'>2011</td>
									<td bgcolor='#A9E2F3'>männlich</td>
									<td bgcolor='#A9E2F3'>$gesamt_0_17_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_18_64_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_65_79_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_80_99_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_65_99_m</td>
									<td rowspan=4 bgcolor='#A9E2F3'>1 : ",round(($gesamt_18_64_m/$gesamt_0_17_m),2),"<br>",round((($gesamt_0_17_m/$gesamt_18_64_m)*100),2)," %</td>
									<td rowspan=4 bgcolor='#A9E2F3'>1 : ",round(($gesamt_18_64_m/$gesamt_65_99_m),2),"<br>",round((($gesamt_65_99_m/$gesamt_18_64_m)*100),2)," %</td>
									<td rowspan=4 bgcolor='#A9E2F3'>1 : ",round(($gesamt_65_79_m/$gesamt_80_99_m),2),"<br>",round((($gesamt_80_99_m/$gesamt_65_79_m)*100),2)," %</td>
									<td rowspan=4 bgcolor='#A9E2F3'>"
?>
										<? if ($gesamt_0_17_m > $gesamt_65_99_m)
											echo '1 : ',round(($gesamt_0_17_m/$gesamt_65_99_m),2),'<br>',round((($gesamt_65_99_m/$gesamt_0_17_m)*100),2),' %';
											else echo '1 : ',round(($gesamt_65_99_m/$gesamt_0_17_m),2),'<br>',round((($gesamt_0_17_m/$gesamt_65_99_m)*100),2),' %';
										?>
<? echo"
									</td>
								</tr>
								<tr>
									<td>männlich % gegenüber männlich gesamt</td>
									<td>".round((($gesamt_0_17_m/$gesamt_m)*100),2)."</td>
									<td>".round((($gesamt_18_64_m/$gesamt_m)*100),2)."</td>
									<td>".round((($gesamt_65_79_m/$gesamt_m)*100),2)."</td>
									<td>".round((($gesamt_80_99_m/$gesamt_m)*100),2)."</td>
									<td>".round((($gesamt_65_99_m/$gesamt_m)*100),2)."</td>
								</tr>
								<tr>
									<td>männlich % gegenüber weiblich</td>
									<td>".round((($gesamt_0_17_m/$gesamt_0_17)*100),2)."</td>
									<td>".round((($gesamt_18_64_m/$gesamt_18_64)*100),2)."</td>
									<td>".round((($gesamt_65_79_m/$gesamt_65_79)*100),2)."</td>
									<td>".round((($gesamt_80_99_m/$gesamt_80_99)*100),2)."</td>
									<td>".round((($gesamt_65_99_m/$gesamt_65_99)*100),2)."</td>
								</tr>
								<tr>
									<td>männlich % an Gesamtbevölkerung</td>
									<td>".round((($gesamt_0_17_m/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_18_64_m/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_65_79_m/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_80_99_m/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_65_99_m/$gesamt)*100),2)."</td>
								</tr>
								<tr bgcolor='#F6CECE'>
									<td>weiblich</td>
									<td>$gesamt_0_17_w</td>
									<td>$gesamt_18_64_w</td>
									<td>$gesamt_65_79_w</td>
									<td>$gesamt_80_99_w</td>
									<td>$gesamt_65_99_w</td>
									<td rowspan=3>1 : ",round(($gesamt_18_64_w/$gesamt_0_17_w),2),"<br>",round((($gesamt_0_17_w/$gesamt_18_64_w)*100),2)," %</td>
									<td rowspan=3>1 : ",round(($gesamt_18_64_w/$gesamt_65_99_w),2),"<br>",round((($gesamt_65_99_w/$gesamt_18_64_w)*100),2)," %</td>
									<td rowspan=3>1 : ",round(($gesamt_65_79_w/$gesamt_80_99_w),2),"<br>",round((($gesamt_80_99_w/$gesamt_65_79_w)*100),2)," %</td>
									<td rowspan=3>"
?>
										<? if ($gesamt_0_17_w > $gesamt_65_99_w)
											echo '1 : ',round(($gesamt_0_17_w/$gesamt_65_99_w),2),'<br>',round((($gesamt_65_99_w/$gesamt_0_17_w)*100),2),' %';
											else echo '1 : ',round(($gesamt_65_99_w/$gesamt_0_17_w),2),'<br>',round((($gesamt_0_17_w/$gesamt_65_99_w)*100),2),' %';
										?>
<? echo"
									</td>
								</tr>
								<tr>
									<td>weiblich %</td>
									<td>".round((($gesamt_0_17_w/$gesamt_0_17)*100),2)."</td>
									<td>".round((($gesamt_18_64_w/$gesamt_18_64)*100),2)."</td>
									<td>".round((($gesamt_65_79_w/$gesamt_65_79)*100),2)."</td>
									<td>".round((($gesamt_80_99_w/$gesamt_80_99)*100),2)."</td>
									<td>".round((($gesamt_65_99_w/$gesamt_65_99)*100),2)."</td>									
								</tr>
								<tr>
									<td>weiblich % an Gesamtbevölkerung</td>
									<td>".round((($gesamt_0_17_w/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_18_64_w/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_65_79_w/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_80_99_w/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_65_99_w/$gesamt)*100),2)."</td>									
								</tr>
								<tr bgcolor='#F3E2A9'>
									<td>gesamt</td>
									<td>$gesamt_0_17</td>
									<td>$gesamt_18_64</td>
									<td>$gesamt_65_79</td>
									<td>$gesamt_80_99</td>
									<td>$gesamt_65_99</td>
									<td rowspan=2>1 : ",round(($gesamt_18_64/$gesamt_0_17),2),"<br>",round((($gesamt_0_17/$gesamt_18_64)*100),2)," %</td>
									<td rowspan=2>1 : ",round(($gesamt_18_64/$gesamt_65_99),2),"<br>",round((($gesamt_65_99/$gesamt_18_64)*100),2)," %</td>
									<td rowspan=2>1 : ",round(($gesamt_65_79/$gesamt_80_99),2),"<br>",round((($gesamt_80_99/$gesamt_65_79)*100),2)," %</td>
									<td rowspan=2>"
?>
										<? if ($gesamt_0_17 > $gesamt_65_99)
											echo '1 : ',round(($gesamt_0_17/$gesamt_65_99),2),'<br>',round((($gesamt_65_99/$gesamt_0_17)*100),2),' %';
											else echo '1 : ',round(($gesamt_65_99/$gesamt_0_17),2),'<br>',round((($gesamt_0_17/$gesamt_65_99)*100),2),' %';
										?>
<? echo "
									</td>
								</tr>
								<tr>
									<td>gesamt % an Gesamtbevölkerung</td>
									<td>".round((($gesamt_0_17/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_18_64/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_65_79/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_80_99/$gesamt)*100),2)."</td>
									<td>".round((($gesamt_65_99/$gesamt)*100),2)."</td>									
								</tr>
							</table>
							</div>
						</td>";
?>	