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
        <script language="javascript">
        function check() {
            if(document.form3.select1.value == "" && document.form3.select2.value == ""&& document.form3.select3.value == ""){
                alert("Please select course and chapter.");
                return false;
            }
            return true;
        }
        </script>
	</head>
	<body>
	<script>NProgress.start()</script>
		<div class="main">
		    <?php include '../inc/navbar.php'?>
        	<?php include '../inc/sidebar.php'?>
            <h2 class="text-center">Check assignment feedbacks</h2><br><br>
            <form name="form3" class="form-inline justify-content-center" action="" method="post" onsubmit="return check()">
            <select name="select1" style="font-size:20;">
                <?php
                    echo " <option>--Please select a course--</option>";
                    for ($i = 0; $i < count($courses); $i++) {
                        $cname = $courses[$i]["cname"];
                        echo "<option value='$cname'>$cname</option>";
                    }
                ?>
            </select>
            &nbsp&nbsp&nbsp&nbsp
            <label>
                <select name="select2" style="font-size:20;">
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
            </label>
            &nbsp&nbsp&nbsp&nbsp
            <label>
                <select name="select3" style="font-size:20;">
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
            </label>
            &nbsp&nbsp&nbsp&nbsp
            <input id="submit" value="OK" name="submit" type="submit" style="height:35px;width:80px;font-size:20;">
            </form>
                <?php
                    if (isset($_POST['submit'])) {
                        $cname = $_POST['select1'];
                        $str11 = $_POST['select2'];
                        $str12 = $_POST['select3'];
                        $hname11 = $str11 . "-" . $str12 . ".cpp";
                        $sql2 = "select student.name as sname, cname, shhname, shguest from student, course, sh where course.cname='$cname' and sh.shhname='$hname11' and course.cno=sh.shcno and sh.shsno=student.sno";
                        $results2 = lms_fetch_all($sql2);
                        if (count($results2) < 1) {
                ?>
                <script language="javascript">
                    alert ("No feed back yet.");
                </script>
                <?php
                    } else {
                ?>
                <br><br>
                <table class="table">
				    <thead class="thead-dark">
					    <tr>
						    <th scope="col">Student Name</th>
						    <th scope="col">Course Name</th>
						    <th scope="col">Assignment Name</th>
						    <th scope="col">Feedback</th>
					    </tr>
				    </thead>
                    <?php
                    for ($i = 0; $i < count($results2); $i++) {
                        $row2 = results2[$i];
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
        </div>
        <script>NProgress.done()</script>
    </body>
</html>
