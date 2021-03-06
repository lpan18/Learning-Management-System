<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../functions.php';
$current_user = lms_get_current_user();
$name = $current_user['name'];
$user_role = lms_get_user_role();
if ($user_role !== 'teacher') {
	echo 'Unauthorized access.';
	exit;
}

$courses = lms_fetch_all("select * from course,teacher where course.ctno=teacher.tno and teacher.name='$name'");
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="gb2312">
		<meta charset="utf-8">
		<title>Learning Management System</title>
		<link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
		<link rel="stylesheet" href="/static/assets/css/user.css">
		<script src="/static/assets/vendors/jquery/jquery.js"></script>
   		<script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
		<script src="/static/assets/vendors/nprogress/nprogress.js"></script>
	    <script src="/static/assets/vendors/chart/Chart.js"></script>
	</head>
	<body>
		<script>NProgress.start()</script>
		<div class="main">
			<?php include '../inc/navbar.php'?>
        	<?php include '../inc/sidebar.php'?>
			
			<form enctype="multipart/form-data" action="" method="post">
			<h2 class="text-center">Publish course materials for
			    <select name="select1" style="font-size:25px;">
					<?php
						for ($i = 0; $i < count($courses); $i++) {
							echo "<option value='" . $courses[$i]["cname"] . "'>" . $courses[$i]["cname"] . "</option>";
						}
					?>
				</select>
			</h2>
			<br><br>
			<h5 class="text-center">Note: PDF files only</h5>
			    <table class="display nowrap" width="50%" border="3" align="center">
					<?php
					for ($i = 1; $i <= 5; $i++) {
					?>
						<tr>
						    <td height="60" align="center">
							    <input type="file" name="upfile[]" size="30" style='font-size:18px'/>
							</td>
						</tr>
					<?php
					}
					?>
					<tr>
					    <td height="60" align="center">
						    <button type="submit" name="submit" class="btn btn-primary" margin-right="15px">Submit</button>
				            <button type="reset" class="btn btn-danger">Reset</button>
					    </td>
					</tr>

					<tr>
					    <td height="100" align="center" >
						<?php
						
						if (isset($_POST["submit"])) {
							$count = count($_FILES['upfile']['name']);
							$cname = $_POST['select1'];
							$path = dirname(__FILE__) . "/../answer";
							$updir = $path . "/$cname/";
							$upfile_types = array('application/pdf');

							if (!is_dir($path)) {
								mkdir($path);
							}
							if (!is_dir($path . "/$cname/")) {
								mkdir($path . "/$cname/");
							}

							for ($i = 0; $i < 5; $i++) {
								if (empty($_FILES['upfile']['tmp_name'][$i])) {
									continue;
								}
								if (!in_array($_FILES['upfile']['type'][$i], $upfile_types)) {
									echo 'Please upload PDF files only.';
									continue;
								}
								if ($_FILES['upfile']['error'][$i] != UPLOAD_ERR_OK) {
									echo $_FILES['upfile']['name'][$i] . 'Unsuccessful file upload.';
									continue;
								}
								$upfile = $updir . $_FILES['upfile']['name'][$i];
								$result = $_FILES['upfile']['name'][$i];
								$type = $result;
								$type1 = substr($type, 0, strrpos($type, '.'));
								if (strstr("$type1", "$cname")) {
									$count = strpos($result, $cname);
									$result1 = substr_replace($result, "", $count, strlen($cname));

									$course = lms_fetch_one("select * from course where course.cname='$cname'");
									$teacher = lms_fetch_one("select * from teacher where teacher.name='$name'");

									$cno = $course['cno'];
									$tno = $teacher['tno'];
									if (file_exists($upfile)) {
										unlink($path . "/$cname/$type");
										echo $_FILES['upfile']['name'][$i] . ' The file already exists and will be replaced.<br/>';
										move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $upfile);
										$sql0 = "delete from answer where ascno='$cno'&& asname='$result1'";
										lms_execute($sql0);
										$sql1 = "insert into answer values(null,'$cno','$result1','/answer/$cname/','$tno')";
										lms_execute($sql1);
									} else {
										echo $_FILES['upfile']['name'][$i] . ' Upload successful<br/>';
										move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $upfile);
										$sql2 = "insert into answer values(null,'$cno','$result1','/answer/$cname/','$tno')";
										lms_execute($sql2);
									}
								} else {
									echo $_FILES['upfile']['name'][$i] . " The file name does not match the course selected.";
									echo "<br>";
								}
							}
						}
						?>
					    </td>
				    </tr>
			    </table>
			</form>
		</div>
    	<script>NProgress.done()</script>
	</body>
</html>