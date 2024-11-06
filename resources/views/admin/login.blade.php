@include('admin.layout.head')
<link rel="stylesheet" href="/static/admin/css/login.css?v={{$version}}" media="all">
<div class="container">
    <div class="main-body">
        <div class="login-main">
            <div class="login-top">
                <span>{{config('admin.admin_site_name')}}</span>
                <span class="bg1"></span>
                <span class="bg2"></span>
            </div>
            <form class="layui-form login-bottom">
                <div class="demo">username:admin password:123456</div>
                <div class="center">

                    <div class="item">
                        <span class="icon icon-2"></span>
                        <input type="text" name="username" lay-verify="required" placeholder="Input account" maxlength="24"/>
                    </div>

                    <div class="item">
                        <span class="icon icon-3"></span>
                        <input type="password" name="password" lay-verify="required" placeholder="Input password" maxlength="20">
                        <span class="bind-password icon icon-4"></span>
                    </div>

                    @if($captcha == 1)
                        <div id="validatePanel" class="item" style="width: 137px;">
                            <input type="text" name="captcha" placeholder="Input captcha" maxlength="4">
                            <img id="refreshCaptcha" class="validateImg" src="{{__url('login/captcha')}}" onclick="this.src='{{__url('login/captcha')}}?seed='+Math.random()">
                        </div>
                    @endif
                </div>
                <div class="tip">
                    <span class="icon-nocheck"></span>
                    <span class="login-tip">Remember me</span>
                </div>
                @csrf
                <div class="layui-form-item" style="text-align:center; width:100%;height:100%;margin:0px;">
                    <button class="login-btn" lay-submit>Login Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.layout.foot')
