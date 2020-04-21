<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA84').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA84').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA84').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA84').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA84">
													<thead>
													<tr>
														<td style="text-align:center;" colspan=22>2018 Schülerzahlen gruppiert nach Gemeinden</td>														
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
													</thead>
													<tbody>
													<tr>
														<?php 										
														for($a_2018=0;$a_2018<$b_2018;$a_2018++)
															{ 
																echo "<td>",$schuelergkz_2018[$a_2018][1],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][2],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][3],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][4],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][5],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][6],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][7],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][8],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][9],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][10],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][11],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][12],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][13],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][14],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][15],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][16],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][17],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][18],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][19],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][20],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][21],"</td>",
																"<td>",$schuelergkz_2018[$a_2018][22],"</td></tr>";
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