<?php
	echo "
	 <td valign=top align=left width='25%'>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=3 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege3')\" title=\"aufklappen/zuklappen\"><b>Bau</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege3\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td colspan=2>Baudenkmale</td>
									<td>$baudenkmale</td>
								</tr>
								<tr>
									<td rowspan=4>Bebauungspläne</td>
									<td>rechtskräftig</td>"
?>
<?
									 if ($bplan_rk == '') echo "<td>k.A.</td>";
										else echo "<td>$bplan_rk</td>";
?>
<?
	echo "
								</tr>
								<tr>
									<td>im Verfahren</td>
									<td>$bplan_iv</td>
								</tr>
								<tr>
									<td>Verfahren eingestellt</td>
									<td>$bplan_ve</td>
								</tr>
								<tr>
									<td>Plan aufgehoben</td>
									<td>$bplan_pa</td>
								</tr>
							</table>
							</div>
						</td>";
?>	