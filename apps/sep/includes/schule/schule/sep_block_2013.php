									<? if (empty($schuelerzahlen_2013[0]))
										{
											echo"<table border=0 width=100%>							
												<tr>
													<td align=center colspan=4>
														2013-09-10<br>keine Schul-Daten vorhanden zu diesem Stichtag<br>Schule entweder geschlossen oder zu diesem Zeitpunkt noch nicht eröffnet. 
													</td>										
												</tr>
											</table>";
										}
										else
										{
									?>		
											<table class="bordered">							
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_211')" title="aufklappen/zuklappen">2013-09-10</th>									
												</tr>
											</table>
										<div id="eintrag_211" style="display: none">
											<table class="bordered">											
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_21')" title="aufklappen/zuklappen">Schuldaten</a></th>
												</tr>
											</table>
											<div id="eintrag_21" style="display: none">
												<table class="bordered">	
													<tr>
														<td>Bezeichnung:</td>
														<td colspan=21><?php echo $schulname_2013; ?></td>
													</tr>
													<tr>
														<td>Schul-ID:</td>
														<td colspan=21><?php echo $schul_id; ?></td>
													</tr>
													<tr>
														<td valign=top>Anschrift:</td>
														<td colspan=21><?php echo $anschrift_2013; ?></td>
													</tr>
													<tr>
														<td>Schulleiter:</td>
														<td colspan=21><?php echo $schulleiter_2013; ?></td>
													</tr>
													<?
														if ($schul_id_2013 = '75530240')
															{
																$teil=explode(';',$tel_2013);
																echo "<tr>
																		<td valign=top>Telefon:</td>
																		<td colspan=21>".$teil[0]."<br>".$teil[1]."</td>
																	</tr>";
															}
														else echo "<tr>
																		<td>Telefon:</td>
																		<td colspan=21>$tel_2013</td>
																	</tr>";
													?>									
													<tr>
														<td>Fax:</td>
														<td colspan=21><?php echo $fax_2013; ?></td>
													</tr>
													<tr>
														<td>E-Mail:</td>
														<td colspan=21><?php echo $mail_2013; ?></td>
													</tr>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_22')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Jahrgangsstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_22" style="display: none">
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
														for($c_2013=0;$c_2013<$d_2013;$c_2013++)
															{ 
																echo "<td>",$schuelerjgst_2013[$c_2013][0],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][1],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][2],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][3],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][4],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][5],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][6],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][7],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][8],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][9],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][10],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][11],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][12],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][13],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][14],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][15],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][16],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][17],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][18],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][19],"</td>",
																"<td>",$schuelerjgst_2013[$c_2013][20],"</td>",																
																"<td>",$schuelerjgst_2013[$c_2013][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2013[0],"</td>",
																"<td>",$schuelerzahlen_2013[1],"</td>",
																"<td>",$schuelerzahlen_2013[2],"</td>",
																"<td>",$schuelerzahlen_2013[3],"</td>",
																"<td>",$schuelerzahlen_2013[4],"</td>",
																"<td>",$schuelerzahlen_2013[5],"</td>",
																"<td>",$schuelerzahlen_2013[6],"</td>",
																"<td>",$schuelerzahlen_2013[7],"</td>",
																"<td>",$schuelerzahlen_2013[8],"</td>",
																"<td>",$schuelerzahlen_2013[9],"</td>",
																"<td>",$schuelerzahlen_2013[10],"</td>",
																"<td>",$schuelerzahlen_2013[11],"</td>",
																"<td>",$schuelerzahlen_2013[12],"</td>",
																"<td>",$schuelerzahlen_2013[13],"</td>",
																"<td>",$schuelerzahlen_2013[14],"</td>",
																"<td>",$schuelerzahlen_2013[15],"</td>",
																"<td>",$schuelerzahlen_2013[16],"</td>",
																"<td>",$schuelerzahlen_2013[17],"</td>",
																"<td>",$schuelerzahlen_2013[18],"</td>",
																"<td>",$schuelerzahlen_2013[19],"</td>",
																"<td>",$schuelerzahlen_2013[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_23')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Klassenstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_23" style="display: none">
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
														for($v_2013=0;$v_2013<$x_2013;$v_2013++)
															{ 
																echo "<td>",$schuelerklassen_2013[$v_2013][0],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][1],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][2],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][3],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][4],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][5],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][6],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][7],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][8],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][9],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][10],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][11],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][12],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][13],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][14],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][15],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][16],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][17],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][18],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][19],"</td>",
																"<td>",$schuelerklassen_2013[$v_2013][20],"</td>",																
																"<td>",$schuelerklassen_2013[$v_2013][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2013[0],"</td>",
																"<td>",$schuelerzahlen_2013[1],"</td>",
																"<td>",$schuelerzahlen_2013[2],"</td>",
																"<td>",$schuelerzahlen_2013[3],"</td>",
																"<td>",$schuelerzahlen_2013[4],"</td>",
																"<td>",$schuelerzahlen_2013[5],"</td>",
																"<td>",$schuelerzahlen_2013[6],"</td>",
																"<td>",$schuelerzahlen_2013[7],"</td>",
																"<td>",$schuelerzahlen_2013[8],"</td>",
																"<td>",$schuelerzahlen_2013[9],"</td>",
																"<td>",$schuelerzahlen_2013[10],"</td>",
																"<td>",$schuelerzahlen_2013[11],"</td>",
																"<td>",$schuelerzahlen_2013[12],"</td>",
																"<td>",$schuelerzahlen_2013[13],"</td>",
																"<td>",$schuelerzahlen_2013[14],"</td>",
																"<td>",$schuelerzahlen_2013[15],"</td>",
																"<td>",$schuelerzahlen_2013[16],"</td>",
																"<td>",$schuelerzahlen_2013[17],"</td>",
																"<td>",$schuelerzahlen_2013[18],"</td>",
																"<td>",$schuelerzahlen_2013[19],"</td>",
																"<td>",$schuelerzahlen_2013[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<? } ?>