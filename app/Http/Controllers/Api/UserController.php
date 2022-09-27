<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Mail\ValidationMail;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use Exception;
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
        $user = User::with('profil')->where('email', $request->email)->first();
        $userCoba = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Akun tidak terdaftar'], 401);
        }

        $profil = User::with('profil')->where('email', $request->email)->first();
        $token = JWTAuth::attempt($credentials);
        try {
            if (!$token) {
                return response()->json(['status' => false, 'message' => 'Password anda salah'], 401);
            }
        } catch (JWTException $th) {
            dd($th);
            return response()->json(['error' => 'could_not_create_token'], false);
        }

        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        $profil['token'] = $token;
        if ($profil->role_id == 2) {
            if ($profil->profil->verifikasi == 0) {
                $profil['token'] = null;
            }
        } else {
            unset($profil->profil['kyc_file']);
            unset($profil->profil['no_ktp']);
            unset($profil->profil['verifikasi']);
        }
        return [
            'status' => true,
            'message' => "Login Success",
            'data' => $profil
        ];
    }


    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            return [
                'status' => true,
                'message' => "Logout Success"
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }



    protected static function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => Auth::user()->nama
        ];
    }

    public function register(CreateRequest $request)
    {


        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $request->validator->errors()->first(),
                // 'data' => $request->validator->errors()->all()
            ], 401);
        }

        $user =  User::create([
            'nama' => $request->nama,
            'role_id' => $request->role_id == null ? 3 : $request->role_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $filename = null;
        if ($request->file('kyc_file') != null && $request->role_id == 2) {
            $filename = $request->file('kyc_file')->getClientOriginalName();
            $request->file('kyc_file')->storeAs('public/kyc', $request->file('kyc_file')->getClientOriginalName());
        }

        $filename_foto = null;
        if ($request->file('foto') != null && $request->role_id == 2) {
            $filename_foto = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/user', $request->file('foto')->getClientOriginalName());
        }

        Profile::create([
            'user_id' => $user->id,
            'kyc_file' => $request->role_id == 2  && $filename != null ? $filename : null,
            'foto' => $request->role_id == 2 && $filename_foto != null ? $filename_foto : null,
            'no_ktp' => $request->role_id == 2 ? $request->no_ktp : null,
            'telepon' => $request->telepon,
        ]);



        $token = JWTAuth::fromUser($user);
        $profil = User::with('profil')->where('email', $request->email)->first();
        if ($profil->profil->verifikasi != 0 || $user->role_id != 2) {
            $profil['token'] = $token;
        } else {
            $profil['token'] = null;
        }

        return [
            'status' => true,
            'message' => "Register Success",
            'data' => $profil
        ];
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

        $user = User::with('profil')->where('id', $user->id)->first();

        return [
            'status' => true,
            'message' => "Success",
            'data' => $user
        ];
    }


    public function updateProfile(Request $request)
    {
        try {
            $user = auth('api')->user();
            $profil = Profile::where('user_id', $user->id);
            $profil->update($request->all());
            return [
                'status' => true,
                'message' => "Success",
                'data' => $profil
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
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

            return [
                'status' => true,
                'message' => 'success',
                'data' => $profil
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
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
            Mail::to($profil->user->email)->send(new ValidationMail($profil));
            return [
                'status' => true,
                'message' => 'success',
                'data' => $profil
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getAllUser()
    {
        try {
            $user = User::with('profil', 'role')->where('role_id', '!=', 1)->get();
            return [
                'status' => true,
                'message' => 'success',
                'data' => $user
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getUmkm(Request $request)
    {
        try {
            $nama = $request->nama ?? "";
            $user = DB::select(DB::raw("SELECT users.id as id, users.nama as nama, users.email as email, profile.foto as foto  FROM users JOIN profile ON profile.user_id = users.id WHERE role_id = 2 AND users.nama LIKE '%$nama%'"));
            return [
                'status' => true,
                'message' => 'success',
                'data' => $user
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


    public function getUserById($id)
    {

        try {
            $user = User::with('profil', 'role')->where('id', $id)->first();
            return [
                'status' => true,
                'message' => 'success',
                'data' => $user
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function dbUser()
    {

        $user = DB::select('select COUNT(users.id) as user, roles.role as role from users JOIN roles ON users.role_id = roles.id where role_id != 1 GROUP BY roles.role');
        return $user;
    }
}
