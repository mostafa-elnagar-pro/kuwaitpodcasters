<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PodcastCommentResource;
use App\Models\Podcast;
use App\Models\PodcastComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PodcastCommentController extends Controller
{
    public function index(Request $request, Podcast $podcast)
    {
        try {
            $comments = $podcast->comments()
                ->with('user:id,name,profile_img')
                ->paginate(20);

            return responseWithPaginatedData(
                $comments,
                PodcastCommentResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of index */

    public function store(Request $request, Podcast $podcast)
    {
        try {
            $request->validate(['comment' => 'required|max:255']);

            $podcast->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $request->comment
            ]);

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of store */

    public function update(Request $request, Podcast $podcast, PodcastComment $comment)
    {
        try {
            Gate::authorize('update', $comment);

            $request->validate(['comment' => 'required|max:255']);

            $comment->update([
                'comment' => $request->comment
            ]);

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of update */

    public function destroy(Podcast $podcast, PodcastComment $comment)
    {
        try {
            Gate::authorize('delete', $comment);

            $comment->delete();

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of destroy */
}
