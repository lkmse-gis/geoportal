								<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tB21').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
												<table id="tB21">													
													<tr>
														<td>Kreisdiagramm</td>
														<td>Kreisdiagramm</td>
													</tr>
													<tr>
														<?php echo "<td><img src=\"../Diagramme/Nationalitaet/Kreisdiagramm_Nationalitaet2_a.php?reg_nr=$reg_nr&stichtage=$stichtage[1]\"></td>"; ?>
														<?php echo "<td><img src=\"../Diagramme/Nationalitaet/Kreisdiagramm_Nationalitaet_a.php?reg_nr=$reg_nr&stichtage=$stichtage[1]\"></td>"; ?>
													</tr>													
												</table>
											
										