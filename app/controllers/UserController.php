<?php

use Illuminate\Support\Facades\Validator;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		
		
	}	


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function signup()
	{
		$data = Input::only('first_name','last_name','email','password');
		$validator = Validator::make($data, User::getRules());
		if($validator->fails()){
			return Response::json($validator->errors(),412);
		}
		$name = Input::get('first_name').' '. Input::get('last_name');
		$email = Input::get('email');
		$password = Input::get('password');
		User::create(['name' => $name, 'email' => $email, 'password'=> Hash::make($password)]);
		return Response::json(['message'=> 'Account Created Successfully'],200);
	}

	public function login()
	{
		
		if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'),
		'active' => 1))) 
		{ 
			$active = true;
		 return Response::json(['message' => 'Welcome to the Blog'], 200);		
		}
		return Response::json(['message' => 'Wrong Username or password.']);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
