<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Feedback;
use App\DataTables\FeedbackDatatable;
use App\Helpers\ExceptionHandler;
use Illuminate\Http\Request;

class FeedbackController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:feedbacks-read', only: ['index','show']),
            new Middleware('permission:feedbacks-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Feedback::select('*');

            return FeedbackDatatable::setDatatable($data);
        }

        return view('dashboard.pages.feedbacks.index');
    }
    /**end of index */

    public function show(Feedback $feedback)
    {
        return view('dashboard.pages.feedbacks.show', [
            'feedback' => $feedback
        ]);
    }


    public function destroy(Feedback $feedback)
    {
        try {
            $feedback->delete();

            return to_route('admin.feedbacks.index')
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
    /**end of destroy */


    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*' => 'numeric'
            ]);

            Feedback::destroy($request->items);

            return to_route('admin.feedbacks.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete*/

}
