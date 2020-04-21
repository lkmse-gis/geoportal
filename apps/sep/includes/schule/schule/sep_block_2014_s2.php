<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA42').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA42').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA42').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA42').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA42">
													<thead>
													<tr>
														<td style="text-align:center;" colspan=23>2014 Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</td>														
													</tr>
													<tr>
														<td></td>
														<td style="text-align:center;" colspan=8>Gesamtzahlen</td>
														<td style="text-align:center;" colspan=7>weiblich</td>
														<td style="text-align:center;" colspan=7>männlich</td>														
													</tr>
													<tr>
														<td></td>
														<td style="text-align:center;" colspan=2></td>
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
														<td>Klassenanzahl</td>
														<td>gesamt</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtl.</td>
														<td>weibl.</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtl.</td>
														<td>männl.</td>
														<td>fristgemäß</td>
														<td>vorzeitig</td>
														<td>verspätet</td>
														<td>Aussiedler</td>
														<td>Asylbewerber</td>
														<td>Flüchtl.</td>
													</tr>
													</thead>
													<tbody>
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
																"<td>",$schuelerjgst_2014[$c_2014][21],"</td>",
																"<td>",$schuelerjgst_2014[$c_2014][22],"</td></tr>";
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
																"<td>",$schuelerzahlen_2014[20],"</td>",
																"<td>",$schuelerzahlen_2014[21],"</td></tr>";																											
														?>
													</tbody>	
												</table>