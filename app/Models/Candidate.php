<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidate';

    protected $fillable = [
        'first_name',
        'last_name',
        'year_of_birth',
        'email',
        'phone',
        'resume_url',
        'resume_file',
        'position_applied',
        'status',
        'interview_date',
        'source_url',
        'notes',
    ];
}
