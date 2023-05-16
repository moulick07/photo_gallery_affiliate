<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use App\Models\User;


class Image extends Model
{
  use HasFactory, UuidTrait;

  protected $fillable = [
    'price',
    'title',
    'tags',
    'imagename',
    'user_id',
  ];

  protected $preventLazyLoading = true;
  public function product()
  {
    //  return $this->belongsTo('App\User', 'user_id');
    $posts = User::all();
    $posts->load('images');
  }
  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }
  public function transaction()
  {
    return $this->belongsToMany('App\Models\Transaction');

  }
}