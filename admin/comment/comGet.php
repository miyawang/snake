<?php 
    //引入工具函数
    include_once '../../fn.php';
    // 根据前端传递页码，返回对应页面评论数据
    //获取前端传递页码和每页数据条数
    
    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];

    //截取数据起始索引
    //起始索引 = (页码 - 1) * 10（每页数据条数）
    $start =  ($page - 1) * $pageSize;

    $sql = "select comments.* , posts.title  from comments 
            join posts  on  comments.post_id = posts.id 
            order by id 
            limit $start, $pageSize";

    $data = my_query($sql);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    //echo 1;
    
    echo json_encode($data); 
?>