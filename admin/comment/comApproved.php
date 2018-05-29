<?php 
    // 根据前端传递id，批准对应数据 
    include_once '../../fn.php';
    //获取前端传递的id
    $id = $_GET['id'];
    //可以满足批量批准
    $sql = "update comments  set status = 'approved' where id in ($id)";
    //执行批准 
    my_exec($sql);

?>