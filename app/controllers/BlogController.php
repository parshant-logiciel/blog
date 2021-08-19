<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Transformers\PostTransformer;
use Sorskod\Larasponse\Larasponse;


class BlogController extends \BaseController{

	protected $response;

	public function __construct(Larasponse $response)
	{
		$this->response = $response;
		if (Input::get('includes')) {
			$this->response->parseIncludes(Input::get('includes'));
		}
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$limit = Input::get('limit') ? : 10;
		$posts = Post::where('title', 'LIKE' , '%' . Input::get('title') . '%' )->orderBy(Input::get('sort_by') ? : 'id' ,Input::get('sort_order'? : 'desc'))->paginate($limit);
		return Response::json($this->response->paginatedCollection($posts, new PostTransformer),200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
		$validator = Validator::make(Input::all(),Post::getRules());
		if( $validator->fails() ){
			return Response::json($this->response->item($validator->errors()),412);
		}
		$data = Post::create(Input::all());
		$transformed = $this->response->item($data, new PostTransformer);
		$message = [
			"Message" => 'Post Created Succesfully',
			"data" => $transformed
		];
		return Response::json($message, 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$posts = Post::find($id);
		if($posts){
			return Response::json($this->response->item($posts, new PostTransformer), 200);
		}
		return Response::json(['message'=>'Please Enter a Valid Id'],404);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Post::where('id', $id)->exists()){
			$data = Input::all();
			$validator = Validator::make($data, Post::getRules($id));
			if ($validator->fails()) {
				return Response::json($this->response->item($validator->errors()), 412);
			}
			$posts = Post::find($id);
			$posts->title = Input::get('title') ? : $posts->title;
			$posts->description = Input::get('description') ? : $posts->description;
			$result = $posts->save();
				if($result){
				return Response::json($this->response->item($posts, new PostTransformer), 200);
				}
		}
		return Response::json(['message' => 'Please enter a Valid id'], 404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$blog = Post::find($id);
		if($blog){
			$blog->delete();
			return Response::json(['message' => 'Post Deleted Succesfully'], 200);
		}
		return Response::json(['message'=> 'Please Enter a Valid Id'],404);
	}




}

