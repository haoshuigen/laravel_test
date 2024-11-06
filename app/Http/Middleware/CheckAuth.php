<?php

namespace App\Http\Middleware;

use App\Http\JumpTrait;
use App\Http\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    use JumpTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminConfig = config('admin');
        $parameters = request()->route()->parameters;
        $controller = $parameters['controller'] ?? 'index';
        $adminId = session('admin.id', 0);
        if (!in_array($controller, $adminConfig['no_login_controller'])) {
            $expireTime = session('admin.expire_time');
            if (empty($adminId)) {
                return $this->responseView('Please log on first', [], __url("/login"));
            }
            // 判断是否登录过期
            if ($expireTime !== true && time() > $expireTime) {
                $request->session()->forget('admin');
                return $this->responseView('Your session has expired, please log in again.', [], __url("/login"));
            }
        }
        // 验证权限
        if ($adminId) {
            $authService = app(AuthService::class, ['adminId' => $adminId]);
            $currentNode = $authService->getCurrentNode();
            if (!in_array($controller, $adminConfig['no_auth_controller']) && !in_array($controller, $adminConfig['no_auth_node'])) {
                $check = $authService->checkNode($currentNode);
                if (!$check) return (request()->ajax() || request()->method() == 'POST') ? $this->error('无权限访问') : $this->responseView('无权限访问');
            }
        }
        return $next($request);
    }
}
