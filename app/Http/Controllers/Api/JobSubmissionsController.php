<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendToEmployer;
use App\Mail\EmailToUser;
use Illuminate\Support\Facades\Mail;
use Resend\Laravel\Facades\Resend;
use App\Models\JobSubmission;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Jobs\SendEmailToUserJob;

class JobSubmissionsController extends Controller
{
    public function getJobSubmissions()
    {

        $employer_id = auth()->user()->id;
        $job_submissions = JobSubmission::with('user_details', 'job_post_details', 'employer_details')->where('employer_id', $employer_id)->get();
        $job_submissions = json_decode(json_encode($job_submissions), true); 
        //echo "<pre>"; print_r($job_submissions); die;

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
        $user_details = User::where('id', $user_id)->first();

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

        //get employer details to send email to employer
        $employer_details = $job_post_details['employer_details'];
        $employer_email = $employer_details['email'];


        //echo "<pre>"; print_r("sent email"); die;
        //save job submission to database
        $job_submission = new JobSubmission();
        $job_submission->user_id = $user_id;
        $job_submission->employer_id = $job_post_details['employer_id'];
        $job_submission->job_post_id = $job_post_id;
        $job_submission->resume = $data['resume'];
        $job_submission->cover_letter = $data['cover_letter'];
        $job_submission->approval_status = 'pending';
        $job_submission->save();

        //sending email to employer about the job submission using resend library 
        Resend::emails()->send([

            'from' => 'no-reply@shikharbahik.com.np',
            'to' => $employer_email,
            'subject' => 'Check employer',
            'html' => '<h1>Hello, '.$employer_details['name'].'</h1> <br>'.$user_details['name'].' has applied for '.$job_post_details['job_title'].' job.'

        ]);
     


        $response = [
           'success' => true,
            'data' => $job_submission,
            'job_post_details' => $job_post_details,
           'message' => 'job applied successfully',
        ];

        return response()->json($response, 200);
    }


    //update job submission status
    public function updateJobSubmissionStatus(Request $request, $id = null)
    {

        $data = $request->all();
        $status = $data['status'];

        
        $job = JobSubmission::find($id);

        //job post details
        $job_post_details = JobPost::find($job['job_post_id']);

        // user details
        $user_details = User::where('id', $job['user_id'])->first();
        $user_email = $user_details['email'];
        $job->update(['status' => $status]);

        // $time = Carbon::now()->addMinutes(1);
        //echo "<pre>"; print_r($time); die;
        // Resend::emails()->later($time, [

        //     'from' => 'no-reply@shikharbahik.com.np',
        //     'to' => $user_email,
        //     'subject' => 'About the Job you have applied',
        //     'html' => '<h1>Hello, '.$user_details['name'].'</h1> <br>'.' Your job for '.$job_post_details['job_title'].' is '.$status.'</br> Thankyou.'

        // ]);
        
        //dispatch SendEmailToUserJob after 10 minutes email will be sent to user 
        SendEmailToUserJob::dispatch($status, $user_details, $job_post_details, $user_email)->delay(now()->addMinutes(10));

        $response = [
           'success' => true,
           'message' => 'job submission status updated successfully',
        ];

        return response()->json($response, 200);
    }
}
