<?php
	include ("../include/connect_geobasis_geoportal2.php");
	
	$gid=$_GET["gid"];
	
	

	$query="SELECT * FROM geoportal.geoportal_2 WHERE gid = $gid";
	$result = $dbqueryp($connectp,$query);
	
	$r = $fetcharrayp($result);
	
	$gid_db = $r[gid];
	$layerid_db = $r[layer_id];
	$themen_name_db = $r[themen_name];
	$online_db = $r[online];
	$dateiname_db = $r[dateiname];
	$dateipfad_db = $r[dateipfad];
	$bearbeiter_db = $r[bearbeiter];
	$stichtag_db = $r[stichtag];
	$kategorie_db = $r[kategorie];
	$beschriftung_db = $r[beschriftung];
	$wms_db = $r[wms];
	$wmslayer_db = $r[wms_layer];
	$schema_db = $r[db_schema];
	$sicht_db = $r[db_sicht];
	$query_db = $r[db_query];

	$filter=array('{','[',']','}');
		
	$beschriftung_db = str_replace($filter,"",$beschriftung_db);
	

?>
<!DOCTYPE html>
<html>

<head>
<title> Geoportal 2.0 Admin</title>
<? include('../head.php'); ?>
<link href="style_admin.css" rel="stylesheet">
<script type="text/javascript">

$(document).ready(function () {
 
window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
    });
}, 1400);
 
});
</script>
</head>

<body>


<div class="admin-panel">



 <?php include ("navigation.php"); ?>

    <div class="main" scroll="auto">
         <div id="tab1">
			<header>
				<h1>Thema <?php echo $themen_name_db;?></h1>
			</header>
		</div> 
		
		<?php
		/////////////////////////////////////////////////////////////// Speichern in die DB //////////////////////////////////////////////////////
		
		if (isset($_GET['neu'])){  
		
		
		$kategorie_neu = $_GET['kategorie'];
		$themen_name = $_GET['themen_name'];
		$layerid = $_GET['layer_id'];
		$dateiname = $_GET['dateiname'];
		$dateipfad = $_GET['dateipfad'];
		$online = $_GET['online'];
		$bearbeiter = $_GET['bearbeiter'];
		$stichtag = $_GET['stichtag'];
		$wms = $_GET['wms'];
		$wmslayer = $_GET['wmslayer'];
		$schema = $_GET['schema'];
		$sicht = $_GET['sicht'];
		$query = $_GET['query'];
		
		$query = "UPDATE geoportal.geoportal_2 SET layer_id = '$layerid', 
													themen_name = '$themen_name', 
													kategorie = '$kategorie_neu', 
													dateiname = '$dateiname',
													dateipfad = '$dateipfad',
													online = '$online',
													wms = '$wms',
													wms_layer = '$wmslayer',
													db_schema = '$schema',
													db_sicht = '$sicht',
													db_query = '$query',
													bearbeiter = '$bearbeiter',
													stichtag = '$stichtag'
											WHERE 	gid = '$gid'"; 											
		$result = $dbqueryp($connectp,$query);  
		if (!$result){  
			echo "<div class='alert alert-danger' role='alert'>Update fehlgeschlagen</div>";  
			}  
		else  
			{
			echo "<div class='alert alert-success' role='alert'>Update erfolgreich gespeichert</div>";  
			
				$query="SELECT * FROM geoportal.geoportal_2 WHERE gid = $gid";
				$result = $dbqueryp($connectp,$query);
				
				$r = $fetcharrayp($result);
				
				$gid_db = $r[gid];
				$layerid_db = $r[layer_id];
				$themen_name_db = $r[themen_name];
				$online_db = $r[online];
				$dateiname_db = $r[dateiname];
				$dateipfad_db = $r[dateipfad];
				$bearbeiter_db = $r[bearbeiter];
				$stichtag_db = $r[stichtag];
				$kategorie_db = $r[kategorie];
				$wms_db = $r[wms];
				$wmslayer_db = $r[wms_layer];
				$schema_db = $r[db_schema];
				$sicht_db = $r[db_sicht];
				$query_db = $r[db_query];
			}; 
		};
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		?>
		  <br>
		  
	<form role="form" action="thema.php" method="GET" style="max-width:600px;margin-left:auto;margin-right:auto;">
		<div class="form-group">
			<label class="control-label">GID</label>
				<input name="gid" maxlength="100" type="text" class="form-control"  readonly  value="<?php echo $gid_db; ?>"  hidden />
		</div>
		<div class="form-group">
			<label class="control-label">LayerID</label>
				<input name="layer_id" maxlength="100" type="text" class="form-control"  value="<?php echo $layerid_db; ?>"   />
		</div>
		<div class="form-group">
			<label class="control-label">Themenname</label>
				<input name="themen_name" maxlength="100" type="text" class="form-control" value="<?php echo $themen_name_db; ?>"  />
		</div>
		<div class="form-group">
			<label for="sel1">Kategorie</label>
			<select class="form-control" id="sel1" name="kategorie" >
				<option <?php if ($kategorie_db == 'Bauen'){ echo'selected';};  ?>>Bauen</option>
				<option <?php if ($kategorie_db == 'Bevölkerung'){ echo'selected';};  ?>>Bevölkerung</option>
				<option <?php if ($kategorie_db == 'Bodenrichtwerte'){ echo'selected';};  ?>>Bodenrichtwerte</option>
				<option <?php if ($kategorie_db == 'Bildung'){ echo'selected';};  ?>>Bildung</option>
				<option <?php if ($kategorie_db == 'Gesundheit'){ echo'selected';};  ?>>Gesundheit</option>
				<option <?php if ($kategorie_db == 'Kreisstruktur'){ echo'selected';};  ?>>Kreisstruktur</option>
				<option <?php if ($kategorie_db == 'Umwelt_Natur'){ echo'selected';};  ?>>Umwelt_Natur</option>
				<option <?php if ($kategorie_db == 'Sicherheit'){ echo'selected';};  ?>>Sicherheit</option>
				<option <?php if ($kategorie_db == 'Tourismus'){ echo'selected';};  ?>>Tourismus</option>
				<option <?php if ($kategorie_db == 'Verkehr'){ echo'selected';};  ?>>Verkehr</option>
				<option <?php if ($kategorie_db == 'Ver_Entsorgung'){ echo'selected';};  ?>>Ver_Entsorgung</option>
				<option <?php if ($kategorie_db == 'Wirtschaft'){ echo'selected';};  ?>>Wirtschaft</option>
			</select>
		</div> 
		<div class="form-group ">
			<div class="control-label"><label>Online</label></div>
			<label class=" switch" for="checkbox">
				<input name="online" style="width:40px;" id="checkbox"  type="checkbox" <?php if ($online_db  == true){ echo 'checked';}; ?> class="form-control"  />	
				<div class="slider round"></div>
				</label>
		</div>
		<div class="form-group">
			<label class="control-label">WMS Pfad</label>
				<input name="wms" maxlength="100" type="text" class="form-control" value="<?php echo $wms_db; ?>"  />
		</div>
		<div class="form-group">
			<label class="control-label">WMS Layer</label>
				<input name="wmslayer" maxlength="100" type="text" class="form-control" value="<?php echo $wmslayer_db; ?>"  />
		</div>
		<div class="form-group">
			<label class="control-label">Datenbank Schema</label>
				<input name="schema" maxlength="100" type="text" class="form-control" readonly  value="<?php echo $schema_db; ?>"  />
		</div>
		<div class="form-group">
			<label class="control-label">Datenbank Sicht</label>
				<input name="sicht" maxlength="100" type="text" class="form-control" readonly  value="<?php echo $sicht_db; ?>"  />
						<?php
							
							$query="SELECT table_name FROM information_schema.tables WHERE table_schema = 'geoportal'";
							
							$result = $dbqueryp($connectp,$query);
							$counter=0;

							while($r = $fetcharrayp($result))
							{
								$table_name[$counter] = $r[table_name];
								$counter++;
							};
							
							echo"<select multiple class='form-control' name='sicht' >";
							for ($i = 0; $i < $counter; $i++)
							{
								echo"<option>$table_name[$i]</option>";
							};
							echo"</select>";
							
						?>
		</div>
		<div class="form-group">
			<label class="control-label">Attribute (Query)</label>
				<input name="query" maxlength="100" type="text" class="form-control" value="<?php echo $query_db; ?>"  />
		</div>
		<?php
		
		$max = substr_count($beschriftung_db,',')+1;
		
		for($i=0; $i < $max; $i++) {
			
			$attr = explode(',',$query_db);
			$beschriftung = explode(',',$beschriftung_db);
			
			echo "<div class='form-group'>
			<label class='control-label'>Beschriftung Attribut $attr[$i]</label>
			<input name='beschriftung$i' maxlength='100' type='text' class='form-control' value='$beschriftung[$i]'  />
		</div>";
		}
		?>
		<div class="form-group">
			<label class="control-label">Dateiname</label>
				<input name="dateiname" maxlength="100" type="text" class="form-control" value="<?php echo $dateiname_db ?>"  />
		</div>
		<div class="form-group">
			<label class="control-label">Dateipfad</label>
				<input name="dateipfad" maxlength="100" type="text" class="form-control" disabled value="<?php echo '../themen/'.strtolower($kategorie_db).'/' ?>" 
		</div>
		<div class="form-group">
			<label class="control-label">Bearbeiter</label>
				<input name="bearbeiter" maxlength="100" type="text" class="form-control" value="<?php echo $bearbeiter_db ?>"  />
		</div>
		<div class="form-group">
			<label class="control-label">Stichtag</label>
				<input name="stichtag" maxlength="100" type="text" class="form-control" readonly  value="<?php echo date(DATE_ATOM); ?>"  />
		</div>

		<input type="submit" id="btn-final"  class="btn btn-primary btn-info-full btn-success" value="Speichern" name="neu"> 
		<input type="reset" id="btn" onclick="window.location.href='themenverwaltung.php'" class="btn btn-default prev-step" value="Abbrechen">
		</div>

		
		
	</div>
	</form>


</div>

</body>

</html>