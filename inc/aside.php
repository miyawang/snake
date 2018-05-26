<?php 
  //aside.php 不是一个单独页面，而是模块
  //1-获取当前用户id
  $id = $_SESSION['user_id'];
  //根据id获取当前用户信息 
  $sql = "select * from users where id = $id";
  //执行
  $data = my_query($sql)[0];
  // echo '<pre>';
  // print_r($data);
  // echo '</pre>';

  //判断是否是文章模块
  $isPost =in_array($page , ['posts', 'post-add', 'categories']);

  
?>

<div class="aside">
    <div class="profile">
      <img class="avatar" src="../<?php echo $data['avatar']?>">
      <h3 class="name"> <?php echo $data['nickname'] ?>  </h3>
    </div>
    <ul class="nav">
      <!-- 仪表盘 -->
      <li  class="<?php echo $page == 'index1'? 'active': '' ?>">
        <a href="index1.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <!-- 文章模块 -->
      <!-- 大li active 让 背景深色 -->
      <li class="<?php echo $isPost?'active':'' ?>">
       <!--  collapsed 让箭头向右  -->
        <a href="#menu-posts" class="<?php echo $isPost ? '':'collapsed' ?>" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <!-- in 类名可以让ul展开 -->
        <ul id="menu-posts" class="collapse <?php echo $isPost?'in':'' ?>">
        <!-- 每个小li加active类名，可以让文字高亮 -->
          <li class="<?php  echo $page == 'posts' ? 'active': '' ?>" ><a href="posts.php">所有文章</a></li>
          <li class="<?php  echo $page == 'post-add' ? 'active': '' ?>" ><a href="post-add.php">写文章</a></li>
          <li class="<?php  echo $page == 'categories' ? 'active': '' ?>" ><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <!-- 评论 -->
      <li class="<?php echo $page == 'comments'? 'active': '' ?>" >
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <!-- 用户 -->
      <li class="<?php echo $page == 'users'? 'active': '' ?>" >
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <!-- 设置 -->
      <li>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="nav-menus.php">导航菜单</a></li>
          <li><a href="slides.php">图片轮播</a></li>
          <li><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>