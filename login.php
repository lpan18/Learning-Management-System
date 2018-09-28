<?php
require_once 'functions.php';
function login() {
	if (empty($_POST['username'])) {
		$GLOBALS['message'] = 'Please enter your username';
		return;
	}
	if (empty($_POST['password'])) {
		$GLOBALS['message'] = 'Please enter your password';
		return;
	}
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = array();
	if ($_POST["radio"] == "student") {
		$user = lms_fetch_one("SELECT * from student where sno = '{$username}' limit 1;");
		if ($username !== $user['sno']) {
			$GLOBALS['message'] = 'Incorrect username or password';
			return;
		}
		if ($password !== $user['password']) {
			$GLOBALS['message'] = 'Incorrect username or password';
			return;
		}
    $_SESSION['user_role'] = 'student';
	} elseif ($_POST["radio"] == "teacher") {
		$user = lms_fetch_one("SELECT * from teacher where tno = '{$username}' limit 1;");
		if ($username !== $user['tno']) {
			$GLOBALS['message'] = 'Incorrect username or password';
			return;
		}
		if ($password !== $user['password']) {
			$GLOBALS['message'] = 'Incorrect username or password';
			return;
		}
    $_SESSION['user_role'] = 'teacher';
	}
	$_SESSION['current_login_user'] = $user;
	header('Location:/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	login();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset=utf-8>
  <title>Login</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/animate/animate.css">
  <link rel="stylesheet" href="/static/assets/css/user.css">
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
</head>
<body>
  <div class="login">
    <!-- 不用加enctype因为没有文件域，在form上添加novalidate 取消浏览器自带的校验H5， 关闭autocompleted取消自动填充 -->
    <!-- 有message就shake https://daneden.github.io/animate.css/ -->
    <form class="login-wrap<?php echo isset($message) ? ' shake animated' : '' ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate autocompleted="off">
      <img class="avatar" src="/static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)): ?>
      <div class="alert alert-danger">
        <strong>Error!</strong> <?php echo "$message"; ?>
      </div>
      <?php endif?>
      <div class="form-group">
        <label><input type="radio" name="radio" value="student">Student</label>
        <label><input type="radio" name="radio" value="teacher">Teacher</label>
      </div>
      <div class="form-group">
        <label for="username" class="sr-only">Username</label>
        <!-- value 不能使用$email,局部变量 -->
        <input id="username" name="username" type="text" class="form-control" placeholder="Username" autofocus value="<?php echo empty($_POST['username']) ? '' : $_POST['username']; ?>">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">Password</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="Password">
      </div>
      <button class="btn btn-primary btn-block">Login</button>
    </form>
  </div>
  <script>
    //沙箱--入口函数 1单独作用域2确保页面加载后进行
      $(function($){
        //目标：用户输入邮箱后，拿到头像
        //实现：
        // -时机：邮箱文本框失去焦点,并且能够拿到文本框填写的邮箱时
        // -事情：获取文本框填写的邮箱对应的头像地址
        var usernameFormat = /^[a-zA-Z0-9_.]+$/;
      $('#username').on('blur', function () {
        var value = $(this).val();  //this为dom对象，通过$函数转成jquery对象，并使用jquery对象的val方法
        //忽略文本框为空或者不是一个邮箱
        if(!value||!usernameFormat.test(value)) return;
        //由于客户端js无法直接操作数据库，应该通过js发送ajax请求，告诉服务端的某个接口，让这个接口帮助客户端获取头像地址
        $.get('/api/avatar.php',{username:value},function(res){
        //email是属性，value是变量，传入变量值
          if(!res) return; //拿不到数据
          //拿到图片地址，设置img的src属性
          // $('.avatar').fadeOut().attr('src', res).fadeIn();
          $('.avatar').fadeOut(function(){
            //等到淡出完成
            $(this).on('load', function(){
              //等到图片加载成功过后
              $(this).fadeIn();
            }).attr('src', res);
          })
        })

      })
      })
  </script>
</body>
</html>
