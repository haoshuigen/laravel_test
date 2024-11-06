define(["jquery", "ea-admin"], function ($, ea) {
    return {
        index: function () {
            layui.use('form', function () {
                let form = layui.form;
                let table = layui.table;
                let csrfToken = "";
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

                        // download a export file without open new page
                        if (dataType === 'json' || dataType === 'excel') {
                            let $a = $('<a>', {
                                href: ea.exportPath + "/" + _data,
                                style: 'display: none;'
                            }).appendTo('body');
                            $a[0].click();
                            return;
                        }

                        // render search result
                        $("#currentTable").show();
                        table.render({
                            elem: '#currentTable',
                            cols: [_cols],
                            data: _data,
                            page: true,
                            limit: 10,
                            limits: [5, 10, 20, 30]
                        });
                    }, function (res) {
                        $("#currentTable").hide();
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
