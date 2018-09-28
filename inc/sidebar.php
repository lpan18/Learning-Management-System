<?php
require_once dirname(__FILE__) . '/../functions.php';
$current_user = lms_get_current_user();
$user_role = lms_get_user_role();
?>
<div class="aside">
    <div class="profile">
        <img class="avatar" src="<?php echo $current_user['avatar']; ?>">
        <h3 class="name"><?php echo $current_user['name']; ?></h3>
    </div>
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <?php
            if ($user_role == 'teacher'){
        ?>
        <a>Courses</a>
        <a href="/teacher/import-students.php">Import Students</a>
        <a href="/teacher/course-materials.php">Course Materials</a>
        <a>Assignments</a>
        <a href="/teacher/post-assignments.php">Post Assignments</a>
        <a href="/teacher/assignment-summary.php">Assignment Summary</a>
        <a href="/teacher/mark-assignments.php">Mark Assignments</a>
        <a href="/teacher/assignment-feedbacks.php">Assignment Feedbacks</a>
        <a href="/teacher/post-keys.php">Post Keys</a>
        <a href="">Settings</a>
        <?php
        } else if ($user_role == 'student') {?>
        <ul class="nav flex-column">
            <li><a>Courses</a></li>
            <li class="nav-item"><a class="nav-link" href="/student/my-courses.php">My Courses</a></li>
            <a href="/student/course-materials.php">Course Materials</a>
            <a>Assignments</a>
            <a href="/student/my-assignments.php">My Assignments</a>
            <a href="/student/submit-answers.php">Submit Answers</a>
            <a href="/student/my-submissions.php">My Submissions</a>
            <a href="/student/keys.php">Keys</a>
        </ul>


<a class="nav-item">Test</a>
        <ul class="nav flex-column">
  <li class="nav-item">
    <a class="nav-link active" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="#">Disabled</a>
  </li>
</ul>
        <!--Enter Student Sidebar here-->
        <?php
        }?> 
    <!-- </div> -->
</div>