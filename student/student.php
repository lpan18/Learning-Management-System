<?php
session_start();
if (isset($_SESSION['STUDEN']) == TRUE) {

	echo '<title>作业发布与提交系统</title>';
	echo '<frameset rows="50,240,18">';
	echo '<framespacing=0 frameborder=0>';
	echo '<frame src="tops.php" frameborder=0 scrolling="no" noresize marginheight="0" marginwidth="0">';

	echo '<frameset rows="*" cols="220,*" framespacing=0 frameborder=0>';
	echo '<frame src="lefts.php" frameborder=0 scrolling="no" noresize marginheight="0" marginwidth="0">';
	echo '<frame src="contents.php" name="frmmain">';
	echo '</frameset>';

} else {
	echo "对不起，您无权限查看此页面！";
}

?>
