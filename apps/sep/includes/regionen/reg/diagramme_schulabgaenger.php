<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA06').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
<table id="tA06">													
	<tr>
		<td>Balkendiagramm</td>
		<td>Liniendiagramm</td>
	</tr>
	<tr>
		<?php echo "<td><img src=\"../Diagramme/schulabgaenger/2D_Balkendiagramm_schulabgaenger_r.php?reg_nr=$reg_nr\"></td>"; ?>
		<?php echo "<td><img src=\"../Diagramme/schulabgaenger/Liniendiagramm_schulabgaenger_r.php?reg_nr=$reg_nr\"></td>"; ?>
	</tr>													
</table>