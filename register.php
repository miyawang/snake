<?php 
    //验证规则
    //如果用户存在，则注册成功（为了简化逻辑）
    if (isset($_POST['name'])){
        $result = [
            "code" => "200",
            "msg" => "注册成功"
        ];
    } else {
        $result = [
            "code" => "100",
            "msg" => "注册失败"
        ];
    }

    echo json_encode($result);
    sleep(3);
?>