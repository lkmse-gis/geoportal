<?php
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');

$heute=date('d.m.Y');
$modus=$_GET["modus"];
$ortslage_id=$_POST["ortslage"];
$filter=$_POST["filter"];
$count=0;




if ($ortslage_id >= 1)
  {
    $query="SELECT ortslage,typ,gemschl FROM management.suchfeld_schnellsprung_ortslagen WHERE gid='$ortslage_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $ortslage=$r["ortslage"];
	  $gemschl=$r["gemschl"];
	  $typ=$r["typ"];
	  
	if ($typ != 'Gemeinde')
      {	
	  $query="SELECT strasse_name,strasse_schluessel,ortsteil,gemeinde FROM address_registry.strasse2ortslage WHERE ortslage_id ='$ortslage_id'";
	  if (isset($filter)) $query=$query." AND strasse_name LIKE '%$filter%'";
	  $query=$query." ORDER BY gemeinde,strasse_name";
	  }
	else
	  {
	  $query="SELECT strasse_name,strasse_schluessel,ortsteil,gemeinde FROM address_registry.strasse2ortslage WHERE  gem_schl='$gemschl'";
	  if (isset($filter)) $query=$query." AND strasse_name LIKE '%$filter%'";
	  $query=$query." ORDER BY gemeinde,strasse_name";
	  }
	
	$result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
  }
  else 
  {
   $ortslage="Gesamtliste";
   if ($modus != 'start')
   {
          $query="SELECT strasse_name,strasse_schluessel,ortsteil,gemeinde FROM address_registry.strasse2ortslage";
		  if (isset($filter)) $query=$query." WHERE strasse_name LIKE '%$filter%'";
		  $query=$query." ORDER BY gemeinde,strasse_name";
	  
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	}
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link href="css/style_css.php" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
	</head>
<body>

<div align=center>
<img src="../../images/geoportal_logo.png" width=1200 >
<h2> Liste der Straßen - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'start')
    {
	 echo 'Gemeinde/Ort/Ortslage: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="post" name="ortslage">
	        
			<select class="select_ort" name="ortslage" onchange="document.ortslage.submit();">
			<option >Bitte auswählen</option>
			<option value="0">Gesamtliste</option>';
			
	  $query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen ORDER BY ortslage";
	  $result = $dbqueryp($connectp,$query);
      while($r = $fetcharrayp($result))
		{
  		echo "<option ";
		if ($r["typ"] == 'Gemeinde') echo "class=bld";
		echo" value=\"$r[2]\"";
		if ($r[2] == $ortslage_id) echo "selected";
		echo ">";
		if ($r[1] == 'Gemeinde') ;
		echo "$r[0]</option>\n";
		}
		echo "</select></form>";
	}
    else 
	{
	  echo "<h3>",$ortslage," - ";
	  if ($count == 0) echo "keine Straße gefunden";
	  if ($count == 1) echo $count," Straße ";
	  if ($count > 1) echo $count," Straßen ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>
<tr>
  <td valign=top align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'start') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=start"><img src="../../kvwmap/graphics/rows.png" width=20 title="andere Gemeinde oder Ortslage wählen" border=0></a>';
 if ($modus != 'start' AND isset($count))
 {
	echo '
<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
  </td>';
  echo '
  <td colspan=2>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="filter">
    <input type=hidden name="ortslage" value="',$ortslage_id,'">
    Straßenname: <input  type=text name="filter" value="',$filter,'" length=50>
	</td><td><input type=submit value="Filter anwenden">
  </form>
  </td>
</tr>
<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle


echo "<td height=30 width=300><b>Straße</b></td>
    <td height=30 width=50></td>
	<td align=center height=30 width=300><b>Ortslage</b></td>
	<td align=center height=30 width=300><b>Gemeinde</b></td>
	<td align=center height=30 width=100><b>Schlüssel</td>
</tr>";

 for($v=0;$v<$z;$v++)
	{   
			$quot=$v;
			if($quot%2 != 0){
				echo "<tr bgcolor='#FCFCFC'";
			} else { 
			echo "<tr bgcolor='#d2e8ff'";
			}
		echo ">";
		
		
		  
			echo '<td align=left>',$bd[$v]["strasse_name"],'</td>';
            echo '<td align=center><a href="https://geoport-lk-mse.de/geoportal/adressen.php?gemeinde=',substr($bd[$v]["strasse_schluessel"],0,8),'&&hausnummer=x&strasse=',substr($bd[$v]["strasse_schluessel"],8,5),'&ortslage=',$ortslage_id,'">zur Karte</a></td>';			
			echo '<td align=left>',$bd[$v]["ortsteil"],'</td>';
			echo '<td align=left>',$bd[$v]["gemeinde"],'</td>';
            echo '<td align=left>',$bd[$v]["strasse_schluessel"],'</td>';			
			
			
			
	    echo '</tr>';
	}
	
echo "</table>";
  }
?>
</body>
</html>