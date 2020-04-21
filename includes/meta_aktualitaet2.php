<?php
	echo "
	<tr>
	    <td valign=bottom align=\"center\" colspan=2>
			<a href=\"metadaten/metadaten.php?Layer_ID=$layerid\" target=\"_blank\" onclick=\"return meta_popup(this.href)\">Info zum Thema $headline</a>
	    </td>
	</tr>
	<tr>
		<td align=\"center\" colspan=2>letzte Aktualisierung: <b><i>"
?>
<? 
	echo get_aktualitaet($db_link,$layerid)
?>
<?
	echo"
		</td>
	</tr>
    <tr>
		<td valign=bottom align=center>
			<a href=\"includes/kartehilfe.php\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\">Wie nutze ich die webbasierte Karte?<br>(OpenLayers)</a>																
		</td>
	</tr>";
?>