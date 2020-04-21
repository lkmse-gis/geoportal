<?php
	echo "
			<tr>
				<td valign=bottom align=right>
					<!-- Tabelle für Legende -->											
					<table border=\"1\" rules=\"none\" width=140 valign=bottom align=right>					
						<tr>
							<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
						</tr>
						<tr>
							<td width=100 align=right><small>$titel2: </td>
							<td align=right><img src=\""
?>
<?
	echo $bildpfad.$leg_bild
?>
<?
	echo "
							\" width=20></td>
							<td align=right><small>Kreisgrenze: </td>
							<td align=right><img src=\"images/gemeindegrenze_2.png\" width=30></td>
						</tr>																						
					</table> <!-- Ende der Tabelle für die Legende -->
				</td>
			</tr>";
?>