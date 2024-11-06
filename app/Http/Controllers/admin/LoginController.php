<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\common\BaseController;
use App\Models\SystemAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Webman\Captcha\CaptchaBuilder;
use Webman\Captcha\PhraseBuilder;

class LoginController extends BaseController
{
    public function initialize():void
    {
        parent::initialize();
        if (\request()->method() == 'GET' && !empty(session('admin')) && $this->action != 'out') {
            redirect(__url())->send();
        }
    }

    public function index(): View|JsonResponse
    {
        $captcha = config('admin.captcha', false);
        if (!request()->ajax()) {
            return view('admin.login', compact('captcha'));
        }
        if ($captcha) {
            if (strtolower(request()->post('captcha')) !== request()->session()->get('captcha')) {
                return $this->error('captcha code is wrong');
            }
        }
        $post      = \request()->post();
        $rules     = [
            'username'   => 'required',
            'password'   => 'required',
         ];
        $validator = Validator::make($post, $rules, [
            'username' => 'username must be not empty',
            'password' => 'password must be not empty',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $admin = SystemAdmin::where(['username' => $post['username']])->first();
        if (empty($admin) || password($post['password']) != $admin->password) {
            return $this->error('username or password is not right');
        }
        if ($admin->status == 0) {
            return $this->error('the account is disabled');
        }
        $admin->login_num   += 1;
        $admin->update_time = time();
        $admin->save();
        $admin = $admin->toArray();
        unset($admin['password']);
        $admin['expire_time'] = $post['keep_login'] == 1 ? true : time() + 7200;
        session(compact('admin'));
        return $this->success('login success', [], __url());
    }

    public function captcha(): Response
    {
        $length  = 4;
        $chars   = '0123456789';
        $phrase  = new PhraseBuilder($length, $chars);
        $builder = new CaptchaBuilder(null, $phrase);
        $builder->build();
        session()->put('captcha', strtolower($builder->getPhrase()));
        $img_content = $builder->get();
        return response($img_content, 200, ['Content-Type' => 'image/jpeg']);

    }

    public function out(): Response|JsonResponse
    {
        \request()->session()->forget('admin');
        return $this->success('logout done!', [], __url('/login'));
    }
}
