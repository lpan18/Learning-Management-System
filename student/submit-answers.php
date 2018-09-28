<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../functions.php';
$current_user = lms_get_current_user();
$name = $current_user['name'];
$user_role = lms_get_user_role();
if ($user_role !== 'student') {
	echo 'Unauthorized access.';
	exit;
}

$courses = lms_fetch_all("select course.cno, course.cname, teacher.name from course, teacher, sc, student where student.sno=sc.scsno and sc.sccno=course.cno and course.ctno=teacher.tno and student.name='$name'");
?>

<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html"; charset="gb2312">
		<meta charset="utf-8">
		<title>Learning Management System</title>
		<link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap-datepicker.css">
		<link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
		<link rel="stylesheet" href="/static/assets/css/user.css">
		<script src="/static/assets/vendors/jquery/jquery.js"></script>
		<script src="/static/assets/vendors/moment/moment.js"></script>
   		<script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
		<script src="/static/assets/vendors/bootstrap/js/bootstrap-datetimepicker.js"></script>
		<script src="/static/assets/vendors/nprogress/nprogress.js"></script>
	    <script src="/static/assets/vendors/chart/Chart.js"></script>
	</head>
	<body>
		<script>NProgress.start()</script>
		<div class="main">
		    <?php include '../inc/navbar.php'?>
        	<?php include '../inc/sidebar.php'?>
			<h2 class="text-center">Submit Answers</h2><br><br>
			<form action="submit-answers.php" method="post" enctype="multipart/form-data">
				<table width="700" border="3" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td height="80" align="center"><font size="5">
							<select name="select1" style="font-size:20px;">
								<?php
								echo "<option>--Please select a course--</option>";
								for ($i = 0; $i < count($courses); $i++) {
									$cname = $courses[$i]["cname"];
									echo "<option value='$cname'>$cname</option>";
								}
								?>
							</select>
							&nbsp&nbsp
							<select name="select2" style="font-size:20px;">
							    <option>--Chapter--</option>
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
							&nbsp&nbsp

							<select name="select3" style="font-size:20px;">
							    <option>--Section--</option>
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
						</td>
					<tr>
						<td height="70" align="center">
							<input type="file" name="upfile" style="height:30px;width:320px;" style='font-size:20px'"/>
						</td>
					</tr>
					<tr>
						<td height="70" align="center" ><span style="color:#FF0000">Note: the maximum file size is 2M.</span></td>
					</tr>

<tr height="150">
<td colspan="3" valign="middle" align="left">
<div  align="center"><font color="#000000" size="4"><b>Comments or feedbacks</font><font color="red"> (required)</b></font><br>
<textarea rows="6" name="message" cols="55" wrap="VIRTUAL"></textarea>
</font></div>
</td>
</tr>
  <tr>
  <td height="80" align='center'><input id="submit" value="Submit" name=submit type=submit style="height:35px;width:130px;" style="font-size:20;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  <input id="reset" value="Reset" name=button type=reset style="height:35px;width:130px;" style="font-size:20;"></td>
  </tr>
<tr><td height="50" align="center">
<?php

	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	if (isset($_POST['submit'])) {
		$cname = $_POST['select1'];
		$q1 = mysqli_query($link, "select * from student where sname='$sname'");
		$q2 = mysqli_query($link, "select * from course where cname='$cname'");
		$sno = mysqli_fetch_assoc($q1);
		$cno = mysqli_fetch_assoc($q2);
		$sno1 = $sno['sno'];
		$cno1 = $cno['cno'];
		$str2 = $_POST['select2'];
		$str3 = $_POST['select3'];
		$hname = $str2 . "-" . $str3;
		$hname1 = $str2 . "-" . $str3 . ".cpp";
		$hname2 = $str2 . "-" . $str3 . ".pdf";
		$q3 = mysqli_query($link, "select * from homework where hname='$hname2' and hcno='$cno1'");
		$home = mysqli_fetch_assoc($q3);
		$hid1 = $home['hid'];
		$upload = $sname . $cname . $hname;
		$shguest = $_POST['message'];

		if (!isset($shguest) or $shguest == "") {
			?>
<script language="javascript">
alert ("请填入反馈信息！");
</script>
<meta http-equiv='refresh' content='0;URL='uploadAssignments.php'>
<?php
} else {
			if (!empty($_FILES[upfile][name])) {
				$type = $_FILES['upfile']['name'];
				$type1 = substr($type, 0, strrpos($type, '.'));
				if ($type1 == "$upload") {
					$type2 = strstr($type, '.');
					$date = date('Y-m-d H:i:s');
					$date1 = $home['htimeend'];
					if ($date < $date1) {
						if ($type2 == ".cpp") {
							if ($_FILES['upfile']['error'] > 0) {
								echo "上传错误:";
								switch ($_FILES['upfile']['error']) {
								case 1:
									echo "上传文件大小超出规定值";
									break;
								case 2:
									echo "上传文件大小超出表单约定值";
									break;
								case 3:
									echo "上传文件不全";
									break;
								case 4:
									echo "没有上传文件";
									break;
								}
							} else {
								if (!is_dir("/http/uploadAssignments/")) {
									mkdir("/http/uploadAssignments/");
								}
								if (!is_dir("/http/uploadAssignments/$cname/")) {
									mkdir("/http/uploadAssignments/$cname/");
								}
								$path = "/http/uploadAssignments/$cname/" . $type;
								$date = date('Y-m-d H:i:s');
								if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
									if (file_exists("$path")) {
										unlink("$path");
										echo $_FILES['upfile']['name'] . '已存在，自动替换原文件!<br/>';
										move_uploaded_file($_FILES['upfile']['tmp_name'], $path);
										$q5 = mysqli_query($link, "insert into subdate values(null,'$sname','$cno1','$hname1','$date')");
										$sql0 = "delete from sh where shsno='$sno1'&&shcno='$cno1'&& shhname='$hname1'";
										mysqli_query($link, $sql0);

										$sql1 = "insert into sh values(null,'$hid1','$sno1','$cno1','$hname1','/http/uploadAssignments/$cname/','$shguest',null,null,'$date')";

										mysqli_query($link, $sql1);

									} else {
										echo $_FILES['upfile']['name'] . "上传成功，大小为：" . $_FILES['upfile']['size'] . "k.";
										move_uploaded_file($_FILES['upfile']['tmp_name'], $path);
										$sql2 = mysqli_query($link, "insert into sh values(null,'$hid1','$sno1','$cno1','$hname1','/http/uploadAssignments/$cname/','$shguest',null,null,'$date')");
										$q6 = mysqli_query($link, "insert into subdate values(null,'$sname','$cno1','$hname1','$date')");
									}
									?>
<tr>
<td height="50" align="center" >
<?php
echo "作业 " . $_FILES['upfile']['name'] . "内容："
									?></td>
</tr>
<tr>
<td height="100" width="700" align="left">
<?php
function read_file($filename) {
										$fp = fopen($filename, "r") or die("未上传");
										$read = fread($fp, filesize($filename));
										fclose($fp);
										return $read;
									}
									$str = read_file($path);
									echo iconv("gb2312", "gbk", $str);
									?>
</td>
</tr>
<?php
} else {
									echo "上传文件" . $_FILES['upfile']['name'] . "不合法！";
								}
							}
						} else {
							echo "上传文件" . $_FILES['upfile']['name'] . "文件类型错误！";
						}
					} else {
						?>
<script language="javascript">
alert ("该作业提交已截止！");
</script>
<?php
}
				} else {
					echo "上传文件 " . $_FILES['upfile']['name'] . "文件名错误！";
				}
			}
		}
	}
	?>
</td>
</tr>
</table>
</div>
    	<script>NProgress.done()</script>
</body>
</html>