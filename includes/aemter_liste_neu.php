<?php
include ("connect_geobasis.php");
include ("connect.php");
include ("portal_functions.php");
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		</head>
		<body>
			<table align=center border=0 cellpadding="5">
				<tr>
					<td colspan=4 align=center height="60px">
						<b><u>Landkreis Mecklenburgische Seenplatte</u></b>
					</td>
				</tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.lvb, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5221;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b><br>LVB: <b>",$r[lvb],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5221
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5513;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5513
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5223;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5223
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5619;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5619
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.lvb, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5522;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b><br>LVB: <b>",$r[lvb],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5522
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.lvb, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5516;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b><br>LVB: <b>",$r[lvb],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5516
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.lvb, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5517;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b><br>LVB: <b>",$r[lvb],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5517
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5618;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5618
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5621;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5621
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.lvb, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5620;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b><br>LVB: <b>",$r[lvb],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5620
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5520;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5520
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5224;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5224
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5222;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5222
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.lvb, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5514;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen],"<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b><br>LVB: <b>",$r[lvb],"</b></td>";
					?>
				</tr>
				<tr height=65>
					<td><b>Gemeinde</b></td>
					<td><b>Gemarkungen</b></td>
					<td><b>Ortsteile</b></td>
					<td><b>B&uuml;rgermeister</b></td>
				</tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5514
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{echo "
							<tr style=\"background-color:#BBBBBB\">
								<td><b>".$gemeinden[$y][0]."</b></td>
								<td></td>
								<td></td>
								<td><b>".$gemeinden[$y][1]."</b></td>
							</tr>
							<tr>
								<td></td>
								<td valign=top>".$gemeinden[$y][3]."</td>
								<td valign=top>".$gemeinden[$y][4]."</td>
								<td></td>
							</tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5208;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen]," (",$r[status],")<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Gemarkungen</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5208
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][3];
							$gemarkungsliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$gemarkungsliste."</td></tr>";}
					?>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Stadtteile</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5208
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][4];
							$stadtteilliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$stadtteilliste."</td></tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5202;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen]," (",$r[status],")<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Gemarkungen</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste FROM gemeinden as c	WHERE c.amt_id::integer = 5202
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][3];
							$gemarkungsliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$gemarkungsliste."</td></tr>";}
					?>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Stadtteile</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5202
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][4];
							$stadtteilliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$stadtteilliste."</td></tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5504;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen]," (",$r[status],")<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Gemarkungen</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste FROM gemeinden as c	WHERE c.amt_id::integer = 5504
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][3];
							$gemarkungsliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$gemarkungsliste."</td></tr>";}
					?>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Stadtteile</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5504
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][4];
							$stadtteilliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$stadtteilliste."</td></tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5503;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen]," (",$r[status],")<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Gemarkungen</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste FROM gemeinden as c	WHERE c.amt_id::integer = 5503
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][3];
							$gemarkungsliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$gemarkungsliste."</td></tr>";}
					?>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Stadtteile</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5503
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][4];
							$stadtteilliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$stadtteilliste."</td></tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 5603;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen]," (",$r[status],")<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b></td>";
					?>
				</tr>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Gemarkungen</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste FROM gemeinden as c	WHERE c.amt_id::integer = 5603
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][3];
							$gemarkungsliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$gemarkungsliste."</td></tr>";}
					?>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Stadtteile</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.ortsteile_liste FROM gemeinden as c	WHERE c.amt_id::integer = 5603
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][4];
							$stadtteilliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$stadtteilliste."</td></tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr>
					<?php
						$query="SELECT b.amts_sf, b.gen, a.strasse, a.plz, a.ort, a.tel, a.fax, a.email, a.internet, b.amtsvorsteher, b.status, b.person_art
								FROM fd_amtssitze_msp as a, fd_amtsbereiche as b
								WHERE b.amts_sf = a.amt_id::integer
								AND b.amts_sf = 13;";
						$result = $dbqueryp($connectp,$query);
						$r = $fetcharrayp($result);
						echo "<td colspan=2><b>",$r[gen]," (",$r[status],")<br>",
									$r[strasse],"<br>",
									$r[plz],"&nbsp;",$r[ort],
									"</b><br>Telefon: ",$r[tel],
									"<br>Fax: ",$r[fax],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$r[email]."</a></td> 
									<td colspan=2 valign='top'>",$r[person_art],": <b>",$r[amtsvorsteher],"</b><br>(Rechtsaufsicht durch Ministerium f. Inneres und Sport M-V)</td>";
					?>
				</tr>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Gemarkungen</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste FROM gemeinden as c	WHERE c.amt_id::integer = 13
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][3];
							$gemarkungsliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$gemarkungsliste."</td></tr>";}
					?>
				<tr style="background-color:#BBBBBB"><td colspan=4><b>Stadtteile</b></td></tr>
					<?php
						$query="SELECT c.gemeinde, c.buergermeister, c.gem_schl, c.gemarkungsliste, c.stadtteile_liste FROM gemeinden as c WHERE c.amt_id::integer = 13
								ORDER BY c.gemeinde;";
						$result = $dbqueryp($connectp,$query);
						$k=0;
						  while($r = $fetcharrayp($result))
							{
							   $gemeinden[$k]=$r;
							   $k++;
							   $count=$k;
							}						
						for($y=0;$y<$k;$y++)						
							{ $liste = $gemeinden[$y][4];
							$stadtteilliste = str_replace('<br>',',&nbsp;',$liste);
							echo "<tr><td colspan=4>".$stadtteilliste."</td></tr>";}
					?>
				<tr height=70><td colspan=4><hr><hr></td></tr>
				<tr ><td colspan=4><b><u>Zweckverb&auml;nde unter Rechtsaufsicht des Landkreises</u></b></td></tr>
				<tr>
					<?php
						$query="SELECT z.verband, z.verbandsvorsteher, z.strasse, z.hausnummer, z.zusatz, z.plz, z.ort, z.tel, z.fax, z.mail, z.homepage, z.art
								FROM supply_and_disposal.zweckverbaende as z
								WHERE z.art = 'Zweckverband';";
						$result = $dbqueryp($connectp,$query);
						$w=0;
						  while($r = $fetcharrayp($result))
							{
							   $zweckverbaende[$w]=$r;
							   $w++;
							   $count=$w;
							}				
						for($v=0;$v<$w;$v++)
						{echo "<td colspan=2><b>",$zweckverbaende[$v][0],"</b><br>",
									$zweckverbaende[$v][2],"&nbsp;",$zweckverbaende[$v][3],"<br>",
									$zweckverbaende[$v][5],"&nbsp;",$zweckverbaende[$v][6],
									"</b><br>Telefon: ",$zweckverbaende[$v][7],
									"<br>Fax: ",$zweckverbaende[$v][8],
									"<br>E-Mail: <a href=\"mailto:$r[email]\">".$zweckverbaende[$v][9]."</a></td> 
									<td colspan=2 valign='top'>Verbandsvorsteher: ",$zweckverbaende[$v][1],"</b></td></tr>";}
					?>				
			</table>
		</body>
		</html>