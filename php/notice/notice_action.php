<? 
	require_once("../../class/class.dba_connect.inc");
	session_start();
	
	$conn = new dba_connect();
	$cdnotice = $conn->getNextCode("VRNOTICE","CDNOTICE");
	
	$sql = "INSERT INTO VRNOTICE (CDNOTICE, CDCOMPANY, NMNOTICE, DSNOTICE, DTNOTICE)
			VALUES (".$cdnotice.", ".$_REQUEST['cdcompany'].", '".$_REQUEST['nmnotice']."', '".$_REQUEST['dsnotice']."', GETDATE())";
	$conn->insert($sql);
	echo "<script>window.open('notice_data.php?cdnotice=".$cdnotice."&cdcompany=".$_REQUEST['cdcompany']."&view=1', '_self')</script>";
?>
