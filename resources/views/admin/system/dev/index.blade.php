@include('admin.layout.head')
<div class="layuimini-container">
    <form id="sqlForm" name="sqlForm" class="layui-form layuimini-form" lay-filter="myForm" method="post">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">Input SQL</label>
            <div class="layui-input-block">
                <textarea name="content" class="layui-textarea"  placeholder="only supports select command" lay-verify="content"></textarea>
            </div>
        </div>
        <div class="layui-form-item text-center">
            <a class="layui-btn layui-btn-normal layui-btn-sm" datatype="raw" lay-submit lay-filter="submitBtn">Execute</a>
            <a class="layui-btn layui-btn-warm layui-btn-sm"  datatype="json" lay-submit lay-filter="submitBtn">ExportJSON</a>
            <a class="layui-btn layui-btn-primary layui-btn-sm" datatype="excel" lay-submit lay-filter="submitBtn">Export Excel</a>
        </div>
    </form>
    <table id="currentTable" class="layui-table layui-hide" lay-filter="currentTable">
    </table>
</div>
@include('admin.layout.foot')
