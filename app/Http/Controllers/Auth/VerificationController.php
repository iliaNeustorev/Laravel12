<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /**
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function repeatSendMail(Request $request): RedirectResponse
    {
        $request->user()->sendEmailVerificationNotification();
        return redirect()->route('posts.index')->with('notification','auth.verify-mail');
    }

    /**
     *
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();
        return redirect()->route('posts.index')->with('notification', 'auth.verify');
    }
    
}
