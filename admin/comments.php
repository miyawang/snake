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
          <button class="btn btn-info btn-sm btn-approveds">批量批准</button>
          <button class="btn btn-danger btn-sm btn-dels">批量删除</button>
        </div>
        <!-- 分页的容器 -->
        <!--  pull-right 有浮动 -->
       <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <!-- 表头 -->
        <thead>
          <tr>
            <th class="text-center" width="40"><input class="th-chk" type="checkbox"></th>
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
  <!-- 引入模板引擎 -->
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

          var current = 1; //记录当前页

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
                //让 全选按钮和批量按钮重置
                $('.th-chk').prop('checked', false);
                $('.btn-batch').hide();
              }
            })
          }
          
          //2-获取第一页评论数据渲染在页面中
          render();
          //3-生成分页方法
          function setPage(page) {
            //1- 获取数据库中数据的总数
            $.ajax({
              url: './comment/comTotal.php',
              dataType: 'json',
              success: function (info) {
                console.log(info);
                //2-生成分页插件
                $('.page-box').pagination(info.total, {
                  prev_text:'上一页',
                  next_text:'下一页',
                  num_display_entries: 5, //连续主体个数
                  current_page:page || 0, //默认选中那一页
                  num_edge_entries: 1,
                  load_first_page:false, //初始化完成不执行回调函数
                  callback: function (index) { //index 是当前点击页码的索引值
                    //渲染对应的页面
                    //索引值比页码小1 
                    render(index + 1);
                    //记录当前页
                    current = index + 1;

                  }
                });
              }
            })
          }
          //4-生成分页
          setPage();

          //5-批准评论
          //点击批准按钮，获取对应数据id，传递给后他进行批准
          //ajax返回数据动态生成结构，给动态生成元素绑定事件用事件委托
          //$('父盒子').on('事件类型','子元素', function(){})
          $('tbody').on('click', '.btn-approved', function () {
            //获取数据id
            var id = $(this).parent().attr('data-id');
           //传给id给后台进行批准
           $.ajax({
             url: './comment/comApproved.php',
             data: {id : id},
             success: function (info) {
               //操作成功 重新渲染当前页面
               render(current);               
             }
           })
          })


          //6-删除功能
          //点击删除按钮，获取对应数据id，传递给后他进行删除
          $('tbody').on('click', '.btn-del', function () {
            var id = $(this).parent().attr('data-id');
            //请求后台进行删除
            $.ajax({
              url: './comment/comDel.php',
              data: {id: id},
              dataType: 'json',
              success: function (info) {
                 console.log(info);                 
                 //删除完成后，判断当前页码 是否大于 数据中数据页码   
                 //数据库中数据的页码  
                  var maxPage = Math.ceil(info.total/10);       
                  if(current > maxPage) {
                    current = maxPage; //把数据库中数据的最大页码赋值给当前页面
                  }    

                 //重新渲染当前页
                 render(current); 
                 //数据库的数据总数发生变化后，重新生成分页标签
                 //默认选中当前页
                 //页码比分页索引值大1 
                 setPage(current -1 );

              }
            })
          })
          

          //7-全选功能
          //7-1 让页面所有小复选框 的选中状态 和 全选按钮保存一致
          //7-2 如果全选按钮选中，批量操作按钮显示， 否则隐藏
          $('.th-chk').change(function () {
            var flag = $(this).prop('checked'); //获取自己选中状态
            $('.tb-chk').prop('checked', flag); //设置小复选框

            //如果全部选中 批量操作按钮应该显示 ，否则隐藏
            if (flag) {
              $('.btn-batch').show();
            } else {
              $('.btn-batch').hide();
            }
          })

          //8 - 多选功能
          // 8-1 如果所有小复选框全部选中，则全选按钮选中，否则取消
          // 8-2 如果有小复选框被选中， 批量按钮显示，否则隐藏
          // 8-3 在渲染方法中，每次页面重新渲染，将全选 和批量操作按钮 进行重置
          $('tbody').on('change', '.tb-chk', function () {
             console.log($('.tb-chk').length); //所有复选框
             console.log($('.tb-chk:checked').length); //被选中的复选框
             //被选中的复选框个数 等于 所有小复选框个数 
             if ( $('.tb-chk').length == $('.tb-chk:checked').length) {
               //全选
               $('.th-chk').prop('checked', true);
             } else {
               $('.th-chk').prop('checked', false);
             }
             
             //如果有复选框被选中，则批量按钮显示，否则隐藏
             if ($('.tb-chk:checked').length > 0) {
                $('.btn-batch').show();
             } else {
                $('.btn-batch').hide();
             }
          })


          //9-获取被选中复选框的 id
          function getId() {
            var arr = [];
            //1-获取被选中复选框 id
            $('.tb-chk:checked').each(function (index, ele) {
               arr.push( $(ele).parent().attr('data-id'));
            })
            arr = arr.join(); //把数组拼接成字符串
            console.log(arr);
            return arr;             
          }

          //10 点击批量按钮，获取被选中的数据的id 
          //10-1 获取被选中的数据id
          //10-2 把id传递给后台，进行批量批准（后台接口用in语法）
          //10-3 批准之后，页面重新渲染
          $('.btn-approveds').click(function () {
            var ids = getId();          
            $.ajax({
              url: './comment/comApproved.php',
              data: {id: ids},
              success: function (info) {
                //重新渲染当前页
                render(current);
              }
            })
          })      
          

          //11 点击批量删除，获取被选中的数据的id 
          //11-1 获取被选中的数据id
          //11-2 把id传递给后台，进行批量删除（后台接口用in语法）
          //11-3 批准之后，页面重新渲染

          $('.btn-dels').click(function () {
            var ids = getId(); //获取被选中id
            $.ajax({
              url: './comment/comDel.php',
              data: {id: ids},
              dataType: 'json',
              success: function (info){
                console.log(info);
                //判断数据库中数据总页码是否 小于当前页current 
                var maxPage = Math.ceil(info.total/10);
                if (current > maxPage) {
                  current = maxPage; 
                }
                //删除完成重新渲染
                render(current);
                //重新生成分页 接收的是页面的索引值
                setPage(current - 1);
              }
            })
          })
          

       })
  </script>
  <script type="text/template" id="tmp">
      {{ each list v i }}
         <tr>
            <td class="text-center" data-id = {{ v.id }}><input class="tb-chk" type="checkbox"></td>
            <td>{{ v.author }}</td>
            <td>{{ v.content.substr(0,20)+'...' }}</td>
            <td>《{{ v.title }}》</td>
            <td>{{ v.created }}</td>
            <td>{{ state[v.status] }}</td>
            <td class="text-right" data-id = {{ v.id }}> <!-- 按钮有对齐-->
              <!-- 只有待审核的需要显示批准按钮 -->
              {{ if v.status == 'held' }}
              <a href="javascript:;" class="btn btn-info btn-xs btn-approved">批准</a>
              {{ /if }}
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
            </td>
          </tr>
      {{ /each }}
  </script>

</body>
</html>

 <!-- 
   引入模板引擎
   引入分页插件的js 和 css文件
  -->
