<?php 
  include_once '../fn.php';
  isLogin(); //判断是否登录过
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>         
        </tbody>
      </table>
    </div>
  </div>
  <!-- 添加页面的标记 -->
  <?php $page = "posts" ?>
  <!-- 引入侧边栏 -->
  <?php include_once './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function () {
      //草稿（drafted）/ 已发布（published）/ 回收站（trashed）
      var state = {
        drafted: '草稿',
        published: '已发布',
        trashed: '回收站'
      }

      var current = 1; //记录当前页
      //1- 根据页码 获取数据并渲染的方法
      function render(page, pageSize) {
        $.ajax({
          url: './posts/postGet.php',        
          data: {
            page: page || 1,
            pageSize: pageSize || 10
          },
          dataType: 'json', 
          success: function (info) {
            console.log(info);
            var obj = {
              list: info,
              state: state
            };
            //组装数据和模板       
            $('tbody').html(template('tmp', obj));  
          }
        })
      }     
      
      //2-请第一屏数据并渲染
      render();

      //3- 封装生成分页页码方法
      function setPage (page) {
        //1-获取服务器数据的总数
        $.ajax({
          url: './posts/postTotal.php',
          dataType: 'json',
          success: function (info) {
            console.log(info);
            $('.page-box').pagination(info.total, {
              prev_text: '上一夜',
              next_text: '下一夜',
              current_page: page - 1 || 0,
              num_display_entries: 7, //连续主体个数
              load_first_page: false, //初始化完成回调函数不执行
              callback: function (index) { //当前页码索引值
                //渲染当前页
                render(index + 1);
                current = index +1; //记录当前页
              }
            });
            
          }
        })
      }

      //4-生成分页
      setPage();

      //5-删除文章
      // 5-1. 点击删除按钮 获取该数据id
      // 5-2. 将id传递给后台，有后台执行删除操作
      // 5-3. 操作完成后， 返回数据库中剩余数据总条数（数据总条数发生变化，分页的页吗也会随之变化）
      // 5-4. 重新渲染数据，看到删除后效果
      $('tbody').on('click', '.btn-del', function () {
        //获取id
        var id = $(this).parent().attr('data-id');
        //请求后台
        $.ajax({
          url: './posts/postDel.php',
          data: {id: id},
          dataType: 'json',
          success: function (info) {
            //每次删除完成后，要判断 数据库数据的总页码 是否小于 当前页
            var  maxPage = Math.ceil(info.total/10);
            if (current > maxPage) {
              current = maxPage;
            }
            //重新渲染当前页
            render(current);
            //重新生成分页页码
            setPage(current);
          }
        })
      })



      
    })
  </script>

  <!-- 准备一个模板 -->
  <script type="text/template" id="tmp" >
    {{ each list v i  }}
        <tr>
            <td class="text-center" data-id = {{ v.id }}><input type="checkbox"></td>
            <td>{{ v.title }}</td>
            <td>{{ v.nickname }}</td>
            <td>{{ v.name }}</td>
            <td class="text-center">{{ v.created }}</td>
            <td class="text-center">{{ state[v.status] }}</td>
            <td class="text-center" data-id = {{ v.id }}>
              <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
            </td>
          </tr>     
    {{ /each }}
  </script>
</body>
</html>
