<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	if ($_GET[type] = del) {
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		$scsno = $_GET[scsno];
		$sccno = $_GET[sccno];
		$sqldel = "delete from sc where scsno='$scsno' and sccno='$sccno'";
		if (mysqli_query($link, $sqldel)) {
			?>
<script language="javascript">
alert ("删除学生成功！");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
}

	} else {echo "出现错误！";}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>

