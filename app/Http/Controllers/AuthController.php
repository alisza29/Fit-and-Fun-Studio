<?php
namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

// class AuthController extends Controller
// {
//     public function login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');

//         if (! $token = JWTAuth::attempt($credentials)) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         return $this->respondWithToken($token);
//     }

//     public function register(Request $request)
//     {
//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => bcrypt($request->password),
//             'role' => $request->role,
//         ]);

//         return response()->json(['user' => $user]);
//     }

//     protected function respondWithToken($token)
//     {
//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'bearer',
//             'expires_in' => JWTAuth::factory()->getTTL() * 60
//         ]);
//     }
// }

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = JWTAuth::user();
        // return response()->json([
        //     'message' => 'User logged in successfully',
        //     'user' => [
        //         'id' => $user->id,
        //         'name' => $user->name,
        //         'email' => $user->email,
        //         'password' => $user->password,
        //     ],
        //     'token' => $token,
        // ]);

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];

        if ($request->role == 'customer') {
            $rules['phone_number'] = 'required';
            $rules['coach'] = 'required';
            $rules['tb'] = 'required';
            $rules['bb'] = 'required';
            $rules['goal'] = 'required';
        } elseif ($request->role == 'coach' || $request->role == 'admin') {
            $rules['phone_number'] = 'required';
        }

        $request->validate($rules);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'coach' => $request->coach,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'goal' => $request->goal,
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
