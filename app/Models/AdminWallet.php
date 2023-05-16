<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class AdminWallet extends Model
{
    use HasFactory,UuidTrait;
    protected $fillable = [
        'add_data_coin','reference_coin'
      ];
}
