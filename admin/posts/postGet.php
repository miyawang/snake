<?php 
    include_once '../../fn.php';
    //根据前端传递页码和每页数据条数，返回对应数据
    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];

    //起始索引
    $start = ($page - 1 ) * $pageSize;
    // 三表联合查询
    $sql = "select posts.*, users.nickname, categories.name from posts 
        join users  on   posts.user_id =  users.id 
        join categories on posts.category_id = categories.id   
        order by posts.id  
        limit $start, $pageSize";

    $data = my_query($sql);

    echo json_encode($data);
?>