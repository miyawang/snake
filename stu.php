<?php 
    //如果有请求过来，返回学生表全部数据
    include '../fn.php';

    $sql = "select * from stu";

    //执行
    $data = my_query($sql);

    //cin_array($a,$b);

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    //echo '呵呵';
    echo json_encode($data);
?>