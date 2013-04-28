<?
    require_once("../../class/class.calendar.inc");
?>
<html>
<head>
<style type="text/css">
    td {
        border:1px solid lightgray;
    }
    th {
        border:1px solid gray;
        height:30px;
    }
</style>
<?
    $variation = (isset($_REQUEST['variation'])? $_REQUEST['variation'] : 0);
	$calendar = new calendar($variation);
?>
</head>
<body style="background-color:#333333; overflow:hidden; margin:4; padding:0;" >
<?
	$calendar->printCalendar();
?>
<script type="text/javascript">
	var variation = <?echo $variation;?>;
	function changeMonth(type)
	{
		if(type == "previous") {
			variation --;
		} else if(type == "next") {
			variation ++;
		}
		location.replace("company_calendar.php?variation="+variation);
	}
</script>
</body>
</html>