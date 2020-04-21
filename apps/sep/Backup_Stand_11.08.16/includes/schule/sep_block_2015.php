									<? if (empty($schuelerzahlen_2015[0]))
										{
											echo"<table border=0 width=100%>							
												<tr>
													<td align=center colspan=4>
														2015-09-30<br>keine Schul-Daten vorhanden zu diesem Stichtag<br>Schule entweder geschlossen oder zu diesem Zeitpunkt noch nicht eröffnet. 
													</td>										
												</tr>
											</table>";
										}
										else
										{
									?>	
										<table class="bordered">							
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_11')" title="aufklappen/zuklappen">2015-09-30</th>									
												</tr>
											</table>
										<div id="eintrag_11" style="display: none">
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_1')" title="aufklappen/zuklappen">Schuldaten</a></th>
												</tr>
											</table>
											<div id="eintrag_1" style="display: none">
												<table class="bordered">	
													<tr>
														<td>Bezeichnung:</td>
														<td colspan=21><?php echo $schulname_2015; ?></td>
													</tr>
													<tr>
														<td>Schul-ID:</td>
														<td colspan=21><?php echo $schul_id_2015; ?></td>
													</tr>
													<tr>
														<td valign=top>Anschrift:</td>
														<td colspan=21><?php echo $anschrift_2015; ?></td>
													</tr>
													<tr>
														<td>Schulleiter:</td>
														<td colspan=21><?php echo $schulleiter_2015; ?></td>
													</tr>
													<?
														if ($schul_id = '75530240')
															{
																$teil=explode(';',$tel_2015);
																echo "<tr>
																		<td valign=top>Telefon:</td>
																		<td colspan=21>".$teil[0]."<br>".$teil[1]."</td>
																	</tr>";
															}
														else echo "<tr>
																		<td>Telefon:</td>
																		<td colspan=21>$tel_2015</td>
																	</tr>";
													?>									
													<tr>
														<td>Fax:</td>
														<td colspan=21><?php echo $fax_2015; ?></td>
													</tr>
													<tr>
														<td>E-Mail:</td>
														<td colspan=21><?php echo $mail_2015; ?></td>
													</tr>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_2')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Jahrgangsstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_2" style="display: none">
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
														for($c_2015=0;$c_2015<$d_2015;$c_2015++)
															{ 
																echo "<td>",$schuelerjgst_2015[$c_2015][0],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][1],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][2],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][3],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][4],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][5],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][6],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][7],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][8],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][9],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][10],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][11],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][12],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][13],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][14],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][15],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][16],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][17],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][18],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][19],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][20],"</td>",
																"<td>",$schuelerjgst_2015[$c_2015][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2015[0],"</td>",
																"<td>",$schuelerzahlen_2015[1],"</td>",
																"<td>",$schuelerzahlen_2015[2],"</td>",
																"<td>",$schuelerzahlen_2015[3],"</td>",
																"<td>",$schuelerzahlen_2015[4],"</td>",
																"<td>",$schuelerzahlen_2015[5],"</td>",
																"<td>",$schuelerzahlen_2015[6],"</td>",
																"<td>",$schuelerzahlen_2015[7],"</td>",
																"<td>",$schuelerzahlen_2015[8],"</td>",
																"<td>",$schuelerzahlen_2015[9],"</td>",
																"<td>",$schuelerzahlen_2015[10],"</td>",
																"<td>",$schuelerzahlen_2015[11],"</td>",
																"<td>",$schuelerzahlen_2015[12],"</td>",
																"<td>",$schuelerzahlen_2015[13],"</td>",
																"<td>",$schuelerzahlen_2015[14],"</td>",
																"<td>",$schuelerzahlen_2015[15],"</td>",
																"<td>",$schuelerzahlen_2015[16],"</td>",
																"<td>",$schuelerzahlen_2015[17],"</td>",
																"<td>",$schuelerzahlen_2015[18],"</td>",
																"<td>",$schuelerzahlen_2015[19],"</td>",
																"<td>",$schuelerzahlen_2015[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_3')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Klassenstufen</a></th>
												</tr>
											</table>
											<div id="eintrag_3" style="display: none">
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
														for($v_2015=0;$v_2015<$x_2015;$v_2015++)
															{ 
																echo "<td>",$schuelerklassen_2015[$v_2015][0],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][1],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][2],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][3],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][4],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][5],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][6],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][7],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][8],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][9],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][10],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][11],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][12],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][13],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][14],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][15],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][16],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][17],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][18],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][19],"</td>",
																"<td>",$schuelerklassen_2015[$v_2015][20],"</td>",																
																"<td>",$schuelerklassen_2015[$v_2015][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2015[0],"</td>",
																"<td>",$schuelerzahlen_2015[1],"</td>",
																"<td>",$schuelerzahlen_2015[2],"</td>",
																"<td>",$schuelerzahlen_2015[3],"</td>",
																"<td>",$schuelerzahlen_2015[4],"</td>",
																"<td>",$schuelerzahlen_2015[5],"</td>",
																"<td>",$schuelerzahlen_2015[6],"</td>",
																"<td>",$schuelerzahlen_2015[7],"</td>",
																"<td>",$schuelerzahlen_2015[8],"</td>",
																"<td>",$schuelerzahlen_2015[9],"</td>",
																"<td>",$schuelerzahlen_2015[10],"</td>",
																"<td>",$schuelerzahlen_2015[11],"</td>",
																"<td>",$schuelerzahlen_2015[12],"</td>",
																"<td>",$schuelerzahlen_2015[13],"</td>",
																"<td>",$schuelerzahlen_2015[14],"</td>",
																"<td>",$schuelerzahlen_2015[15],"</td>",
																"<td>",$schuelerzahlen_2015[16],"</td>",
																"<td>",$schuelerzahlen_2015[17],"</td>",
																"<td>",$schuelerzahlen_2015[18],"</td>",
																"<td>",$schuelerzahlen_2015[19],"</td>",
																"<td>",$schuelerzahlen_2015[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_4')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Gemeinden</a></th>
												</tr>
											</table>
											<div id="eintrag_4" style="display: none">
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
														<td>Gemeinde</td>
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
														for($a_2015=0;$a_2015<$b_2015;$a_2015++)
															{ 
																echo "<td>",$schuelergkz_2015[$a_2015][1],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][2],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][3],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][4],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][5],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][6],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][7],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][8],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][9],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][10],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][11],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][12],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][13],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][14],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][15],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][16],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][17],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][18],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][19],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][20],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][21],"</td>",
																"<td>",$schuelergkz_2015[$a_2015][22],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2015[0],"</td>",
																"<td>",$schuelerzahlen_2015[1],"</td>",
																"<td>",$schuelerzahlen_2015[2],"</td>",
																"<td>",$schuelerzahlen_2015[3],"</td>",
																"<td>",$schuelerzahlen_2015[4],"</td>",
																"<td>",$schuelerzahlen_2015[5],"</td>",
																"<td>",$schuelerzahlen_2015[6],"</td>",
																"<td>",$schuelerzahlen_2015[7],"</td>",
																"<td>",$schuelerzahlen_2015[8],"</td>",
																"<td>",$schuelerzahlen_2015[9],"</td>",
																"<td>",$schuelerzahlen_2015[10],"</td>",
																"<td>",$schuelerzahlen_2015[11],"</td>",
																"<td>",$schuelerzahlen_2015[12],"</td>",
																"<td>",$schuelerzahlen_2015[13],"</td>",
																"<td>",$schuelerzahlen_2015[14],"</td>",
																"<td>",$schuelerzahlen_2015[15],"</td>",
																"<td>",$schuelerzahlen_2015[16],"</td>",
																"<td>",$schuelerzahlen_2015[17],"</td>",
																"<td>",$schuelerzahlen_2015[18],"</td>",
																"<td>",$schuelerzahlen_2015[19],"</td>",
																"<td>",$schuelerzahlen_2015[20],"</td>",																
																"<td>",$schuelerzahlen_2015[21],"</td></tr>";																											
														?>
												</table>
											</div>
										</div>
											<? } ?>