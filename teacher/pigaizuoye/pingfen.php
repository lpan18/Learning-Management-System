<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {

	if ($_GET[type] = reset) {
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		$sno = $_GET[sno];
		$cno = $_GET[cno];
		$hname = $_GET[hname];
		$shhname = substr($hname, 0, 3) . ".cpp";
		$_SESSION['s1'] = $sno;
		$_SESSION['s2'] = $cno;
		$_SESSION['s3'] = $shhname;
		$q1 = mysqli_query($link, "select cname from course where cno='$cno'");
		$row1 = mysqli_fetch_assoc($q1);
		$cname = $row1["cname"];
		$_SESSION['s4'] = $cname;
		$q2 = mysqli_query($link, "select sname from student where sno='$sno'");
		$row2 = mysqli_fetch_assoc($q2);
		$sname = $row2["sname"];
		$_SESSION['s5'] = $sname;
		?>

<script language="javascript">
//获得焦点输入背景设置为红色
function setStyle(x)
{
document.getElementById(x).style.background="pink"
}
//失去焦点输入背景重置为白色
function recoveryStyle(y)
{
document.getElementById(y).style.background="White"
}
</script>
<form id="formpingfen" name="formpingfen" method="post" action="tijiao.php" ">
<div align="center"><b><font size='6'>查看与批改作业</font></b><br><br></div>
<table width="700" border="1" align="center" cellpadding=5>
<tr>
<td>
<?php
$hhname = $_SESSION['s3'];
		$cname = $_SESSION['s4'];
		$sname = $_SESSION['s5'];
		$path = "/http/tijiaozuoye/$cname/" . $sname . $cname . $hhname;
		echo "<b>" . $sno . "&nbsp" . $sname . "&nbsp" . $cname . "&nbsp" . $hhname . "<br><br>作业内容如下：<br><br></b>";
		function read_file($filename) {
			$fp = fopen($filename, "r") or die("读取文件内容错误");
			$read = fread($fp, filesize($filename));
			fclose($fp);
			return $read;
		}
		$str = read_file($path);
		echo iconv("gb2312", "gbk", $str);
		?>
</td>
</tr>
<tr height=80>
<td>请给出评分(请输入0-100的数字)：<br><input type="text" name="score" id="score" onfocus="setStyle(this.id)" id="score" onBlur="recoveryStyle(this.id)" style="height=25px;width=80px;">
<script language="javascript">
document.all.score.focus()
</script></td>
</tr>
<tr  height=80>

<td>请给出评语(50个汉字或100个字符左右）：<br><input type="text" name="word" id="word" onfocus="setStyle(this.id)" id="word" onBlur="recoveryStyle(this.id)" style="height=25px;width=480px;">
</td>
</tr>
<tr align="center">
<td><input type=submit name=submit id=submit value="批改完毕提交" style="height=30px;width=90px;">
<input type="reset" name="reset" id="reset" value="重置" style="height=30px;width=90px;"></td>
</tr>

</table>
</form>
</html>
<?php

	}
} else {
	echo "对不起，您无权限查看此页面！";
}

?>

