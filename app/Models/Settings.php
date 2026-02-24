<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'base_price',
        'extra_fee',
        'player_limit',
        'member_discount',
        'super_member_discount',
        'youth',
        'child',
        'greenfee'
    ];
}
