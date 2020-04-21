<?php
	echo "
	 <td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=11 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege14')\" title=\"aufklappen/zuklappen\"><b>Geburten- Sterbedaten</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege14\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2></td>			
									<td>lebend geboren</td>
									<td>verstorben</td>
									<td>Differenz</td>
									<td>Verhältnis</td>
								</tr>
								<tr>
									<td rowspan=10 align=center width='5%'>2011</td>
									<td bgcolor='#A9E2F3'>männlich</td>
									<td bgcolor='#A9E2F3'>$gesamt_lebend_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_tot_m</td>
									<td bgcolor='#A9E2F3'>",$gesamt_lebend_m-$gesamt_tot_m,"</td>
									<td bgcolor='#A9E2F3' rowspan=4>"
?>
										<? if ($gesamt_lebend_m > $gesamt_tot_m)
											echo '1 : ',round(($gesamt_lebend_m/$gesamt_tot_m),2),'<br>',round((($gesamt_tot_m/$gesamt_lebend_m)*100),2),' %';
											else echo '1 : ',round(($gesamt_tot_m/$gesamt_lebend_m),2),'<br>',round((($gesamt_lebend_m/$gesamt_tot_m)*100),2),' %';
										?>
<? echo"
									</td>
								</tr>
								<tr>
									<td>gegenüber gesamt männlich</td>
									<td>".round((($gesamt_lebend_m/$gesamt_m)*100),2)." %</td>
									<td>".round((($gesamt_tot_m/$gesamt_m)*100),2)." %</td>
									<td>".round((($gesamt_lebend_m-$gesamt_tot_m)/($gesamt_m)*100),2)." %</td>
								</tr>
								<tr>
									<td>gegenüber weiblich</td>
									<td>".round((($gesamt_lebend_m/$gesamt_lebend)*100),2)." %</td>
									<td>".round((($gesamt_tot_m/$gesamt_tot)*100),2)." %</td>
									<td></td>
								</tr>
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td>".round((($gesamt_lebend_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_tot_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_lebend_m-$gesamt_tot_m)/($gesamt)*100),2)." %</td>
								</tr>
								<tr bgcolor='#F6CECE'>
									<td>weiblich</td>
									<td>$gesamt_lebend_w</td>
									<td>$gesamt_tot_w</td>
									<td>",$gesamt_lebend_w-$gesamt_tot_w,"</td>
									<td rowspan=4>"
?>
										<? if ($gesamt_lebend_w > $gesamt_tot_w)
											echo '1 : ',round(($gesamt_lebend_w/$gesamt_tot_w),2),'<br>',round((($gesamt_tot_w/$gesamt_lebend_w)*100),2),' %';
											else echo '1 : ',round(($gesamt_tot_w/$gesamt_lebend_w),2),'<br>',round((($gesamt_lebend_w/$gesamt_tot_w)*100),2),' %';
										?>
<? echo "
									</td>
								</tr>
								<tr>
									<td>gegenüber gesamt weiblich</td>
									<td>".round((($gesamt_lebend_w/$gesamt_w)*100),2)." %</td>
									<td>".round((($gesamt_tot_w/$gesamt_w)*100),2)." %</td>
									<td>".round((($gesamt_lebend_w-$gesamt_tot_w)/($gesamt_w)*100),2)." %</td>
								</tr>
								<tr>
									<td>gegenüber männlich</td>
									<td>".round((($gesamt_lebend_w/$gesamt_lebend)*100),2)." %</td>
									<td>".round((($gesamt_tot_w/$gesamt_tot)*100),2)." %</td>
									<td></td>
								</tr>
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td>".round((($gesamt_lebend_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_tot_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_lebend_w-$gesamt_tot_w)/($gesamt)*100),2)." %</td>
								</tr>
								<tr bgcolor='#F3E2A9'>
									<td>gesamt</td>
									<td>$gesamt_lebend</td>
									<td>$gesamt_tot</td>
									<td>",$gesamt_lebend-$gesamt_tot,"</td>
									<td rowspan=2>"
?>						
										<? if ($gesamt_lebend > $gesamt_tot)
											echo '1 : ',round(($gesamt_lebend/$gesamt_tot),2),'<br>',round((($gesamt_tot/$gesamt_lebend)*100),2),' %';
											else echo '1 : ',round(($gesamt_tot/$gesamt_lebend),2),'<br>',round((($gesamt_lebend/$gesamt_tot)*100),2),' %';
										?>
<? echo "
									</td>
								</tr>
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td>".round((($gesamt_lebend/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_tot/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_lebend-$gesamt_tot)/($gesamt)*100),2)." %</td>
								</tr>
							</table>
							</div>
						</td>";
?>	