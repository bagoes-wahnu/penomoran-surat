<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(){
        $credentials = request()->only(['username', 'password']);

        if (! $token = JwtAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
         }
        return $this->createNewToken($token);
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => JwtAuth::factory()->getTTL() * 60,
            'expires_in' => JwtAuth::factory()->getTTL() * 60 * 60 * 24 * 7,
            // 'expires_in' => JwtAuth::factory()->getTTL() * 1440,
            'user' => auth()->user()
        ]);
    }

    public function changePassword(Request $request)
    {   
        $user = auth()->user();
        $validator = Validator::make($request->all(),[
            'old_pass' => 'required',
            'new_pass' => 'required|min:8|confirmed',
        ]);
        if($validator->fails()){
           $this->responseCode = 400;
           $this->responseMessage = 'Bad Request!';
           $this->responseData = $validator->errors();

           return response()->json($this->getResponse(), $this->responseCode);
        }

        $oldPass = $request->input('old_pass');
        $newPass = $request->input('new_pass');
        $checkPass = Hash::check($oldPass, $user->password, []);

        if ($checkPass == 1) {
            $change = User::where('id', $user->id)
                      ->update([
                        'password' => Hash::make($newPass)
                      ]);
           $this->responseCode = 200;
           $this->responseMessage = 'buat key data sukses';
           $this->responseData = $change;
 
        } else{

           $this->responseCode = 401;
           $this->responseMessage = 'Password lama salah!';
           $this->responseData = 'Old Password : '. $oldPass;
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
  
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
