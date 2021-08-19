<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Post extends Eloquent implements UserInterface, RemindableInterface
{
  use UserTrait, RemindableTrait;

  protected $table = 'posts';

  public $primaryKey = 'id';

  public $timestamps = true;

  protected $fillable = ['title', 'description'];

  protected static function getRules($id)
  {
    $Rules = [
    'title' => 'required|max:20|unique:posts,title'. ($id ? ',$id': ''),
    'description' => 'required|max:200',
    ];
    return $Rules;
  }
  public function comments(){

    return $this->hasMany(Comment::class);
  }
}


