<?php
	echo "
	<tr>
		<td colspan=2></td>                                       										
		<td><small>
			 $cr| &nbsp;<a href=\"includes/kartehilfe.php\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\">Hilfe zur Kartennutzung</a>
		</td>	
		<td>
			<a href=\"metadaten/metadaten.php?Layer_ID=$layerid\" target=\"_blank\" onclick=\"return meta_popup(this.href)\"><img src=\"images/info_button.gif\" title=\"Metadaten\" border=0></a>
		</td>
		<td align=right>
			<a href=\"$_SERVER[PHP_SELF]?ortsteil=$ortsteil_id\"><img src=\"images/reload.png\" title=\"Kartenausschnitt neu laden\"></a>
		</td>
	</tr>";
?>