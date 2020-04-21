<?php
include ("includes/portal_functions.php");
include ("includes/connect_i_procedure_mse.php");

$letter=$_GET["letter"];

$query="SELECT m.*,l.Layer_ID,l.Datentyp,g.Gruppenname FROM metadaten as m, layer as l, u_groups as g  WHERE m.layer_id=l.Layer_ID AND l.Gruppe=g.id AND m.layer_typ != 'technisch'  AND m.layer_status != 'inaktiv' AND m.alias != '' AND m.alias LIKE '$letter%' ORDER BY m.alias";

$result=mysqli_query($db_link,$query);

$z=0;
while($r = mysqli_fetch_array($result))
	{
		$daten[$z]=$r;
		$z++;
		$count=$z;	
	}

?>
<html>
<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
<head>
<?php include ("includes/meta_popup.php"); ?>
</head>
<body background="images/bg2.gif">
	<br>
	<br>
	<table border="0" valign="middle" align="center" cellpadding="3" width="90%">
		<tr bgcolor=<? echo $header_farbe ;?>>
			<td align="center">
				<h2><? echo $font_farbe ;?>Themen&uuml;bersicht<? echo $font_farbe_end ;?><br><font size="-1" color=white><? if (strlen($letter) > 0) echo "$count Treffer";?></font></h2>
			</td>
		</tr>
		<tr>
			<td align=center height=30>
				<?php
				$query="SELECT DISTINCT SUBSTR(m.alias,1,1) FROM metadaten as m, layer as l  WHERE m.layer_id=l.layer_id ORDER BY m.alias";
				$result=mysqli_query($db_link,$query);
				while($r = mysqli_fetch_array($result))
					{
					    $firstletter=$r[0];
						echo "<a href=\"javascript:ajaxpage('neues.php?letter=$firstletter', 'content')\"><b>",$r[0],"</b></a>&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				echo "<small><a href=\"javascript:ajaxpage('neues.php?letter=%', 'content')\"><b>Alle anzeigen</b></a>&nbsp;&nbsp;&nbsp;&nbsp;";
				?>
			</td>
		</tr>
	</table>
	<?php
	if (strlen($letter) > 0)
	{
		echo"<table width='90%' align='center' style='font-family:Arial; font-size: 10pt; font-weight: bold'>
		<tr bgcolor=$header_farbe height=35>
			<td>&nbsp;&nbsp;$font_farbe<i>Bezeichnung $font_farbe_end</i></td>
			<td>&nbsp;&nbsp;$font_farbe<i>Gruppe $font_farbe_end</i></td>
			<td>&nbsp;&nbsp;$font_farbe<i>Datentyp $font_farbe_end</i></td>
			<td>&nbsp;&nbsp;$font_farbe<i>Info $font_farbe_end</i></td>
			<td>&nbsp;&nbsp;$font_farbe<i>Link $font_farbe_end</i></td>
		</tr>";
		for($v=0;$v<$z;$v++)
			{
			echo "<tr bgcolor=",get_farbe($v)," height=25>";
				echo "<td>&nbsp;&nbsp;",$daten[$v]['alias'],"</td>",
					"<td><small>&nbsp;&nbsp;",$daten[$v]['Gruppenname'],"</td>";
				if ($daten[$v]['Datentyp']==0)
					{
						echo "<td><small>&nbsp;&nbsp;Punktgeometrie</td>";
					}
				if ($daten[$v]['Datentyp']==1)
					{
						echo "<td><small>&nbsp;&nbsp;Liniengeometrie</td>";
					}	
				if ($daten[$v]['Datentyp']==2)
					{
						echo "<td><small>&nbsp;&nbsp;Fl&auml;chengeometrie</td>";
					}
				if ($daten[$v]['Datentyp']==3)
					{
					echo "<td><small>&nbsp;&nbsp;Basiskarte</td>";
					}
					echo "<td>&nbsp;&nbsp;<a href=\"metadaten/metadaten.php?Layer_ID=",$daten[$v][layer_id],"\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\"><img src=\"images/info_button.gif\" title=\"Metadaten\" border=0></a></td>";
				
				echo "<td>";
				if ($daten[$v]['script'] != "")
						{
						echo "<small>&nbsp;&nbsp;<a href=".$daten[$v]['script'].">Thema ansehen</a>";
						}
				if ($daten[$v]['script'] == "")
						{
						echo "<small>&nbsp;&nbsp;<a href='kvwmap.php' target='_blank'>kvwmap verwenden</a>";
						}
				
				if ($daten[$v]['url_mp'] != "") 
						{
						
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="',$daten[$v][url_mp],'" target="_blank"><img src="buttons/kartenportal_button.gif" style="width:80px;height:15px;"  title="Kartenportal" border=0 ></a>';

						}
				echo "</td>";
				
			echo "</tr>";
			}
	}
	else
	{
		echo"<table width='90%' align='center' style='font-family:Arial; font-size: 10pt; font-weight: bold'>
				<tr bgcolor=$element_farbe height=30>
					<td align=center>&nbsp;&nbsp;<i>W&auml;hlen Sie einen Anfangsbuchstaben aus, um sich die Themen anzeigen zu lassen.</i></td>				
				</tr>
				<tr height=100></tr>				
			</table>";
	}
	?>
	</table>
	<br>
	<br>
</body>
</html>