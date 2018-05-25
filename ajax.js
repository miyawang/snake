var $ = {
    ajax: function (option) {
        //1-参数处理
        var type = option.type || 'get'; //默认值get
        var url = option.url || location.href; //默认请求当前页面
        var callback = option.callback; //渲染数据方法
        var  data = this.setParam(option.data);  //name=zs&age=18&sex=m  但option是对象 
        
        //2-开始封装ajax的实现代码
        //2-1-创建一个XMLHttpRequest对象
        var  xhr = new XMLHttpRequest();
        
        //get请求在url后面拼接数据
        if (type == 'get') {
            url = url + '?' + data; //aa.php?name=zs&age=18
            data = null; 
        }
        //2-2请求行
        xhr.open(type, url);
        //2-3请求头
        if (type == 'post') {
            xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
        }
        //2-4请求主体
        xhr.send(data);

        //3-监听服务器响应
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var r = xhr.responseText;
                //渲染数据
                //把服务器返回的数据交给callback来渲染
                // if(callback) {
                //     callback(r);
                // }
                //如果callback存在，则执行callback
                callback && callback(r);

            }
        }

    },
    //专门用于将对象转成 name=zs&age=18格式 
    //obj 是对象  返回的是   name=zs&age=18 字符串
    setParam: function (obj) {
        var str = '';
        if(obj) {
            for (var k in obj) {
                str += k + '=' + obj[k] + '&';
            }
            //substr(起始索引，截取长度)
            str= str.substr(0, str.length - 1);//去掉最后一个字符
        }
        return str;
    }
}