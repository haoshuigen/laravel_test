define(["jquery", "ea-admin"], function ($, ea) {
    return {
        index: function () {
            layui.use('form', function () {
                var form = layui.form;
                var table = layui.table;
                var csrfToken = "";
                form.verify({
                    content: function (value) {
                        const regex = /^\s*SELECT\s+.*$/i;
                        if (!regex.test(value)) {
                            ea.msg.error('Please Input Select Type Sql');
                            return false;
                        }
                    }
                });

                form.on('submit(submitBtn)', function (data) {
                    let dataType = $(this).attr("datatype");
                    $("#currentTable").hide();
                    const regex = /^\s*SELECT\s+.*$/i;
                    if (!regex.test(data.field.content)) {
                        ea.msg.error('Please input Select type sql');
                        return false;
                    }
                    let submitFields = data.field;
                    if (csrfToken !== "") {
                        submitFields._token = csrfToken;
                    }
                    submitFields.data_type = dataType;

                    ea.request.post({url: 'system.dev/index', prefix: true, data: submitFields}, function (res) {
                        let _data = res.data;
                        let _cols = res.cols;
                        csrfToken = res.token;
                    }, function (res) {
                        ea.msg.error(res.msg);
                        csrfToken = res.token;
                        return false;
                    });

                    return false;
                });
            });
            ea.listen();
        },
    };
});
