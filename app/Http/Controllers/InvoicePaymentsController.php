<?php

namespace App\Http\Controllers;

use App\Models\InvoicePayments;
use Illuminate\Http\Request;

class InvoicePaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.invoice.payments.create');
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
     * @param  \App\Models\InvoicePayments  $invoicePayments
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicePayments $invoicePayments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicePayments  $invoicePayments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicePayments  $invoicePayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicePayments $invoicePayments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicePayments  $invoicePayments
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicePayments $invoicePayments)
    {
        //
    }
}
