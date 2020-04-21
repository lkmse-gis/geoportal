									<? if (empty($schuelerzahlen_2014[0]))
										{
											echo"<table border=0 width=100%>							
												<tr>
													<td align=center colspan=4>
														2014-09-23<br>keine Schul-Daten vorhanden zu diesem Stichtag<br>Schule entweder geschlossen oder zu diesem Zeitpunkt noch nicht eröffnet. 
													</td>										
												</tr>
											</table>";
										}
										else
										{
									?>	
											<table class="bordered">							
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_111')" title="aufklappen/zuklappen">2014-09-23</th>									
												</tr>
											</table>
										<div id="eintrag_111" style="display: none">
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_11')" title="aufklappen/zuklappen">Schuldaten</a></th>
												</tr>
											</table>
											<div id="eintrag_11" style="display: none">
												<table class="bordered">	
													<tr>
														<td>Bezeichnung:</td>
														<td colspan=21><?php echo $schulname_2014; ?></td>
													</tr>
													<tr>
														<td>Schul-ID:</td>
														<td colspan=21><?php echo $schul_id_2014; ?></td>
													</tr>
													<tr>
														<td valign=top>Anschrift:</td>
														<td colspan=21><?php echo $anschrift_2014; ?></td>
													</tr>
													<tr>
														<td>Schulleiter:</td>
														<td colspan=21><?php echo $schulleiter_2014; ?></td>
													</tr>
													<?
														if ($schul_id = '75530240')
															{
																$teil=explode(';',$tel_2014);
																echo "<tr>
																		<td valign=top>Telefon:</td>
																		<td colspan=21>".$teil[0]."<br>".$teil[1]."</td>
																	</tr>";
															}
														else echo "<tr>
																		<td>Telefon:</td>
																		<td colspan=21>$tel_2014</td>
																	</tr>";
													?>									
													<tr>
														<td>Fax:</td>
														<td colspan=21><?php echo $fax_2014; ?></td>
													</tr>
													<tr>
														<td>E-Mail:</td>
														<td colspan=21><?php echo $mail_2014; ?></td>
													</tr>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_12')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Jahrgangsstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_12" style="display: none">
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
														for($c_2014=0;$c_2014<$d_2014;$c_2014++)
															{ 
																echo "<td>",$schuelerjgst_2014[$c_2014][0],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][1],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][2],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][3],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][4],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][5],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][6],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][7],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][8],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][9],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][10],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][11],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][12],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][13],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][14],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][15],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][16],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][17],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][18],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][19],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][20],"</td>",																
																"<td>",$schuelerjgst_2014[$c_2014][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2014[0],"</td>",
																"<td>",$schuelerzahlen_2014[1],"</td>",
																"<td>",$schuelerzahlen_2014[2],"</td>",
																"<td>",$schuelerzahlen_2014[3],"</td>",
																"<td>",$schuelerzahlen_2014[4],"</td>",
																"<td>",$schuelerzahlen_2014[5],"</td>",
																"<td>",$schuelerzahlen_2014[6],"</td>",
																"<td>",$schuelerzahlen_2014[7],"</td>",
																"<td>",$schuelerzahlen_2014[8],"</td>",
																"<td>",$schuelerzahlen_2014[9],"</td>",
																"<td>",$schuelerzahlen_2014[10],"</td>",
																"<td>",$schuelerzahlen_2014[11],"</td>",
																"<td>",$schuelerzahlen_2014[12],"</td>",
																"<td>",$schuelerzahlen_2014[13],"</td>",
																"<td>",$schuelerzahlen_2014[14],"</td>",
																"<td>",$schuelerzahlen_2014[15],"</td>",
																"<td>",$schuelerzahlen_2014[16],"</td>",
																"<td>",$schuelerzahlen_2014[17],"</td>",
																"<td>",$schuelerzahlen_2014[18],"</td>",
																"<td>",$schuelerzahlen_2014[19],"</td>",
																"<td>",$schuelerzahlen_2014[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_13')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Klassenstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_13" style="display: none">
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
														for($v_2014=0;$v_2014<$x_2014;$v_2014++)
															{ 
																echo "<td>",$schuelerklassen_2014[$v_2014][0],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][1],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][2],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][3],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][4],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][5],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][6],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][7],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][8],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][9],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][10],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][11],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][12],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][13],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][14],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][15],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][16],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][17],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][18],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][19],"</td>",
																"<td>",$schuelerklassen_2014[$v_2014][20],"</td>",																
																"<td>",$schuelerklassen_2014[$v_2014][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2014[0],"</td>",
																"<td>",$schuelerzahlen_2014[1],"</td>",
																"<td>",$schuelerzahlen_2014[2],"</td>",
																"<td>",$schuelerzahlen_2014[3],"</td>",
																"<td>",$schuelerzahlen_2014[4],"</td>",
																"<td>",$schuelerzahlen_2014[5],"</td>",
																"<td>",$schuelerzahlen_2014[6],"</td>",
																"<td>",$schuelerzahlen_2014[7],"</td>",
																"<td>",$schuelerzahlen_2014[8],"</td>",
																"<td>",$schuelerzahlen_2014[9],"</td>",
																"<td>",$schuelerzahlen_2014[10],"</td>",
																"<td>",$schuelerzahlen_2014[11],"</td>",
																"<td>",$schuelerzahlen_2014[12],"</td>",
																"<td>",$schuelerzahlen_2014[13],"</td>",
																"<td>",$schuelerzahlen_2014[14],"</td>",
																"<td>",$schuelerzahlen_2014[15],"</td>",
																"<td>",$schuelerzahlen_2014[16],"</td>",
																"<td>",$schuelerzahlen_2014[17],"</td>",
																"<td>",$schuelerzahlen_2014[18],"</td>",
																"<td>",$schuelerzahlen_2014[19],"</td>",
																"<td>",$schuelerzahlen_2014[20],"</td></tr>";																											
														?>
												</table>
											</div>
										</div>
											<? } ?>