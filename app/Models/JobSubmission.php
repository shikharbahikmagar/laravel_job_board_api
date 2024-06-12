<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSubmission extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
         'job_post_id',
         'resume',
         'cover_letter',
         'approval_status',
        
    ];

    public function user_details()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->select('id', 'name', 'email');
    }

    public function job_post_details()
    {
        return $this->belongsTo('App\Models\JobPost', 'job_post_id');
    }

    public function employer_details()
    {
        return $this->belongsTo('App\Models\Employer', 'employer_id')->select('id', 'name', 'email', 'company_name');
    }
}
