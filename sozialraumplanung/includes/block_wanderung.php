<?php
	echo "
	 <td colspan=4>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=11 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege16')\" title=\"aufklappen/zuklappen\"><b>Wanderung</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege16\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2></td>	
									<td>Einwohner</td>
									<td>Zuzüge</td>
									<td>Fortzüge</td>
									<td>Differenz</td>
									<td>Verhältnis</td>
								</tr>
								<tr>
									<td rowspan=10 align=center width='5%'>2011</td>
									<td>Anzahl</td>
									<td rowspan=2>$gesamt</td>
									<td>$gesamt_zuzuege</td>
									<td>$gesamt_fortzuege</td>
									<td>",$gesamt_zuzuege-$gesamt_fortzuege,"</td>
									<td rowspan=2>"
?>
										<? if ($gesamt_zuzuege > $gesamt_fortzuege)
											echo '1 : ',round(($gesamt_zuzuege/$gesamt_fortzuege),2),'<br>',round((($gesamt_fortzuege/$gesamt_zuzuege)*100),2),' %';
											else echo '1 : ',round(($gesamt_fortzuege/$gesamt_zuzuege),2),'<br>',round((($gesamt_zuzuege/$gesamt_fortzuege)*100),2),' %';
										?>
<? echo"
									</td>
								</tr>								
								<tr>
									<td>gegenüber Gesamtbevölkerung</td>
									<td>".round((($gesamt_zuzuege/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_fortzuege/$gesamt)*100),2)." %</td>
									<td>".round((($gesamt_zuzuege-$gesamt_fortzuege)/($gesamt)*100),2)." %</td>
								</tr>
							</table>
							</div>
						</td>";
?>	