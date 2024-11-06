<?php

namespace App\Exceptions;

use App\Http\Services\SqlLogService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\View\View;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|HttpResponse|View
     * @throws Throwable
     */
    public function render($request, Throwable $e):JsonResponse|HttpResponse|View
    {
        if ($e instanceof QueryException) {
            try {
                SqlLogService::record($e, '');
            } catch (Exception $childException) {
                Log::error('Failed to log query exception: ', ['exception' => $childException]);
            }

            if (request()->ajax()) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'msg' => $e->getMessage()
                ], 500);
            } else {
                return response()->view('admin.error',
                    ['code' => 0, 'msg' => $e->getMessage(), 'wait' => 5, 'url' => url('admin/index')],
                    500
                );
            }
        }

        return parent::render($request, $e);
    }
}
