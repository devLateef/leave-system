<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_type',
        'department',
        'start_date',
        'end_date',
        'designation',
        'standin_staff',
        'comment',
        'status'
    ];
}
