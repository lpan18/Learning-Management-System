<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {

	if (isset($_GET['type']) && $_GET['type'] = 'reset') {
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		if (isset($_GET['sno'])) {
			$sno = $_GET['sno'];
		}
		$md5chushi = md5($sno);
		$namet = $_SESSION['TEACH'];

		$sql = "select * from mima_student where mima_student.tname='$namet' and sno='$sno'";
		$results = mysqli_query($link, $sql);
		$rowmima = mysqli_fetch_assoc($results);

		if ($rowmima['spassword'] == $md5chushi) {
			?>
<script language="javascript">
alert ("密码已为初始密码，无需重置！");
</script>
<meta http-equiv='refresh' content='0;URL=mimachongzhi.php'>
<?php
} else {
			$sqlreset = "update student set spassword='$md5chushi' where sno='$sno'";
			if (mysqli_query($link, $sqlreset)) {
				?>
<script language="javascript">
alert ("密码重置成功！");
</script>
<meta http-equiv='refresh' content='0;URL=mimachongzhi.php'>
<?php
}
		}
	}
} else {
	echo "对不起，您无权限查看此页面！";
}

?>

