<?php 
    //php操作cookie 
    //setcookie(k, v, 有效期 );
    //设置
    setcookie('name', 'php-name');
    setcookie('age', 'php-age');
    //获取cookie 
    //$_COOKIE 超全局变量  获取cookie的数据 
    echo '<pre>';
    print_r($_COOKIE);
    echo '</pre>';
?>