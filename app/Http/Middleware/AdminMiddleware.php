<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // sử dụng auth để check đã đăng nhập hay chưa
        if(!Auth::check()){
            return redirect('/');
        }

        // check phân quyền của admin
        if(Auth::user()->role !== 'admin'){
            return redirect('/')->with('messageLogin','Bạn không đủ quyền truy cập !!');
        }
        return $next($request);
    }
}
