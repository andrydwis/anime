<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($driver)
    {
        return Socialite::driver($driver)->with(['prompt' => 'select_account'])->redirect();
    }

    public function callback($driver)
    {
        $socialiteUser = Socialite::driver($driver)->stateless()->user();

        $user = User::updateOrCreate([
            'email' => $socialiteUser->email,
        ], [
            'name' => $socialiteUser->name,
            'email' => $socialiteUser->email,
            'last_login_at' => now(),
        ]);

        if ($user->getRoleNames()->isEmpty()) {
            $user->assignRole('user');
        }

        Auth::login($user);

        return redirect()->intended('/');
    }
}
