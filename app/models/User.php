<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = ['name','email','password'];

	public static function getRules()
	{
		$Rules = [
			'first_name' => 'required|max:12|min:3|unique:users,name',
			'last_name' => 'required|max:10|min:3',
			'email' => 'required|email|unique:users,email',
		];
		return $Rules;
	}
}
