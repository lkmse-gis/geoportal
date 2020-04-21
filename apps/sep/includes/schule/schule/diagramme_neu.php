<div class="btn-group">				 
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-floppy-disk"> Speichern </span>&nbsp;&nbsp;<span class="caret"></span></button> 
									<ul class="dropdown-menu">					
										<li>
											<a href="#" onclick="$('#tA01').tableExport({type:'png'});"><img src='../../export_libs/icons/png.png' alt="PNG" style="width:24px">  ... als PNG</a>
										</li>
									</ul>
								</div>
<table id="tA01">													
	<tr>
		<td>Balkendiagramm</td>
		<td>Liniendiagramm</td>
	</tr>
	<tr>
		<?php echo "<td><img src=\"../Diagramme/2D_Balkendiagramm.php?schul_id=$schul_id\"></td>"; ?>
		<?php echo "<td><img src=\"../Diagramme/Liniendiagramm.php?schul_id=$schul_id\"></td>"; ?>
	</tr>													
</table>