<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
{
if ($exception instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException) {
return response()->json(['error' => 'Token expired'], 401);
} elseif ($exception instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException)
{
return response()->json(['error' => 'Token invalid'], 401);
} elseif ($exception instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException) {
return response()->json(['error' => 'Token absent'], 401);
}return parent::render($request, $exception);
}
}
