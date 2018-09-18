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
		$hname = $_GET['hname'];
		$hname1 = substr($hname, 0, strrpos($hname, '.'));
		$ch = $cname . $hname1;
		$hcontent = $_GET['hcontent'];
		$sqldel = "delete from homework where hname='$hname' and hcontent='$hcontent'";
		// echo $sqldel;
		$dir = $hcontent . $cname . $hname;
		unlink(ROOT_DIR . "$dir");
		if (mysqli_query($link, $sqldel)) {
			?>

<script language="javascript">
alert ("删除作业成功！");
</script>
<meta http-equiv='refresh' content='0;URL=showhomeworkteach.php'>

<?php
}
	} else {echo "出现错误！";}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>

