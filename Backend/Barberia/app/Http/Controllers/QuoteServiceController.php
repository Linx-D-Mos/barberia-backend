<?php

namespace App\Http\Controllers;

use App\Models\QuoteService;
use App\Http\Requests\StoreQuoteServiceRequest;
use App\Http\Requests\UpdateQuoteServiceRequest;

class QuoteServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuoteServiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(QuoteService $quoteService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuoteService $quoteService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteServiceRequest $request, QuoteService $quoteService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuoteService $quoteService)
    {
        //
    }
}
