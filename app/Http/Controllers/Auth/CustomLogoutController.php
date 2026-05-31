<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CustomLogoutController extends Controller
{
    public function destroy(Request $request)
    {
        // Cierra la sesión del usuario actual
        Auth::logout();

        // Invalida la sesión y regenera el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Limpia manualmente todas las cookies relevantes
        Cookie::queue(Cookie::forget('laravel_session'));
        Cookie::queue(Cookie::forget('XSRF-TOKEN'));
        Cookie::queue(Cookie::forget(Auth::getRecallerName())); // cookie "remember_me"
        Cookie::queue(Cookie::forget('remember_web_' . sha1(config('app.key'))));

        // Limpia cualquier sesión persistente en el servidor
        Session::flush();

        // Redirige al login
        return redirect('/login')->with('status', 'Sesión cerrada correctamente.');
    }
}
