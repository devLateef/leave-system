<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_type',
        'start_date',
        'end_date',
        'designation',
        'standin_staff',
        'comment',
        'hod_approval',
        'final_approval'
    ];

    public function comment(){
        return $this->hasMany(Comment::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
