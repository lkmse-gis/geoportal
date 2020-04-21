<html>
<title>Geoportal Landkreis M&uuml;ritz</title>
<head>
<meta name="author" content="Kai Oswald Seidler">
</head>
<body link=#000000 alink=#000000 vlink=#000000>
<font face="Arial">
<div align="center">
<img src="/portal/buttons/layout.gif" width="600">
<div align="left">
&nbsp;&nbsp;&nbsp;<a href="/portal/metadaten/meta_gruppe.php">Zurück</a>
&nbsp;&nbsp;&nbsp;<a href="/portal/index.php">Zur Startseite</a><hr>
<div align="center">



<?php
include ("../connect.php");
$gruppe=$_GET["group"];

$query="SELECT Gruppenname FROM u_groups WHERE id='$gruppe'";
$result=mysql_query($query);
$r=mysql_fetch_array($result);
$gruppenname=$r[0];

?>

<br>
<font face=arial>
<div align="center">
<h2>Metadatenliste</h2>

Gruppe: <?php echo $gruppenname; ?>
<br>
<br>
<table>
<?php
$query="SELECT m.*, l.* from metadaten as m, layer as l WHERE m.layer_id=l.Layer_ID AND l.gruppe=$gruppe ORDER BY m.layer_id";

$result=mysql_query($query);
$i=1;
while ($r=mysql_fetch_array($result))
  {
    $quot=$i%2;
    if($quot ==1)
    {
    $Farbe="#D8DCDE";
    }
    else
    {
    $Farbe="#FCFCFC";
    }


    echo "<tr bgcolor=\"$Farbe\"><td width=\"300\">$r[Name]</td>
    <td width=\200\"><a href=\"meta_info.php?id=$r[layer_id]&wohin=liste\"><img src=\"/portal/buttons/s_info.png\" border=\"0\"></a></td>
     </tr>";
    $i++;
  }

?>
</table>
<br>
<hr>
</div>
<a href="meta_gruppe.php">[Zurück]</a>&nbsp;&nbsp;<a href="/portal/index.php">[Startseite]</a>
</body>
</html>