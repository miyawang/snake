/*
* 需求:
* 1. 我们已经通过媒体查询给 >= 640 的屏幕, 添加了样式
* 2. 需要根据不同的屏幕宽度, 加载显示不同的图片
* 3. 图片地址存在自定义属性中
* */
$(function() {

  // 获取所有的图片
  var $imgs = $('.carousel img');


  // 添加屏幕改变的监听
  $(window).on("resize", function() {
    // 获取屏幕宽度, 根据屏幕宽度, 判断加载哪个图片
    var pageWidth = $(window).width();

    // 标记当前屏幕是不是小屏幕
    var isMobile = pageWidth < 640 ? true : false;

    // 遍历图片, 根据 isMobile 读取不同的图片进行设置
    $imgs.each(function() {
      //var src = isMobile ? "读取小图片" : "读取大图片";
      var src = isMobile ? $(this).data("msrc") : $(this).data("psrc");
      // 设置给图片 src
      $(this).attr("src", src);
    });
  });
  // 触发一次 resize 事件
  $(window).trigger("resize");

});


/*
* 轮播图移动端, 手指滑动功能
* */
$(function() {

  // 找到轮播图
  var $carousel = $('.wjs_banner .carousel');

  // 需求根据滑动的距离, 判断左滑动, 还是右滑动
  // 记录开始位置
  var startX = 0;

  // jQuery 对原生事件进行了封装处理, 解决了兼容性问题
  // 里面 originalEvent 才是 原始的事件对象

  $carousel.on("touchstart", function( e ) {
    startX = e.originalEvent.touches[0].clientX;
  });
  $carousel.on("touchend", function( e ) {
    // 获取手指移动的距离
    var distanceX = e.originalEvent.changedTouches[0].clientX - startX;
    console.log( distanceX );
    if ( distanceX > 50 ) {
      // 往右滑动, 显示上一张
      $carousel.carousel("prev");
    }

    if ( distanceX < -50 ) {
      // 往左滑动, 显示下一张
      $carousel.carousel("next");
    }
  });

})



// 实现区域滚动功能
$(function() {

  // 动态设置 ul 宽度时, 需要将每一个 li 的宽度都加起来进行计算
  var $ul = $('.wjs_product .tab_wrapper ul');
  var $li = $ul.children();

  var total = 0;
  // 遍历 li 计算 ul 的总长
  $li.each(function() {
    // 获取每一个 li 的宽度
    var liWidth = $(this).width();
    total += liWidth;
  })
  console.log( total );
  // 设置给 ul
  $ul.width( total );

  // 设置宽度, 需要在初始化区域滚动之前做
  new IScroll(".tab_wrapper", {
    scrollX: true,
    scrollY: false
  });
});