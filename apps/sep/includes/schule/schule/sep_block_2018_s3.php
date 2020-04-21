<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA83').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA83').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA83').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA83').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA83">
													<thead>
													<tr>
														<td style="text-align:center;" colspan=22>2018 Schülerzahlen gruppiert nach Klassenstufen</td>														
													</tr>
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
													</thead>
													<tbody>
													<tr>
														<?php 										
														for($v_2018=0;$v_2018<$x_2018;$v_2018++)
															{ 
																echo "<td>",$schuelerklassen_2018[$v_2018][0],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][1],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][2],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][3],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][4],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][5],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][6],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][7],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][8],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][9],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][10],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][11],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][12],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][13],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][14],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][15],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][16],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][17],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][18],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][19],"</td>",
																"<td>",$schuelerklassen_2018[$v_2018][20],"</td>",	
																"<td>",$schuelerklassen_2018[$v_2018][21],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2018[1],"</td>",
																"<td>",$schuelerzahlen_2018[2],"</td>",
																"<td>",$schuelerzahlen_2018[3],"</td>",
																"<td>",$schuelerzahlen_2018[4],"</td>",
																"<td>",$schuelerzahlen_2018[5],"</td>",
																"<td>",$schuelerzahlen_2018[6],"</td>",
																"<td>",$schuelerzahlen_2018[7],"</td>",
																"<td>",$schuelerzahlen_2018[8],"</td>",
																"<td>",$schuelerzahlen_2018[9],"</td>",
																"<td>",$schuelerzahlen_2018[10],"</td>",
																"<td>",$schuelerzahlen_2018[11],"</td>",
																"<td>",$schuelerzahlen_2018[12],"</td>",
																"<td>",$schuelerzahlen_2018[13],"</td>",
																"<td>",$schuelerzahlen_2018[14],"</td>",
																"<td>",$schuelerzahlen_2018[15],"</td>",
																"<td>",$schuelerzahlen_2018[16],"</td>",
																"<td>",$schuelerzahlen_2018[17],"</td>",
																"<td>",$schuelerzahlen_2018[18],"</td>",
																"<td>",$schuelerzahlen_2018[19],"</td>",
																"<td>",$schuelerzahlen_2018[20],"</td>",
																"<td>",$schuelerzahlen_2018[21],"</td></tr>";																											
														?>
													</tbody>	
												</table>