<!doctype html>

<HTML>

<HEAD>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>	
	
		<!-- Latest compiled and minified JavaScript -->
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://openlayers.org/en/v3.20.1/build/ol.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.14/proj4.js"></script>
	<script src="ol3-layerswitcher-master/src/ol3-layerswitcher.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet">
	<link rel="stylesheet" href="ol3-layerswitcher-master/src/ol3-layerswitcher.css" />
	<link rel="stylesheet" href="https://openlayers.org/en/v3.20.1/css/ol.css" type="text/css">
	

	
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
	</script>




<script>
//Variables
var overlay = $("#overlay"),
        fab = $(".fab"),
     cancel = $("#cancel"),
     submit = $("#submit");

//fab click
fab.on('click', openFAB);
overlay.on('click', closeFAB);
cancel.on('click', closeFAB);

function openFAB(event) {
  if (event) event.preventDefault();
  fab.addClass('active');
  overlay.addClass('dark-overlay');

}

function closeFAB(event) {
  if (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
  }

  fab.removeClass('active');
  overlay.removeClass('dark-overlay');
  
}
</script>
<script>
$(document).ready(function(){
	
 	$("body").on("click","#btn",function(){
  	  	
    	$("#myModal").modal("show");
        
    	$(".blue").addClass("after_modal_appended");
    
    	//appending modal background inside the blue div
    	$('.modal-backdrop').appendTo('.blue');   
    
    	//remove the padding right and modal-open class from the body tag which bootstrap adds when a modal is shown
    
    	$('body').removeClass("modal-open")
   	 	$('body').css("padding-right","");     
  });

});
</script>

<?php include("connect_geobasis.php"); ?>
<title>Funk- und Siganlstandorte MSE</title>
</HEAD>

<BODY>



<header>						

<div class="conatiner">
<nav class="navbar navbar-default">
   <div class="container-fluid">
     <div class="navbar-header">
       <h3>Funk- und Siganlstandorte <small>im Landkreis Mecklenburgische Seenplatte</small></h3>
     </div>
	 <ul class="nav navbar-nav navbar-right">
		<li><img src="logo_landkreis-mecklenburgische-seenplatte.png" style="width:150px;margin-top:10px;margin-right:20px;"></li>
    </ul>
   </div>
</nav>
</div>
<div class="kopf1"></div>
<div class="kopf"></div>
</header>

		<div class="container" >
			<div class="row">
				<div id="sonstwas">
				
				<div class="col-sm-6"><div><a href="funk.php"> <div class="but"><img src="funk1.jpg"><div class="kopf"></div><div class="box">Funkstandorte</div></div></a></div></div>
				<div class="col-sm-6"><a href="sirenen.php"><div class="but"><img src="sirene.jpg"><div class="kopf"></div><div class="box"> Sirenenstandorte</div></div></a></div>
				
				

	

					</div>
					</div>
					</div>




</BODY>

</HTML>