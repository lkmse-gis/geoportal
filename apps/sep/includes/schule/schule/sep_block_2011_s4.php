<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA14').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA14').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA14').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA14').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA14">
													<thead>
													<tr>
														<td style="text-align:center;" colspan=22>2011 Schülerzahlen gruppiert nach Gemeinden</td>														
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
														for($a_2011=0;$a_2011<$b_2011;$a_2011++)
															{ 
																echo "<td>",$schuelergkz_2011[$a_2011][1],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][2],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][3],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][4],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][5],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][6],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][7],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][8],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][9],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][10],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][11],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][12],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][13],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][14],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][15],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][16],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][17],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][18],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][19],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][20],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][21],"</td>",
																"<td>",$schuelergkz_2011[$a_2011][22],"</td></tr>";
															};
														?>
													<tr>
														<?php 
														echo "<td>&sum;</td>
																<td>",$schuelerzahlen_2011[1],"</td>",
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
																"<td>",$schuelerzahlen_2011[20],"</td>",	
																"<td>",$schuelerzahlen_2011[21],"</td></tr>";																											
														?>
													</tbody>	
												</table>