<?
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$conn = new dba_connect();
	
	$imagem = "NULL";
	
	if(!empty($_FILES["flphoto_room"]['tmp_name']))
		$imagem = "'".uploadImg($_FILES["flphoto_room"], 1000, 1000)."'";
	
	$table = array("table" => "VRROOM", 
						"primarykey" => "CDROOM");
						
	$fields = array("CDCOMPANY" => $_REQUEST['cdcompany'],
						"NMROOM" => $conn->formatString($_REQUEST['nmroom']),
						"DSROOM" => $conn->formatString($_REQUEST['dsroom']),
						"VLHOUR" => $_REQUEST['vlhour'],
						"FLPHOTO" => $conn->formatString($imagem),
						"DSADRESS" => $conn->formatString($_REQUEST['dsadress']),
						"HOURST" => $_REQUEST['hourst'],
						"HOUREND" => $_REQUEST['hourend'],
						"FGSUNDAY" => isset($_REQUEST['fgsunday'])?1:0,
						"FGMONDAY" => isset($_REQUEST['fgmonday'])?1:0,
						"FGTUESDAY" => isset($_REQUEST['fgtuesday'])?1:0,
						"FGWEDNESDAY" => isset($_REQUEST['fgwednesday'])?1:0,
						"FGTHURSDAY" => isset($_REQUEST['fgthursday'])?1:0,
						"FGFRIDAY" => isset($_REQUEST['fgfriday'])?1:0,
						"FGSATURDAY" => isset($_REQUEST['fgsaturday'])?1:0
				);
	
		if($_REQUEST['action'] == 1)
		{
			$fieldInsert = array("IDROOM" => $conn->selectID("ROOM", "CDROOM", "VRROOM"));
			$fields = array_merge($fields, $fieldInsert);
			
			$conn->transaction("insert", $table,$fields);
			$conn->close();
		}
		else if($_REQUEST['action'] == 2)
		{
			$where = array("CDROOM = ".$_REQUEST['cdroom']=>" AND ");
		
			$conn->transaction("update", $table,$fields,$where);
			$conn->close();
		}
		
		echo "<script>window.opener.location.reload();window.close()</script>";
?>