<?
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$conn = new dba_connect();
	
	$table = array("table" => "VROBJECT", 
						"primarykey" => "CDOBJECT");
						
	$fields = array("CDCOMPANY" => $_REQUEST['cdcompany'],
						"NMOBJECT" => $conn->formatString($_REQUEST['nmobject']),
						"VLOBJECT" => $_REQUEST['vlobject'],
						"FGCONDITION" => $_REQUEST['fgcondition'],
						"QTOBJECT" => 1
				);
	
		if($_REQUEST['action'] == 1)
		{
			$fieldInsert = array("IDOBJECT" => $conn->selectID("OBJECT", "CDOBJECT", "VROBJECT"));
			$fields = array_merge($fields, $fieldInsert);
			
			$conn->transaction("insert", $table,$fields);
			$conn->close();
		}
		else if($_REQUEST['action'] == 2)
		{
			$where = array("CDOBJECT = ".$_REQUEST['cdobject']=>" AND ");
		
			$conn->transaction("update", $table,$fields,$where);
			$conn->close();
		}
		
		echo "<script>window.opener.location.reload();window.close()</script>";
?>