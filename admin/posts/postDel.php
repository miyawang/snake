<?php 
    //根据前端传递的id  删除数据
    include_once '../../fn.php';

    //获取前端的id
    $id = $_GET['id'];

    //准备sql
    $sql = "delete from posts where id in ($id)";

    //执行
    my_exec($sql);

    //返回删除后 剩余的数据总数

    $sql1 = "select count(*) as total  from posts  
    join users  on posts.user_id = users.id
    join categories on posts.category_id = categories.id ";

    echo json_encode( my_query($sql1)[0] );   
   

?>