<?php
namespace App\Transformers;


use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['comments'];


  public function transform($posts)
  { 
    
    return [
      'id'      => $posts->id,
      'Post-Title'  => $posts->title,
      'Post-Description' => $posts->description,
      'created_at' => $posts->created_at->format('Y-m-d') . " at " . $posts->created_at->format('h:m:s'),
      'updated_at' => $posts->updated_at->format('Y-m-d') . " at " . $posts->updated_at->format('h:m:s')
    ];
  }

  public function includeComments($posts)
  {
     $comments =  $posts->comments;
     
     if($comments){
       return $this->collection($comments, new CommentTransformer);
     }
  }


}