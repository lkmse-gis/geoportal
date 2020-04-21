<!DOCTYPE html>
<html>

<head>
<title> Geoportal 2.0 Admin</title>
<? include('../head.php'); ?>
<?php include ("../include/connect_geobasis_geoportal2.php"); ?>
<link href="style_admin.css" rel="stylesheet">
<meta charset="utf-8"  />



</head>

<body>


<div class="admin-panel" >

<?php include ("navigation.php"); ?>


<?php
 
$query="SELECT gid FROM geoportal.geoportal_2";

$result = $dbqueryp($connectp,$query);
$themen_count=0;

while($r = $fetcharrayp($result))
  {
    $themen_count++;
	}
?>


    <div class="main">
         <div id="tab1">
			<header>
				<h1>Übersicht</h1>
			</header>		
			<p>

		
			<div class="container">
      
				<table class="table" style="width:50%;">
					<tbody>
					<tr>
						<td>Geoportal Version</td>
						<td>0.6.6-0356</td>
					</tr>
					<tr>
						<td>Aktuelle Themen</td>
						<td><?php echo $themen_count; ?></td>
					</tr>
					<tr>
						<td>Geoport Admin Version</td>
						<td>0.2.1-0076</td>
					</tr>
					</tbody>
				</table>
				</div>
<br><br>
  <!--<h2 class="text-center">Scroll down the page a bit</h2><br><br> -->
<div class="container">
  <div class="row">
    <div class="col-md-2 col-lg-2"></div>
     <div class="col-md-8 col-lg-8">
       
<div class="barWrapper">
 <span class="progressText"><B>Geoportal 2.0</B></span>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" >   
        <span  class="popOver" data-toggle="tooltip" data-placement="top" title="30%"> </span>     
</div>
</div>

<div class="barWrapper">
 <span class="progressText"><B>Geoport Admin</B></span>
<div class="progress ">
  <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="10" aria-valuemax="100" style="">
     <span  class="popOver" data-toggle="tooltip" data-placement="top" title="25%"> </span>  
  </div>
  
</div>
</div>
<!--
<div class="barWrapper">
 <span class="progressText"><B>BOOTSTRAP</B></span>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
     <span  class="popOver" data-toggle="tooltip" data-placement="top" title="65%"> </span>  
  </div>
</div>
</div>
<div class="barWrapper">
 <span class="progressText"><B>JQUERY</B></span>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
         <span  class="popOver" data-toggle="tooltip" data-placement="top" title="55%"> </span>  
  </div>
</div>
</div>
<div class="barWrapper">
 <span class="progressText"><B>MYSQL</B></span>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
      <span  class="popOver" data-toggle="tooltip" data-placement="top" title="70%"> </span>  
  </div>
</div>
</div>
  <div class="barWrapper">
 <span class="progressText"><B>PHP</B></span>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
      <span  class="popOver" data-toggle="tooltip" data-placement="top" title="75%"> </span> 
  </div>
</div>
</div>
-->
</div>
     <div class="col-md-2 col-lg-2"></div>
    </div>
</div>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
<script >$(function () { 
  $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
});  

 
  $(".progress-bar").each(function(){
    each_bar_width = $(this).attr('aria-valuenow');
    $(this).width(each_bar_width + '%');
  });
       

</script>

			</div>
			</p>
		</div> 

 
</div>

</body>

</html>