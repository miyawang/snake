define([], function () {
    console.log('我是模块test1');
    function say () {
        console.log('我是模块test1d的say方法');
    }

    //导出项
    return say;
});
