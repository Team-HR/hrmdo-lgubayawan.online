<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcrRecord extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'period_id',
        'employee_id',
        'department_id',
        'employee_type',
        'form_type',
        'immediate_supervisor',
        'department_head',
        'head_of_agency',
        'date_submitted',
        'date_approved',
        'date_certified',
        'record_logs'
    ];
}
