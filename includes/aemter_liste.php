<?php
include ("connect_geobasis.php");
include ("connect.php");
include ("portal_functions.php");

	  $query="SELECT a.name, a.amts_sf FROM fd_amtsbereiche as a ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$k]=$r;
		   $k++;
		   $count=$k;
		}
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		</head>
		<body>
			<table border=1 width="400px" cellpadding="5">
				<tr height="30px">
					<td><b>Name</b></td>
					<td><b>Amtsschlüssel</b></td>
				</tr>
				<tr>					
					<?php 
						for($y=0;$y<$k;$y++)
							{echo "<td height=\"30px\">".$aemter[$y][0]."</td><td>".$aemter[$y][1]."</td></tr>";}
					?>																		
			</table>
		</body>
		</html>