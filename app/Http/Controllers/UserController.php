<?php

namespace App\Http\Controllers;

use App\Mail\ValidationMail;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $credentials = request(['email', 'password']);
        $user = User::where('email', $request->email)->first();

        $userCoba = User::where('email', $request->email)->first();
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $th) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        Auth::login($user);
        $_SESSION['users'] = $userCoba;

        return response()->json(['message' => "Login Success", 'token' => $token, 'web' => Auth::check()], 200,);
    }

    protected static function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => Auth::user()->nama
        ];
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user =  User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'role_id' => $request->role_id == null ? 3 : $request->role_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $profil =  Profile::create([
            'user_id' => $user->id
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['message' => 'Successfully created user!', 'user' => $token], 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getCode());
        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getCode());
        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getCode());
        }

        return response()->json(compact('user'));
    }


    public function verifKYC(Request $request)
    {
        try {
            $profil = Profile::with('user')->where('user_id', Auth::user()->id)->first();
            if ($request->file('kyc_file') != null) {
                $filename = $request->file('kyc_file')->getClientOriginalName();
                $request->file('kyc_file')->storeAs('public/kyc', $request->file('kyc_file')->getClientOriginalName());
            }
            $profil->kyc_file = $filename;
            $profil->save();
            return response()->json(['message' => 'Successfully updated user!'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to update user!', 'error' => $e->getMessage()], 500);
        }
    }

    public function changeVerif(Request $request)
    {
        try {
            $profil = Profile::with('user')->where('user_id', $request->id)->first();
            if (!$profil) {
                return response()->json(['message' => 'User not found!'], 404);
            } else {
                $profil->verifikasi = '1';
                $profil->save();
            }
            return response()->json(['message' => 'Successfully Verified user!', 'user' => $profil], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to update user!', 'error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/authenticate');
    }
}
