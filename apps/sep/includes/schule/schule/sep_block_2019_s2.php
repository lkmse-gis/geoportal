<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA92').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA92').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA92').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA92').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA92">
													<thead>
													<tr>
														<td style="text-align:center;" colspan=23>2019 Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler und Klassenenanzahl</td>														
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
														<td>Flüchtlinge</td>
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
														for($c_2019=0;$c_2019<$d_2019;$c_2019++)
															{ 
																echo "<td>",$schuelerjgst_2019[$c_2019][0],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][1],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][2],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][3],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][4],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][5],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][6],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][7],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][8],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][9],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][10],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][11],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][12],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][13],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][14],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][15],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][16],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][17],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][18],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][19],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][20],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][21],"</td>",
																"<td>",$schuelerjgst_2019[$c_2019][22],"</td></tr>";
															};
														?>
													<tr>
														<?php 
																echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2019[0],"</td>",
																"<td>",$schuelerzahlen_2019[1],"</td>",
																"<td>",$schuelerzahlen_2019[2],"</td>",
																"<td>",$schuelerzahlen_2019[3],"</td>",
																"<td>",$schuelerzahlen_2019[4],"</td>",
																"<td>",$schuelerzahlen_2019[5],"</td>",
																"<td>",$schuelerzahlen_2019[6],"</td>",
																"<td>",$schuelerzahlen_2019[7],"</td>",
																"<td>",$schuelerzahlen_2019[8],"</td>",
																"<td>",$schuelerzahlen_2019[9],"</td>",
																"<td>",$schuelerzahlen_2019[10],"</td>",
																"<td>",$schuelerzahlen_2019[11],"</td>",
																"<td>",$schuelerzahlen_2019[12],"</td>",
																"<td>",$schuelerzahlen_2019[13],"</td>",
																"<td>",$schuelerzahlen_2019[14],"</td>",
																"<td>",$schuelerzahlen_2019[15],"</td>",
																"<td>",$schuelerzahlen_2019[16],"</td>",
																"<td>",$schuelerzahlen_2019[17],"</td>",
																"<td>",$schuelerzahlen_2019[18],"</td>",
																"<td>",$schuelerzahlen_2019[19],"</td>",
																"<td>",$schuelerzahlen_2019[20],"</td>",
																"<td>",$schuelerzahlen_2019[21],"</td></tr>";																											
														?>
													</tbody>	
												</table>