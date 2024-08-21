<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    use HasFactory;

    protected $table = 'coreapp_appconfig';

    protected $fillable = ['id', 'sms_token', 'reward_value', 'enable_sms', 'enable_notification'];
}
