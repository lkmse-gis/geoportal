<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA11').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  ... als Excel</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA11').tableExport({type:'doc'});"><img src='../../export_libs/icons/word.png' alt="WORD" style="width:24px">  ... als Word</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA11').tableExport({type:'csv'});"><img src='../../export_libs/icons/csv.png' alt="CSV" style="width:24px">  ... als CSV</a>
										</li>
										<li>
											<a href="#" onclick="$('#tA11').tableExport({type:'txt'});"><img src='../../export_libs/icons/txt.png' alt="TXT" style="width:24px">  ... als TXT</a>
										</li>
									</ul>
								</div>
								
													<table class="bordered" id="tA11">
														<thead>	
															<tr>
																<td style="text-align:center;" colspan=22>2011 Schuldaten</td>														
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Bezeichnung:</td>
																<td colspan=21><?php echo $schulname_2011; ?></td>
															</tr>
															<tr>
																<td>Schul-ID:</td>
																<td colspan=21><?php echo $schul_id; ?></td>
															</tr>
															<tr>
																<td valign=top>Anschrift:</td>
																<td colspan=21><?php echo $anschrift_2011; ?></td>
															</tr>
															<tr>
																<td>Schulleiter:</td>
																<td colspan=21><?php echo $schulleiter_2011; ?></td>
															</tr>
															<?
																if ($schul_id_2011 = '75530240')
																	{
																		$teil=explode(';',$tel_2011);
																		echo "<tr>
																				<td valign=top>Telefon:</td>
																				<td colspan=21>".$teil[0]."<br>".$teil[1]."</td>
																			</tr>";
																	}
																else echo "<tr>
																				<td>Telefon:</td>
																				<td colspan=21>$tel_2011</td>
																			</tr>";
															?>									
															<tr>
																<td>Fax:</td>
																<td colspan=21><?php echo $fax_2011; ?></td>
															</tr>
															<tr>
																<td>E-Mail:</td>
																<td colspan=21><?php echo $mail_2011; ?></td>
															</tr>
														</tbody>	
													</table>