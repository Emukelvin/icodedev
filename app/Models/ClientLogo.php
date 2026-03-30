<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLogo extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
