<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Transaction extends Model
{
    use HasFactory,UuidTrait;
    protected $fillable = [
        'amount',
        'user_id'
        ,'image_id',
        'type'
    ];
    public function image(){
      return $this->hasOne('App\Models\Image');

    }
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
