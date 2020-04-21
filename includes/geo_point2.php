								<table border=0>
									<tr height="35">
										<td bgcolor=<? echo $header_farbe ;?> align=center valign=center width="350" valign=top><b><font size="+1" color=white>Geodätisches...</font></b></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $header_farbe ;?> align=center valign=center width="350"><font color=white>Objekt Position</font></td>
									</tr>
									<tr>
										<td>
											<table border="0" rules="none" width="100%">
												<tr>									
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>Gauß-Krüger<br>S42/83 3&deg; 4-Streifen<br>Krassowski</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>Gauß-Krüger<br>RD/83 3&deg; 4-Streifen<br>Bessel</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_s4283coordinates_lon($s4283);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_rd83coordinates_lon($rd83);?></b></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_s4283coordinates_lat($s4283);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_rd83coordinates_lat($rd83);?></b></td>
												</tr>												
												<tr>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>WGS84<br>(geografisch)</td>
													<td colspan=2 align=center bgcolor=<? echo $element_farbe ?>>UTM<br>ETRS89 6&deg; Zone-33<br>GRS80</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;östl. L.:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_long($geo);?></b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lon($utm);?></b></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;nördl. Br.:</td>
													<td><b>&nbsp;&nbsp;<? echo get_geocoordinates_lat($geo);?></b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;<? echo get_utmcoordinates_lat($utm);?></b></td>
												</tr>																							
											</table>
										</td>
									</tr>									
								</table>
