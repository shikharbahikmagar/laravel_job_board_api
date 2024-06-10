<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = '';
    protected $fillable = [
    'name',
    'email',
    'phone_number',
    'address',
    'company_name',
    'company_address',
    'password',
];

    protected $hidden = [
    'password',
    'remember_token',
];
}
