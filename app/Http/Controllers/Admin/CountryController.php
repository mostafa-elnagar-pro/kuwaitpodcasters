<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\DataTables\CountryDatatable;
use App\Helpers\ExceptionHandler;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:countries-read', only: ['index', 'show']),
            new Middleware('permission:countries-create', only: ['create', 'store']),
            new Middleware('permission:countries-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Country::select('*');

            return CountryDatatable::setDatatable($data);
        }

        return view('dashboard.pages.countries.index');
    }
    /** end of index */


    public function create()
    {
        return view('dashboard.pages.countries.create', [
            'existingCountryFlags' => Country::select('id', 'flag')->get()->pluck('flag')
        ]);
    }
    /** end of create */


    public function store(Request $request)
    {
        try {
            $countryList = [];
            foreach ($request->countries as $country) {
                $country = (array) json_decode($country);
                $country['created_at'] = now();

                $countryList[] = $country;
            }

            Country::insert($countryList);

            forgetCachedSettings();

            return to_route('admin.countries.index')
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /** end of store */


    public function show(Country $country)
    {
        return view('dashboard.pages.countries.show', [
            'country' => $country
        ]);
    }
    /** end of show */


    public function destroy(Country $country)
    {
        try {
            $country->delete();

            forgetCachedSettings();

            return to_route('admin.countries.index')
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
    /** end of destroy */


    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*' => 'numeric'
            ]);

            Country::destroy($request->items);

            forgetCachedSettings();

            return to_route('admin.countries.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /** end of bulkDelete */
}
