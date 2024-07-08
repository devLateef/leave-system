<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "start_date",
        "end_date",
        "message",
        "days_given",
        "leave_id",
        "user_id"
    ];

    public function leave(){
        return $this->belongsTo(Leave::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
