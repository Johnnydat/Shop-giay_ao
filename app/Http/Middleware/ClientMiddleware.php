<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // dd('Middleware đang chạy!', Auth::check()); // Kiểm tra xem có chạy không
        if(!Auth::check()){
            // dd('Bạn chưa đăng nhập');
            return redirect('/')->with('messageLogin','Bạn chưa đăng nhập!!');
        }
        return $next($request);
    }
}
