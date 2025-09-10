<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\Login as LoginRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SessionController extends Controller
{
    /**
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->route('posts.index');
    }

    /**
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    
    /**
     *
     * @param Request $request
     * @return array
     */
    public function getUser(Request $request): array
    {
        $user = $request->user()?->load('roles', 'avatar');
        $img = $user?->avatar?->url;
        $roles = $user?->roles?->pluck('name')->toArray();
        $user = $user?->toArray();
        $filtredUser = [
            'id' => $user['id'] ?? null,
            'first_name' => $user['first_name'] ?? null,
            'middle_name' => $user['middle_name'] ?? null,
            'last_name' => $user['last_name'] ?? null,
            'phone' => $user['phone'] ?? null,
            'email_verified_at' => $user['email_verified_at'] ?? null,
            'img' => $img,
            'created_at' => $user['created_at'] ?? null,
            'email' => $user['email'] ?? null,
            'roles' => $roles,
        ];
        return $filtredUser;
    }
}
    

