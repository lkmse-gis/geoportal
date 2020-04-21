<?
	echo"	
		<script type='text/javascript'>
			function meta_popup (url) {
				fenster = window.open(url, 'Popupfenster', 'width=700,height=650,resizable=no,scrollbars=yes,toolbar=no,status=no,menubar=no,location=no,directories=no');
				fenster.focus();
				return false;
			}
		</script>
		<script type='text/javascript'>
			function hilfe_popup (url) {
				fenster = window.open(url, 'Popupfenster', 'width=675,height=855,resizable=yes');
				fenster.focus();
				return false;
			}
		</script>
		<script type='text/javascript'>
			function liste_popup (url) {
				fenster = window.open(url,'Popupfenster','width=460,resizable=yes,scrollbars=yes,');
				fenster.focus();
				return false;
			}
		</script>
		
	";
?>