    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	

    <title>Geoportal LK MSE</title>
	
	
		<!-- Latest compiled and minified JavaScript -->

    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v3.20.1/build/ol.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.14/proj4.js"></script>
	<script src="../../module/ol3-layerswitcher-master/src/ol3-layerswitcher.js"></script>
	
	<!-- Latest compiled and minified CSS -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="../../module/ol3-layerswitcher-master/src/ol3-layerswitcher.css" />

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://openlayers.org/en/v3.20.1/css/ol.css" type="text/css">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/geoportal2_2.css" rel="stylesheet">
	
	
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
	</script>

	<script>
var min=8; 
var max=19; 

function increaseFontSize14() { 
  
   var p = document.getElementsByTagName('body'); 
   for(i=0;i<p.length;i++) { 
  
      if(p[i].style.fontSize) { 
         var s = parseInt(p[i].style.fontSize.replace("px","")); 
      } else { 
  
         var s = 16; 
      } 
      if(s!=max) { 
  
         var s = 14; 
      } 
      p[i].style.fontSize = s+"px" 
  
   } 
} 

function increaseFontSize16() { 
  
   var p = document.getElementsByTagName('body'); 
   for(i=0;i<p.length;i++) { 
  
      if(p[i].style.fontSize) { 
         var s = parseInt(p[i].style.fontSize.replace("px","")); 
      } else { 
  
         var s = 16; 
      } 
      if(s!=max) { 
  
         var s = 16; 
      } 
      p[i].style.fontSize = s+"px" 
  
   } 
} 

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

