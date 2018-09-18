<?php
require_once '../../config.php';
session_start();

if (isset($_SESSION['ADMIN']) == TRUE) {

	if ($_GET[type] = reset) {
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		$sno = $_GET[sno];
		$md5chushi = md5($sno);
		$namet = $_SESSION['TEACH'];

		$sql = "select * from student where student.sno='$sno'";
		$results = mysqli_query($link, $sql);
		$rowmima = mysqli_fetch_assoc($results);

		if ($rowmima[spassword] == $md5chushi) {
			?>
<script language="javascript">
alert ("密码已为初始密码，无需重置！");
</script>
<meta http-equiv='refresh' content='0;URL=mimachongzhia.php'>
<?php
} else {
			$sqlreset = "update student set spassword='$md5chushi' where sno='$sno'";
			if (mysqli_query($link, $sqlreset)) {
				?>
<script language="javascript">
alert ("密码重置成功！");
</script>
<meta http-equiv='refresh' content='0;URL=mimachongzhia.php'>
<?php
}
		}
	}
} else {
	echo "对不起，您无权限查看此页面！";
}

?>

