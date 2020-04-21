<?
	echo "
		<script type='text/javascript'>
			<!--
			function init(){
				getTime();
				window.setInterval('getTime();',1000);
			}

			function nullOderNicht(wert){
				wert = String(wert);
				if(wert.length < 2){
					return 0+wert;
				}else{
					return wert;
				}
			}

			function getTime(){
				var dat = new Date();
				document.getElementById('zeit').innerHTML = 
			nullOderNicht(dat.getHours())+':'+nullOderNicht(dat.getMinutes())+':'+nullOderNicht(dat.getSeconds());
			}
			-->
		</script>
	"
?>