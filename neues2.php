
<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");

$datei=$_SERVER["PHP_SELF"];
$letter=$_GET["letter"];
$suchbegriff=$_POST["suchbegriff"];
$count=0;

if (isset($letter)) $query="SELECT m.*,l.Layer_ID,l.Datentyp,g.Gruppenname FROM metadaten as m, layer as l, u_groups as g  WHERE m.layer_id=l.Layer_ID AND l.Gruppe=g.id AND m.layer_typ != 'technisch'  AND m.layer_status != 'inaktiv' AND m.alias != '' AND m.alias LIKE '$letter%' ORDER BY m.alias";

if (isset($suchbegriff)) $query="SELECT m.*,l.Layer_ID,l.Datentyp,g.Gruppenname FROM metadaten as m, layer as l, u_groups as g  WHERE m.layer_id=l.Layer_ID AND l.Gruppe=g.id AND m.layer_typ != 'technisch'  AND m.layer_status != 'inaktiv' AND m.alias != '' AND m.alias LIKE '%$suchbegriff%' ORDER BY m.alias";

if (isset($query))
   {
    $result=mysqli_query($db_link,$query);
    $z=0;
    while($r = mysqli_fetch_array($result))
	{
		$daten[$z]=$r;
		$z++;
		$count=$z;	
	}
   }

?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		
		</head>
		<body onload="load();init()">
		<div id="container">
			<div id="header">
				<?php
					head_portal();
				?>
			</div>
			<div id="wrapper">
				<div id="content">
				<br>
	<table border="0" valign="middle" align="center" cellpadding="3" width="90%">
		<tr bgcolor=<? echo $header_farbe ;?>>
			<td align="center">
				<h2><? echo $font_farbe ;?>Themen&uuml;bersicht<? echo $font_farbe_end ;?><br><font size="-1" color=white><? if ($count > 0) echo "$count Treffer";?></font></h2>
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
						echo '<a href="',$datei,'?letter=',$r[0],'"><b>',$r[0],'</b></a>&nbsp;&nbsp;&nbsp;&nbsp;';
					}
				echo '<small><a href="',$datei,'?letter=%"><b>Alle anzeigen</b></a>&nbsp;&nbsp;&nbsp;&nbsp;';
				?>
			</td>
		</tr>
		<tr><td>
		    <form action="<? echo $datei ?>" method="post">
			<input type="text" name="suchbegriff" size="50" maxlength="50" value="<? echo $suchbegriff ?>">
			<input type="submit" value="Suche starten">
			</form>
		</td></tr>
	</table>
	<?php
	if ($count > 0)
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
					echo "<td>&nbsp;&nbsp;<a href=\"metadaten/metadaten.php?Layer_ID=",$daten[$v]['layer_id'],"\" target=\"_blank\" onclick=\"return hilfe_popup(this.href)\"><img src=\"images/info_button.gif\" title=\"Metadaten\" border=0></a></td>";
				
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
						
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="',$daten[$v]["url_mp"],'" target="_blank"><img src="buttons/kartenportal_button.gif" style="width:80px;height:15px;"  title="Kartenportal" border=0 ></a>';

						}
				echo "</td>";
				
			echo "</tr>";
			}
	}
	else
	{
		echo"<table width='90%' align='center' style='font-family:Arial; font-size: 10pt; font-weight: bold'>
				<tr bgcolor=$element_farbe height=30>
					<td align=center>&nbsp;&nbsp;<i>W&auml;hlen Sie einen Anfangsbuchstaben aus oder geben Sie einen Suchbegriff ein.</i></td>				
				</tr>
				<tr height=100></tr>				
			</table>";
	}
	?>
	</table>
	</div>
			</div>
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
				<? include ("includes/news.php"); ?>
			</div>
			<div id="footer">			
		  </div>
		</div>
		</body>
		</html>

