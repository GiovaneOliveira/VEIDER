<? 
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$conn = new dba_connect();
	$next = $conn->getNextCode("VRUSER","CDUSER");
	
	$imagem = 'null';
	
	if(!empty($_FILES["flphoto"]['tmp_name']))
		$imagem = "'".uploadImg($_FILES["flphoto"])."'";
	
	if($_REQUEST['action'] == 1)
	{
		$sql = "INSERT INTO VRUSER VALUES (".$next.",
															'USER".$next."',
															'".$_REQUEST['nmuser']."',
															'".$_REQUEST['idlogin']."',
															'".$_REQUEST['idpassword']."',
															'".$_REQUEST['idmail']."',
															'".$_REQUEST['dsadress']."',
															'".$_REQUEST['nrphone']."',
															1,
															null,
															".$imagem.",
															".$_REQUEST['nmstate'].",
															".$_REQUEST['nmcity']."
														)";
	}
	else if($_REQUEST['action'] == 2)
	{
		$sql = "UPDATE VRUSER SET NMUSER = '".$_REQUEST['nmuser']."',
											 IDLOGIN = '".$_REQUEST['idlogin']."',
											 IDPASSWORD = '".$_REQUEST['idpassword']."',
											 IDMAIL = '".$_REQUEST['idmail']."',
											 DSADRESS = '".$_REQUEST['dsadress']."',
											 NRPHONE = '".$_REQUEST['nrphone']."',
											 ".(!empty($_FILES["flphoto"]['tmp_name'])?"FLPHOTO = ".$imagem.",":"")."
											 CDSTATE = ".$_REQUEST['nmstate'].",
											 CDCITY = ".$_REQUEST['nmcity']."
											 WHERE CDUSER = '".$_SESSION['user_code']."'
				";
	}
	
	$conn->insert($sql);
	
	echo "<script>".($_REQUEST['action'] == 2?"alert('relogar');":"")."window.close()</script>";
?>
