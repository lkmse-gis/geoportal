<?php
	echo "
	 <td valign=top align=left width='25%'>
							<table width='100%' border='1' cellpadding='3' cellspacing='0'>
								<tr bgcolor='#BDBDBD'>
									<td align=center colspan=2 height=50>
										<a href=\"#\" onclick=\"klappe('eintraege')\" title=\"aufklappen/zuklappen\"><b>Allgemeines</b></a>
									</td>							
								</tr>
							</table>
							<div id=\"eintraege\" style=\"display: none\">
								<table width='100%' border='1' cellpadding='3' cellspacing='0'>
									<tr>
										<td>Amtsvorsteher</td>
										<td>".$amtsvorsteher."</td>
									</tr>
									<tr>
										<td>Fläche</td>
										<td>".$flaeche." km²</td>
									</tr>
									<tr>
										<td>Einwohner</td>
										<td>".$gesamt."</td>
									</tr>
									<tr>
										<td>Einwohner/km</td>
										<td>".round($gesamt/$flaeche,2)." Einwohner pro km²</td>
									</tr>
								</table>
							</div>
						</td>";
?>	