<?php
	echo "
			<tr>
				<td valign=bottom align=right>
					<!-- Tabelle f�r Legende -->											
					<table border=\"1\" rules=\"none\" width=140 valign=bottom align=right>					
						<tr>
							<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
						</tr>
						<tr>
							<td width=100 align=right><small>$titel_legende: </td>
							<td align=right><img src=\""
?>
<?
	echo $bildpfad.$leg_bild
?>
<?
	echo "
							\" width=20></td>							
						</tr>																						
					</table> <!-- Ende der Tabelle f�r die Legende -->
				</td>
			</tr>";
?>