<?php
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title> 布置作业 </title>
</head>
<body>
<table width="900" border="3" cellpadding="0" cellspacing="0" align="center">
<form action="" method="post" enctype="multipart/form-data">
<tr>
    <td height="160" bgcolor="pink" align="center" face="微软雅黑" ><b><font size="6">布置&nbsp;</font>
<select name="select0" style="font-size:25px;">
<?php
require_once '../../config.php';
	$tname = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from course,teacher where course.ctno=teacher.tno&&teacher.tname='$tname'";
	$results = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_object($results)) {
		echo "<option value='$row->cname'>$row->cname</option>";
	}
	?>
</select>
<font size="6">课程作业：</font>  </b><br><br>
    <span style="color:#FF0000">注意：</span>布置作业文件名称必须为课程名加章节，如数据库系统概论1-1，<br>&nbsp&nbsp&nbsp文件类型必须为（*.pdf），一次最多只能同时布置5节作业</td>
</tr>
<?php
for ($i = 1; $i <= 5; $i++) {
		?>
<tr><td height="70" align="center"><font size=5>作业题目</font>&nbsp<input type="file" name="upfile[]" size="25"  style='font-size:20px'/>&nbsp&nbsp<font size=5>提交截至时间:</font>
<?php
echo " <select name=selectm" . $i . " style=\"font-size:20px;\" > ";
		for ($h = 1; $h <= 12; $h++) {
			echo " <option value=$h>$h</option>";
		}
		echo " </select>" . "月";
		echo " <select name=selectd" . $i . " style=\"font-size:20px;\" > ";
		for ($j = 1; $j <= 31; $j++) {
			echo " <option value=$j>$j</option>";
		}
		echo " </select>" . "日";
		echo " <select name=selecty" . $i . " style=\"font-size:20px;\" > ";
		for ($k = 2018; $k <= 2020; $k++) {
			echo " <option value=$k>$k</option>";
		}
		echo " </select>" . "年";
		?>
</br></td></tr>
<?php
}
	?>
<tr>
<td height="80" align="center">
<input type="submit" name="submit" value="布置作业">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<input type="reset" name="button" value="重新设置">
</td>
</tr>

<tr>
<td height="100" align="center" >
<?php
require_once '../../config.php';
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	if (isset($_POST['submit'])) {
		$count = count($_FILES['upfile']['name']);
		$cname = $_POST['select0'];
		for ($i = 1; $i <= 5; $i++) {
			$year[$i] = $_POST['selecty' . $i];
			$month[$i] = $_POST['selectm' . $i];
			$day[$i] = $_POST['selectd' . $i];
			$deadline[$i] = $year[$i] . "-" . $month[$i] . "-" . $day[$i] . " " . "12:00:00";
		}
		$path = ROOT_DIR . "/postassignment";
		if (!is_dir($path)) {
			mkdir($path);
		}
		if (!is_dir($path . "/$cname/")) {
			mkdir($path . "/$cname/");
		}
		$updir = $path . "/$cname/";
		$max_size_upfile = '102400';
		$upfile_types = array('application/pdf');
		for ($i = 0; $i < 5; $i++) {
			if (empty($_FILES['upfile']['tmp_name'][$i])) {
				continue;
			}
			if ($_FILES['upfile']['size'][$i] > $max_size_upfile) {
				echo $_FILES['upfile']['name'][$i] . '文件大小超过最大！';
				continue;
			}
			if (!in_array($_FILES['upfile']['type'][$i], $upfile_types)) {
				echo '只能上传pdf类型!';
				continue;
			}
			if ($_FILES['upfile']['error'][$i] != UPLOAD_ERR_OK) {
				echo $_FILES['upfile']['name'][$i] . '文件上传不成功!';
				continue;
			}
			$upfile = $updir . $_FILES['upfile']['name'][$i];
			$result = $_FILES['upfile']['name'][$i];
			$type = $result;
			$type1 = substr($type, 0, strrpos($type, '.'));

			if (strstr("$type1", "$cname")) {
				$count = strpos($result, $cname);
				$result1 = substr_replace($result, "", $count, strlen($cname));
				$q1 = mysqli_query($link, "select * from course where course.cname='$cname'");
				$q2 = mysqli_query($link, "select * from teacher where teacher.tname='$tname'");
				$cno = mysqli_fetch_assoc($q1);
				$tno = mysqli_fetch_assoc($q2);
				$cno1 = $cno['cno'];
				$tno1 = $tno['tno'];
				$a = $i + 1;
				if (file_exists($upfile)) {
					unlink($path . "/$cname/$type");
					echo '作业' . $_FILES['upfile']['name'][$i] . '已存在，自动替换原文件!<br/>';
					move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $upfile);
					$sql0 = "delete from homework where hcno='$cno1'&& hname='$result1'";
					mysqli_query($link, $sql0);
					$sql1 = "insert into homework values(null,'$result1','$cno1','/postassignment/$cname/','$tno1','$deadline[$a]')";
					mysqli_query($link, $sql1);
				} else {
					echo '作业' . $_FILES['upfile']['name'][$i] . '布置成功<br/>';
					move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $upfile);
					$sql2 = "insert into homework values(null,'$result1','$cno1','/postassignment/$cname/','$tno1','$deadline[$a]')";
					// echo $sql2;
					mysqli_query($link, $sql2);
				}
			} else {
				echo "文件名与所选课程不匹配";
				echo "<br>";
			}
		}
	}
	?>
</td>
</tr>
</form>
</table>
</body>
</html>
<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>