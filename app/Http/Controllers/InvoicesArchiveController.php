<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoicesArchive;
use Illuminate\Http\Request;

class InvoicesArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        $title = "ارشيف الفواتير";
        return view('invoices.archivedInvoices', compact('invoices','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoicesArchive  $invoicesArchive
     * @return \Illuminate\Http\Response
     */
    public function show(invoicesArchive $invoicesArchive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoicesArchive  $invoicesArchive
     * @return \Illuminate\Http\Response
     */
    public function edit(invoicesArchive $invoicesArchive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoicesArchive  $invoicesArchive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoicesArchive $invoicesArchive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoicesArchive  $invoicesArchive
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoicesArchive $invoicesArchive)
    {
        //
    }
}
