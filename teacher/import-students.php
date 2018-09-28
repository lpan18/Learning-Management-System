<?php
require_once dirname(__FILE__) . '/../functions.php';
$current_user = lms_get_current_user();
$user_role = lms_get_user_role();
$message = '';

if ($user_role !== 'teacher') {
	echo 'Unauthorized access.';
	exit;
}

if (isset($_FILES['upload_file']) && $_FILES['upload_file']['name'] !== null) {    
	$temp = file($_FILES['upload_file']['tmp_name']);
	$filetype = strstr($_FILES['upload_file']['name'], '.');
	
	if ($filetype !== ".csv") {
		$message = 'Please upload a csv file.';
	} else {
		$affected_rows = 0;

		for ($i = 1; $i < count($temp); $i++) {
			$string = explode(",", $temp[$i]);
			$affected_rows += lms_execute("insert into sc values('$string[0]','$string[1]');");
		}
	
		if ($affected_rows > 0) {
			$message = "success";
		} elseif ($affected_rows == -1) {
			$message = "error";
		} elseif ($affected_rows == 0 && count($temp) > 0) {
			$message = "duplicate upload";
		}
	}
}
$namet = $current_user['name'];
$row = lms_fetch_all("select sno,s.name,s.sex,s.major,cno,cname from student as s,teacher as t,course as c,sc where s.sno=sc.scsno and sc.sccno=c.cno and t.tno=c.ctno and t.name='$namet'");
?>

<!DOCTYPE html>
<html>
<head>
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
		    <?php if ($message === "success"): ?>
			    <div class="alert alert-success">
					<strong>Upload Success!</strong>
				</div>
            <?php elseif ($message !== ''): ?>
				<div class="alert alert-danger">
					<strong><?php echo $message; ?></strong>
				</div>
			<?php endif?>
			<div class="form-group">
				<div class="input-group input-file" name="upload_file">
					<input type="text" class="form-control" name="upload_file" id="upload_file" placeholder='Choose a file...' />
					<span class="input-group-btn">
					<button class="btn btn-default btn-choose" type="button" value="submit">Upload new course.csv</button>
					</span>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary pull-right">Submit</button>
				<button type="reset" class="btn btn-danger">Reset</button>
			</div>
		</form>
<script>
	function bs_input_file() {
		$(".input-file").before(
			function() {
				if ( ! $(this).prev().hasClass('input-ghost') ) {
					var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
					element.attr("name",$(this).attr("name"));
					element.change(function(){
						element.next(element).find('input').val((element.val()).split('\\').pop());
					});
					$(this).find("button.btn-choose").click(function(){
						element.click();
					});
					$(this).find("button.btn-reset").click(function(){
						element.val(null);
						$(this).parents(".input-file").find('input').val('');
					});
					$(this).find('input').css("cursor","pointer");
					$(this).find('input').mousedown(function() {
						$(this).parents('.input-file').prev().click();
						return false;
					});
					return element;
				}
			}
		);
	}
	$(function() {
		bs_input_file();
	});
</script>
		<br><br>
		<h5 class="text-center"><strong>Students Registered For My Courses</strong></h5>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Student Number</th>
					<th scope="col">Name</th>
					<th scope="col">Sex</th>
					<th scope="col">Major</th>
					<th scope="col">Course</th>
					<th scope="col">Course Number</th>
				</tr>
			</thead>
	        <tbody>
<?php
for ($i = 1; $i < count($row); $i++) {
    echo "<tr>";
    echo '<th scope="row">' . $i . '</th>';
    echo "<td>";
    echo $row[$i]["sno"];
    echo "</td>";
    echo "<td>";
    echo $row[$i]["name"];
    echo "</td>";
    echo "<td>";
    echo $row[$i]["sex"];
    echo "</td>";
    echo "<td>";
    echo $row[$i]["major"];
    echo "</td>";
    echo "<td>";
    echo $row[$i]["cname"];
    echo "</td>";
    echo "<td>";
    echo $row[$i]["cno"];
    echo "</td>";
    echo "<tr>";
}?>
	        </tbody>
	    </table>
    </div>
    <script>NProgress.done()</script>
</body>
</html>