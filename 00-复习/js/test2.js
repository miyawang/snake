define(['./test1'], function (test1) {
    console.log('我是模块test2');
    test1(); //调用模块test1 - say方法

    return {name: 'zs', age: 18};

})