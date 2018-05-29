<?php 
    include_once '../../fn.php';
    //获取分类的数据返回
    $sql = "select * from categories";
    //执行
    $data = my_query($sql); 

    echo json_encode($data);
?>