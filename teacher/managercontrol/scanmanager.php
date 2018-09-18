<?php
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {

	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

function check()
{
var tian=document.all;

if(tian.msno.value=="")
{
alert("请您输入新管理员的学号！");
tian.msno.focus();
return false;
}

if(tian.mcno.value=="")
{
alert("请您输入新管理员管理的课程编号！");
tian.mcno.focus();
return false;
}
}

</script>
</head>
<body>
<p align="center"><b><font size="6">管理员名单</font></b></p>
<?php
require_once '../../config.php';
	$namet = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from scanmanager_teacher where scanmanager_teacher.tname='$namet' order by sccno";
	$results = mysqli_query($link, $sql);
	$rows = @mysqli_num_rows($results);

	if ($rows < 1) {
		echo '<p align="center">没有管理员</p>';
	} else {
		?>
<table border='1' space="1" align='center' width=800  Cellpadding=10>

<tr bgcolor="pink" align="center">
<th>
管理员学号
</th>
<th>
管理员姓名
</th>
<th>
管理的课程编号
</th>
<th>
管理的课程名
</th>
<th>
删除管理员
</th>
</tr>


<?php

		while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td>";
			echo $row["scsno"];
			echo "</td>";
			echo "<td>";
			echo $row["sname"];
			echo "</td>";
			echo "<td>";
			echo $row["sccno"];
			echo "</td>";
			echo "<td>";
			echo $row["cname"];
			echo "</td>";
			echo "<td>";
			echo "<a  href=delmanager.php?scsno=" . $row["scsno"] . "&sccno=" . $row["sccno"] . "&type=del onclick=\"return confirm('您真的要删除该管理员吗？')\">删除</a>";
			echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}
	?>

<form id="formadd" name="formadd" method="post" action="addmanager.php" onsubmit="return check()">
<p align="center"><b><font size="6"><br>添加管理员<br><br></font></b></p>
<table width="300" border="0" align="center">
<tr>
<td>管理员学号：</td>
<td><input name="msno" type="text" id="msno" size=20 onfocus="setStyle(this.id)" onBlur="recoveryStyle(this.id)">
<script language="javascript">
document.all.msno.focus()
</script>
</td>
</tr>
<tr>
<td>管理的课程编号：</td>
<td><input name="mcno" type="text" id="mcno" size=20 onfocus="setStyle(this.id)" onBlur="recoveryStyle(this.id)">
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td>
<p align="center"><input type="submit" name="submit" value="提交" style="height=25px;width=80px;" ></p>
</td>
</tr>
</table>
</form>



<br><p align="center"><b><font size="6">我的学生</font></b></p>
<?php
$sqll = "select * from set_manager where set_manager.tname='$namet' order by sccno,sno";
	$results = mysqli_query($link, $sqll);
	$rowss = mysqli_num_rows($results);
	if ($rowss < 1) {
		echo '<p align="center">学生列表为空</p>';
	} else {
		?>

<table border='1' space="1" align='center' width=800  Cellpadding=10>

<tr bgcolor="pink" align="center">
<th>
课程编号
</th>
<th>
课程名称
</th>
<th>
学生学号
</th>
<th>
学生姓名
</th>
<th>
是否为管理员<br>
（y为是，n为否）
</th>
</tr>
<?php

		while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td>";
			echo $row["sccno"];
			echo "</td>";
			echo "<td>";
			echo $row["cname"];
			echo "</td>";
			echo "<td>";
			echo $row["sno"];
			echo "</td>";
			echo "<td>";
			echo $row["sname"];
			echo "</td>";
			echo "<td>";
			echo $row["ifmanager"];
			echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>

