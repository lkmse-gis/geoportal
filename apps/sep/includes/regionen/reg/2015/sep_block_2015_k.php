										<table class="bordered">							
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2015_11')" title="aufklappen/zuklappen">2015-09-30</th>									
												</tr>
										</table>
										<div id="_2015_11" style="display: none">											
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('_2015_2')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a></th>
												</tr>
											</table>
											<div id="_2015_2" style="display: none">
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
														for($z_2015=0;$z_2015<$a_2015;$z_2015++)
															{ 
																echo "<td>",$schuelerjgst_2015_k[$z_2015][0],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][1],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][2],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][3],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][4],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][5],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][6],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][7],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][8],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][9],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][10],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][11],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][12],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][13],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][14],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][15],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][16],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][17],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][18],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][19],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][20],"</td>",
																"<td>",$schuelerjgst_2015_k[$z_2015][21],"</td></tr>";
															};
														?>
														<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2015_k[0],"</td>",
																"<td>",$schuelerzahlen_2015_k[1],"</td>",
																"<td>",$schuelerzahlen_2015_k[2],"</td>",
																"<td>",$schuelerzahlen_2015_k[3],"</td>",
																"<td>",$schuelerzahlen_2015_k[4],"</td>",
																"<td>",$schuelerzahlen_2015_k[5],"</td>",
																"<td>",$schuelerzahlen_2015_k[6],"</td>",
																"<td>",$schuelerzahlen_2015_k[7],"</td>",
																"<td>",$schuelerzahlen_2015_k[8],"</td>",
																"<td>",$schuelerzahlen_2015_k[9],"</td>",
																"<td>",$schuelerzahlen_2015_k[10],"</td>",
																"<td>",$schuelerzahlen_2015_k[11],"</td>",
																"<td>",$schuelerzahlen_2015_k[12],"</td>",
																"<td>",$schuelerzahlen_2015_k[13],"</td>",
																"<td>",$schuelerzahlen_2015_k[14],"</td>",
																"<td>",$schuelerzahlen_2015_k[15],"</td>",
																"<td>",$schuelerzahlen_2015_k[16],"</td>",
																"<td>",$schuelerzahlen_2015_k[17],"</td>",
																"<td>",$schuelerzahlen_2015_k[18],"</td>",
																"<td>",$schuelerzahlen_2015_k[19],"</td>",
																"<td>",$schuelerzahlen_2015_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2015_3')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Schularten der Schule</a></th>
												</tr>
											</table>
											<div id="_2015_3" style="display: none">
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
														for($z_2015=0;$z_2015<$b_2015;$z_2015++)
															{ 
																echo "<td>",$schularten_2015_k[$z_2015][0],"</td>",
																"<td>",$schularten_2015_k[$z_2015][1],"</td>",
																"<td>",$schularten_2015_k[$z_2015][2],"</td>",
																"<td>",$schularten_2015_k[$z_2015][3],"</td>",
																"<td>",$schularten_2015_k[$z_2015][4],"</td>",
																"<td>",$schularten_2015_k[$z_2015][5],"</td>",
																"<td>",$schularten_2015_k[$z_2015][6],"</td>",
																"<td>",$schularten_2015_k[$z_2015][7],"</td>",
																"<td>",$schularten_2015_k[$z_2015][8],"</td>",
																"<td>",$schularten_2015_k[$z_2015][9],"</td>",
																"<td>",$schularten_2015_k[$z_2015][10],"</td>",
																"<td>",$schularten_2015_k[$z_2015][11],"</td>",
																"<td>",$schularten_2015_k[$z_2015][12],"</td>",
																"<td>",$schularten_2015_k[$z_2015][13],"</td>",
																"<td>",$schularten_2015_k[$z_2015][14],"</td>",
																"<td>",$schularten_2015_k[$z_2015][15],"</td>",
																"<td>",$schularten_2015_k[$z_2015][16],"</td>",
																"<td>",$schularten_2015_k[$z_2015][17],"</td>",
																"<td>",$schularten_2015_k[$z_2015][18],"</td>",
																"<td>",$schularten_2015_k[$z_2015][19],"</td>",
																"<td>",$schularten_2015_k[$z_2015][20],"</td>",																
																"<td>",$schularten_2015_k[$z_2015][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2015_k[0],"</td>",
																"<td>",$schuelerzahlen_2015_k[1],"</td>",
																"<td>",$schuelerzahlen_2015_k[2],"</td>",
																"<td>",$schuelerzahlen_2015_k[3],"</td>",
																"<td>",$schuelerzahlen_2015_k[4],"</td>",
																"<td>",$schuelerzahlen_2015_k[5],"</td>",
																"<td>",$schuelerzahlen_2015_k[6],"</td>",
																"<td>",$schuelerzahlen_2015_k[7],"</td>",
																"<td>",$schuelerzahlen_2015_k[8],"</td>",
																"<td>",$schuelerzahlen_2015_k[9],"</td>",
																"<td>",$schuelerzahlen_2015_k[10],"</td>",
																"<td>",$schuelerzahlen_2015_k[11],"</td>",
																"<td>",$schuelerzahlen_2015_k[12],"</td>",
																"<td>",$schuelerzahlen_2015_k[13],"</td>",
																"<td>",$schuelerzahlen_2015_k[14],"</td>",
																"<td>",$schuelerzahlen_2015_k[15],"</td>",
																"<td>",$schuelerzahlen_2015_k[16],"</td>",
																"<td>",$schuelerzahlen_2015_k[17],"</td>",
																"<td>",$schuelerzahlen_2015_k[18],"</td>",
																"<td>",$schuelerzahlen_2015_k[19],"</td>",
																"<td>",$schuelerzahlen_2015_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2015_4')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Schulart der Schüler</a></th>
												</tr>
											</table>
											<div id="_2015_4" style="display: none">
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
														for($z_2015=0;$z_2015<$c_2015;$z_2015++)
															{ 
																echo "<td>",$schulart_2015_k[$z_2015][0],"</td>",
																"<td>",$schulart_2015_k[$z_2015][1],"</td>",
																"<td>",$schulart_2015_k[$z_2015][2],"</td>",
																"<td>",$schulart_2015_k[$z_2015][3],"</td>",
																"<td>",$schulart_2015_k[$z_2015][4],"</td>",
																"<td>",$schulart_2015_k[$z_2015][5],"</td>",
																"<td>",$schulart_2015_k[$z_2015][6],"</td>",
																"<td>",$schulart_2015_k[$z_2015][7],"</td>",
																"<td>",$schulart_2015_k[$z_2015][8],"</td>",
																"<td>",$schulart_2015_k[$z_2015][9],"</td>",
																"<td>",$schulart_2015_k[$z_2015][10],"</td>",
																"<td>",$schulart_2015_k[$z_2015][11],"</td>",
																"<td>",$schulart_2015_k[$z_2015][12],"</td>",
																"<td>",$schulart_2015_k[$z_2015][13],"</td>",
																"<td>",$schulart_2015_k[$z_2015][14],"</td>",
																"<td>",$schulart_2015_k[$z_2015][15],"</td>",
																"<td>",$schulart_2015_k[$z_2015][16],"</td>",
																"<td>",$schulart_2015_k[$z_2015][17],"</td>",
																"<td>",$schulart_2015_k[$z_2015][18],"</td>",
																"<td>",$schulart_2015_k[$z_2015][19],"</td>",
																"<td>",$schulart_2015_k[$z_2015][20],"</td>",																
																"<td>",$schulart_2015_k[$z_2015][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2015_k[0],"</td>",
																"<td>",$schuelerzahlen_2015_k[1],"</td>",
																"<td>",$schuelerzahlen_2015_k[2],"</td>",
																"<td>",$schuelerzahlen_2015_k[3],"</td>",
																"<td>",$schuelerzahlen_2015_k[4],"</td>",
																"<td>",$schuelerzahlen_2015_k[5],"</td>",
																"<td>",$schuelerzahlen_2015_k[6],"</td>",
																"<td>",$schuelerzahlen_2015_k[7],"</td>",
																"<td>",$schuelerzahlen_2015_k[8],"</td>",
																"<td>",$schuelerzahlen_2015_k[9],"</td>",
																"<td>",$schuelerzahlen_2015_k[10],"</td>",
																"<td>",$schuelerzahlen_2015_k[11],"</td>",
																"<td>",$schuelerzahlen_2015_k[12],"</td>",
																"<td>",$schuelerzahlen_2015_k[13],"</td>",
																"<td>",$schuelerzahlen_2015_k[14],"</td>",
																"<td>",$schuelerzahlen_2015_k[15],"</td>",
																"<td>",$schuelerzahlen_2015_k[16],"</td>",
																"<td>",$schuelerzahlen_2015_k[17],"</td>",
																"<td>",$schuelerzahlen_2015_k[18],"</td>",
																"<td>",$schuelerzahlen_2015_k[19],"</td>",
																"<td>",$schuelerzahlen_2015_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2015_5')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a></th>
												</tr>
											</table>
											<div id="_2015_5" style="display: none">
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
														for($z_2015=0;$z_2015<$d_2015;$z_2015++)
															{ 
																echo "<td>",$bildungsgang_2015_k[$z_2015][0],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][1],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][2],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][3],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][4],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][5],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][6],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][7],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][8],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][9],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][10],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][11],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][12],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][13],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][14],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][15],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][16],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][17],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][18],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][19],"</td>",
																"<td>",$bildungsgang_2015_k[$z_2015][20],"</td>",																
																"<td>",$bildungsgang_2015_k[$z_2015][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2015_k[0],"</td>",
																"<td>",$schuelerzahlen_2015_k[1],"</td>",
																"<td>",$schuelerzahlen_2015_k[2],"</td>",
																"<td>",$schuelerzahlen_2015_k[3],"</td>",
																"<td>",$schuelerzahlen_2015_k[4],"</td>",
																"<td>",$schuelerzahlen_2015_k[5],"</td>",
																"<td>",$schuelerzahlen_2015_k[6],"</td>",
																"<td>",$schuelerzahlen_2015_k[7],"</td>",
																"<td>",$schuelerzahlen_2015_k[8],"</td>",
																"<td>",$schuelerzahlen_2015_k[9],"</td>",
																"<td>",$schuelerzahlen_2015_k[10],"</td>",
																"<td>",$schuelerzahlen_2015_k[11],"</td>",
																"<td>",$schuelerzahlen_2015_k[12],"</td>",
																"<td>",$schuelerzahlen_2015_k[13],"</td>",
																"<td>",$schuelerzahlen_2015_k[14],"</td>",
																"<td>",$schuelerzahlen_2015_k[15],"</td>",
																"<td>",$schuelerzahlen_2015_k[16],"</td>",
																"<td>",$schuelerzahlen_2015_k[17],"</td>",
																"<td>",$schuelerzahlen_2015_k[18],"</td>",
																"<td>",$schuelerzahlen_2015_k[19],"</td>",
																"<td>",$schuelerzahlen_2015_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
										</div>