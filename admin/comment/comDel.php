<?php 
    
    //引入
    include_once '../../fn.php';
    // 根据前端传id ，删除对应id数据
    $id = $_GET['id'];
    //准备sql
    $sql = "delete from comments where id in ($id)";
    //执行
    my_exec($sql);
    //删除会导致数据总量发生变化，导致前端分页标签 页重新生成
    //给前端返回 数据剩余数据总条数

    $sql1 = "select count(*) as total from comments join posts on comments.post_id = posts.id";

    //执行
    $data = my_query($sql1)[0];
    //返回剩余数据总数
    echo json_encode($data);

?>