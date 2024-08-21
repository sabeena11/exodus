<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsOverview extends Model
{
    use HasFactory;
    protected $table = 'clients_overview';
    protected $fillable = [
        'desc','name','designation','rating star','image',
    ];
}
