<?php
require_once 'functions.php';
$current_user = lms_get_current_user();
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
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>
  <div class="main">
    <?php include 'inc/navbar.php'?>
    <?php include 'inc/sidebar.php'?>
    <div>
      <h1>Welcome, <?php echo $current_user['name']?>.</h1>
    </div>
  </div>
  <script>NProgress.done()</script>
</body>
</html>