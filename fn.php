<?php 
    //封装php操作数据库函数
    //定义常量，存数据相关信息
    define('HOST', '127.0.0.1');
    define('UNAME', 'root');
    define('PWD', 'root');
    define('DB', 'z_baixiu');

    //封装执行非查询语句方法 
    //返回值 成功 true  失败false 

    function my_exec($sql) {
        //1-连接数据库
        $link = @mysqli_connect(HOST, UNAME, PWD, DB);

        if (!$link) {
            echo '数据库连接失败！';
            return false;
        }
        //2-执行sql语句，并分析结果
        if (!mysqli_query($link, $sql)) {
            //关闭数据库
            mysqli_close($link);
            echo '操作失败：'.mysqli_error($link);
            return false;
        }
        //3-关闭数据库
        mysqli_close($link);
        return true;
    }

    // $sql = "insert into categories (slug, name) values('aa', 'bb')";
    // my_exec($sql);

    //封装执行查询语句方法
    //成功 二维数组， 失败 false

    function my_query($sql) {
        //1-连接数据库
        $link = @mysqli_connect(HOST, UNAME, PWD, DB);

        if (!$link) {
            echo '数据库连接失败！';
            return false;
        }
        //执行
        $res = mysqli_query($link, $sql);

        //判断是否有数据
        if(!$res || mysqli_num_rows($res) == 0 ) {
            mysqli_close($link);
            echo '未获取到数据！';
            return false;
        }

        //获取数据

       while ($row = mysqli_fetch_assoc($res)){
           $data[] = $row;
       }
       mysqli_close($link);
       return $data; //返回数据
    }


    // $sql = "select * from users";
    // $data = my_query($sql);

    //判断用户是否登录过方法
    function isLogin() {
        //登录过用户可以访问者页面
        //1-cookie 肯定有PHPSESSID 
        if ( !empty($_COOKIE['PHPSESSID']) ){
            session_start();//开启sesion
            if( empty($_SESSION['user_id'])) {
            // 跳出到登录页，重新登录
            header('location:./login.php');
            die(); //终止下面代码执行
            }
        } else {
            // 跳出到登录页，重新登录
            header('location:./login.php');
            die(); //终止下面代码执行
        }
    }



?>