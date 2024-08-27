<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserRole;
use App\Http\Requests\RequestAuth;
use App\Http\Requests\RequestRegister;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function checkAuth(): JsonResponse
    {
        try {
            $user = '';
            if (Auth::check()) {
                $user = User::with('roles:user_id,name')->find(Auth::id());
                return sendSuccessResponse('User Authenticate', 200, $user);
            } else {
                return sendErrorResponse('User Unauthenticated', 404);
            }
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong : ' . $exception->getMessage(), 404);
        }
    }

    public function login(RequestAuth $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            $token  = $user->createToken('MyAppToken')->plainTextToken;
            $data = [
                'user' => $user,
                'token' => $token
            ];
            return sendSuccessResponse('Logged in Successfully!!', '200', $data);
        }catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: '. $exception->getMessage());
        }
    }


    public function registerStep1(RequestRegister $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('12345678')
            ]);
            $user->roles()->create([
                'name' => UserRole::ROLE_USER,
            ]);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return sendErrorResponse('Something went wrong : ' . $exception->getMessage());
        }
        return sendSuccessResponse('User created successfully', 200, $user);
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            auth()->guard('web')->logout();
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Logout successful');
    }
}
