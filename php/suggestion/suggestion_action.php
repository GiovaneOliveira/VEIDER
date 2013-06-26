<?
	require_once("../../class/class.dba_connect.inc");
	
	$conn = new dba_connect();
	
	$table = array(
		"table"=>"VRSUGGESTION",
		"primarykey"=>"CDSUGGESTION"
	);
	
	if($_REQUEST['type'] == 1) {
		$fields = array(
			"CDUSER"=>$_REQUEST['cduser'],
			"CDCOMPANY"=>$_REQUEST['cdcompany'],
			"NMSUGGESTION"=>$conn->formatString($_REQUEST['nmsuggestion']),
			"DSSUGGESTION"=>$conn->formatString($_REQUEST['dssuggestion']),
			"DTSUGGESTION"=>"GETDATE()"
		);
		$conn->transaction("insert", $table, $fields);
		$conn->close();
		
		echo "
			<script>
				alert('Sugestão cadastrada!');
				window.close();
			</script>
		";
	}
	else if($_REQUEST['type'] == 2) {
		$where = array(
			"CDSUGGESTION = ".$_REQUEST['cdsuggestion']=>" AND "
		);
		$conn->transaction("delete", $table, array(), $where);
		$conn->close();
		
		echo "
			<script>
				parent.parent.refreshSrc('middle','');
				alert('Sugestão excluída.');
			</script>
		";
	}
?>