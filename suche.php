<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");

$suchbegriff=$_GET["suche"];
$suchbegriff2=rtrim($suchbegriff);
$begriff=strtolower($suchbegriff2);
$query="SELECT DISTINCT b.name, b.link, b.kategorie, a.keyword FROM suche_keywords as a, suche_themen as b WHERE a.thema_id=b.gid AND lower(a.keyword) LIKE '$begriff%' ORDER by b.name";
$result = $dbqueryp($connectp,$query);
$z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $ergebnis[$z]=$r;
		   $z++;
		   	
		}
$query= "SELECT * FROM suche_tabelle ORDER BY thema";
$result = $dbqueryp($connectp,$query);
	  while($r = $fetcharrayp($result))
	    {
	     $subquery="SELECT $r[feld],$r[feld_wert] ";
         if (strlen($r[zusatzfeld]) > 0) $subquery=$subquery." ,$r[zusatzfeld] ";
		 $subquery=$subquery."FROM $r[tabelle] WHERE LOWER($r[feld]) LIKE '%$begriff%'";
		 $subresult=$dbqueryp($connectp,$subquery);
		 
		 while ($subr = $fetcharrayp($subresult))
		    {
			 
				 if (strlen($subr[2]) > 0) $ergebnis[$z][name]=$subr[0].", ".$subr[2];
				 else $ergebnis[$z][name]=$subr[0];
				 
				 $ergebnis[$z][kategorie]=$r[thema];
				 $ergebnis[$z][link]=$r[link_str].$subr[1];
				 $ergebnis[$z][keyword]="Treffer Datenbank";
				 $z++;
			
			}
					   	
		}
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		</head>
		<body onload="init();load();">
		<div id="container">
		  <div id="header">
			<?php
				head_portal();
			?>
		  </div>
			<div id="wrapper">
				<div id="content">
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top align=center>
								<br>
								<table border=0 align=center width="900" cellpadding=5>									
									<?php
										echo "<tr bgcolor=$header_farbe height=35>
												<td colspan=4 align=center>
													<h3>$font_farbe Suchergebnis für \"$suchbegriff\" ($z Treffer)$font_farbe_end</h3>
												</td>
											</tr>
											<tr height=40>
												<td></td>
												<td><b><i>&darr; In der Kategorie</i></b></td>
												<td><b><i>&darr; wurde gefunden</i></b></td>
												<td></td>
											</tr>
											";
										for($v=0;$v<$z;$v++)											
												{													
													$zähler=$v+1;
													$link=$ergebnis[$v][link];
													$name=$ergebnis[$v][name];
													$kat=$ergebnis[$v][kategorie];
													$schlagwort=$ergebnis[$v][keyword];
													echo "<tr bgcolor=",get_farbe($v)," height=25>
															<td width=20>
																$zähler.
															</td>												
															<td>
																<b>$kat</b>
															</td>
															<td>
																<b>$name</b></i>
															</td>
															<td align=center>
																<a href=$link><b><img src=\"buttons/zeigen.gif\" width=73 border=0></a>
															</td>												
														</tr>										
													";
												}										
									?>									
								</table>
								<? 
								$rest=10-$z;
								for($i=0;$i<$rest;$i++) echo "<br>";
								?>
								<br>
							</td>
						</tr>						
					</table>
				</div>
			</div>
			<div id="navigation">
				<table border="0" align="left">
					<tr>
						<td>
							<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js"></script>
						</td>
					</tr>
				</table>
			</div>
			<div id="extra">
				<? include ("includes/news.php"); ?>
			</div>
			<div id="footer">    
			</div>
		</div>		
		</body>
		</html>