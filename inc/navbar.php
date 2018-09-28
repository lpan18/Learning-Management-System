<?php
require_once dirname(__FILE__) . '/../functions.php';
$current_user = lms_get_current_user();
?>
<nav class="navbar">
  <button class="btn btn-default navbar-btn fa fa-bars"></button>
  <ul class="nav navbar-nav navbar-right">
    <li><a href="/admin/profile.php"><span><i class="fa fa-user"></i></span>Profile</a></li>
    <!-- 添加action参数，方便在login.php中通过传入参数执行删除session的操作 -->
    <li><a href="/admin/login.php?action=logout"><span><i class="fa fa-sign-out"></i></span>Logout</a></li>
  </ul>
</nav>