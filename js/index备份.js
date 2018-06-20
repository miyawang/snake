/**
 * Created by Jepson on 2018/6/19.
 */

// 需求:
// 1. 检测屏幕大小变化
// 2. 如果宽度 >= 640, 加载大图片
// 3. 如果宽度 < 640, 加载小图片

$(function() {

  // 获取所有的图片, jquery对象前面命名时, 会加上 $ 前缀
  var $imgs = $('.carousel img');

  $(window).on("resize", function() {

    // 获取屏幕宽度
    var pageWidth = $(window).width();   // window.innerWidth;

    if ( pageWidth >= 640 ) {
      // 加载大图片
      $imgs.each(function() {
        var src = $(this).data("psrc");
        $(this).attr( "src", src );
      })

    }
    else {
      // 加载小图片, 换图片的 src 路径 (每张都要换)
      $imgs.each(function() {
        // 获取图片路径, jQuery 对自定义属性进行了封装, 提供了一个 data 方法,
        // 可以很方便的获取自定义属性
        var src = $(this).data('msrc');
        $(this).attr( "src", src );
      })

    }

  });

  // 触发 window 的 resize 事件
  $(window).trigger("resize");

});

/*
* 总结:
* 1. 一进入页面, 动态检测屏幕宽度的变化, 根据屏幕宽度, 加载不同的图片
* 2. 图片路径存在自定义属性中, 通过 data('..') 获取图片路径
* 3. pc端的样式稍微有点不一样, 需要通过媒体查询进行定制
* */
