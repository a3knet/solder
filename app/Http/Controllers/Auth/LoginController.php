<?php

/*
 * This file is part of Solder.
 *
 * (c) Kyle Klaus <kklaus@indemnity83.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    /**
    +     * Show the login page.
    +     *
    +     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    +     */
    public function show()
    {

        if (isset($_SERVER['REMOTE_USER'])) {
            $username = $_SERVER['REMOTE_USER'];

            $user = User::where('username', $username)->first();
            if ($user) {
                Auth::login($user);

                return redirect(session()->pull('url.intended', '/'));
            }
        }

        return view('auth.login');
    }

    public function login()
    {
        if (Auth::attempt(request(['email', 'password']))) {
            return redirect(session()->pull('url.intended', '/'));
        }

        return redirect('/login')->withInput(request(['email']))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
