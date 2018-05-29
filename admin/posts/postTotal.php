<?php 
    // 返回 有效（对应作者 和 分类都存在 ）文章的总数
    
    include_once '../../fn.php';

    $sql = "select count(*) as total  from posts  
            join users  on posts.user_id = users.id
            join categories on posts.category_id = categories.id ";

    echo json_encode( my_query($sql)[0] );       
?>