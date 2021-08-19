<?php
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

use App\Transformers\CommentTransformer;
use Sorskod\Larasponse\Larasponse;
class CommentController extends \BaseController {

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
		$limit = Input::get('limit') ?: 10;
		$data = Comment::orderBy(Input::get('sort_by') ?: 'id', Input::get('sort_order') ?: 'desc')->paginate($limit);
		return Response::json($this->response->paginatedCollection($data, new CommentTransformer));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Post::where('id', Input::get('post_id'))->exists()) {
			$comment = Input::all();
			$validator = Validator::make($comment, ['post_id' => 'integer', 'comment' => 'min:3|max:200']);
			if ($validator->fails()) {
				return Response::json($this->response->item($validator->errors()), 412);
			}
			$comment = new Comment();
			$comment->comment = Input::get('comment');
			$blog = Post::find(Input::get('post_id'));
			$blog->comments()->save($comment);

			$transformed = $this->response->item($comment, new CommentTransformer);
			$message = [
				"Message" => 'Commented Succesfully',
				"data" => $transformed
			];
			return Response::json($message, 200);
		}
		return Response::json(['message' => 'Please Enter a Valid Id'], 404);
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
		if ($comment = Comment::find($id)) {
			$comment->comment = Input::get('comment') ?: $comment->comment;
			$result = $comment->save();
			if ($result) {
				return Response::json($this->response->item($comment, new CommentTransformer), 200);
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
		$comment = Comment::find($id);
		if ($comment) {
			$comment->delete();
			return Response::json(['message' => 'Comment Deleted Succesfully'], 200);
		}
		return Response::json(['message' => 'Please Enter a Valid Id'], 404);
	}


}
