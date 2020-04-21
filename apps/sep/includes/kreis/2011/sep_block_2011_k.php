										<table class="bordered">							
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2011_11')" title="aufklappen/zuklappen">2011-09-09</th>									
												</tr>
										</table>
										<div id="_2011_11" style="display: none">											
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('_2011_2')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</a></th>
												</tr>
											</table>
											<div id="_2011_2" style="display: none">
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
														for($z_2011=0;$z_2011<$a_2011;$z_2011++)
															{ 
																echo "<td>",$schuelerjgst_2011_k[$z_2011][0],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][1],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][2],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][3],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][4],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][5],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][6],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][7],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][8],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][9],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][10],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][11],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][12],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][13],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][14],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][15],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][16],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][17],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][18],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][19],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][20],"</td>",
																"<td>",$schuelerjgst_2011_k[$z_2011][21],"</td></tr>";
															};
														?>
														<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2011_k[0],"</td>",
																"<td>",$schuelerzahlen_2011_k[1],"</td>",
																"<td>",$schuelerzahlen_2011_k[2],"</td>",
																"<td>",$schuelerzahlen_2011_k[3],"</td>",
																"<td>",$schuelerzahlen_2011_k[4],"</td>",
																"<td>",$schuelerzahlen_2011_k[5],"</td>",
																"<td>",$schuelerzahlen_2011_k[6],"</td>",
																"<td>",$schuelerzahlen_2011_k[7],"</td>",
																"<td>",$schuelerzahlen_2011_k[8],"</td>",
																"<td>",$schuelerzahlen_2011_k[9],"</td>",
																"<td>",$schuelerzahlen_2011_k[10],"</td>",
																"<td>",$schuelerzahlen_2011_k[11],"</td>",
																"<td>",$schuelerzahlen_2011_k[12],"</td>",
																"<td>",$schuelerzahlen_2011_k[13],"</td>",
																"<td>",$schuelerzahlen_2011_k[14],"</td>",
																"<td>",$schuelerzahlen_2011_k[15],"</td>",
																"<td>",$schuelerzahlen_2011_k[16],"</td>",
																"<td>",$schuelerzahlen_2011_k[17],"</td>",
																"<td>",$schuelerzahlen_2011_k[18],"</td>",
																"<td>",$schuelerzahlen_2011_k[19],"</td>",
																"<td>",$schuelerzahlen_2011_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2011_3')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Schularten der Schule</a></th>
												</tr>
											</table>
											<div id="_2011_3" style="display: none">
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
														for($z_2011=0;$z_2011<$b_2011;$z_2011++)
															{ 
																echo "<td>",$schularten_2011_k[$z_2011][0],"</td>",
																"<td>",$schularten_2011_k[$z_2011][1],"</td>",
																"<td>",$schularten_2011_k[$z_2011][2],"</td>",
																"<td>",$schularten_2011_k[$z_2011][3],"</td>",
																"<td>",$schularten_2011_k[$z_2011][4],"</td>",
																"<td>",$schularten_2011_k[$z_2011][5],"</td>",
																"<td>",$schularten_2011_k[$z_2011][6],"</td>",
																"<td>",$schularten_2011_k[$z_2011][7],"</td>",
																"<td>",$schularten_2011_k[$z_2011][8],"</td>",
																"<td>",$schularten_2011_k[$z_2011][9],"</td>",
																"<td>",$schularten_2011_k[$z_2011][10],"</td>",
																"<td>",$schularten_2011_k[$z_2011][11],"</td>",
																"<td>",$schularten_2011_k[$z_2011][12],"</td>",
																"<td>",$schularten_2011_k[$z_2011][13],"</td>",
																"<td>",$schularten_2011_k[$z_2011][14],"</td>",
																"<td>",$schularten_2011_k[$z_2011][15],"</td>",
																"<td>",$schularten_2011_k[$z_2011][16],"</td>",
																"<td>",$schularten_2011_k[$z_2011][17],"</td>",
																"<td>",$schularten_2011_k[$z_2011][18],"</td>",
																"<td>",$schularten_2011_k[$z_2011][19],"</td>",
																"<td>",$schularten_2011_k[$z_2011][20],"</td>",																
																"<td>",$schularten_2011_k[$z_2011][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2011_k[0],"</td>",
																"<td>",$schuelerzahlen_2011_k[1],"</td>",
																"<td>",$schuelerzahlen_2011_k[2],"</td>",
																"<td>",$schuelerzahlen_2011_k[3],"</td>",
																"<td>",$schuelerzahlen_2011_k[4],"</td>",
																"<td>",$schuelerzahlen_2011_k[5],"</td>",
																"<td>",$schuelerzahlen_2011_k[6],"</td>",
																"<td>",$schuelerzahlen_2011_k[7],"</td>",
																"<td>",$schuelerzahlen_2011_k[8],"</td>",
																"<td>",$schuelerzahlen_2011_k[9],"</td>",
																"<td>",$schuelerzahlen_2011_k[10],"</td>",
																"<td>",$schuelerzahlen_2011_k[11],"</td>",
																"<td>",$schuelerzahlen_2011_k[12],"</td>",
																"<td>",$schuelerzahlen_2011_k[13],"</td>",
																"<td>",$schuelerzahlen_2011_k[14],"</td>",
																"<td>",$schuelerzahlen_2011_k[15],"</td>",
																"<td>",$schuelerzahlen_2011_k[16],"</td>",
																"<td>",$schuelerzahlen_2011_k[17],"</td>",
																"<td>",$schuelerzahlen_2011_k[18],"</td>",
																"<td>",$schuelerzahlen_2011_k[19],"</td>",
																"<td>",$schuelerzahlen_2011_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2011_4')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Schulart der Schüler</a></th>
												</tr>
											</table>
											<div id="_2011_4" style="display: none">
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
														for($z_2011=0;$z_2011<$c_2011;$z_2011++)
															{ 
																echo "<td>",$schulart_2011_k[$z_2011][0],"</td>",
																"<td>",$schulart_2011_k[$z_2011][1],"</td>",
																"<td>",$schulart_2011_k[$z_2011][2],"</td>",
																"<td>",$schulart_2011_k[$z_2011][3],"</td>",
																"<td>",$schulart_2011_k[$z_2011][4],"</td>",
																"<td>",$schulart_2011_k[$z_2011][5],"</td>",
																"<td>",$schulart_2011_k[$z_2011][6],"</td>",
																"<td>",$schulart_2011_k[$z_2011][7],"</td>",
																"<td>",$schulart_2011_k[$z_2011][8],"</td>",
																"<td>",$schulart_2011_k[$z_2011][9],"</td>",
																"<td>",$schulart_2011_k[$z_2011][10],"</td>",
																"<td>",$schulart_2011_k[$z_2011][11],"</td>",
																"<td>",$schulart_2011_k[$z_2011][12],"</td>",
																"<td>",$schulart_2011_k[$z_2011][13],"</td>",
																"<td>",$schulart_2011_k[$z_2011][14],"</td>",
																"<td>",$schulart_2011_k[$z_2011][15],"</td>",
																"<td>",$schulart_2011_k[$z_2011][16],"</td>",
																"<td>",$schulart_2011_k[$z_2011][17],"</td>",
																"<td>",$schulart_2011_k[$z_2011][18],"</td>",
																"<td>",$schulart_2011_k[$z_2011][19],"</td>",
																"<td>",$schulart_2011_k[$z_2011][20],"</td>",																
																"<td>",$schulart_2011_k[$z_2011][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2011_k[0],"</td>",
																"<td>",$schuelerzahlen_2011_k[1],"</td>",
																"<td>",$schuelerzahlen_2011_k[2],"</td>",
																"<td>",$schuelerzahlen_2011_k[3],"</td>",
																"<td>",$schuelerzahlen_2011_k[4],"</td>",
																"<td>",$schuelerzahlen_2011_k[5],"</td>",
																"<td>",$schuelerzahlen_2011_k[6],"</td>",
																"<td>",$schuelerzahlen_2011_k[7],"</td>",
																"<td>",$schuelerzahlen_2011_k[8],"</td>",
																"<td>",$schuelerzahlen_2011_k[9],"</td>",
																"<td>",$schuelerzahlen_2011_k[10],"</td>",
																"<td>",$schuelerzahlen_2011_k[11],"</td>",
																"<td>",$schuelerzahlen_2011_k[12],"</td>",
																"<td>",$schuelerzahlen_2011_k[13],"</td>",
																"<td>",$schuelerzahlen_2011_k[14],"</td>",
																"<td>",$schuelerzahlen_2011_k[15],"</td>",
																"<td>",$schuelerzahlen_2011_k[16],"</td>",
																"<td>",$schuelerzahlen_2011_k[17],"</td>",
																"<td>",$schuelerzahlen_2011_k[18],"</td>",
																"<td>",$schuelerzahlen_2011_k[19],"</td>",
																"<td>",$schuelerzahlen_2011_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
											<table class="bordered">
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('_2011_5')" title="aufklappen/zuklappen">Schülerzahlen gruppiert nach Bildungsgang der Schüler</a></th>
												</tr>
											</table>
											<div id="_2011_5" style="display: none">
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
														for($z_2011=0;$z_2011<$d_2011;$z_2011++)
															{ 
																echo "<td>",$bildungsgang_2011_k[$z_2011][0],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][1],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][2],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][3],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][4],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][5],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][6],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][7],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][8],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][9],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][10],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][11],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][12],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][13],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][14],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][15],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][16],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][17],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][18],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][19],"</td>",
																"<td>",$bildungsgang_2011_k[$z_2011][20],"</td>",																
																"<td>",$bildungsgang_2011_k[$z_2011][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2011_k[0],"</td>",
																"<td>",$schuelerzahlen_2011_k[1],"</td>",
																"<td>",$schuelerzahlen_2011_k[2],"</td>",
																"<td>",$schuelerzahlen_2011_k[3],"</td>",
																"<td>",$schuelerzahlen_2011_k[4],"</td>",
																"<td>",$schuelerzahlen_2011_k[5],"</td>",
																"<td>",$schuelerzahlen_2011_k[6],"</td>",
																"<td>",$schuelerzahlen_2011_k[7],"</td>",
																"<td>",$schuelerzahlen_2011_k[8],"</td>",
																"<td>",$schuelerzahlen_2011_k[9],"</td>",
																"<td>",$schuelerzahlen_2011_k[10],"</td>",
																"<td>",$schuelerzahlen_2011_k[11],"</td>",
																"<td>",$schuelerzahlen_2011_k[12],"</td>",
																"<td>",$schuelerzahlen_2011_k[13],"</td>",
																"<td>",$schuelerzahlen_2011_k[14],"</td>",
																"<td>",$schuelerzahlen_2011_k[15],"</td>",
																"<td>",$schuelerzahlen_2011_k[16],"</td>",
																"<td>",$schuelerzahlen_2011_k[17],"</td>",
																"<td>",$schuelerzahlen_2011_k[18],"</td>",
																"<td>",$schuelerzahlen_2011_k[19],"</td>",
																"<td>",$schuelerzahlen_2011_k[20],"</td></tr>";																											
														?>
												</table>
											</div>
										</div>