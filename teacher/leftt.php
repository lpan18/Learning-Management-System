<?php
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
	<!DOCTYPE html>
    <html>
    <head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
    <body>
    	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    	<div class='navbar navbar-inverse'>
  <div class='nav-collapse' style="height: auto;">
    <ul class="nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page One</a></li>
      <li><a href="#">Page Two</a></li>
    </ul>
  </div>
</div>

    <div>
    <span>个人信息</span>
    <a href="contentt.php" target="frmmain">> 首页</a>
    <a href="/teacher/mima/gaimimat.php" target="frmmain">> 修改密码</a>
    </div>
    <div>
    <span>课程信息管理</span>
    <a href="changestudent/mycourse.php" target="frmmain">> 我的课程</a>
    <a href="changestudent/pladdstudent.php" target="frmmain">> 批量导入课程信息</a>
    <a href="changestudent/changestudent.php" target="frmmain">> 个别学生信息管理</a>
    <a href="/teacher/managercontrol/scanmanager.php" target="frmmain">> 管理员管理</a>
    <a href="/teacher/mima/mimachongzhi.php" target="frmmain">> 为学生重置密码</a>
    </div>
    <div>
    <span> 作业信息管理</span>
    <a href="thomework/buzhizuoye.php" target="frmmain">> 导入作业信息</a>
    <a href="thomework/showhomeworkteach.php" target="frmmain" >> 查看和删除布置的作业</a>
    <a href="thomework/showuploadteach.php" target="frmmain" >> 全体学生作业上交情况</a>
    <a href="thomework/showupload2teach.php" target="frmmain" >> 个别学生作业上交详情</a>
    <a href="pigaizuoye/pigaiyemian.php" target="frmmain" >> 查看和批改上交的作业</a>
    <a href="thomework/ckguest.php" target="frmmain" >> 查看学生作业反馈信息</a>
    <a href="thomework/upanswer.php" target="frmmain" >> 发布课件或作业答案</a>
    <a href="thomework/showanswerteach.php" target="frmmain" >> 课件及作业答案管理</a>
    </div>
    </div>
    </body>
    </html>

<?php

} else {
	echo "对不起，您无权限查看此页面！";
}

?>
