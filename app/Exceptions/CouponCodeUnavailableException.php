<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class CouponCodeUnavailableException extends Exception
{
    public function __construct($message = "", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // 当这个异常触发时，会调用 render 方法来输出给用户
    public function render(Request $request)
    {
        // 如果用户是通过 Api 请求，则返回 JSON 格式的错误信息
        if ($request->expectsJson()) {
            return response()->json(['msg'=>$this->message], $this->code);
        }

        // 否则返回上一页，并且带上错误信息
        return redirect()->back()->withErrors(['coupon_code'=>$this->message]);
    }
}