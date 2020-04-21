<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="refresh" content="20">
		
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
		<script src="../einsatztagebuch/jquery-3.3.1/jquery-3.3.1.js"></script>
		<script src="../einsatztagebuch/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>

		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
		
		<link rel="stylesheet" href="../einsatztagebuch/bootstrap-4.1.3-dist/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		<!--<link rel="stylesheet" href="../einsatztagebuch/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" />-->
		<link rel="stylesheet" href="style.css" type="text/css" />
		
		<?php include("../../includes/connect_geobasis.php"); ?>
		
		<title>Einsatztagebuch</title>
		
	<?php
	//////// Konfiguration ETB / Funktionen /////////////////////////////////////////////////////////
	
	$verteiler 	= 'verteiler_lage';
	$limit		= '100';
	$stelle		= 'Lage/Dokumentation';
	
	
	function lesebestaetigung($verteiler,$status,$label){

	global $i;
	
	if($verteiler[$i] == "t"){
		if ($status[$i] == true){
			echo "<div style='white-space: nowrap;display: inline-block;'><font style='border:1px dotted;margin-left:4px;padding-left:3px;padding-right:3px;font-size:0.8em;'><b> $label <span class='fas fa-check'></span></b></font></div>";}
		else{echo "<div style='white-space: nowrap;display: inline-block;'><font style='border:1px dotted;margin-left:4px;padding-left:3px;padding-right:3px;font-size:0.8em;'>$label</font></div>";}
		};

	}
	?>
	</head>
	<body>
	
	<?php
	
		$query="SELECT *
		FROM katastrophenschutz.vierfachvordruck 
		WHERE $verteiler is TRUE AND status is null OR absender='$stelle' AND status is null 
		ORDER by zeitstempel DESC LIMIT $limit;";

		$result = $dbqueryp($connectp,$query);
		$count=0;
	
	
		while($r = $fetcharrayp($result))
		{
			$gid[$count] 				= $r[gid];
			$zeitstempel[$count] 		= $r[zeitstempel];
			$nutzer[$count] 			= $r[nutzer];
			$kat_nr[$count] 			= $r[kat_nr];
			$nachweisung_nr[$count] 	= $r[nachweisung_nr];
			$vorrangstufe[$count]		= $r[vorrangstufe];
			$aufgeber_anschr[$count] 	= $r[aufgeber_anschrift];
			$spruchkopf[$count] 		= $r[spruchkopf];
			$absender[$count] 			= $r[absender];
			$inhalt[$count] 			= $r[inhalt];
			$art[$count] 				= $r[art];
			$art_vermerk[$count] 		= $r[art_vermerk];
			$vermerke[$count] 			= $r[vermerke];
			$notiz[$count]				= $r[gespraechsnotiz];
			$verteiler_leiter[$count]	= $r[verteiler_leiter];
			$verteiler_id[$count]		= $r[verteiler_id];
			$verteiler_lage[$count]		= $r[verteiler_lage];
			$verteiler_iuk[$count]		= $r[verteiler_iuk];
			$verteiler_buma[$count]		= $r[verteiler_buma];
			$gelesen_leiter[$count]		= $r[gelesen_leiter];
			$gelesen_id[$count]			= $r[gelesen_id];
			$gelesen_lage[$count]		= $r[gelesen_lage];
			$gelesen_iuk[$count]		= $r[gelesen_iuk];
			$gelesen_buma[$count]		= $r[gelesen_buma];
			$status[$count]				= $r[status];
		
			$count++;
		}
		
		echo'
		
		

<nav class="navbar navbar-default">
<a class="navbar-brand" href="#"><img src="Logo2.jpg" style="width:30%;"></a>
   <div class="container-fluid">
     <div class="navbar-header">
	 
       <h3 style="margin-top:10px;">
	   <div style="font-size:14px;letter-spacing:6px;margin-left:2px;padding-bottom:5px;">Brand- und Katastrophenschutz MSE</div><b>Einsatztagebuch</b> | '.$stelle.'</h3>
	   
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

		<div class="kopf"></div>';
		
		if ($count>0) 
		{
			echo'
				<section class="msger">
					<header class="msger-header">
						<div class="msger-header-title">
							<i class="fas fa-comment-alt"></i> 
						</div>
						<div class="msger-header-options">
							<span><i class="fas fa-cog"></i></span>
						</div>
					</header>';
					
					
			for ($i = 0; $i < $count; $i++)
			{
				echo'	<main class="msger-chat">
						<div class="';if ( $absender[$i] == $stelle) { echo 'msg right-msg';}
										ELSE{ echo 'msg left-msg'; }; echo'">
							<div class="msg-img" style="background-image: url()">';
							if ( $absender[$i] == $stelle) { echo '<p style="font-size:1.5em;margin-top:10px;margin-left:12px;padding:0px;"><i class="fas fa-pencil-alt" style="font-size:36px"></i></p> ';} 
								ELSE {
									switch ($absender[$i]) {
										CASE 'Leiter KGS': echo'<p style="margin-top:20px;margin-left:8px;"><b>Leiter</b></p>';
										break;	
										CASE 'Innerer Dienst': echo'<p style="margin-top:20px;margin-left:22px;"><b>ID</b></p>';
										break;								
										CASE 'Lage/Dokumentation': echo'<p style="margin-top:22px;margin-left:11px;"><b>Lage</b></p>';
										break;
										CASE 'IuK': echo'<p style="margin-top:20px;margin-left:14px;"><b>IuK</b></p>';
										break;
										CASE 'BuMa': echo'<p style="margin-top:20px;margin-left:6px;"><b>BuMa</b></p>';
										break;								
										}
								}
							echo'</div>

						<div class="msg-bubble">
							<div class="msg-info">
								<div class="msg-info-name">';
									lesebestaetigung($verteiler_leiter,$gelesen_leiter,"Leiter KGS");
									lesebestaetigung($verteiler_id,$gelesen_id,"Innerer Dienst");
									lesebestaetigung($verteiler_lage,$gelesen_lage,"Lage/Dokumentation");
									lesebestaetigung($verteiler_iuk,$gelesen_iuk,"IuK");
									lesebestaetigung($verteiler_buma,$gelesen_buma,"BuMa");	
								echo'
								</div>
								<div class="msg-info-time"><b>'.date("H:",strtotime($zeitstempel[$i])).'<sup style="text-decoration:underline;">'.date("i",strtotime($zeitstempel[$i])).'</sup> Uhr</b><br><sup>('.date("d.m.Y",strtotime($zeitstempel[$i])).')</sup><br><b>'.$nachweisung_nr[$i].'</b></div>
								</div>
								<div class="msg-text"><b>';
									echo $spruchkopf[$i]; echo'</b><br>';
									echo $inhalt[$i];
								echo'</div><br>
								<div class="button"><a href="https://geoport-lk-mse.de/kvwmap/index.php?go=neuer_Layer_Datensatz&selected_layer_id=120130&attributenames[0]=spruchkopf&values[0]=AW: '.$spruchkopf[$i].' ( '.$nachweisung_nr[$i].' )" target="_blank">Antworten</a></div>
							</div>
						</div>
					</main>';
			}

				echo'</section>';
			
		}
	?>

	</body>
</html>