<?php 
  include_once '../fn.php';
  isLogin(); //判断是否登录过
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <!-- 分页样式 -->
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
  
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <!-- 分页的容器 -->
        <!--  pull-right 有浮动 -->
       <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- 添加页面的标记 -->
  <?php $page = "comments" ?>
  <!-- 引入侧边栏 -->
  <?php include_once './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <!-- 分页插件 -->
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <!-- <script>NProgress.done()</script> -->
  <script>
       
       $(function () {
          // 待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed）
          var state  = {
            held: '待审核',
            approved: '批准',
            rejected: '拒绝',
            trashed: '回收站'
          }

          //翻译   state[held]  state[approved]
         
          //1-获取评论数据并渲染
          function render(page, pageSize) {
            $.ajax({
              type: 'get',
              url: './comment/comGet.php',
              data: {
                page: page || 1,
                pageSize: pageSize || 10
              },
              dataType: 'json',
              success: function (info) {
                console.log(info);   //数组
                var  obj = {
                  list: info,
                  state: state
                }
                //组装数据和模板
                $('tbody').html(template('tmp', obj));
              }
            })
          }
          //2-获取第一页评论数据渲染在页面中
          render();
          //3-生成分页
          function setPage() {
            //1- 获取数据库中数据的总数
            $.ajax({
              url: './comment/comTotal.php',
              dataType: 'json',
              success: function (info) {
                console.log(info);
                //生成分页插件
                $('.page-box').pagination(info.total, {
                  prev_text:'上一页',
                  next_text:'下一页',
                  num_display_entries: 5, //连续主体个数
                  num_edge_entries: 1,
                  load_first_page:false, //初始化完成不执行回调函数
                  callback: function (index) {
                    //渲染对应的页面
                    //索引值比页码小1 
                    render(index + 1);
                  }
                });
              }
            })
          }

          setPage();
        

       })
  </script>
  <script type="text/template" id="tmp">
      {{ each list v i }}
         <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{ v.author }}</td>
            <td>{{ v.content.substr(0,20)+'...' }}</td>
            <td>《{{ v.title }}》</td>
            <td>{{ v.created }}</td>
            <td>{{ state[v.status] }}</td>
            <td class="text-right"> <!-- 按钮有对齐-->
              <!-- 只有待审核的需要显示批准按钮 -->
              {{ if v.status == 'held' }}
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              {{ /if }}
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
      {{ /each }}
  </script>

</body>
</html>
