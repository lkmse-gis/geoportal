								<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tB42').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
												<table id="tB42">													
													<tr>
														<td>Kreisdiagramm</td>
														<td>Kreisdiagramm</td>
													</tr>
													<tr>
														<?php echo "<td><img src=\"../Diagramme/Schulart/Kreisdiagramm_schulart_r.php?reg_nr=$reg_nr&stichtage=$stichtage[3]\"></td>"; ?>
														<?php echo "<td><img src=\"../Diagramme/Schulart/Kreisdiagramm_bildungsgang_r.php?reg_nr=$reg_nr&stichtage=$stichtage[3]\"></td>"; ?>
													</tr>													
												</table>
											
										