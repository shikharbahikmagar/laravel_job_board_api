<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use Validator;
use Auth;

class EmployersController extends Controller
{
        //employer registration
        public function register(Request $request)
        {
            // $data = $request->all();
            $validator = Validator::make($request->all(),
            [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email',
                'phone_number' => 'required|digits:10',
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
    
            //check if email already exist
            $checkEmail = Employer::where('email', $data['email'])->count();
    
            if($checkEmail > 0)
            {
                $response = [
                    'success' => false,
                    'message' => 'email already exists',
                ];
                return response()->json($response, 400);
            }
            
            //save to database
            $employer = Employer::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'company_name' => $data['company_name'],
                'company_address' => $data['company_address'],
                'password' => bcrypt($data['password']),
            ]);

            $success['token'] = $employer->createToken("employer token")->plainTextToken;
            $success['name'] = $employer->name;
                
            //send response
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'employer registered successfully',
            ];
    
            return response()->json($response, 200);
        }
    
        //employer login
        public function login(Request $request)
        {
            //validate employer inputs
            $validator = Validator::make($request->all(),
            [
                'email' =>'required|email',
                'password' => 'required',
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
            $checkEmail = Employer::where('email', $data['email'])->count();
    
            if($checkEmail == 0)
            {
                $response = [
                   'success' => false,
                   'message' => 'employer does not exist',
                ];
                return response()->json($response, 400);
            }
    
            //check if email or password is correct
            if(Auth::guard('employer')->attempt(['email'=>$data['email'], 'password'=>$data['password']]))
            {
    
                $employer = Auth::guard('employer')->user();
                $success['token'] = $employer->createToken('JobBoarding')->plainTextToken;
                $success['name'] = $employer->name;
    
                $response = [
                   'success' => true,
                    'data' => $success,
                   'message' => 'employer logged in successfully',
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
    
        public function profile()
        {
            $user = auth()->user();
            //$user->token()->delete();
            $response = [
                'status' => true,
                'message' => 'profile',
                'id' => $user->id,
                'data' => $user,
            ];
            return response()->json($response, 200);
    
        }
    
        //employer logout
        public function logout()
        {
            auth()->user()->tokens()->delete();
            $response = [
                'status' => true,
                'message' => 'employee logout successfully',
            ];
            return response()->json($response, 200);
        }
}
