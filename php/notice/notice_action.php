<? 
	require_once("../../class/class.dba_connect.inc");
	
	$conn = new dba_connect();
	
	$table = array(
		"table"=>"VRNOTICE",
		"primarykey"=>"CDNOTICE"
	);
	$fields = array(
		"CDCOMPANY"=>$_REQUEST['cdcompany'],
		"NMNOTICE"=>$conn->formatString($_REQUEST['nmnotice']),
		"DSNOTICE"=>$conn->formatString($_REQUEST['dsnotice']),
		"DTNOTICE"=>"GETDATE()"
	);
	
	$conn->transaction("insert", $table, $fields);
	$conn->close();
	
	echo "
		<script>
			opener.parent.refreshSrc('right', '');
			alert('Notícia cadastrada!');
			window.close();
		</script>
	";
?>
