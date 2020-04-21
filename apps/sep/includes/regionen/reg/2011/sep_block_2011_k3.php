<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA13').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA13').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA13').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA13').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA13">
													<thead>
													<tr>
														<td style="text-align:center;" colspan=22>2011 Schülerzahlen gruppiert nach Schulart der Schüler</td>														
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
																<td>",$schuelerzahlen_2011_k[1],"</td>",
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
																"<td>",$schuelerzahlen_2011_k[20],"</td>",
																"<td>",$schuelerzahlen_2011_k[21],"</td></tr>";																											
														?>
													</tbody>	
												</table>