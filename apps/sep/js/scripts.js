	(function($){
		$(document).ready(function(){
			$('ul.dropdown-menu [data-toggle=dropdown]').mouseover('click', function(event) {
				event.preventDefault(); 
				event.stopPropagation(); 
				$(this).parent().siblings().removeClass('open');
				$(this).parent().toggleClass('open');
			});
		});
	})(jQuery);
	
	function klappe (Id){
		if (document.getElementById) {
			var mydiv = document.getElementById(Id);
			mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
		}
		return true;
	}