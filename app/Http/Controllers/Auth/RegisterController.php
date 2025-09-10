<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\Register as RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisterController extends Controller
{

    /**
     *
     * @return View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     *
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $request->session()->regenerate();
        Auth::login($user);
        return redirect()->route('posts.index')->with('notification', 'auth.register');
    }
}
