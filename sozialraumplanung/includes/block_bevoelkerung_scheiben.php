<?php
	echo "
	<td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=11 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege11')\" title=\"aufklappen/zuklappen\"><b>Bevölkerung 10 Jahres Scheiben</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege11\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2></td>									
									<td>gesamte Bevölkerung</td>
									<td><a href=\"0_10.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">0-u10</a></td>
									<td><a href=\"10_20.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">10-u20</a></td>
									<td><a href=\"20_30.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">20-u30</a></td>
									<td><a href=\"30_40.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">30-u40</a></td>
									<td><a href=\"40_50.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">40-u50</a></td>
									<td><a href=\"50_60.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">50-u60</a></td>
									<td><a href=\"60_70.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">60-u70</a></td>
									<td><a href=\"70_80.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">70-u80</a></td>
									<td><a href=\"80_90.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">80-u90</a></td>
									<td><a href=\"90_100.php?amt=$amt_id\" target=\"_blank\" onclick=\"return popup(this.href)\">90-u100</a></td>
								</tr>
								<tr>
									<td rowspan=8 align=center width='5%'>2011</td>
									<td bgcolor='#A9E2F3'>männlich</td>
									<td bgcolor='#A9E2F3'>$gesamt_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_0_9_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_10_19_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_20_29_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_30_39_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_40_49_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_50_59_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_60_69_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_70_79_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_80_89_m</td>
									<td bgcolor='#A9E2F3'>$gesamt_90_99_m</td>
								</tr>
								<tr>
									<td>gegenüber weiblich</td>
									<td>".round((($gesamt_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_0_9_m/$gesamt_0_9)*100),2)." %</td>
									<td>".round((($gesamt_10_19_m/$gesamt_10_19)*100),2)." %</td>
									<td>".round((($gesamt_20_29_m/$gesamt_20_29)*100),2)." %</td>
									<td>".round((($gesamt_30_39_m/$gesamt_30_39)*100),2)." %</td>
									<td>".round((($gesamt_40_49_m/$gesamt_40_49)*100),2)." %</td>
									<td>".round((($gesamt_50_59_m/$gesamt_50_59)*100),2)." %</td>
									<td>".round((($gesamt_60_69_m/$gesamt_60_69)*100),2)." %</td>
									<td>".round((($gesamt_70_79_m/$gesamt_70_79)*100),2)." %</td>
									<td>".round((($gesamt_80_89_m/$gesamt_80_89)*100),2)." %</td>
									<td>".round((($gesamt_90_99_m/$gesamt_90_99)*100),2)." %</td>
								</tr>
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td></td>
									<td>".round((($gesamt_0_9_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_10_19_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_20_29_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_30_39_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_40_49_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_50_59_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_60_69_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_70_79_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_80_89_m/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_90_99_m/$gesamt)*100),2)." %</td>
								</tr>
								<tr bgcolor='#F6CECE'>
									<td>weiblich</td>
									<td>$gesamt_w</td>
									<td>$gesamt_0_9_w</td>
									<td>$gesamt_10_19_w</td>
									<td>$gesamt_20_29_w</td>
									<td>$gesamt_30_39_w</td>
									<td>$gesamt_40_49_w</td>
									<td>$gesamt_50_59_w</td>
									<td>$gesamt_60_69_w</td>
									<td>$gesamt_70_79_w</td>
									<td>$gesamt_80_89_w</td>
									<td>$gesamt_90_99_w</td>
								</tr>
								<tr>
									<td>gegenüber männlich</td>
									<td>".round((($gesamt_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_0_9_w/$gesamt_0_9)*100),2)." %</td>
									<td>".round((($gesamt_10_19_w/$gesamt_10_19)*100),2)." %</td>
									<td>".round((($gesamt_20_29_w/$gesamt_20_29)*100),2)." %</td>
									<td>".round((($gesamt_30_39_w/$gesamt_30_39)*100),2)." %</td>
									<td>".round((($gesamt_40_49_w/$gesamt_40_49)*100),2)." %</td>
									<td>".round((($gesamt_50_59_w/$gesamt_50_59)*100),2)." %</td>
									<td>".round((($gesamt_60_69_w/$gesamt_60_69)*100),2)." %</td>
									<td>".round((($gesamt_70_79_w/$gesamt_70_79)*100),2)." %</td>
									<td>".round((($gesamt_80_89_w/$gesamt_80_89)*100),2)." %</td>
									<td>".round((($gesamt_90_99_w/$gesamt_90_99)*100),2)." %</td>
								</tr>
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td></td>
									<td>".round((($gesamt_0_9_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_10_19_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_20_29_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_30_39_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_40_49_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_50_59_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_60_69_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_70_79_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_80_89_w/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_90_99_w/$gesamt)*100),2)." %</td>
								</tr>
								<tr bgcolor='#F3E2A9'>
									<td>gesamt</td>
									<td>$gesamt</td>
									<td>$gesamt_0_9</td>
									<td>$gesamt_10_19</td>
									<td>$gesamt_20_29</td>
									<td>$gesamt_30_39</td>
									<td>$gesamt_40_49</td>
									<td>$gesamt_50_59</td>
									<td>$gesamt_60_69</td>
									<td>$gesamt_70_79</td>
									<td>$gesamt_80_89</td>
									<td>$gesamt_90_99</td>
								</tr>
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td></td>
									<td>".round((($gesamt_0_9/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_10_19/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_20_29/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_30_39/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_40_49/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_50_59/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_60_69/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_70_79/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_80_89/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_90_99/$gesamt)*100),2)." %</td>
								</tr>
								</table>
							</div>
						</td>";
?>