<?php

namespace App\Http\Controllers\V1;

use App\Http\Exceptions\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use \stdClass;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->
        json(['data'=>$user,'access_token' => $token, 'token_type'=>'Bearer']);
    }

    public function login(Request $request) : JsonResponse
    {


        if ($request->method() !== 'POST') {
            return response()->json(['message' => 'Method Not Allowed'], 405);
        }

        try{
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw new AuthenticationException();
            }
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->successResponse($token,'Hi'.$user->name,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorResponse("Login Error",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function logout() : JsonResponse{
        try{
            Auth::user()->tokens->delete();
            return $this->successResponse(null,'Bye',Response::HTTP_OK);
        }catch (Exception $e){
            return $this->errorResponse("Logout Error",$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
