<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use Validator;

class JobPostsController extends Controller
{
    public function jobs()
    {
        //returning jobs with job posters details
        $jobs = JobPost::with('employer_details')->get();
        $jobs = json_decode(json_encode($jobs), true);
        
        $reponse = [
            'success' => true,
            'jobs' => $jobs,
        ];

        return response()->json($reponse, 200);
    }

   
    //add edit job posts
    public function addJobs(Request $request)
    {
            $message = "job added successfully";
            $job_post = New JobPost;


        if($request->isMethod('post'))
        {
            
            $validator = Validator::make($request->all(),
            [
                'job_title' =>'required',
                'company_name' => 'required',
                'location' => 'required',
                'skills' => 'required',
                'experience' => 'required',
                'salary' => 'required',
                'description' => 'required',
            ]);

            if($validator->fails())
            {
                $response = [
                   'success' => false,
                   'message' => $validator->errors()
                ];
                return response()->json($response, 400);
            }

            $data = $request->all();

             $job_post->employer_id = auth()->user()->id;
             $job_post->job_title = $data['job_title'];
             $job_post->company_name = $data['company_name'];
             $job_post->location = $data['location'];
             $job_post->skills = $data['skills'];
             $job_post->experience = $data['experience'];
             $job_post->salary = $data['salary'];
             $job_post->description = $data['description'];
             $job_post->status = 1;
            $job_post->save();

            $response = [
               'success' => true,
                'data' => $job_post,
               'message' => $message,
            ];

            return response()->json($response, 200);
    
        }
    }

    //edit job posts
    public function editJobs(Request $request, $id=null)
    {
        if($id == "")
        {
            $response = [
               'success' => false,
               'message' => 'job not found',
            ];
            return response()->json($response, 400);
        }

        $jobCount = JobPost::where('id', $id)->count();

        if($jobCount == 0)
        {
            $response = [
                'success' => false,
                'message' => 'job not found',
             ];
             return response()->json($response, 400);
        }

        $message = "job added successfully";
        $job_post = JobPost::find($id);

        if($job_post->employer_id != auth()->user()->id )
        {
            $response = [
                "success" => false,
                "message" => "You are not authorized to edit this job",
            ];

            return response()->json($response, 400);
        }

        if($request->isMethod('put'))
        {
            
            $validator = Validator::make($request->all(),
            [
                'job_title' =>'required',
                'company_name' => 'required',
                'location' => 'required',
                'skills' => 'required',
                'experience' => 'required',
                'salary' => 'required',
                'description' => 'required',
            ]);

            if($validator->fails())
            {
                $response = [
                   'success' => false,
                   'message' => $validator->errors()
                ];
                return response()->json($response, 400);
            }

            $data = $request->all();

             $job_post->employer_id = auth()->user()->id;
             $job_post->job_title = $data['job_title'];
             $job_post->company_name = $data['company_name'];
             $job_post->location = $data['location'];
             $job_post->skills = $data['skills'];
             $job_post->experience = $data['experience'];
             $job_post->salary = $data['salary'];
             $job_post->description = $data['description'];
             $job_post->status = 1;
            $job_post->save();

            $response = [
               'success' => true,
                'data' => $job_post,
               'message' => $message,
            ];

            return response()->json($response, 200);
    
        }
    }

    //delete job posts
    public function deleteJob($id=null)
    {
        //handele empty id value
        if($id == "")
        {
            $response = [
               'success' => false,
               'message' => 'job not found',
            ];
            return response()->json($response, 400);
        }

        //check if job exist or not
        $jobCount = JobPost::where('id', $id)->count();

        if($jobCount == 0)
        {
            $response = [
                'success' => false,
                'message' => 'job not found',
             ];
             return response()->json($response, 400);
        }

        $job_post = JobPost::find($id);

        //check if employer is authorized to delete job or not
        if($job_post->employer_id!= auth()->user()->id )
        {
            $response = [
                "success" => false,
                "message" => "You are not authorized to delete this job",
            ];

            return response()->json($response, 400);
        }

        $job_post->delete();
        $response = [
           'success' => true,
           'message' => 'job deleted successfully',
        ];
        return response()->json($response, 200);


    }
}
