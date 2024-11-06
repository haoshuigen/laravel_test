<?php

const HOME_PID = 99999999;
const SUPER_ADMIN_ID = 1;

/**
 * @param string $url
 * @param array $vars
 * @param false $suffix
 * @return string
 */
function __url(string $url = '', array $vars = [], bool $suffix = false): string
{
    $url = config('admin')['admin_alias_name'] . (str_starts_with($url, '/') ? $url : "/{$url}");
    $_url = url($url, $vars, $suffix);
    return explode(request()->schemeAndHttpHost(), $_url)[1] ?? '/' . $url;

}

if (!function_exists('parse_name')) {
    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string $name 字符串
     * @param int $type 转换类型
     * @param bool $ucfirst 首字母是否大写（驼峰规则）
     * @return string
     */
    function parse_name(string $name, int $type = 0, bool $ucfirst = true): string
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);

            return $ucfirst ? ucfirst($name) : lcfirst($name);
        }

        return strtolower(trim(preg_replace('/[A-Z]/', '_\\0', $name), '_'));
    }
}


if (!function_exists('password')) {
    /**
     * 密码加密算法
     * @param string $value 需要加密的值
     * @return string
     */
    function password(string $value): string
    {
        $value = sha1('admin_') . md5($value) . md5('_encrypt') . sha1($value);
        return sha1($value);
    }
}

if (!function_exists('json')) {

    function json(array $data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json($data);
    }
}
