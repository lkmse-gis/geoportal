								<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA51').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA51').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA51').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA51').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA51">
													<thead>
													<tr>
														<td style="text-align:center;" colspan=22>2015 Schülerzahlen gruppiert nach Jahrgangsstufen der Schüler</td>														
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
													</tbody>	
												</table>