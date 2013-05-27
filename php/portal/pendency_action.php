<?
	require_once("../../class/class.dba_connect.inc");
	
	$conn = new dba_connect();
	
	switch($_REQUEST['type'])
	{
		case 1: // Desbloqueia administrador após pagamento
			$sql = "SELECT CDADMIN FROM VRCOMPANY WHERE CDCOMPANY = ".$_REQUEST['cdcompany'];
			$ex = $conn->query($sql);
			
			$table = array("table"=>"VRUSER");
			$fields = array("FGTYPE"=>2, "FGBLOCK"=>0);
			$where = array("CDUSER=".$ex[0]['cdadmin'] => " AND ");
			
			$ex = $conn->transaction("update", $table, $fields, $where);
			
			echo "<script>parent.location.reload();</script>";
		break;
		
		case 2:
			$sql = "SELECT CDADMIN FROM VRCOMPANY WHERE CDCOMPANY = ".$_REQUEST['cdcompany'];
			$ex = $conn->query($sql);
			
			$table = array("table"=>"VRCOMPANY");
			$where = array("CDCOMPANY=".$_REQUEST['cdcompany'] => " AND ");
			
			$del = $conn->transaction("delete", $table, null, $where);
			
			if($del) {
				$table = array("table"=>"VRUSER");
				$fields = array("FGBLOCK"=>0);
				$where = array("CDUSER=".$ex[0]['cdadmin'] => " AND ");
				$updt = $conn->transaction("update", $table, $fields, $where);
			}
			
			echo "<script>parent.location.reload();</script>";
		break;
		
		case 3:
			$table = array("table"=>"VRUSER");
			$fields = array("FGBLOCK"=>0);
			$where = array("CDUSER=".$_REQUEST['cduser']=>" AND ");
			
			$updt = $conn->transaction("update", $table, $fields, $where);
			
			echo "<script>parent.location.reload();</script>";
		break;
		
		case 4:
			$table = array("table"=>"VRUSER");
			$fields = array("FGBLOCK"=>1);
			$where = array("CDUSER=".$_REQUEST['cduser']=>" AND ");
			
			$updt = $conn->transaction("update", $table, $fields, $where);
			
			echo "<script>parent.location.reload();</script>";
		break;
	}
?>