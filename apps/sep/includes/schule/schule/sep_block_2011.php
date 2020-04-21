									<? if (empty($schuelerzahlen_2011[0]))
										{
											echo"<table border=0 width=100%>							
												<tr>
													<td align=center colspan=4>
														2011-09-09<br>keine Schul-Daten vorhanden zu diesem Stichtag<br>Schule entweder geschlossen oder zu diesem Zeitpunkt noch nicht eröffnet. 
													</td>										
												</tr>
											</table>";
										}
										else
										{
									?>													
											<table class="bordered">							
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_411')" title="aufklappen/zuklappen">2011-09-09</th>										
												</tr>
											</table>
										<div id="eintrag_411" style="display: none">
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_41')" title="aufklappen/zuklappen">Schuldaten</a></th>
												</tr>
											</table>
											<div id="eintrag_41" style="display: none">
												<table class="bordered">	
													<tr>
														<td>Bezeichnung:</td>
														<td colspan=21><?php echo $schulname_2011; ?></td>
													</tr>
													<tr>
														<td>Schul-ID:</td>
														<td colspan=21><?php echo $schul_id; ?></td>
													</tr>
													<tr>
														<td valign=top>Anschrift:</td>
														<td colspan=21><?php echo $anschrift_2011; ?></td>
													</tr>
													<tr>
														<td>Schulleiter:</td>
														<td colspan=21><?php echo $schulleiter_2011; ?></td>
													</tr>
													<?
														if ($schul_id_2011 = '75530240')
															{
																$teil=explode(';',$tel_2011);
																echo "<tr>
																		<td valign=top>Telefon:</td>
																		<td colspan=21>".$teil[0]."<br>".$teil[1]."</td>
																	</tr>";
															}
														else echo "<tr>
																		<td>Telefon:</td>
																		<td colspan=21>$tel_2011</td>
																	</tr>";
													?>									
													<tr>
														<td>Fax:</td>
														<td colspan=21><?php echo $fax_2011; ?></td>
													</tr>
													<tr>
														<td>E-Mail:</td>
														<td colspan=21><?php echo $mail_2011; ?></td>
													</tr>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_42')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Jahrgangsstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_42" style="display: none">
												<table border=0 width=100% class="bordered">
													<tr>
														<td rowspan=2></td>
														<td style="text-align:center;" colspan=7>Gesamtzahlen</td>
														<td style="text-align:center;" colspan=7>weiblich</td>
														<td style="text-align:center;" colspan=7>männlich</td>														
													</tr>
													<tr>
														<td></td>
														<td style="text-align:center;" colspan=3>Art der Einschulung</td>
														<td style="text-align:center;" colspan=3>Migrantenstatus</td>
														<td></td>
														<td style="text-align:center;" colspan=3>Art der Einschulung</td>
														<td style="text-align:center;" colspan=3>Migrantenstatus</td>
														<td></td>
														<td style="text-align:center;" colspan=3>Art der Einschulung</td>
														<td style="text-align:center;" colspan=3>Migrantenstatus</td>
													</tr>
													<tr>
														<td>Stufe</td>
														<td>gesamt</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtlinge</td>
														<td>weiblich</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtlinge</td>
														<td>männlich</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtlinge</td>
													</tr>
													<tr>
														<?php 										
														for($c_2011=0;$c_2011<$d_2011;$c_2011++)
															{ 
																echo "<td>",$schuelerjgst_2011[$c_2011][0],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][1],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][2],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][3],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][4],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][5],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][6],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][7],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][8],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][9],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][10],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][11],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][12],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][13],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][14],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][15],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][16],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][17],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][18],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][19],"</td>",
																"<td>",$schuelerjgst_2011[$c_2011][20],"</td>",																
																"<td>",$schuelerjgst_2011[$c_2011][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2011[0],"</td>",
																"<td>",$schuelerzahlen_2011[1],"</td>",
																"<td>",$schuelerzahlen_2011[2],"</td>",
																"<td>",$schuelerzahlen_2011[3],"</td>",
																"<td>",$schuelerzahlen_2011[4],"</td>",
																"<td>",$schuelerzahlen_2011[5],"</td>",
																"<td>",$schuelerzahlen_2011[6],"</td>",
																"<td>",$schuelerzahlen_2011[7],"</td>",
																"<td>",$schuelerzahlen_2011[8],"</td>",
																"<td>",$schuelerzahlen_2011[9],"</td>",
																"<td>",$schuelerzahlen_2011[10],"</td>",
																"<td>",$schuelerzahlen_2011[11],"</td>",
																"<td>",$schuelerzahlen_2011[12],"</td>",
																"<td>",$schuelerzahlen_2011[13],"</td>",
																"<td>",$schuelerzahlen_2011[14],"</td>",
																"<td>",$schuelerzahlen_2011[15],"</td>",
																"<td>",$schuelerzahlen_2011[16],"</td>",
																"<td>",$schuelerzahlen_2011[17],"</td>",
																"<td>",$schuelerzahlen_2011[18],"</td>",
																"<td>",$schuelerzahlen_2011[19],"</td>",
																"<td>",$schuelerzahlen_2011[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_43')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Klassenstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_43" style="display: none">
												<table class="bordered">
													<tr>
														<td rowspan=2></td>
														<td style="text-align:center;" colspan=7>Gesamtzahlen</td>
														<td style="text-align:center;" colspan=7>weiblich</td>
														<td style="text-align:center;" colspan=7>männlich</td>														
													</tr>
													<tr>
														<td></td>
														<td style="text-align:center;" colspan=3>Art der Einschulung</td>
														<td style="text-align:center;" colspan=3>Migrantenstatus</td>
														<td></td>
														<td style="text-align:center;" colspan=3>Art der Einschulung</td>
														<td style="text-align:center;" colspan=3>Migrantenstatus</td>
														<td></td>
														<td style="text-align:center;" colspan=3>Art der Einschulung</td>
														<td style="text-align:center;" colspan=3>Migrantenstatus</td>
													</tr>
													<tr>
														<td>Stufe</td>
														<td>gesamt</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtlinge</td>
														<td>weiblich</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtlinge</td>
														<td>männlich</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtlinge</td>
													</tr>
													<tr>
														<?php 										
														for($v_2011=0;$v_2011<$x_2011;$v_2011++)
															{ 
																echo "<td>",$schuelerklassen_2011[$v_2011][0],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][1],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][2],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][3],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][4],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][5],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][6],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][7],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][8],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][9],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][10],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][11],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][12],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][13],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][14],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][15],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][16],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][17],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][18],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][19],"</td>",
																"<td>",$schuelerklassen_2011[$v_2011][20],"</td>",																
																"<td>",$schuelerklassen_2011[$v_2011][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2011[0],"</td>",
																"<td>",$schuelerzahlen_2011[1],"</td>",
																"<td>",$schuelerzahlen_2011[2],"</td>",
																"<td>",$schuelerzahlen_2011[3],"</td>",
																"<td>",$schuelerzahlen_2011[4],"</td>",
																"<td>",$schuelerzahlen_2011[5],"</td>",
																"<td>",$schuelerzahlen_2011[6],"</td>",
																"<td>",$schuelerzahlen_2011[7],"</td>",
																"<td>",$schuelerzahlen_2011[8],"</td>",
																"<td>",$schuelerzahlen_2011[9],"</td>",
																"<td>",$schuelerzahlen_2011[10],"</td>",
																"<td>",$schuelerzahlen_2011[11],"</td>",
																"<td>",$schuelerzahlen_2011[12],"</td>",
																"<td>",$schuelerzahlen_2011[13],"</td>",
																"<td>",$schuelerzahlen_2011[14],"</td>",
																"<td>",$schuelerzahlen_2011[15],"</td>",
																"<td>",$schuelerzahlen_2011[16],"</td>",
																"<td>",$schuelerzahlen_2011[17],"</td>",
																"<td>",$schuelerzahlen_2011[18],"</td>",
																"<td>",$schuelerzahlen_2011[19],"</td>",
																"<td>",$schuelerzahlen_2011[20],"</td></tr>";																											
														?>
												</table>
											</div>
										</div>
										<? } ?>