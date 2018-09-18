<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title> 发布课件或者作业答案 </title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<b><center><font size='6'>发布课程 </font>
<select name="select1" style="font-size:25px;">
<?php
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
<font size='6'> 课件或作业答案：</font></b><br><br>
 <span style="color:#FF0000"><font size='5'><br>注意：文件名如"数据库系统概论1-1答案"或"数据<br>&nbsp;&nbsp;&nbsp;库系统概论1-1课件"，类型为（*.pdf）</span></font></center>
<table width="550" border="3" cellpadding="0" cellspacing="0" align="center">
<?php
for ($i = 1; $i <= 5; $i++) {
		?>
<tr><td height="60" align="center"><font size='5'>文件&nbsp;</font>&nbsp<input type="file" name="upfile[]" size="30"  style='font-size:20px'/></td></tr>
<?php
}
	?>
<tr><td height="60" align="center">
<input type="submit" name="submit" value="发布"  style="height:35px;width:100px;"  style='font-size:20px' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<input type="reset" name="button" value="重新选择"  style="height:35px;width:100px;"  style='font-size:20px'>
</td></tr><br><br>

<tr><td height="100" align="center" >
<?php
if (isset($_POST["submit"])) {
		$count = count($_FILES['upfile']['name']);
		$cname = $_POST['select1'];
		$path = ROOT_DIR . "/answer";
		if (!is_dir($path)) {
			mkdir($path);
		}
		if (!is_dir($path . "/$cname/")) {
			mkdir($path . "/$cname/");
		}
		$updir = $path . "/$cname/";
		$upfile_types = array('application/pdf');
		for ($i = 0; $i < 5; $i++) {
			if (empty($_FILES['upfile']['tmp_name'][$i])) {
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
				if (file_exists($upfile)) {
					unlink($path . "/$cname/$type");
					echo $_FILES['upfile']['name'][$i] . '已存在，自动替换原文件!<br/>';
					move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $upfile);
					$sql0 = "delete from answer where ascno='$cno1'&& asname='$result1'";
					mysqli_query($link, $sql0);
					$sql1 = "insert into answer values(null,'$cno1','$result1','/answer/$cname/','$tno1')";
					mysqli_query($link, $sql1);
				} else {
					echo $_FILES['upfile']['name'][$i] . '发布成功<br/>';
					move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $upfile);
					$sql2 = "insert into answer values(null,'$cno1','$result1','/answer/$cname/','$tno1')";
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
</table>
</body>
</html>
<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>