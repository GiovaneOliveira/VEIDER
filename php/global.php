<?
	function createSession()
	{
		session_start();
		$session_id = session_id();
		$_SESSION["ID"] = $session_id;
	}
?>