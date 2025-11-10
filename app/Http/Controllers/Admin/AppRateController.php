<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\DataTables\AppRateDatatable;
use App\Helpers\ExceptionHandler;
use App\Models\AppRate;
use Illuminate\Http\Request;

class AppRateController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:app_rates-read', only: ['index', 'show']),
            new Middleware('permission:app_rates-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AppRate::select('*')->with('user');

            return AppRateDatatable::setDatatable($data);
        }

        return view('dashboard.pages.app_rates.index');
    }
    /**end of index */

    public function show($id)
    {
        return view('dashboard.pages.app_rates.show', [
            'app_rate' => AppRate::with('user')->findOrFail($id)
        ]);
    }


    public function destroy(AppRate $app_rate)
    {
        try {
            $app_rate->delete();

            return to_route('admin.app_rates.index')
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

            AppRate::destroy($request->items);

            return to_route('admin.app_rates.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete*/

}
