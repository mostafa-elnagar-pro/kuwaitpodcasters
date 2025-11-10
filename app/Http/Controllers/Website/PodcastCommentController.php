<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\PodcastCommentResource;
use App\Models\Podcast;
use Illuminate\Http\Request;
use App\Models\PodcastComment;

class PodcastCommentController extends Controller
{
    public function index(Request $request, Podcast $podcast)
    {
        $comments = $podcast->comments()->with('user:id,name,profile_img')->whereNot('user_id', auth()->id());

        $sort = $request->query('sort', 'latest');

        $comments = match ($sort) {
            'oldest' => $comments = $comments->oldest('id'),
            default => $comments = $comments->latest('id'),
        };

        $comments = $comments->paginate(10);

        return responseWithPaginatedData(
            $comments,
            PodcastCommentResource::class,
        );
    }

    public function store(Request $request, Podcast $podcast)
    {
        $request->validate(['comment' => 'required|string|max:255']);

        $newComment = auth()->user()->comment()->create([
            'podcast_id' => $podcast->id,
            'comment' => $request->comment,
        ]);

        return responseWithData(
            PodcastCommentResource::make($newComment),
        );
    }

    public function update(Request $request, Podcast $podcast, PodcastComment $comment)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        if ($comment->user_id !== auth()->id()) {
            return errorResponse();
        }

        $comment->update([
            'comment' => $request->comment,
        ]);

        return responseWithData(
            PodcastCommentResource::make($comment),
        );
    }

    public function destroy(Request $request, Podcast $podcast, PodcastComment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return errorResponse();
        }

        $comment->delete();

        return successResponse();
    }
}
