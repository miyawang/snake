<?php 
  include_once '../fn.php';
  isLogin(); //判断是否登录过
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="./posts/postAdd.php" method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id="strong">slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" id="img" src="" style="display: none; height:80px;width:80px">
              <!-- 控制选中文件类型 :只要图片 accept="image/gif, image/jpeg"   -->
            <input id="feature" class="form-control" name="feature" type="file" accept="image/gif, image/jpeg">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>  
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>   
            </select>
          </div>
          <div class="form-group">
            <!-- <button class="btn btn-primary" type="submit">保存</button> -->
            <input class="btn btn-primary" type="submit" value="保存">
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- 添加页面的标记 -->
  <?php $page = "post-add" ?>
  <!-- 引入侧边栏 -->
  <?php include_once './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <!-- 时间格式的插件 -->
  <script src="../assets/vendors/moment/moment.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function () {
      //对表单进行优化：
      // 1. 分类下拉数据填充
      // 通过接口，获取分类数据，基于模板动态生成option
      $.ajax({
        url: './categroy/cateGet.php',
        dataType: 'json',
        success: function (info) {
          console.log(info);
          console.log(template('tmp-cate', {list: info}));          
          $('#category').html( template('tmp-cate', {list: info}) );          
        }
      })
      // 2. 状态下拉数据填充
      //遍历state对象，每个属性生成一个option标签
      var state = {  //文章的状态  for -in 
        drafted: '草稿',
        published: '已发布',
        trashed: '回收站'
      }

      //生成状态结构
      console.log(template('tmp-state', {obj: state} ));      
      $('#status').html( template('tmp-state', {obj: state} ));


      // 3. 别名同步
      //oninput当用户输入是触发
      $('#slug').on('input', function () {
        $('#strong').text($(this).val() || 'slug');
      })
      // 4. 默认时间设置
      $('#created').val(moment().format('YYYY-MM-DDTHH:mm'));
      // 5. 图片本地预览
      $('#feature').change(function () {
        var file = this.files[0];
        console.log(file);
        //获取选中文件URL地址
        var url = URL.createObjectURL(file);
        $('#img').attr('src', url).show(); 
      })
      // 6. 富文本编辑器的使用

    })
  </script>

  <!-- 准备分类下拉列表的模板 -->
  <script type="text/template" id="tmp-cate" >
    {{ each list v i }}
      <option value="{{ v.id }}">{{ v.name }}</option>  
    {{ /each }}
  </script>
  <!-- 文章状态的模板 -->
  <!-- 模板引擎遍历对象也是可以的 -->
  <!-- obj是被遍历的对象 v 被遍历属性的值 ， k 被遍历键  -->
  <script type="text/template" id="tmp-state">
    {{ each obj v k }}
       <option value="{{ k }}">{{ v }}</option>   
    {{ /each }}
  </script>
</body>
</html>
