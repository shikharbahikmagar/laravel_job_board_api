<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
         'job_title',
         'company_name',
         'location',
         'skills',
         'experience',
        'salary',
         'description',
         'status'
    ];

    public function employer_details()
    {
        return $this->belongsTo('App\Models\Employer', 'employer_id');
    }

}
