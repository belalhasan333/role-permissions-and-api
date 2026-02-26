<?php

namespace App\Http\Controllers\WEB;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed: ' . $e->getMessage());
        }

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user);

        return redirect()->route('home');
    }
}
