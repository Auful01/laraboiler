<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user->role->role != 'admin') {
            return redirect('authenticate')->with('error', 'You are not authorized to access this page');
        }
        // $token = JWTAuth::attempt($credentials);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        User::where('email', $request->email)->update(['remember_token' => $token]);

        return redirect('/')->withCookie(cookie()->forever('token', $token));
    }

    public function logout()
    {
        // dd('logout');
        Auth::logout();
        return redirect('/');
    }
}
