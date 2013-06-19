<? 
	require_once("../../class/class.dba_connect.inc");
	
	$conn = new dba_connect();
	
	$table = array(
		"table"=>"VRNOTICE",
		"primarykey"=>"CDNOTICE"
	);
	$fields = array(
		"CDCOMPANY"=>$_REQUEST['cdcompany'],
		"NMNOTICE"=>$conn->formatStringDBA($_REQUEST['nmnotice']),
		"DSNOTICE"=>$conn->formatStringDBA($_REQUEST['dsnotice'])
		"DTNOTICE"=>"GETDATE()"
	);
	
	$conn->transaction("insert", $table, $fields);
	$conn->close();
	
	echo "
		<script>
			window.open('notice_data.php?cdnotice=".$cdnotice."&cdcompany=".$_REQUEST['cdcompany']."&view=1', '_self')
		</script>
	";
?>
