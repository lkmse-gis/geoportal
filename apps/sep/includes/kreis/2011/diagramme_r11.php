								<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tB11').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
												<table id="tB11">													
													<tr>
														<td>Kreisdiagramm</td>
														<td>Kreisdiagramm</td>
													</tr>
													<tr>
														<?php echo "<td><img src=\"../Diagramme/Nationalitaet/Kreisdiagramm_Nationalitaet2_k.php?stichtage=$stichtage[0]\"></td>"; ?>
														<?php echo "<td><img src=\"../Diagramme/Nationalitaet/Kreisdiagramm_Nationalitaet_k.php?stichtage=$stichtage[0]\"></td>"; ?>
													</tr>													
												</table>
											
										