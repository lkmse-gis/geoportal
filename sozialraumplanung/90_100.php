<?php
include ("../includes/connect_geobasis.php");

$amt_id=$_GET["amt"];

if ($amt_id > 0)
   { 
	  include ("sql_includes/bevoelkerungsdaten.php");
	  include ("sql_includes/allgemeine_daten.php");
	  include ("bev_90_99.php");
    
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>		
		</head>
		<body onload="init();load();">
		<div id="container">
			<div id="wrapper">
				<div id="content">
				<table width="100%" border="0" cellpadding="5" align="center" cellspacing="2" style="font-family:'Arial'">					
					<tr>
						<td colspan=4>
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=12 height=50>
										<b>Bevölkerungsdaten 90 bis unter 100 pro Jahr</b>							
									</td>							
								</tr>
								<tr>
									<td colspan=2 height=40><b>Amt <? echo $amtsname ;?></td>
									<td><b>90-u91</td>
									<td><b>91-u92</td>
									<td><b>92-u93</td>
									<td><b>93-u94</td>
									<td><b>94-u95</td>
									<td><b>95-u96</td>
									<td><b>96-u97</td>
									<td><b>97-u98</td>
									<td><b>98-u99</td>
									<td><b>99-u100</td>
								</tr>
								<tr>
									<td rowspan=10 align=center width="5%">2011</td>
									<td bgcolor="#A9E2F3">männlich</td>
									<td bgcolor="#A9E2F3"><? echo $m[0]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[1]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[2]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[3]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[4]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[5]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[6]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[7]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[8]; ?></td>
									<td bgcolor="#A9E2F3"><? echo $m[9]; ?></td>
								</tr>
								<tr>
									<td>männlich %</td>
									<td><? echo round((($m[0]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[1]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[2]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[3]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[4]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[5]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[6]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[7]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[8]/$gesamt_90_99_m)*100),2); ?></td>
									<td><? echo round((($m[9]/$gesamt_90_99_m)*100),2); ?></td>
								</tr>
								<tr>
									<td>männlich % am weiblichen Anteil</td>
									<td><? echo round((($m[0])/($m[0]+$w[0])*100),2); ?>
									<td><? echo round((($m[1])/($m[1]+$w[1])*100),2); ?>
									<td><? echo round((($m[2])/($m[2]+$w[2])*100),2); ?>
									<td><? echo round((($m[3])/($m[3]+$w[3])*100),2); ?>
									<td><? echo round((($m[4])/($m[4]+$w[4])*100),2); ?>
									<td><? echo round((($m[5])/($m[5]+$w[5])*100),2); ?>
									<td><? echo round((($m[6])/($m[6]+$w[6])*100),2); ?>
									<td><? echo round((($m[7])/($m[7]+$w[7])*100),2); ?>
									<td><? echo round((($m[8])/($m[8]+$w[8])*100),2); ?>
									<td><? echo round((($m[9])/($m[9]+$w[9])*100),2); ?>
								</tr>
								<tr>
									<td>männlich % an Gesamtbevölkerung</td>
									<td><? echo round((($m[0]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[1]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[2]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[3]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[4]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[5]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[6]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[7]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[8]/$gesamt)*100),2); ?></td>
									<td><? echo round((($m[9]/$gesamt)*100),2); ?></td>
								</tr>
								<tr bgcolor="#F6CECE">
									<td>weiblich</td>
									<td><? echo $w[0]; ?></td>
									<td><? echo $w[1]; ?></td>
									<td><? echo $w[2]; ?></td>
									<td><? echo $w[3]; ?></td>
									<td><? echo $w[4]; ?></td>
									<td><? echo $w[5]; ?></td>
									<td><? echo $w[6]; ?></td>
									<td><? echo $w[7]; ?></td>
									<td><? echo $w[8]; ?></td>
									<td><? echo $w[9]; ?></td>
								</tr>
								<tr>
									<td>weiblich %</td>
									<td><? echo round((($w[0]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[1]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[2]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[3]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[4]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[5]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[6]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[7]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[8]/$gesamt_90_99_w)*100),2); ?></td>
									<td><? echo round((($w[9]/$gesamt_90_99_w)*100),2); ?></td>
								</tr>
								<tr>
									<td>weiblich % am männlichen Anteil</td>
									<td><? echo round((($w[0])/($m[0]+$w[0])*100),2); ?>
									<td><? echo round((($w[1])/($m[1]+$w[1])*100),2); ?>
									<td><? echo round((($w[2])/($m[2]+$w[2])*100),2); ?>
									<td><? echo round((($w[3])/($m[3]+$w[3])*100),2); ?>
									<td><? echo round((($w[4])/($m[4]+$w[4])*100),2); ?>
									<td><? echo round((($w[5])/($m[5]+$w[5])*100),2); ?>
									<td><? echo round((($w[6])/($m[6]+$w[6])*100),2); ?>
									<td><? echo round((($w[7])/($m[7]+$w[7])*100),2); ?>
									<td><? echo round((($w[8])/($m[8]+$w[8])*100),2); ?>
									<td><? echo round((($w[9])/($m[9]+$w[9])*100),2); ?>
								</tr>
								<tr>
									<td>weiblich % an Gesamtbevölkerung</td>
									<td><? echo round((($w[0]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[1]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[2]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[3]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[4]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[5]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[6]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[7]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[8]/$gesamt)*100),2); ?></td>
									<td><? echo round((($w[9]/$gesamt)*100),2); ?></td>
								</tr>
								<tr bgcolor="#F3E2A9">
									<td>gesamt</td>
									<td><? echo $m[0]+$w[0]; ?></td>
									<td><? echo $m[1]+$w[1]; ?></td>
									<td><? echo $m[2]+$w[2]; ?></td>
									<td><? echo $m[3]+$w[3]; ?></td>
									<td><? echo $m[4]+$w[4]; ?></td>
									<td><? echo $m[5]+$w[5]; ?></td>
									<td><? echo $m[6]+$w[6]; ?></td>
									<td><? echo $m[7]+$w[7]; ?></td>
									<td><? echo $m[8]+$w[8]; ?></td>
									<td><? echo $m[9]+$w[9]; ?></td>
								</tr>
								<tr>
									<td>gesamt % an Gesamtbevölkerung</td>
									<td><? echo round(((($m[0]+$w[0])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[1]+$w[1])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[2]+$w[2])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[3]+$w[3])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[4]+$w[4])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[5]+$w[5])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[6]+$w[6])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[7]+$w[7])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[8]+$w[8])/$gesamt)*100),2); ?></td>
									<td><? echo round(((($m[9]+$w[9])/$gesamt)*100),2); ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</div>
			</div>
		</div>
		</body>
		</html>
<?  }





else
    { 	
	?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		</head>
		<body onload="init();load();">
		<div id="container">
		  <div id="header">
		  </div>
		  <div id="wrapper">
			<div id="content">
				<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
					<tr>
						<td align="center" height=30 colspan=2>
							Amt ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 	  
							<form action="statistik.php" method="get" name="amt">
								<select name="amt" onchange="document.amt.submit();">
									 <?php
									 $query="SELECT * FROM fd_amtsbereiche ORDER BY name";
									 $result = $dbqueryp($connectp,$query);

									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[amts_sf]\">$r[name]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
			</div>
		</div>
		</body>
		</html>
<?	} ?>
