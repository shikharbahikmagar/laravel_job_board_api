<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobSubmission;
use App\Models\JobPost;

class JobSubmissionsController extends Controller
{
    public function getJobSubmissions()
    {


        $job_submissions = JobSubmission::with('user_details', 'job_post_details')->get();

        $response = [
            'success' => true,
            'job_submissions' => $job_submissions,
        ];

        return response()->json($response, 200);
    }



    //add job submissions
    public function addJobSubmission(Request $request, $id=null)
    {
        //handle empty id value
        if($id == "")
        {
            $response = [
                'success' => false,
                'message' => 'job not found',
            ];

            return response()->json($response, 400);
        }

        //check if job available or not
        $job_post_count = JobPost::where('id', $id)->count();

        if($job_post_count == 0)
        {
            $response = [
               'success' => false,
               'message' => 'job not found',
            ];
            return response()->json($response, 400);
        }

        //get data and save to database
        $data = $request->all();

        $user_id = auth()->user()->id;

        $job_post_id = $id;


        //get job details to get employer details and id
        $job_post_details = JobPost::with('employer_details')->where('id', $job_post_id)->first();
        //make in json format so it will be easier to read
        $job_post_details = json_decode(json_encode($job_post_details), true);
        //echo "<pre>"; print_r($job_post_details); die;


        //check if user already applied for this job
        $job_submission_count = JobSubmission::where('user_id', $user_id)->where('job_post_id', $job_post_id)->count();

        if($job_submission_count > 0)
        {
            $response = [
               'success' => false,
               'message' => 'You have already applied for this job',
            ];
            return response()->json($response, 400);
        }

        //save job submission to database
        $job_submission = new JobSubmission();
        $job_submission->user_id = $user_id;
        $job_submission->employer_id = $job_post_details['employer_id'];
        $job_submission->job_post_id = $job_post_id;
        $job_submission->resume = $data['resume'];
        $job_submission->cover_letter = $data['cover_letter'];
        $job_submission->approval_status = 'pending';
        $job_submission->save();

        $response = [
           'success' => true,
            'data' => $job_submission,
            'job_post_details' => $job_post_details,
           'message' => 'job applied successfully',
        ];

        return response()->json($response, 200);
    }
}
