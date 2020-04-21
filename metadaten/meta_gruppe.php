<html>
<title>Geoportal Landkreis M&uuml;ritz</title>
<head>
<meta name="author" content="Kai Oswald Seidler">
</head>

<?php
include ("../connect.php");
include ("../portal_functions.php");
$gruppe=$_GET["group"];
$grname=$_GET["grname"];
?>
<body>
<?php

	echo "<br><table align='center' width='465'><tr><td><b>Sie befinden sich hier: <a href=javascript:ajaxpage('metadaten/meta_gruppe.php','content')>Metadaten</a> >> ".$grname."</b></td></tr></table>";

?>

<div align="center">
<table>
<tr>
<td width=440 bgcolor=<? echo $header_farbe ;?>>
<h2>Metadatenliste</h2>
</td>
</tr>
</table>
Die Daten sind in folgenden Gruppen organisiert:
<br>
<br>
<table>
<?php
$query="SELECT * from u_groups WHERE Gruppenname != 'Suchergebnis' ORDER BY Gruppenname";
$result=mysql_query($query);
$i=1;
while ($r=mysql_fetch_array($result))
  {
    $countquery="SELECT count(*) FROM metadaten as m, layer as l WHERE m.layer_id=l.Layer_ID AND l.gruppe=$r[id]";
    $countresult=mysql_query($countquery);
    $count_r=mysql_fetch_array($countresult);
    if ($count_r[0] > 0)
     {
      $quot=$i%2;
      if($quot ==1)
      {
        $Farbe=$element_farbe;
      }
      else
      {
       $Farbe="#FCFCFC";
      }
     if ($gruppe == $r[id]) $size="16pt";  
                     else $size="11pt"; 


    echo "<tr bgcolor=\"$Farbe\"><td width=\"300\" style=\"font-family:Arial; font-size: $size; font-weight: bold\">$r[Gruppenname]</td>
        <td width=30>$count_r[0]</td>
        <td width=80>Themen</td>    
     <td width=\50\" align=right>";
     if ($gruppe == $r[id])
       {
         echo "<a href=\"javascript:ajaxpage('metadaten/meta_gruppe.php?group=0&wohin=liste','content')\"><<</a></td></tr>";
$gquery="SELECT m.*, l.* from metadaten as m, layer as l WHERE m.layer_id=l.Layer_ID AND l.gruppe=$gruppe ORDER BY m.layer_id";

$gresult=mysql_query($gquery);
$gi=1;
echo "<tr><td colspan=4><hr></td></tr>";
while ($gr=mysql_fetch_array($gresult))
  {
    $quot=$gi%2;
    if($quot ==1)
    {
    $Farbe=$element_farbe;
    }
    else
    {
    $Farbe="#FCFCFC";
    }


    echo "<tr><td width=\"300\" align=right>$gr[Name]</td>
    <td width=\200\"><a href=\"javascript:ajaxpage('metadaten/meta_info.php?id=$gr[layer_id]&wohin=liste&group=$gruppe', 'content')\"><img src=\"/portal/buttons/s_info.png\" border=\"0\"></a></td>
     </tr>";
    $gi++;
  }
echo "<tr><td colspan=4><hr></td></tr>";

       }
       else
       {
         echo "<a href=\"javascript:ajaxpage('metadaten/meta_gruppe.php?group=$r[id]&grname=$r[Gruppenname]&wohin=liste','content')\">>></a></td></tr>";

       }

     

   
    $i++;
    }
  }

?>
</table>
</div>
<div align="center"><a href="metadaten/Metadaten.pdf" target="_blank">Erfassungsbogen f&uuml;r Metadaten</a></div>
<br>
<br>
</body>
</html>