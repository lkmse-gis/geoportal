								<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tB32').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
												<table id="tB32">													
													<tr>
														<td>Kreisdiagramm</td>
														<td>Kreisdiagramm</td>
													</tr>
													<tr>
														<?php echo "<td><img src=\"../Diagramme/Schulart/Kreisdiagramm_schulart_k.php?stichtage=$stichtage[2]\"></td>"; ?>
														<?php echo "<td><img src=\"../Diagramme/Schulart/Kreisdiagramm_bildungsgang_k.php?stichtage=$stichtage[2]\"></td>"; ?>
													</tr>													
												</table>
											
										