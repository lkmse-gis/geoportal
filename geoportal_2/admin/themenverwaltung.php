<?php include ("../include/connect_geobasis_geoportal2.php"); ?>
<!DOCTYPE html>
<html>

<head>
<title> Geoportal 2.0 Admin</title>
<? include('../head.php'); ?>
<link href="style_admin.css" rel="stylesheet">


<script>
function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>

<script type="text/javascript">

$(document).ready(function () {
 
window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
    });
}, 1500);
 
});
</script>
</head>

<body>


<div class="admin-panel">



 <?php include ("navigation.php"); ?>
  
    <div class="main">
         <div id="tab1">
			<header>
				<h1>Themenverwaltung</h1>
			</header>
		</div> 
  <?php
  
	$gid = $_GET['gid'];
  
			/////////////////////////////////////////////// Datensatz löschen /////////////////////////////////////////////
	if (isset($_GET['delete'])){  
		
		
		$gid = $_GET['gid'];

		echo "<div class='popup' onLoad='myFunction()'>
				<span class='popuptext' id='myPopup'>Popup text...</span>
				</div> ";
		//$query = "DELETE FROM geoportal.geoportal_2 WHERE gid = '$gid'"; 
		//$result = $dbqueryp($connectp,$query);  
				};	
		/////////////////////////////////////////////////// Dummy erstellen /////////////////////////////////////////////
  
		if (isset($_GET['dummy'])){  
		
		
		$query = "INSERT INTO 
					geoportal.geoportal_2 (	layer_id,
											themen_name,
											kategorie,
											dateiname,
											dateipfad,
											online,
											bearbeiter,
											stichtag,
											wms,
											wms_layer,
											db_schema,
											db_sicht,
											db_query,
											beschriftung)
								VALUES 	(	'110650',
											'Dummy',
											'Gesundheit',
											'dummy.php',
											'$dateipfad',
											'',
											'$bearbeiter',
											'2017-10-05',
											'http://www.google.de',
											'Gesundheit',
											'geoportal',
											'apotheken',
											'gid,ih,stichtag',
											'{GID,Inhaber}')"; 
											
		$result = $dbqueryp($connectp,$query);   
		if (!$result){  
			echo "<div class='alert alert-danger' role='alert'>Update fehlgeschlagen</div>";  
			}  
		else  
			{
			echo "<div class='alert alert-success' role='alert'>Dummy erfolgreich generiert</div>";  
			

			}; 
		};	
  
	
  
	///////////////////////////////////////////// DB auslesen /////////////////////////////////////////////////
	$query="SELECT * FROM geoportal.geoportal_2 WHERE 1=1 ORDER BY gid";


	
	$result = $dbqueryp($connectp,$query);
	$counter=0;
	
	
	while($r = $fetcharrayp($result))
	
  {
	$gid[$counter] = $r[gid];
	$layerid[$counter] = $r[layer_id];
	$themen_name[$counter] = $r[themen_name];
	$online[$counter] = $r[online];
    $counter++;
	};


if ($counter>0) 

	{
		echo "
			
			<div class='verwaltung'>
			<input type='text' class='glyphicon glyphicon-search' id='myInput' onkeyup='myFunction()' placeholder='&#xe003 Themensuche'>
			<a href='thema_neu.php'><input type='button' id='btn-final'  class='btn btn-primary btn-info-full btn-success' value='Neuer Datensatz'></a>
			<a href='themenverwaltung.php?dummy'><input type='button' id='btn-final'  class='btn btn btn-warning ' value='Dummydatensatz'></a>
			<table class='table table-responsive' id='myTable'>
			<tr class='header'>
				<th width=150><b>GID</th>
				<th width=150><b>LayerID</th>
				<th width=300><b>Thema</th>
				<th width=100 ><b>Onlinestatus</th>
				<th><b>Einstellungen</th>
			</tr>";

		for ($i = 0; $i < $counter; $i++)
		{	
			echo "	<tr >
						<td>$gid[$i]</td>
						<td>$layerid[$i]</td>
						<td width='500'>$themen_name[$i]</td>
						<td width='200'>";
						
						if($online[$i] == true)
							{
								echo "<button style='border-radius:20px;width:40px;height:40px;' readonly type='button' class='btn btn-success  glyphicon glyphicon-ok'></button></td>";
							}
						else
							{
								echo "<button style='border-radius:20px;width:40px;height:40px;' type='button' class='btn btn-danger glyphicon glyphicon-remove'></button></td>";
							}

						echo "
						<td>
							<a href='thema.php?gid=$gid[$i]'><button type='button' class='btn btn-default prev-step'>                           
								<span>
									<i class='glyphicon glyphicon-cog'></i>
								</span>
							</button></a>
							<a href='https://geoport-lk-mse.de/schaeff/metadaten/meta_edit2.php?id=$layerid[$i]' target='blank'><button type='button'  class='btn btn-default prev-step'>                           
								<span>
									<b>LIS</b>
								</span>
							</button></a>
							
							<a href='themenverwaltung.php?gid=$gid[$i]&delete' onsubmit='return confirm('Wollen Sie diesen Eintrag wirklich löschen?')'><button type='button'  class='btn btn-default prev-step'>                           
								<span>
									<i class='glyphicon glyphicon-remove' style='color:red;'></i>
								</span>
							</button></a>
						</td>
					</tr>";
			
		}
	}
	ELSE {
		echo"<div class='verwaltung'>
		<table><tr>
		<a href='thema_neu.php'><input type='button' id='btn-final'  class='btn btn-primary btn-info-full btn-success' value='Neuer Datensatz'></a>
			<a href='themenverwaltung.php?dummy'><input type='button' id='btn-final'  class='btn btn btn-warning ' value='Dummydatensatz'></a></tr>";
	}
		echo "</table></div></p>";
			
	
?>

</div>
</div>
</body>

</html>