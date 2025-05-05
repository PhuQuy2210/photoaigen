<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Session;
use Str;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('error') && $request->get('error') === 'access_denied') {
            // Người dùng nhấn hủy
            return redirect('/')->with('error', 'Bạn đã hủy đăng nhập bằng Google.');
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Đăng nhập bằng Google thất bại.');
        }

        $social = SocialAccount::where('provider', 'google')
            ->where('provider_id', $googleUser->getId())
            ->first();

        if ($social) {
            $user = $social->user;
        } else {
            // Kiểm tra hoặc tạo user
            $user = User::firstOrCreate([
                'email' => $googleUser->getEmail()
            ], [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(10)),
                'is_active' => 1,
                'role_id' => 2 // gán mặc định role 'user'
            ]);

            // Liên kết social account
            $user->socialAccounts()->create([
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'avatar_url' => $googleUser->getAvatar()
            ]);
        }

        Auth::login($user);
        Session::flash('success', 'Xin chào ' . $user->name);
        return redirect('/');
    }

    // public function handleGoogleCallback()
    // {
    //     $googleUser = Socialite::driver('google')->user();

    //     $social = SocialAccount::where('provider', 'google')
    //         ->where('provider_id', $googleUser->getId())
    //         ->first();

    //     if ($social) {
    //         $user = $social->user;
    //     } else {
    //         // Kiểm tra hoặc tạo user
    //         $user = User::firstOrCreate([
    //             'email' => $googleUser->getEmail()
    //         ], [
    //             'name' => $googleUser->getName(),
    //             'password' => bcrypt(Str::random(10)),
    //             'is_active' => 1,
    //             'role_id' => 2 // gán mặc định role 'user' (id = 2)
    //         ]);

    //         // Liên kết social account
    //         $user->socialAccounts()->create([
    //             'provider' => 'google',
    //             'provider_id' => $googleUser->getId(),
    //             'email' => $googleUser->getEmail(),
    //             'name' => $googleUser->getName(),
    //             'avatar_url' => $googleUser->getAvatar()
    //         ]);
    //     }

    //     Auth::login($user);
    //     Session::flash('success', 'Xin chào ' . $user->name);
    //     return redirect('/');
    // }

}
