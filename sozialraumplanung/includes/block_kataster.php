<?php
	echo "
	 <td valign=top align=left width='25%'>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=2 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege2')\" title=\"aufklappen/zuklappen\"><b>Kataster</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege2\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td>Grenzlänge</td>
									<td>$grenzlaenge km</td>
								</tr>
								<tr>
									<td>Mittelpunkt</td>
									<td>$mittelpunkt</td>
								</tr>
								<tr>
									<td>Gemeinden</td>
									<td>$gemeinden</td>
								</tr>
								<tr>
									<td>Gemarkungen</td>
									<td>$gemarkungen</td>
								</tr>
								<tr>
									<td>Fluren</td>
									<td>$fluren</td>
								</tr>
								<tr>
									<td>Flurstücke</td>
									<td>$flurstuecke</td>
								</tr>
							</table>
							</div>
						</td>";
?>	