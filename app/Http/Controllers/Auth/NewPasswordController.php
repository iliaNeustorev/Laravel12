<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Contracts\View\View ;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Requests\Auth\PasswordReset as PasswordResetRequest;
use Illuminate\Auth\Events\PasswordReset;

class NewPasswordController extends Controller
{
   /**
    *
    * @param string $token
    * @return View
    */
   public function create(string $token): View
   {
     return view('auth.reset-password', ['token' => $token]);
   }

   /**
    *
    * @param PasswordResetRequest $request
    * @return RedirectResponse
    */
   public function store(PasswordResetRequest $request): RedirectResponse
   {
      $data = $request->validated();
      $status = Password::reset(
      $data,
      function ($user, $password) {
          $user->forceFill([
              'password' => Hash::make($password)
          ])->setRememberToken(Str::random(60));

          $user->save();

          event(new PasswordReset($user));
        }
      );
      return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('notification', 'password.reset')
            : back()->withErrors(['email' => [__($status)]]);
      }
}
