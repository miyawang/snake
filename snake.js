 //因为是在实例对象的原型对象中添加的render方法
    // 所以 可以用实例对象直接调用该方法
    // 3蛇 宽 高 颜色 坐标 蛇头 蛇身 方法：渲染 动起来（最后一个作为第一个）
function Snake(options) {
  options = options || {};
  this.width = options.width || 20;
  this.height = options.height || 20;
  this.headColor = options.headColor || '#0f0';
  this.bodyColor = options.bodyColor || '#00f';
  //因为蛇头和蛇身的颜色不一样
  this.direction = options.direction || 'right';
  // 确定默认移动方向
  this.body = [{ x: 2, y: 0 }, { x: 1, y: 0 }, { x: 0, y: 0 }];
  //给蛇设定默认坐标
}
Snake.prototype.render = function (target) {
  //新建元素 因为是渲染每一个蛇节 所以 要用到for来遍历
  for (var i = 0; i < this.body.length; i++) {    // this.body.length是构造函数中 body里传入的参数个数
    var span = document.createElement('span');
    span.style.width = this.width + 'px';
    span.style.height = this.height + 'px';
    span.style.backgroundColor = (i === 0) ? this.headColor : this.bodyColor;
    span.style.position = 'absolute';
    span.style.left = this.body[i].x * this.width + 'px';
    span.style.top = this.body[i].y * this.height + 'px';
    target.appendChild(span); //target 是传入哪个参数 就在哪个参数后面渲染
  }
}

//给原型对象添加move方法 以便调用r
Snake.prototype.move = function (target,food) {
  var newNode = { 
    x: this.body[0].x,
    y: this.body[0].y }
  // 新增的节 出现在蛇的第一节 也就是蛇头
  switch (this.direction) {
    case 'right':
      newNode.x++;
      break;
    case 'left':
      newNode.x--;
      break;
    case 'up':
      newNode.y--;
      break;
    case 'down':
      newNode.y++
      break;
  }
  // console.log(food.x,food.y);
  
  if ((newNode.x === food.x) && (newNode.y === food.y)) {
    target.removeChild(food.foodElement)
    food.render(target)
  } else {
    this.body.pop();
  }
  this.body.unshift(newNode);
  //把新的节添加到第一个位置
 
  //将最后一节 从蛇中删除 body中
  // console.log(this.body[this.body.length - 1]);
  

 
  //重新格局最新的位置 渲染蛇 每次重新渲染蛇的时候
  // 都要将原来的蛇节对应的元素从页面中删除

  var spans = document.querySelectorAll('span');
  for (var i = 0; i < spans.length; i++) {
    target.removeChild(spans[i]);
  }
  this.render(target);
}

