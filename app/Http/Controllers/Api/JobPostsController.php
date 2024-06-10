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
    public function addEditJobs(Request $request, $id=null)
    {
        if($id == "")
        {
            $title = "Add Job";
            $message = "job added successfully";
            $job_post = New JobPost;

        }else
        {

            $title = "Edit Job";
            $message = "job updated successfully";
            $job_post = JobPost::find($id);

            if($job_post->employer_id != auth()->user()->id )
            {
                $response = [
                    "success" => false,
                    "message" => "You are not authorized to edit this job",
                ];

                return response()->json($response, 400);
            }
        }

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
}
