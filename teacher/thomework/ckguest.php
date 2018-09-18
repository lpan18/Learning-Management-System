<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>查看反馈信息</title>
<script language="javascript">
	function check()
	{
		if(document.form3.select1.value == "" && document.form3.select2.value == ""&& document.form3.select3.value == ""){
			alert("请选择课程和章节");
			return false;
		}
		return true;
	}
</script>
</head>
<body>
<form name="form3" action="" method="post" onsubmit="return check()">
<br><p align="center"><b><font size="6">查看反馈信息<br><br></font></b></p>
<p align="center"><font size="6">
<select name="select1" style="font-size:25px;">
<?php
require_once '../../config.php';
session_start();
$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
if (!$link) {
	die('Not connected : ' . mysqli_error());
}
mysqli_select_db($link, LMS_DB_NAME);
$sql1 = "Select * from course where ctno='" . $_SESSION['ID'] . "'";
$result1 = mysqli_query($link, $sql1);
echo " <option>--请选择查看的课程--</option>";
while ($row1 = mysqli_fetch_object($result1)) {
	echo "<option value='$row1->cname'>$row1->cname</option>";
}
?>
</select>

<label>
  <select name="select2" style="font-size:25px;">
    <option>--第几章--</option>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
    <option>6</option>
    <option>7</option>
    <option>8</option>
    <option>9</option>
    <option>10</option>
  </select>
  </label>

<label>
  <select name="select3" style="font-size:25px;">
    <option>--第几节--</option>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
    <option>6</option>
    <option>7</option>
    <option>8</option>
    <option>9</option>
    <option>10</option>
  </select>
  </label>
<input id="submit" value="查看" name="submit" type="submit" style="height:35px;width:80px;font-size:25px;">
</font></p>
<?php
if (isset($_POST['submit'])) {
	$cname = $_POST['select1'];
	$str11 = $_POST['select2'];
	$str12 = $_POST['select3'];
	$hname11 = $str11 . "-" . $str12 . ".cpp";
	mysqli_query($link, "set names gbk");
	$sql2 = "select sname,cname,shhname,shguest  from student,course,sh where course.cname='$cname' and sh.shhname='$hname11' and course.cno=sh.shcno and sh.shsno=student.sno";
	$result2 = mysqli_query($link, $sql2);
	$row2 = mysqli_num_rows($result2);
	if ($row2 < 1) {
		?>
<script language="javascript">
alert ("暂无反馈信息！");
</script>;
<?php
} else {
		?>
<table width='95%' border='1' align='center' >
<tr bgcolor='yellow'>
<td>姓名</td>
<td>课程名</td>
<td>作业名</td>
<td>内容</td>
</tr>
<?php
while ($row2 = mysqli_fetch_assoc($result2)) {
			echo "<tr>";
			echo "<td><center>";
			echo $row2["sname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row2["cname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row2["shhname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row2["shguest"];
			echo "</center></td>";
			echo "</tr>";
		}
	}
}
echo "</table>";
?>
</form>
</body>
</html>


