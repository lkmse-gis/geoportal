<?php

$console = false;
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');
session_start();
$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);



if ($_SESSION['angemeldet'] === true){
	
	


?>
<!doctype html>

<HTML>

<HEAD>
<meta http-equiv="refresh" content="200">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css" type="text/css" />

<?php include("../../includes/connect_geobasis.php"); ?>
<!--<script>
            setInterval(function() {
                  window.location.reload();
                }, 240000); 
				
</script>-->
<title>Einsatztagebuch</title>
</HEAD>

<BODY>

<?php		

function lesebestaetigung($verteiler,$status,$label){

	global $i;
	
if($verteiler[$i] == "t"){
	if ($status[$i] == true){
		echo "<div style='white-space: nowrap;display: inline-block;'><font style='border:1px dotted;margin-left:4px;padding-left:3px;padding-right:3px;'><b> $label <span class='glyphicon glyphicon-ok'></span></b></font></div>";}
	else{echo "<div style='white-space: nowrap;display: inline-block;'><font style='border:1px dotted;margin-left:4px;padding-left:3px;padding-right:3px;'>$label</font></div>";}
	};

}

			
						if(isset($_POST["gelesen"])) {
						$gid1=$_POST["gid"];
						$gelesen1=$_POST["gelesen"];
						$query = "UPDATE protection.vierfachvordruck SET gelesen_s2 = '$gelesen1'  WHERE gid = '$gid1'"; 												
						$result = $dbqueryp($connectp,$query);  };
						
						if(isset($_POST["uncheck"])) {
						$gid1=$_POST["gid"];
						$gelesen1=$_POST["gelesen"];
						$query = "UPDATE protection.vierfachvordruck SET gelesen_s2 = '$gelesen1'  WHERE gid = '$gid1'"; 												
						$result = $dbqueryp($connectp,$query);  };
						
						if(isset($_POST["support"])) {
						$support1=$_POST["support"]; 
						$query = "UPDATE protection.vierfachvordruck_support SET s2_lage = '$support1'  WHERE gid = '1'"; 												
						$result = $dbqueryp($connectp,$query);  };
						
					
						if(isset($_POST["select"])) {
						$anzahl=$_POST["select"];
						if ($anzahl == '5'){
						$handle = fopen("config_s2.cfg", "w");
						fwrite ( $handle, "5"); 
						fclose ( $handle );
						}elseif($anzahl == '10'){
						$handle = fopen("config_s2.cfg", "w");
						fwrite ( $handle, "10"); 
						fclose ( $handle );
						}elseif($anzahl == '20'){
						$handle = fopen("config_s2.cfg", "w");
						fwrite ( $handle, "20"); 
						fclose ( $handle );
						}elseif($anzahl == '50'){
						$handle = fopen("config_s2.cfg", "w");
						fwrite ( $handle, "50"); 
						fclose ( $handle );
						}elseif($anzahl == '100'){
						$handle = fopen("config_s2.cfg", "w");
						fwrite ( $handle, "100"); 
						fclose ( $handle );
						}
						};
						
				

						
	
						?>

						
<div id="ausgabe">
<div class="conatiner">
<nav class="navbar navbar-default">
   <div class="container-fluid">
     <div class="navbar-header">
       <h3 style="margin-top:10px;">
	   <div style="font-size:14px;letter-spacing:6px;margin-left:2px;padding-bottom:5px;">Brand- und Katastrophenschutz MSE</div><b>Einsatztagebuch</b> | S2 - Lage / GIS</h3>
	   
     </div>
    <!-- <ul class="nav navbar-nav">
       <li class="active"></li>
       <li style="margin-left:20px;"><a href="#"><span style="font-size:1.5em;text-align:center;display:block;margin-bottom:-15px;" class="glyphicon glyphicon-file" aria-hidden="false"></span><br>Export PDF</a></li>
       <li><a href="#" class="disabled"><span style="font-size:1.5em;text-align:center;display:block;margin-bottom:-15px;" class="glyphicon glyphicon-list-alt" aria-hidden="false"></span><br>Export CSV</a></li>
       <li><a href="#"></a></li>
     </ul>-->
	 <ul class="nav navbar-nav navbar-right">
	<small style="color:white;"> v1.2.6</small>
    </ul>
   </div>
</nav>
</div>
<div class="kopf"></div>
<div class="container">
</div>
<br>
<?php

$hilfe="SELECT * FROM protection.vierfachvordruck_support WHERE s2_lage is not NULL ";
$ergebnis  = $dbqueryp($connectp,$hilfe);
while($t = $fetcharrayp($ergebnis))
  {
	$support = $t[s2_lage];
	$count++;
  };	

						$filename = "config_s2.cfg";
						$file = fopen($filename, "r");
						$anzahl =  fread($file, filesize($filename));
						fclose($file);
						
$query="SELECT *
  FROM protection.vierfachvordruck 
  WHERE verteiler_s2 is TRUE AND status is null OR absender='S2-lage/GIS'AND status is null 
  ORDER by zeitstempel DESC LIMIT $anzahl;";

$result = $dbqueryp($connectp,$query);
$count=0;


while($r = $fetcharrayp($result))
  {
	$gid[$count] = $r[gid];
	$zeitstempel[$count] = $r[zeitstempel];
	$nutzer[$count] = $r[nutzer];
	$kat_nr[$count] = $r[kat_nr];
	$nachweisung_nr[$count] = $r[nachweisung_nr];
	$vorrangstufe[$count] = $r[vorrangstufe];
	$aufgeber_anschr[$count] = $r[aufgeber_anschrift];
	$spruchkopf[$count] = $r[spruchkopf];
	$absender[$count] = $r[absender];
	$inhalt[$count] = $r[inhalt];
	$art[$count] = $r[art];
	$art_vermerk[$count] = $r[art_vermerk];
	$vermerke[$count] = $r[vermerke];
	$verteiler_s1_kum[$count] = $r[verteiler_s1_kum];
	$verteiler_s1_id[$count] = $r[verteiler_s1_id];
	$verteiler_s1_objekt[$count] = $r[verteiler_s1_objekt];
	$verteiler_s1_verkehr[$count] = $r[verteiler_s1_verkehr];
	$verteiler_s2[$count] = $r[verteiler_s2];
	$verteiler_s3[$count] = $r[verteiler_s3];
	$verteiler_s4[$count] = $r[verteiler_s4];
	$verteiler_s5_presse[$count] = $r[verteiler_s5_presse];
	$verteiler_s5_buergertelefon[$count] = $r[verteiler_s5_buergertelefon];
	$verteiler_s6_sichtna[$count] = $r[verteiler_s6_sichtna];
	$verteiler_s6_funk[$count] = $r[verteiler_s6_funk];
	$verteiler_s6_iuk[$count] = $r[verteiler_s6_iuk];
	$notiz[$count]=$r[gespraechsnotiz];
	$gelesen_s1_kum[$count] = $r[gelesen_s1_kum];
	$gelesen_s1_id[$count] = $r[gelesen_s1_id];
	$gelesen_s1_objekt[$count] = $r[gelesen_s1_objekt];
	$gelesen_s1_verkehr[$count] = $r[gelesen_s1_verkehr];
	$gelesen_s2[$count] = $r[gelesen_s2];
	$gelesen_s3[$count] = $r[gelesen_s3];
	$gelesen_s4[$count] = $r[gelesen_s4];
	$gelesen_s5_presse[$count] = $r[gelesen_s5_presse];
	$gelesen_s5_buergertelefon[$count] = $r[gelesen_s5_buergertelefon];
	$gelesen_s6_sichtna[$count] = $r[gelesen_s6_sichtna];
	$gelesen_s6_funk[$count] = $r[gelesen_s6_funk];
	$gelesen_s6_iuk[$count] = $r[gelesen_s6_iuk];
	$sichter[$count] = $r[sichter];

    $count++;
	}
	
if ($count>0) 

	{
	echo"	<div class='container'>
				<div class='panel panel-default'>
					<div class='panel-heading' style='height:100px;'>
					<img src='logo_landkreis-mecklenburgische-seenplatte.png' style='width:150px;margin-top:5px;margin-right:20px;padding:5px;'>
					<form action='s2.php' method='post'>
					<button class='buttons'";if($support === 'warten'){echo"style='background-color:#F29900;' type='submit'>In Warteschlange <span class='glyphicon glyphicon-bullhorn'></span></button>";}
					elseif($support === 'angenommen'){echo"style='background-color:#01A714;' type='submit'>Support unterwegs <span class='glyphicon glyphicon-bullhorn'></span></button>";}
					else{echo"type='submit'>Support anfordern <span class='glyphicon glyphicon-bullhorn'></span></button>";};
				echo"	<input type='hidden' value='warten' name='support'>
					</form>
					<a href='einsatz_druck.php' target='_blank'><p class='buttons'>Drucken <span class='glyphicon glyphicon-print'></span></p> </a>
						<div class='selectb'>
							<form action='s2.php' method='post'>
								<div class='form-group'>
									<label for='sel1'>Nachrichten</label>
									<select class='form-control' id='sel1' name='select'>
										<option onclick='this.form.submit()'  ";if($anzahl == '5'){echo "selected";} echo">5</option>
										<option onclick='this.form.submit()' "; if($anzahl == '10'){echo "selected";} echo">10</option>
										<option onclick='this.form.submit()' "; if($anzahl == '20'){echo "selected";} echo">20</option>
										<option onclick='this.form.submit()' "; if($anzahl == '50'){echo "selected";} echo">50</option>
										<option onclick='this.form.submit()' "; if($anzahl == '100'){echo "selected";} echo">100</option>
									</select>
								</div> 
							</form>
						</div>
					</div>
						<div class='panel-body'>
							<br>
							<table class='table '>";

		
	for ($i = 0; $i < $count; $i++)
		{	
			echo " 
					<tr  "; if ($gelesen_s2[$i] == true){ echo 'style="color:#bbb;"';} if ($vorrangstufe[$i] == ""){ echo "style='background-color:#F5F5F5 ;'";}; 
																						if ($vorrangstufe[$i] == "Normal"){ echo "style='background-color:#F5F5F5 ;'";}; 
																						if ($vorrangstufe[$i] == "Sofort"){ echo "style='background-color:lightyellow;'";}; 
																						if ($vorrangstufe[$i] == "Blitz"){ echo "style='background-color:LightSalmon;'";};echo">
						<td class='spalte0' id='[$i]'>
							<form name='b1' id='b1' action='s2.php#[$i]' method='post'>
							   <div  data-toggle='buttons'>
								<label class='switch'>
									<input type='checkbox' id='checkbox' onclick='this.form.submit()' value='";if ($gelesen_s2[$i] == true){ echo '';}else{ echo 'on';} echo"' name='gelesen' "; if ($gelesen_s2[$i] == true){ echo 'checked';} echo "><div class='slider round'></div>
									<input type='hidden' value='$gid[$i]' name='gid'>";
									if ($gelesen_s2[$i] == true){echo "<input type='hidden' name='uncheck'>";}
									if ($absender[$i] == "S2-Lage/GIS"){ echo "<br><p style='margin-left:50px;margin-top:10px;font-size: 3.2em;'><span class='glyphicon glyphicon-send'></span></p>    ";};
								echo"</label>
							</div>	 
							</form>
						</td>
						<td class='spalte1'>
							<div>$zeitstempel[$i]</div>
							<div>$nachweisung_nr[$i]</div>
							<div>$art[$i]</div>
							<div>";if($notiz[$i] == "t"){echo "<small>Gesprächsnotiz !</small>";}; echo"</div>
						</td>
						<td class='spalte2'>
							<div><table><tr><td style='width:130px;vertical-align: top; '><font style='border:1px dotted;margin-right:2px;'>$absender[$i]</font> <span class='glyphicon glyphicon-arrow-right'></span></td><td> "; 	
								lesebestaetigung($verteiler_s1_kum,$gelesen_s1_kum,"S1 - KuM");
								lesebestaetigung($verteiler_s1_id,$gelesen_s1_id,"S1 - iD");
								lesebestaetigung($verteiler_s1_objekt,$gelesen_s1_objekt,"S1 - Objekt");
								lesebestaetigung($verteiler_s1_verkehr,$gelesen_s1_verkehr,"S1 - Verkehrslenkung");
								lesebestaetigung($verteiler_s2,$gelesen_s2,"S2 - Lage");
								lesebestaetigung($verteiler_s3,$gelesen_s3,"S3 - Einsatz");
								lesebestaetigung($verteiler_s4,$gelesen_s4,"S4 - Versorgung");
								lesebestaetigung($verteiler_s5_presse,$gelesen_s5_presse,"S5 - Presse");
								lesebestaetigung($verteiler_s5_buergertelefon,$gelesen_s5_buergertelefon,"S5 - Bürgertelefon");
								lesebestaetigung($verteiler_s6_sichtna,$gelesen_s6_sichtna,"S6 - Sicht.Na."); 
								lesebestaetigung($verteiler_s6_funk,$gelesen_s6_funk,"S6 - Funk"); 
								lesebestaetigung($verteiler_s6_iuk,$gelesen_s6_iuk,"S6 - IuK"); 
								echo" </td></tr></table></div>
								<div>Anschrift: $aufgeber_anschr[$i]</div><br>
							<div><b>$spruchkopf[$i] [$vorrangstufe[$i] $art_vermerk[$i]]</b></div>		
							<div>$inhalt[$i]</div>
							<div>Vermerke: $vermerke[$i]</div>
						</td>
					</tr>";

		}
		echo "			</table>  
					</div>
					<div class='panel-footer'>© Landkreis Mecklenburgische Seenplatte 2019</div>
				</div>";
	}
	
?>
</div>


		

    <script>
    function refresh() {
      $.ajax({
        url: "",
        dataType: "text",
		cache: false,
        success: function(data) {
          $('#ausgabe').replaceWith($.parseHTML(data));

          setTimeout(refresh,10000);
        }
      });
    }
    refresh();
    </script>	

<?php 
}
else{ include ('errorpage.php'); };
?>
</BODY>

</HTML>