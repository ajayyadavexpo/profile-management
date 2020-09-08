<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use App\Userdetail;
use Image;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }


    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        $user->detail;
        return response()->json(compact('user'));
    }

    public function update(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $user->update($request->all());
        $data= [
            'father'=>$request->father,
            'mother'=>$request->mother,
            'wife'=>$request->wife,
            'child'=>$request->child,
            'address'=>$request->address,
            'country'=>$request->country,
            'state'=>$request->state,
            'city'=>$request->city,
            'zip_code'=>$request->zip_code,
        ];

        if($user->detail){
            $user->detail()->update($data);
        }else{
            $user->detail()->create($data);
        }
        return $user;
    }

    public function updateprofile(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $name = $this->uploadImage($request);
        $user->profile_image = $name;
        $user->save();
        return $name;

    }

    private function uploadImage($request){
        $folder = '/image/';
        $strpos = strpos($request->file,';');
        $sub = substr($request->file,0,$strpos);
        $ex = explode('/',$sub)[1];
        $name = time().".".$ex;
        $img = Image::make($request->file)->resize(210, 120);
        $upload_path = public_path().$folder;
        $img->save($upload_path.$name);
        return $name;    
    }
    
}
