<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'id',
        'tenant_id',
        'title',
        'slug',
        'compensation_and_benefits',
        'salary',
        'company_logo',
        'location',
        'post_link',
        'application_deadline',
        'job_responsibility',
        'job_context',
        'educational_requirements',
        'additional_requirements',
        'employee_status',
        'status',
        ];
}
