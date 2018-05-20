<?php
// php代码 放在php标签的内部
header('content-Type:text/html;charset=utf-8'); 
echo 'hello world!';
print 'aaaaa';
echo '中文中文';
print 'p中文';
echo '<br>';
$name = 'zs';
$_Age = 20;
echo $name;
echo '<br>';
echo $_Age;
// isset(); //判断变量是否赋值 变量未赋值或者值为null 都是没有值的情况
// empty(); //如果变量没有值 或者值为null 0 false [] {} php会认为以上的值都是空 虽然有值 但是没有意义
// unset() 删除变量
?>