<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rules\Password;

class UserAccountController extends Controller
{
    /**
     * Display the user's account page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        $orders = Auth::user()->orders()->latest()->paginate(10);

        // dd($user->full_name);
        return view('client.users.account', compact('user','orders'));
    }

    /**
     * Update the user's personal information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:M,F,O'
        ]);

        $user->update($validated);

        return back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    /**
     * Update the user's avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $user = Auth::user();

        // Define paths
        $storageRelativePath = 'uploads/avatars';  // For database storage
        $storageFullPath = storage_path('app/public/' . $storageRelativePath);
        $publicPath = 'storage/' . $storageRelativePath;

        // Ensure directory exists with proper permissions
        if (!file_exists($storageFullPath)) {
            mkdir($storageFullPath, 0755, true);
        }

        // Delete old avatar if exists
        if ($user->avatar) {
            $oldAvatarPath = storage_path('app/public/' . $user->avatar);
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }

        // Process new avatar
        $image = $request->file('avatar');
        $extension = $image->getClientOriginalExtension();
        $filename = Str::random(32) . '.' . $extension;
        $relativeFilePath = $storageRelativePath . '/' . $filename;
        $fullFilePath = $storageFullPath . '/' . $filename;

        // Resize and save image
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image->getRealPath());
        $img->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($fullFilePath);

        // Update user record with relative path
        $user->update(['avatar' => $relativeFilePath]);

        return back()->with('success', 'Avatar updated successfully!');
    }
    /**
     * Change the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ]
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
}
