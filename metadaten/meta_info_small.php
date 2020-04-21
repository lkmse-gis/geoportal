<html>
<head>
<!--<meta http-equiv="content-type" content="text/html; charset=utf-8">-->
</head>
<body background="../images/bg2.gif">
<?php
include ("../includes/connect.php");

$id=$_GET["id"];


$query="SELECT m.*, l.*,g.* FROM metadaten as m, layer as l, u_groups as g  WHERE m.layer_id=$id  AND m.layer_id=l.layer_id AND l.gruppe=g.id";
$result=mysql_query($query);
$r=mysql_fetch_array($result);
$range=$r[range]/2;
$koordinate=explode(",",$r[center]);
$lur=$koordinate[0]-$range;
$luh=$koordinate[1]-$range;
$ror=$koordinate[0]+$range;
$roh=$koordinate[1]+$range;



?>
<?php


?>
<div align="center"><font face=arial>
<table style="font-family:Arial; font-size: 14pt; font-weight: bold">
	<tr>
		<td align=center>
			<img src="../images/geoportal_logo.png" width=650>
		</td>
	</tr>
	<tr>
		<td height=45 align=center valign=center bgcolor="#3264af">
			<font color=white>Informationen zum Thema <?php echo $r[Name]; ?></font>
		</td>
	</tr>
</table>
<div align="center">
<table style="font-family:Arial; font-size: 10pt; font-weight: bold">
	<tr bgcolor="#d2e8ff">
		<td width="200" valign="top">Bezeichnung</td>
		<td width="450"><?php echo utf8_encode($r[Name]); ?></td>
	</tr>
	<tr>
		<td valign="top">Gruppe</td>
		<td><?php echo utf8_encode($r[Gruppenname]); ?></td>
	</tr>
	<tr bgcolor="#d2e8ff">
		<td valign="top">Klassifizierung</td>
		<td><ul><?php 
		  $classquery="SELECT * FROM classes WHERE Layer_ID = '$r[layer_id]' ORDER BY Class_ID";
		  $classresult=mysql_query($classquery);
		  while ($cr=mysql_fetch_array($classresult)) echo "<li>$cr[Name]</li>";
		  echo "</ul>";
		 ?>
		</td>
	</tr>
	<tr>
		<td>Datentyp</td>
		<td><?php 
		  if ($r[Datentyp] == '0') echo "Vektorlayer (Punktgeometrie)";
		  if ($r[Datentyp] == '1') echo "Vektorlayer (Liniengeometrie)";
		  if ($r[Datentyp] == '2') echo "Vektorlayer (Fl&auml;chenobjekte)";
		  if ($r[Datentyp] == '3') echo "Rasterdaten";
		 ?>
		</td>
	</tr>
	<tr bgcolor="#d2e8ff">
		<td valign="top">Datenquelle</td>
		<td><?php echo $r[quelle]; ?></td>
	</tr>
	<tr>
		<td valign="top">letzte Aktualisierung</td>
		<td><?php echo $r[aktualitaet]; ?></td>
	</tr>
	<tr bgcolor="#d2e8ff">
		<td valign="top">Kontakt</td>
		<td><?php echo $r[k_fa_b]."<br>".$r[fachamt]."<br>".$r[k_fa]."<br>Telefon: ".$r[k_fa_tel]."<br>E-Mail: ".$r[k_fa_mail]; ?></td>
	</tr>
	<tr>
		<td valign="top">Bemerkungen</td>
		<td><?php echo $r[comment]; ?></td>
	</tr>
	<tr bgcolor="#d2e8ff">
		<td valign="top">Lagebezugssystem</td>
		<td><?php 
		  if ($r[epsg_code] == '2398') echo "Gau&szlig;-Kr&uuml;ger Abbildung<br>S42/83 (Krassowski-Ellipsoid)<br>3-Grad Streifensystem<br>Streifen 4";
		  if ($r[epsg_code] == '31468') echo "Gau&szlig;-Kr&uuml;ger Abbildung<br>RD/83 (Bessel-Ellipsoid)<br>3-Grad Streifensystem<br>Streifen 4";
		  if ($r[epsg_code] == '25833') echo "UTM Abbildung<br>ETRS 89 (GRS 80)<br>6-Grad Streifensystem<br>ohne f&uuml;hrender Zone 33";
		  if ($r[epsg_code] == '35833') echo "UTM Abbildung<br>ETRS 89 (GRS 80)<br>6-Grad Streifensystem<br>mit f&uuml;hrender Zone 33";
		 ?>
		</td>
	</tr>
	<tr>
		<td valign="top">EPSG-Code</td>
		<td><?php 
			if ($r[epsg_code] == '35833') echo $r[epsg_code]." (nicht OGC-konform)";
			else echo $r[epsg_code]; ?></td>
	</tr>
	<tr bgcolor="#d2e8ff">
		<td valign="top">Ver&ouml;ffentlichung</td>
		<td><?php 
		  if ($r[open] == 0) echo "Layer wird nur internen Nutzern angeboten";
		  if ($r[open] == 1) echo "Layer wird zugriffsberechtigeten Stellen angeboten";
		  if ($r[open] == 2) echo "Layer ist &ouml;ffentlich";
			?>
		</td>
	<?php
	 if (strlen($r[ko_auszug]) > 0) echo "
	</tr>
	<tr>
	<td width=\"300\" valign=\"top\">Kosten f&uuml;r einen Auszug</td>
	<td width=\"500\" valign=\"top\">", $r[ko_auszug]," </td>
	</tr>";

	 if (strlen($r[ko_flat]) > 0) echo "
	</tr>
	<tr bgcolor='#d2e8ff'>
	<td width=\"300\" valign=\"top\">Kosten f&uuml;r die Nutzung &uuml;ber kvwmap<br>(monatlich)</td>
	<td width=\"500\" valign=\"top\">", $r[ko_flat]," </td>
	</tr>";

	?>
</table>
</body>
</html>
