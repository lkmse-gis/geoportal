								<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tB61').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
												<table id="tB61">													
													<tr>
														<td>Kreisdiagramm</td>
														<td>Kreisdiagramm</td>
													</tr>
													<tr>
														<?php echo "<td><img src=\"../Diagramme/Nationalitaet/Kreisdiagramm_Nationalitaet2_s.php?schul_id=$schul_id&stichtage=$stichtage[5]\"></td>"; ?>
														<?php echo "<td><img src=\"../Diagramme/Nationalitaet/Kreisdiagramm_Nationalitaet_s.php?schul_id=$schul_id&stichtage=$stichtage[5]\"></td>"; ?>
													</tr>													
												</table>
											
										