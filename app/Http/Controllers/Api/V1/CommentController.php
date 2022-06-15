<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Film;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CommentsResource;

class CommentController extends Controller
{

    public $comment;
    public $film;

    /**
     * Create a new Film model instance.
     *
     * @param  array  $attributes
     * @return void
     */

    public function __construct(Comment $comment, Film $film)
    {
        $this->comment = $comment;
        $this->film = $film;
    }
    /**
     * Login the user into system.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = $this->comment->create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'film_id' => $request->film_id,
            'comment_id' => $request->comment_id ?? null,
        ]);
        return new CommentsResource($comment->load(['childs.user', 'user']));
    }
    public function commentReply(Request $request)
    {
        $comment = $this->comment->create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'film_id' => $request->film_id,
            'comment_id' => $request->comment_id ?? null,
        ]);
        return new CommentsResource($this->comment->find($request->comment_id)->load(['childs.user', 'user']));
    }

}
