<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	if ($_GET['type'] = 'del') {
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		$cname = $_GET['cname'];
		$asname = $_GET['asname'];
		$ascontent = $_GET['ascontent'];
		$sqldel = "delete from answer where asname='$asname' and ascontent='$ascontent'";
		$dir = $ascontent . $cname . $asname;
		unlink(ROOT_DIR . "$dir");
		if (mysqli_query($link, $sqldel)) {
			?>

<script language="javascript">
alert ("删除课件或答案成功！");
</script>
<meta http-equiv='refresh' content='0;URL=showanswerteach.php'>

<?php
}
	} else {echo "出现错误！";}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>

