<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
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
