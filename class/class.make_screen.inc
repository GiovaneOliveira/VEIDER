<?
	class make_screen
	{
		function make_screen()
		{
			echo "<script language='javascript' src='../../js/screen.js'></script>";
		}
		
		function split_screen($top, $login, $left, $middle, $right, $bottom)
		{
			echo "
					<script type='text/javascript'>
						var top = '".$top."';
						var login = '".$login."';
						var left = '".$left."';
						var middle = '".$middle."';
						var right = '".$right."';
						var bottom = '".$bottom."';
						
						split_screen();
					</script>
				";
		}
	}
?>