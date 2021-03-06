<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = 'Businesses';
        $page_description = 'Businesses overview';
        $businesses = Business::orderBy('id', 'DESC')->get();
        return view('admin.business')->with(compact('businesses', 'page_title', 'page_description'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        if ($business->products()->count() > 0 || $business->services()->count() > 0) {
            $warning = 'Business has one or more products/services. Please delete them first.';
            return back()
                ->with('warning', $warning);
        } else {
            $business->users()->detach();
            $business->delete();
            return back()
                // return redirect()->route('admin.settings.users.index')
                ->with('success', 'Business deleted successfully');
        }
    }
}
