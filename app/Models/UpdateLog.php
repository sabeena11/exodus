<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateLog extends Model
{
    use HasFactory;
     protected $table = 'rewardapp_updatelog';
     
     protected $fillable = [
        'data', 'end_device_id',

    ];

}
