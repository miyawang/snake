<?php 
  //获取表单提交时数据，验证用户是否登录成功
  //1-获取邮箱和密码
  //2-判断用户和密码是否为空 
  //3-根据用户名 去后台取出对应密码， 把数据库密码 和 输入的密码进行对比
  //4-登录成功跳转到首页
  //5-登录失败重新登录
  //引入fn

  include '../fn.php'; 
  //如果以post方式提交，则获取用户和密码
  if(!empty($_POST) ) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //判断用户和密码是否为空 
    if (empty($email) || empty($password)) {
      $msg = '用户名和密码不能为空！';
    } else {
      //根据用户名去查询对应数据
      $sql = "select * from users where email = '$email'";
      //查询
      $data = my_query($sql);
      //判断$data 中是否有数据
      if (empty($data)) {
        $msg = '用户名不存在！';
      } else {
        //判断密码是否正确
        $data = $data[0]; //把二维数组转成一维数组
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        if ($password == $data['password']) {
          //登录成功
          //记录当前用户的标记
          session_start();
          //记录当前用户信息 记录用户id 
          $_SESSION['user_id'] = $data['id'];
          //跳转到首页
          header('location:./index1.php');
        } else {
          //密码错误
          $msg = '密码错误！';
        }
      }

      // echo '<pre>';
      // print_r($data);
      // echo '</pre>';
      
    } 
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <!-- action如果不写，默认请求当前页面 -->
    <form class="login-wrap" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时 需要展示 -->
      <?php if(isset($msg)) { ?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $msg ?>
        </div>
      <?php } ?>

      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input  id="email" 
                type="email" 
                name="email" 
                class="form-control" 
                placeholder="邮箱" 
                value="<?php echo isset($msg)? $email : '' ?>"
                autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input  id="password" 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="密码">
      </div>
      <!-- <a class="btn btn-primary btn-block" href="index.html">登 录</a> -->
      <input class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  
  </div>
</body>
</html>
  <!-- 
    1- form  action method
    2- input 表单 添加name 属性 
    3- 修改了提交按钮 


    4-判断用户名和密码是否正确

    5-优化：
    登录失败时，保留用户之前输入邮箱账号

   -->


