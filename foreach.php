<?php
header('content-type:text/html;charset=utf-8');
// $arr = [1,2,3,4,5];
// $sum = 0;
// for($i = 0; $i < count($arr);$i++){
//   $sum += $arr[$i];
// }
// echo $sum;


// $mul ;
// for($i = 0;$i<10;$i++){
//   for($j = 1;$j <= $i; $j++){
//     $mul = $i * $j;
//     echo ($j . '*' . $i . '=' . $mul . '  ');   
//   }
//   echo ('<br>');  
// }
// echo ('<br>');
// for($i = 0; $i < 10; $i++){
//   for($j = 1; $j <= $i; $j++){
//     $mul = $i * $j;
//     echo ($j . '*' . $i . '=' . $mul . '  ');

//   }
//   echo ('<br>');
// }
// echo ('<br>');

// for($i = 0; $i < 10; $i++){
//   for($j = 1; $j <= $i; $j++){
//     $mul = $i * $j;
//     echo ($j . '*' . $i . '=' .$mul . '  ');
    
//   }
//   echo ('<br>');
// }

// $info = [
//   'name'=>'zss',
//   'age'=>10,
//   'gender'=>'nan'
// ];
// foreach($info as $k => $v ) {
//   echo $k .'---' . $v .'<br>';
// }


// foreach($info as $k => $v){
//   echo $k . '---' .$v . '<br>';
// }


// function sayHi($name = 'zss'){
//   echo 'hi'.$name;
// }
// sayHi();
// sayHi('lss');

// function sayHi1($name = 'zss'){
//   echo 'hello'.$name;
// }
// sayHi1();

// define('PI',3.14);
// define('VERSION','1.12.12');
// echo PI;
// // define('PI',200);
echo date('Y年m月d日 H小时i分钟s秒',time());
echo date('Y-m-d H:i:s',time());


echo date('Y年m月d日 H小时i分钟s秒',time());
echo date('Y-m-d H:i:s',time());
?>