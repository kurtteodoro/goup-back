<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Validator;
use Hash;
use DB;

class UserController extends Controller
{

        
    /**
     * store - Realiza o cadastro do usuário
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);
        if ($validator->fails())
            return response()->json([ 'errors' => $validator->errors()->all() ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()) {
            return response()->json([
                'success' => true
            ]);
        } else 
            return response()->json([ 'success' => false ]);
    }
        
    /**
     * login - Realiza o login do usuário
     *
     * @param  mixed $request
     * @return Response
     */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
            return response()->json([ 'errors' => $validator->errors()->all() ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response()->json([ 'success' => true, 'token' => $token, 'user' => $user ]);
            } else {
                return response()->json([ 'error' => true, 'message' => 'Senha inválida' ]);
            }
        } else
            return response()->json([ 'error' => true, 'message' => 'Login inválido' ]);
    }
}
