<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTestJson extends Model
{
    use HasFactory;

    protected $fillable = [
        'json',
        'user_id',
    ];
}
