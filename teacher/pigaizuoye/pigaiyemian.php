<?php
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
<!--
@import url(student/css/public.css);
body {
	margin-left: 10px;
	margin-top: 5px;
	background-color:white;
}
*{
	padding:0;
	margin:0;
	}
#container{
	width:700px;
	margin:6px auto 0 auto;
	background-color:#fff;
	border:1px dashed #C6C6C6;
	padding:7px;
	}
h1{
	color:black;
	font-size:24px;
	text-align:center;
	background-color:pink;
	height:50px;
	line-height:50px;
	}
-->
</style>
<title> 查看某学生已提交作业 </title>
</head>
<body>

<center>
<div id="container">
		<h1><font size='6'>查看和批改作业</font></h1>
	<div style="height:5px;background-color:pink;line-height:0;">&nbsp;</div>
	</div><br>
</center>
</body>

<form name="form1" action="pigaiyemian.php" method="post">
<center>
<?php
require_once '../../config.php';
	$tname = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql1 = "select distinct cno,cname from course,homework,teacher where homework.hcno=course.cno and course.ctno=teacher.tno and homework.htno=teacher.tno and teacher.tname='$tname' ";
	$result = mysqli_query($link, $sql1);

	?>

<select name="sell"  onchange="return changeit()"  style="font-size:20px;">
<?php
echo " <option value=\"abcdefg\">--请先选择课程--</option>";
	while ($row = mysqli_fetch_object($result)) {
		echo "<option value='$row->cno'>$row->cname</option>";
	}
	?>
</select>

&nbsp&nbsp&nbsp&nbsp

<select name="zhangjie_name" style="font-size:20px;">
<?php

	echo " <option value=\"abcdefg\">--请按章节选择作业--</option>";

	?>
</select>

  <label>
	  	&nbsp;&nbsp;&nbsp;<input type="submit" name="submit"  value="查看" style="height:35px;width:80px;" style="font-size:20;">
	  </label>
	</form>



<?php
require_once '../../config.php';
	$tname = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$tname = $_SESSION['TEACH'];
	$sql = "select * from course,teacher where tname='$tname' and course.ctno=teacher.tno";
	$results = mysqli_query($link, $sql);
	$i = 0;
	while ($row = mysqli_fetch_object($results)) {
		$course_nos[$i] = $row->cno;
		$i = $i + 1;
	}

	$j = 0;
	while ($j < $i) {
		$sql = "select hname from homework,course where homework.hcno=course.cno and homework.hcno='" . $course_nos[$j] . "'";
		$results = mysqli_query($link, $sql);
		$h = 0;
		while ($row = mysqli_fetch_object($results)) {
			$course_no_name[$j][$h] = $row->hname;
			$h++;
		}
		$j = $j + 1;
	}

	echo "<script language=\"javascript\"> ";
	echo "var map_array = new Array();";
	$w = 0;
	while ($w < $i) {
		$tmp = "";
		$ii = 0;
		$tmp = "map_array[\"" . $course_nos[$w] . "\"] = new Array(";
		while ($ii < count($course_no_name[$w])) {
			$tmp = $tmp . "\"" . $course_no_name[$w][$ii] . "\"";
			if ($ii < count($course_no_name[$w]) - 1) {
				$tmp = $tmp . ",";
			}

			$ii++;
		}
		$tmp = $tmp . ");";
		$w++;
		echo $tmp;
	}
	$tname = $_SESSION['TEACH'];
	$sql2 = "select  hname from homework,teacher where homework.htno=teacher.tno and teacher.tname='$tname' order by hname";
	// echo $sql2;
	$result2 = mysqli_query($link, $sql2);
	$ttmp = "map_name_array = new Array(";
	$w = 0;
	while ($row = mysqli_fetch_object($result2)) {
		$zhangjie_names[$w] = $row->hwname;
		$w++;
	}

	$pp = 0;
	while ($pp < $w) {
		$ttmp = $ttmp . "\"" . $row->hname . "\"";
		if ($pp < $w - 1) {
			$ttmp = $ttmp . ",";
		}

		$pp++;
	}
	;
	$ttmp = $ttmp . ");";
	echo $ttmp;
	echo "</script>";
	echo "<br>";
	?>
<script language="javascript">
function changeit()
{
	var id = document.form1.sell.value;
	document.form1.zhangjie_name.options.length = 0;
	var y=document.createElement('option');
	y.text= "--请按章节选择作业--";
	y.value = "abcdefg";
	document.form1.zhangjie_name.options.add(y);
	var i = 0;
	if(id == "abcdefg"){
		for(i = 0;i< map_name_array.length;i++)
		{
			var y=document.createElement('option');
              	 	y.text= map_name_array[i];
			y.value = map_name_array[i];
			document.form1.zhangjie_name.options.add(y);
		}
		document.form1.zhangjie_name.selectedIndex = 0;
		return;
	}

	for(i = 0;i< map_array[id].length;i++)
	{
	        var y=document.createElement('option');
               y.text= map_array[id][i];
		y.value = map_array[id][i];
		document.form1.zhangjie_name.options.add(y);
	}
	document.form1.zhangjie_name.selectedIndex = 0;

}
</script>

<center><font size='5' color='red'>说明：上述下拉框先选择课程，再选择章节，若没有选项，<br>说明您还未布置作业，请先导入作业信息！</font></center>

<?php

	if (isset($_POST['submit'])) {
		$cno = $_POST['sell'];
		$hname = $_POST['zhangjie_name'];
		$sql2 = "select * from student,homework,sh where student.sno=sh.shsno and sh.shhid=homework.hid and hname='$hname' and hcno='$cno' order by sno";
		$result2 = mysqli_query($link, $sql2);
		$row = mysqli_num_rows($result2);
		if ($row < 1) {
			echo '<p align="center"><br><br><b>暂无学生提交' . $cno . '号课程' . substr($hname, 0, 3) . '章节的作业</b></p>';
		} else {

			echo '<p align="center"><b><font size="4"><br><br>下面是学生已提交的' . $cno . '号课程' . substr($hname, 0, 3) . '章节作业</font></b></p><br><br>';
			?>
<table border='1' space="1" align='center' width=900  Cellpadding=25 >
<tr bgcolor="pink" align="center" height='40'>
<th>
学号
</th>
<th>
姓名
</th>
<th>
提交时间
</th>
<th>
查看作业
</th>
<th>
评分
</th>
<th>
评语
</th>
</tr>
<?php
while ($row2 = mysqli_fetch_assoc($result2)) {
				echo "<tr>";
				echo "<td><center>";
				echo $row2["shsno"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row2["sname"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row2["shsubdate"];
				echo "</center></td>";
				echo "<td><center>";

				echo "<a  style=\"text-decoration:none; color:#0000FF\"  href=pingfen.php?sno=" . $row2["shsno"] . "&cno=" . $cno . "&hname=" . $hname . "&type='reset' target=_blank>查看</a>";
				echo "</center></td>";

				echo "<td><center>";
				$aaa = $row2[shscore];

				if ($aaa) {
					echo $aaa;
				} else {
					echo "未评";
				}

				echo "</center></td>";
				echo "<td width='250'><center>";

				$bbb = $row2[shremark];

				if ($bbb) {
					echo $bbb;
				} else {
					echo "未评";
				}

				echo "</center></td>";
				echo "</tr>";

			}

			echo "</table>";

		}

	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>

