<? 
	require_once("../class/class.dba_connect.inc");
	require_once("../class/veider_functions.inc");
	
	$conn = new dba_connect();
	$next = $conn->getNextCode("VRUSER","CDUSER");
	
	$imagem = 'null';
	
	if(!empty($_FILES["foto"]['tmp_name']))
		$imagem = "'".uploadImg($_FILES["flfoto"])."'";

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
														".$imagem."
													)";
	$conn->executeDBA($sql);
	
	echo "<script>window.close()</script>";
?>
