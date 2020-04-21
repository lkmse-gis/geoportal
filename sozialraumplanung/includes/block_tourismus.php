<?php
	echo "
	 <td valign=top align=left width='25%'>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=2 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege4')\" title=\"aufklappen/zuklappen\"><b>Tourismus</b></a>							
									</td>							
								</tr>
							</table>
							<div id=\"eintraege4\" style=\"display: none\">
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr>
									<td>Badestellen</td>
									<td>$badestellen</td>
								</tr>
								<tr>
									<td>Kirchen</td>
									<td>$kirchen</td>
								</tr>
								<tr>
									<td>Tourist-Informationen</td>
									<td>$touristinfos</td>
								</tr>
							</table>
							</div>
						</td>";
?>	