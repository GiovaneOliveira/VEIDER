<?
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$conn = new dba_connect();
	
	
	$next = $conn->getNextCode("VRUSER","CDUSER");
	
	$imagem = "'".'null'."'";
	
	if(!empty($_FILES["flphoto_room"]['tmp_name']))
		$imagem = "'".uploadImg($_FILES["flphoto_room"], 1000, 1000)."'";
	
		if($_REQUEST['action'] == 1)
		{
			$conn->transaction("insert", array("table" => "VRROOM", 
													"primarykey" => "CDROOM"),
											array("CDCOMPANY" => $_REQUEST['cdcompany'],
													"IDROOM" => "'"."ROOM".$next."'",
													"NMROOM" => "'".$_REQUEST['nmroom']."'",
													"DSROOM" => "'".$_REQUEST['dsroom']."'",
													"VLHOUR" => $_REQUEST['vlhour'],
													"FLPHOTO" => $imagem,
													"DSADRESS" => "'".$_REQUEST['dsadress']."'",
													"HOURSST" => $_REQUEST['hoursst'],
													"HOURSEND" => $_REQUEST['hoursend'],
													"FGSUNDAY" => isset($_REQUEST['fgsunday'])?1:0,
													"FGMONDAY" => isset($_REQUEST['fgmonday'])?1:0,
													"FGTUESDAY" => isset($_REQUEST['fgtuesday'])?1:0,
													"FGWEDNESDAY" => isset($_REQUEST['fgwednesday'])?1:0,
													"FGTHURSDAY" => isset($_REQUEST['fgthursday'])?1:0,
													"FGFRIDAY" => isset($_REQUEST['fgfriday'])?1:0,
													"FGSATURDAY" => isset($_REQUEST['fgsaturday'])?1:0
											)
										);
			
			
		}
		else if($_REQUEST['action'] == 2)
		{
			
		}
		
		echo "<script>window.opener.location.reload();window.close()</script>";
?>