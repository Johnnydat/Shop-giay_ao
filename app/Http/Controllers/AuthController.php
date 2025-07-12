<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showFormRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Xử lý đăng nhập
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if ($user->status == 0) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa.',
                ])->onlyInput('email');
            }

            return match ($user->role) {
                'admin' => redirect()->intended('/admin')
                    ->with('success', 'Đăng nhập admin thành công'),
                default => redirect()->intended('/')
                    ->with('success', 'Đăng nhập thành công')
            };
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone'     => ['required', 'regex:/^0[0-9]{9,10}$/'],
            'gender'    => ['nullable', Rule::in(['M', 'F', 'O'])],
            'agreeTerms' => ['accepted'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'agreeTerms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $user = User::create([
            'username' => $validated['username'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => 1,
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công!');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đăng xuất thành công');
    }
}
