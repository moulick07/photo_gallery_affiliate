<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;


class Wallet extends Model
{
    use HasFactory,UuidTrait;
    protected $fillable = [
        'balance','user_id',
      ];

      public function product()
      {
        return $this->belongsTo('App\Image', 'user_id');
      }
    public function user(){
        return $this->belongsTo ('App\Models\User','user_id','id');
    }
}

