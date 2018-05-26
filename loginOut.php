<?php 
    //用户退出：删除用户在服务器标记，并且跳转到登录页
    session_start(); //开启
    unset($_SESSION['user_id']);
    /// 跳出到登录页，重新登录
    header('location:./login.php'); 
?>