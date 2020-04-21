<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA05').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
<table id="tA05">													
	<tr>
		<td>Balkendiagramm</td>
		<td>Liniendiagramm</td>
	</tr>
	<tr>
		<?php echo "<td><img src=\"../Diagramme/2D_Balkendiagramm_Migranten_gesamt_k.php\"></td>"; ?>
		<?php echo "<td><img src=\"../Diagramme/Liniendiagramm_Migranten_gesamt_k.php\"></td>"; ?>
	</tr>													
</table>