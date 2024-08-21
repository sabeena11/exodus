<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    use HasFactory;
    protected $table = 'rewardapp_event';
     
     protected $fillable = [

      'user_id','title', 'desc','start_date','end_date','image','created','action',

    ];
}
