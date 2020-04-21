											<table class="bordered">							
												<tr>
													<th colspan=4><a href="#anker" onclick="klappe('eintrag_1001')" title="aufklappen/zuklappen">Diagramme</th>									
												</tr>
											</table>
										<div id="eintrag_1001" style="display: none">
											<table class="bordered">
												<tr>
													<th colspan=22><a href="#anker" onclick="klappe('eintrag_1000')" title="aufklappen/zuklappen">Entwicklung Schülerzahlen</a></th>
												</tr>
											</table>
											<div id="eintrag_1000" style="display: none">
												<table class="bordered">													
													<tr>
														<td>Balkendiagramm</td>
														<td>Liniendiagramm</td>
													</tr>
													<tr>
														<?php echo "<td><img src=\"includes/Diagramme/2D_Balkendiagramm.php?schul_id=$schul_id\"></td>"; ?>
														<?php echo "<td><img src=\"includes/Diagramme/Liniendiagramm.php?schul_id=$schul_id\"></td>"; ?>
													</tr>													
												</table>
											</div>
										</div>