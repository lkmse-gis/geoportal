<?
include ("includes/portal_functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
	<table border="0" align="center" cellpadding="3" width="100%">
		<tr bgcolor=<? echo $header_farbe ;?>>
			<td align=center colspan="3" height=40>
				<font size="+1" color=white>Sitemap</font>
			</td>
		</tr>
		<tr valign="top">
			<td bgcolor=<? echo $element_farbe ;?> rowspan=6>
				<ul>
					<li><a href="index.php">Startseite</a></li>
				</ul>
			</td>
			<td bgcolor=<? echo $element_farbe ;?> rowspan=6>
				<ul>
					<li>Wo finde ich was?</li>
						<ul>
							<li>Bev&ouml;lkerung</li>
								<ul>
									<li>Bev&ouml;lkerungsdichte</a></li>
										<ul>
											<li>Gemeinde</li>
												<ul>
													<li><a href="bevdichte_2012_msp.php">2012</a></li>
													<li><a href="bevdichte_2011_msp.php">2011</a></li>
													<li><a href="bevdichte_2010_msp.php">2010</a></li>
													<li><a href="bevdichte_2009_msp.php">2009</a></li>
													<li><a href="bevdichte_1995_msp.php">1995</a></li>
													<li><a href="bevdichte_1990_msp.php">1990</a></li>
												</ul>
										</ul>
									<li>Bev&ouml;lkerungsgewichtung</a></li>
										<ul>
											<li>Gemeinde</li>
												<ul>
													<li><a href="bevgewichtung_2012_msp.php">2012</a></li>
													<li><a href="bevgewichtung_2011_msp.php">2011</a></li>
													<li><a href="bevgewichtung_2010_msp.php">2010</a></li>
													<li><a href="bevgewichtung_2009_msp.php">2009</a></li>
													<li><a href="bevgewichtung_1995_msp.php">1995</a></li>
													<li><a href="bevgewichtung_1990_msp.php">1990</a></li>
												</ul>
										</ul>
									<li>Bev&ouml;lkerungszahlen</a></li>
										<ul>
											<li>Gemeinde</li>
												<ul>
													<li><a href="bevgw_2012_msp.php">2012</a></li>
													<li><a href="bevgw_2011_msp.php">2011</a></li>
													<li><a href="bevgw_2010_msp.php">2010</a></li>
													<li><a href="bevgw_2009_msp.php">2009</a></li>
													<li><a href="bevgw_1995_msp.php">1995</a></li>
													<li><a href="bevgw_1990_msp.php">1990</a></li>
												</ul>
										</ul>
								</ul>
							<li>Bodenrichtwerte</li>
								<ul>
									<li><a href="borisagr.php">Bodenrichtwerte Ackerland/Gr&uuml;nland</a></li>
									<li><a href="borisf.php">Bodenrichtwerte Bauland</a></li>
								</ul>
							<li>Bildung</li>
								<ul>
									<li><a href="schulen_msp.php">Schulen</a></li>									
								</ul>
							<li>Energie</li>
								<ul>
									<li><a href="bioenergie_msp.php">Bioenergieanlagen</a></li>
									<li><a href="solar_msp.php">Solaranlagen</a></li>
								</ul>
							<li>Gesundheit</li>
								<ul>
									<li><a href="apo_msp.php">Apotheken</a></li>
									<li><a href="kh_msp.php">Krankenh&auml;user</a></li>
								</ul>
							<li>Kreisstruktur</li>
								<ul>
									<li><a href="aemter_msp.php">Amtsbereiche</a></li>
									<li><a href="gemeinden_msp.php">Gemeinden</a></li>
									<li><a href="gemarkungen_msp.php">Ortschaften(Gemarkungen)</a></li>									
									<li><a href="plz_msp.php">Postleitzahlbereiche</a></li>
									<li><a href="regionen_msp.php">Regionen</a></li>
								</ul>
							<li>Natur/Umwelt</li>
								<ul>
									<li><a href="ffh_fl_msp.php">Fauna Flora Habitat Gebiete</a></li>
									<li><a href="ffh_pkt_msp.php">Fauna Flora Habitat Punkte</a></li>
									<li><a href="geotop_fl_msp.php">Geotope (Fl&auml;chen)</a></li>									
									<li><a href="geotop_pkt_msp.php">Geotope (Punkte)</a></li>
									<li><a href="horst_msp.php">Horststandorte (SPA)</a></li>
									<li><a href="lsg_msp.php">Landschaftsschutzgebiete</a></li>
									<li><a href="nlp_msp.php">Nationalparke</a></li>
									<li><a href="npa_msp.php">Naturparke</a></li>									
									<li><a href="nsg_msp.php">Naturschutzgebiete</a></li>
									<li><a href="nw_msp.php">nat&uuml;rliche W&auml;lder</a></li>
									<li><a href="spa_msp.php">Vogelschutzgebiete</a></li>
								</ul>
							<li>Sicherheit/Ordnung</li>
								<ul>
									<li><a href="polizei_msp.php">Polizei</a></li>									
								</ul>
							<li>Tourismus</li>
								<ul>
									<li><a href="badestellen_msp.php">Badestellen</a></li>
									<li><a href="kirchen_msp.php">Kirchen</a></li>									
								</ul>
							<li>Verkehr</li>
								<ul>																	
									<li><a href="sbab_msp.php">Stra&szlig;enbau&auml;mter<br>(Bereiche)</a></li>
									<li><a href="sbmb_msp.php">Stra&szlig;enmeisterein<br>(Bereiche)</a></li>
									<li><a href="sbm_msp.php">Stra&szlig;enmeisterein<br>(Sitze)</a></li>
								</ul>
							<li>Versorgung/Entsorgung</li>
								<ul>
									<li><a href="tank_msp.php">Tankstellen</a></li>									
								</ul>
							<li>Verwaltung</li>
								<ul>
									<li><a href="arge_msp.php">Arbeitsagenturen</a></li>
									<li><a href="finanz_msp.php">Finanz&auml;mter</a></li>
									<li><a href="gerichte_msp.php">Gerichte/Staatsanwaltschaft</a></li>
									<li><a href="jcenter_msp.php">Jobcenter</a></li>
									<li><a href="notare_msp.php">Notare</a></li>
									<li><a href="sba_msp.php">Stra&szlig;enbau&auml;mter</a></li>
									<li><a href="vsitz_msp.php">Verwaltungsstandorte<br>&Auml;mter</a></li>
									<li><a href="ksitz_msp.php">Verwaltungsstandorte<br>Landkreis</a></li>
								</ul>							
						</ul>
				</ul>
			</td>
			<td bgcolor=<? echo $element_farbe ;?>>
				<ul>
					<li><a href="javascript:ajaxpage('neues.php', 'content')">Themen&uuml;bersicht</a></li>
				</ul>
			</td>			
		</tr>
		<tr>
			<td bgcolor=<? echo $element_farbe ;?>>
				<ul>
					<li><a href="allinone_msp.php">Alles Themen auf<br> einen Blick</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td bgcolor=<? echo $element_farbe ;?>>
				<ul>
					<li>kvwmap Start</li>
						<ul>
							<li><a href="../kvwmapmsp/index.php?gast=50" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;">B&uuml;rgerportal</a></li>
							<li><a href="../kvwmapmsp" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;">registrierte User</a></li>
						</ul>
				</ul>
			</td>					
		</tr>
		<tr>			
			<td bgcolor=<? echo $element_farbe ;?>>
				<ul>
					<li><a href="javascript:ajaxpage('../both/portale.php', 'content')">Geoportale der<br> anderen Kreise</a></li>
				</ul>
			</td>
		</tr>
	</table>
</body>
</html>