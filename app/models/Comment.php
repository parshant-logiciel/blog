<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Comment extends Eloquent implements UserInterface, RemindableInterface
{
  use UserTrait, RemindableTrait;

  public $table = 'comments';

  public $primaryKey = 'id';

  public $timestamps = true;

  protected $fillable = ['comments'];

  public function post(){
    return $this->belongsTo(Post::class);
  }
}
