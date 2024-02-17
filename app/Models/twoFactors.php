<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class twoFactors extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['id','user_id','code','failed_attempts'];
}
