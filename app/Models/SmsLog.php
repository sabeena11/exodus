<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

       protected $table = 'rewardapp_smslog';
     protected $fillable = [
        'response', 'message', 'user_id', 'success','created',
    ];

    
}
