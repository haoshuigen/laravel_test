define(["jquery", "ea-admin","miniAdmin", "miniTab"], function ($, ea, miniAdmin, miniTab) {
    var Controller = {
        index: function () {
            var options = {
                iniUrl: ea.url('ajax/initAdmin'),    // 初始化接口
                clearUrl: ea.url("ajax/clearCache"), // 缓存清理接口
                urlHashLocation: true,      // 是否打开hash定位
                bgColorDefault: false,      // 主题默认配置
                multiModule: true,          // 是否开启多模块
                menuChildOpen: false,       // 是否默认展开菜单
                loadingTime: 0,             // 初始化加载时间
                pageAnim: true,             // iframe窗口动画
                maxTabNum: 20,              // 最大的tab打开数量
            };
            miniAdmin.render(options);

            $('.login-out').on("click", function () {
                ea.request.get({
                    url: 'login/out',
                    prefix: true,
                }, function (res) {
                    ea.msg.success(res.msg, function () {
                        window.location = ea.url('login/index');
                    })
                });
            });
            layui.form.on('switch(header-theme-mode)', function (data) {
                let dark_mode = this.checked
                let that = $('iframe').contents()
                if (dark_mode) {
                    $('#layuicss-theme-dark').attr({
                        rel: "stylesheet",
                        type: "text/css",
                        href: "/static/admin/css/layui-theme-dark.css"
                    })
                        .appendTo("head");
                    that.find("html").addClass('dark')
                    $('html').addClass('dark')
                } else {
                    $('#layuicss-theme-dark').attr({
                        rel: "stylesheet",
                        type: "text/css",
                        href: ""
                    })
                    that.find("html").removeClass('dark')
                    $('html').removeClass('dark')
                }
            });
        },
        welcome: function () {
            miniTab.listen();
        }
    };
    return Controller;
});
