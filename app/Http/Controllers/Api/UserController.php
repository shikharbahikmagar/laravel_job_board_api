<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    //user registration
    public function register(Request $request)
    {
        // $data = $request->all();
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password|min:8',

        ]);

        if($validator->fails())
        {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        //get all data
        $data = $request->all();

        //check if email already exist
        $checkEmail = User::where('email', $data['email'])->count();

        if($checkEmail > 0)
        {
            $response = [
                'success' => false,
                'message' => 'email already exists',
            ];
            return response()->json($response, 400);
        }
        
        //save to database
        $user = New User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();

        // $success['token'] = $user->createToken('JobBoarding')->plainTextToken();
        $success['name'] = $user->name;
            
        //send response
        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'user registered successfully',
        ];

            return response()->json($response, 200);
    }

    //user login
    public function login(Request $request)
    {
        //validate user inputs
        $validator = Validator::make($request->all(),
        [
            'email' =>'required|email',
            'password' => 'required|min:8',
        ]);

        if($validator->fails())
        {
            $response = [
               'success' => false,
               'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        //get all data
        $data = $request->all();

        //check if email exist
        $checkEmail = User::where('email', $data['email'])->count();

        if($checkEmail == 0)
        {
            $response = [
               'success' => false,
               'message' => 'user does not exist',
            ];
            return response()->json($response, 400);
        }

        //check if email or password is correct
        if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']]))
        {

            $user = Auth::user();
            // $success['token'] = $user->createToken('JobBoarding')->plainTextToken();
            $success['name'] = $user->name;

            $response = [
               'success' => true,
                'data' => $success,
               'message' => 'user logged in successfully',
            ];

            return response()->json($response, 200);

        }
        else
        //send error message
        {
            $response = [
                'success' => false,
               'message' => 'invalid credentials',
            ];

            return response()->json($response, 400);
        }
    }


    //user logout
    public function logout()
    {
            Auth::logout();
            $response = [
                'message' => 'logout'
            ];
            return response()->json($response, 400);
        // }else
        // {
        //     $response = [
        //         'message' => 'login'
        //     ];
        //     return response()->json($response, 400);
        // }
    }
}
