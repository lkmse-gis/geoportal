<?php
include ("../connect.php");

$id=$_GET["id"];
$wohin=$_GET["wohin"];
$gruppe=$_GET["group"];

$query="SELECT m.*, l.*,g.* FROM metadaten as m, layer as l, u_groups as g  WHERE m.layer_id=$id  AND m.layer_id=l.layer_id AND l.gruppe=g.id;";
$result=mysql_query($query);
$r=mysql_fetch_array($result);
$range=$r[range]/2;
$koordinate=explode(",",$r[center]);
$lur=$koordinate[0]-$range;
$luh=$koordinate[1]-$range;
$ror=$koordinate[0]+$range;
$roh=$koordinate[1]+$range;



?>
<div align="center"><font face=arial>
<h2>Metadaten für den Layer <?php echo $r[Name]; ?></h2>
<div align="left">
<?php

if ($wohin == 'liste') $direction="meta_gruppe.php?group=".$gruppe;
   else $direction="../index.php";

 echo "<a href=$direction>Zurück</a>";

?>
<hr>
<div align="center">
<table style="font-family:Arial; font-size: 10pt; font-weight: bold">
<tr bgcolor=#D8DCDE>
<td width="300">Layer-ID</td>
<td width="500"><?php echo $r[layer_id]; ?></td>
</tr>
<tr>
<td width="300" valign="top">Bezeichnung</td>
<td width="500"><?php echo "$r[Name]"; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">Gruppe</td>
<td width="500"><?php echo $r[Gruppenname]; ?></td>
</tr>
<tr>
<td width="300" valign="top">Klassifizierung</td>
<td width="500"><ul><?php 
  $classquery="SELECT * FROM classes WHERE Layer_ID = '$r[layer_id]' ORDER BY Class_ID";
  $classresult=mysql_query($classquery);
  while ($cr=mysql_fetch_array($classresult)) echo "<li>$cr[Name]</li>";
  echo "</ul>";
 ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300">Datentyp</td>
<td width="500"><?php 
  if ($r[Datentyp] == '0') echo "Vektorlayer (Punktgeometrie)";
  if ($r[Datentyp] == '1') echo "Vektorlayer (Liniengeometrie)";
  if ($r[Datentyp] == '2') echo "Vektorlayer (Flächenobjekte)";
  if ($r[Datentyp] == '3') echo "Rasterdaten";
 ?></td>
</tr>
<tr>
<td width="300" valign="top">Datenquelle</td>
<td width="500"><?php echo $r[quelle]; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">letzte Aktualisierung</td>
<td width="500"><?php echo $r[aktualitaet]; ?></td>
</tr>
<tr>
<td width="300" valign="top">Kontakt</td>
<td width="500"><?php echo $r[kontakt]; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">Bemerkungen</td>
<td width="500"><?php echo $r[comment]; ?></td>
</tr>
<tr>
<td width="300" valign="top">Veröffentlichung</td>
<td width="500"><?php 
  if ($r[open] == 0) echo "Layer wird nur internen Nutzern angeboten";
  if ($r[open] == 1) echo "Layer wird zugriffsberechtigeten Stellen angeboten";
  if ($r[open] == 2) echo "Layer ist öffentlich";

 ?></td>
<?php
 if (strlen($r[ko_auszug]) > 0) echo "
</tr>
<tr bgcolor=#D8DCDE>
<td width=\"300\" valign=\"top\">Kosten für einen Auszug</td>
<td width=\"500\" valign=\"top\">", $r[ko_auszug]," </td>
</tr>";

 if (strlen($r[ko_flat]) > 0) echo "
</tr>
<tr bgcolor=#D8DCDE>
<td width=\"300\" valign=\"top\">Kosten für die Nutzung über kvwmap<br>(monatlich)</td>
<td width=\"500\" valign=\"top\">", $r[ko_flat]," </td>
</tr>";

?>



<tr><td colspan="2"><hr></td></tr>
<?php

  

   if (strlen($r[center]) > '0')
     {
 $wms_call=URL."cgi-bin/mapserv?map=/srv/www/wms/meta.map&request=getMap&VERSION=1.1.0&layers=".$r[layers]."&srs=epsg:2398&width=400&height=400&FORMAT=image/png&BBOX=".$lur.",".$luh.",".$ror.",".$roh;      
      echo "<tr><td valign=\"top\" align=\"left\">Beispielkarte mit den Layern:<br>$r[layers]
       </td>
      <td align=\"center\"><img src=$wms_call alt=\"\" width=\"400\" border=\"3\">
       </td></tr>";  
      }
?>
</table>
<br>
<br>
<?php



 echo "<a href=$direction>Zurück</a>";

?>