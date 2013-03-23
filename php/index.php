<?
	require_once("global.php");
	
	createSession();
	
	echo "
		<script type='text/javascript'>
			params = 'height='+screen.height+', width='+screen.width+', top=0, left=0, resizable=0, scroolbars=0';
			//params = 'height=768, width=1366, top=0, left=0, resizable=0, scroolbars=0';
			setTimeout('window.close()', 500);
			window.open('makescreen.php', '_blank', params);
		</script>
	";
?>