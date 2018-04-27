// 2食物 宽 高 颜色 坐标 方法是渲染到页面
    function Food(options) {
      //构造函数来创建
      options = options || {};
      this.width = options.width || 20;
      this.height = options.height || 20;
      this.bgColor = options.bgColor || '#f99'
      this.x = options.x || 0;
      this.y = options.y || 0;
    }

    // var food = new Food({ bgColor: '#f00' });
    //创建实例对象 
    // console.log(food.bgColor);
    Food.prototype.render = function (target) {
      // 在构造函数的原型对象中创建render方法 这样可以实现复用 渲染就是 为页面添加元素
      var foodElement = document.createElement('div'); //创建元素 
      this.foodElement = foodElement
      foodElement.style.width = this.width + 'px';
      foodElement.style.height = this.height + 'px';
      foodElement.style.backgroundColor = this.bgColor;
      foodElement.style.position = 'absolute';
      //因为要用到x 和 y坐标 所以 定义下构造函数的x 和 y坐标
      //但是 由于自上而下解析  所以 把坐标放在前面;
      this.x = parseInt(Math.random() * (map.offsetWidth / this.width));
      this.y = parseInt(Math.random() * (map.offsetHeight / this.height));
      foodElement.style.left = this.x * this.width + 'px';
      foodElement.style.top = this.y * this.height + 'px';
      // 为元素添加内容
      target.appendChild(foodElement);
      // 追加到map
    }
   