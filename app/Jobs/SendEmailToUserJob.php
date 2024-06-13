<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\EmailToUser;
use Illuminate\Support\Facades\Mail;

class SendEmailToUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $status;
    protected $user_email;
    protected $user_details;
    protected $job_post_details;
    /**
     *  * Create a new job instance.
     *
     * @param string $status
     * * @param string $user_email
     * @param array $user_details
     * @param array $job_post_details
    
     */
    public function __construct($status, $user_details, $job_post_details, $user_email)
    {
        $this->status = $status;
        $this->user_email = $user_email;
        //echo "<pre>"; print_r($this->user_email); die;
        $this->user_details = $user_details;
        $this->job_post_details = $job_post_details;
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //echo "<pre>"; print_r($this->job_post_details); die;
        //handling the job to send email to the user
        try {
            Mail::to($this->user_email)->send(new EmailToUser($this->status, $this->user_details, $this->job_post_details));
        } catch (\Exception $e) {
            // Handle email sending failure
            \Log::error('Failed to send email: ' . $e->getMessage());
            // You can also dispatch an event here for further handling
            // For example: event(new EmailSendingFailed($e->getMessage(), $this->status, $this->user_details, $this->job_post_details));
        }
        
    }
}

