<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);

	if ($_POST) {
		$score = $_POST["score"];
		$word = $_POST["word"];

		$snoo = $_SESSION['s1'];
		$cnoo = $_SESSION['s2'];
		$zhangg = $_SESSION['s3'];

		$sql11 = "update sh set shscore='$score' where shhname='$zhangg' and shcno='$cnoo' and  shsno='$snoo'";
		$result1 = mysqli_query($link, $sql11);
		$sql22 = "update sh set shremark='$word' where shhname='$zhangg' and shcno='$cnoo' and  shsno='$snoo'";
		$result2 = mysqli_query($link, $sql22);
		?>
<script language="javascript">
alert ("批改信息提交成功");
    <!--

                        close(); 　这里是关闭。
                        　-->

                        </SCRIPT>
<?php

	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>


