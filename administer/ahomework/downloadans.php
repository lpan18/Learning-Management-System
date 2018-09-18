<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['ADMIN']) == TRUE) {
	if ($_GET[type] = download) {
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		$cname = $_GET[cname];
		$asname = $_GET[asname];
		$ascontent = $_GET[ascontent];
		$file_name = "$cname" . "$asname";
		$file_dir = "$ascontent";
		echo $file_name;
		echo $file_dir;
		$file = fopen($file_dir . $file_name, "r");
		Header("Content-type: text/plain");
		Header("Accept-Ranges:bytes");
		Header("Accept-Length:" . filesize($file_dir . $file_name));
		Header("Content-Disposition: attachment; filename=" . $file_name);
		readfile($file_dir . $file_name);
	} else {echo "出现错误！";}
	?>
<meta http-equiv='refresh' content='0;URL=showanswerstude.php'>
<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>

