<?php
include ("../connect.php");

$id=$_GET["id"];


$query="SELECT  l.*,g.* FROM  layer as l, u_groups as g  WHERE l.Layer_ID=$id  AND  l.gruppe=g.id";
$result=mysql_query($query);
$r=mysql_fetch_array($result);
echo "<form action=\"meta_insert.php\" method=\"post\" target=\"\">
<input type=hidden name=\"id\" value=\"$id\">
<input type=hidden name=\"what\" value=\"i\">";
?>
<div align="left"><font face=arial>
<a href="layer_liste.php">Zurück zur Liste</a>&nbsp;&nbsp;&nbsp;&nbsp;
Bearbeitung der Metadaten für den Layer <?php echo $r[Name]; ?>
<hr>
<div align="left">
<table style="font-family:Arial; font-size: 10pt; font-weight: bold">
<?php
echo "<tr>
   <td colspan=\"2\" bgcolor=\"#D8DCDE\"> <input type=\"Submit\" name=\"\" value=\"&Auml;nderungen eintragen\">&nbsp;&nbsp;<input type=\"reset\">&nbsp;
   </td>
   </tr>";
?>
<tr bgcolor=#D8DCDE>
<td width="300">Layer-ID/Veröffentlichung</td>
<td width="500"><?php echo "$id&nbsp;&nbsp; 
<select name=\"open\">
   <option value=\"0\">nur intern</option>
   <option value=\"1\">frei für Verwaltungen</option>
   <option value=\"2\">öffentlich</option>
   </select> </td>";

?>
</tr>
<tr>
<td width="300">Bezeichnung</td>
<td width="500"><?php echo $r[Name]; ?></td>
</tr>
<tr>
<td width="300">Alias</td>
<td width="500"><?php echo "<input type=\"text\" name=\"alias\" value=\"$r[alias]\" size=\"80\">"; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300">Gruppe</td>
<td width="500"><?php echo $r[Gruppenname]; ?></td>
</tr>
<tr>
<td width="300" valign="top">Datenquelle</td>
<td width="500"><?php echo "<textarea name=\"quelle\" cols=\"60\" rows=\"6\"></textarea>"; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">letzte Aktualisierung</td>
<td width="500"><?php echo "<input type=\"text\" name=\"aktualitaet\"  size=\"25\" maxlength=\"25\">"; ?></td>
</tr>
<tr>
<td width="300" valign="top">Kontakt</td>
<td width="500"><?php echo "<textarea name=\"kontakt\" cols=\"60\" rows=\"4\"></textarea>"; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">Bemerkungen</td>
<td width="500"><?php echo "<textarea name=\"comment\" cols=\"60\" rows=\"6\"></textarea>"; ?></td>
</tr>
<tr>
<td width="300" valign="top">Scriptname</td>
<td width="500"><?php echo "<input type=\"text\" name=\"script\" value=\"$r[script]\" size=\"80\" maxlength=\"80\">"; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">Kosten für Auszug</td>
<td width="500"><?php echo "<input type=\"text\" name=\"ko_auszug\"  size=\"25\" maxlength=\"25\">"; ?></td>
</tr>
<tr>
<td width="300" valign="top">Kosten für Bezug über kvwmap (monatlich)</td>
<td width="500"><?php echo "<input type=\"text\" name=\"ko_flat\"  size=\"25\" maxlength=\"25\">"; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">Koordinate für Beispielkarte</td>
<td width="500"><?php echo "<input type=\"text\" name=\"center\"  size=\"25\" maxlength=\"25\">"; ?></td>
</tr>
<tr>
<td width="300" valign="top">Seitenlänge der Beispielkarte in m</td>
<td width="500"><?php echo "<input type=\"text\" name=\"range\"  size=\"5\" maxlength=\"5\">"; ?></td>
</tr>
<tr bgcolor=#D8DCDE>
<td width="300" valign="top">Layer in der Beispielkarte</td>
<td width="500"><?php echo "<input type=\"text\" name=\"layers\" size=\"80\" maxlength=\"80\">"; ?></td>
</tr>
<?php
echo "<tr>
   <td colspan=\"2\" bgcolor=\"#D8DCDE\"> <input type=\"Submit\" name=\"\" value=\"&Auml;nderungen eintragen\">&nbsp;&nbsp;<input type=\"reset\">&nbsp;
   </td>
   </tr>";
?>
</table>
</form>
<br>
<br>
<?php

if ($wohin == 'liste') $direction="meta_liste.php?group=".$r[id];
   else $direction="/portal_entwicklung/msp/metadaten/layer_lste.php";

 echo "<a href=$direction>Zurück</a>";

?>