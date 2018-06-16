// 页面滚动 动态设置头部透明度
(function() {
  var header = document.querySelector('header');
  window.addEventListener('scroll', function() {
    var scrollTop = window.pageYOffset;
    var opacity = 0;
    if (scrollTop > 600) {
      opacity = 0.9;
    } else {
      opacity = (scrollTop / 600) * 0.9;
    }
    header.style.backgroundColor = 'rgba(222,24,27,' + opacity + ')';
  });
})();
// bnaner 轮播图
(function() {
  var ul = document.querySelector('.banner ul');
  var lis = ul.children;
  var width = lis[0].offsetWidth;
  var points = document.querySelectorAll('.banner ol li');
  var index = 1;
  var timer = setInterval(function() {
    index++;
    addTransition();
    setTranslateX(-index * width);
  }, 3000);
  ul.addEventListener('transitionend', function() {
    if (index >= lis.length - 1) {
      index = 1;
      removeTransition();
      setTranslateX(-index * width);
    }
    if (index <= 0) {
      index = lis.length - 2;
      removeTransition();
      setTranslateX(-index * width);
    }
    // 同步小圆点
    points.forEach(function(v, i) {
      v.classList.remove('current');
    });
    points[index - 1].classList.add('current');
  });
  // 手指滑动
  var startX = 0;
  var startTime = 0;
  ul.addEventListener('touchstart', function(e) {
    startX = e.touches[0].clientX;
    startTime = new Date();
    clearInterval(timer);
  });
  ul.addEventListener('touchmove', function(e) {
    var distanceX = e.touches[0].clientX - startX;
    // removeTransition();
    removeTransition();
    setTranslateX(-index * width + distanceX);
  });
  ul.addEventListener('touchend', function(e) {
    var distanceX = e.changedTouches[0].clientX - startX;
    var time = new Date() - startTime;
    if (distanceX > width / 3 || (time < 200 && distanceX > 50)) {
      index--;
    } else if (distanceX < -width / 3 || (time < 200 && distanceX < 50)) {
      index++;
    }
    addTransition();
    setTranslateX(-index * width);
    timer = setInterval(function(){
      index++;
      addTransition();
      setTranslateX(-index * width);
    },3000);
  });
  window.addEventListener('resize',function(){
    width = lis[0].offsetWidth;
    removeTransition();
    setTranslateX(-index*width);
  })
  function addTransition(){
    ul.style.transition = 'all .5s';
    ul.style.webkitTransition = 'all .5s';
  }
  function removeTransition(){
    ul.style.transition = 'none';
    ul.style.webkitTransition = 'none';
  }
  function setTranslateX(value){
    ul.style.transform = 'translateX(' + value + 'px)';
    ul.style.webkitTransform = 'translateX(' + value + 'px)'
  }
})();
