<?php 
    //获取评论的总数  
    // 注意点： 我们在查询评论数据时，关联文章表， 所以能够显示在页面上评论，都是有对应的文章
    // 我们在查询总数是，也要排除那些没有对应文章 评论

    //$sql = "select count(*) from comments"
    //查询 有效评论数据总数（评论对应文章是存在的）
    include_once '../../fn.php';

    $sql = "select count(*) as total from comments join posts on comments.post_id = posts.id";

    //执行
    $data = my_query($sql)[0];

    echo json_encode($data);

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>