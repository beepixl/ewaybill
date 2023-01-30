<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
  
        return view('admin.invoice.list', ['invoice' => Invoice::class]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pdf = Pdf::loadView('admin.invoice.invoice-pdf');

        return $pdf->stream('invoice.pdf');
  

        return view('admin.invoice.create');
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

        $validator = Validator::make($request->all(), [
            'customerId' => 'required|numeric',
            'invNo' => 'required|numeric',
            'invoice_date' => 'required|date',
            'supplyType' => 'required'
        ]);

        if ($validator->fails())
            return comJsRes(true, $validator->messages()->first());

        try {
            $customerId = $request->customerId;

            $inv  =  Invoice::create($request->all());

            if (Cache::has("$customerId-invProducts")) {
                $products = Cache::get("$customerId-invProducts");

                foreach ($products as $product) {
                    $newProduct =  new Product();
                    $newProduct->invID = $inv->id;
                    $newProduct->productId = $product['productId'];
                    $newProduct->productName = $product['productName'];
                    $newProduct->productPrice = $product['productPrice'];
                    $newProduct->quantity = $product['qty'];
                    $newProduct->qtyUnit = $product['unit'];
                    $newProduct->productNotes = $product['notes'];
                    $newProduct->hsnCode = $product['hsnCode'];
                    $newProduct->cgstRate = $product['cgst'];
                    $newProduct->sgstRate = $product['sgst'];
                    $newProduct->igstRate = $product['igst'];

                    $newProduct->cessRate = 0;
                    $newProduct->cessNonadvol = 0;
                    $newProduct->save();
                }

                Cache::forget("$customerId-invProducts");
            } else {
                return comJsRes(true, 'No Products Found In Cart');
            }
        } catch (Exception $e) {

            return comJsRes(true, $e->getMessage());
        }

        return comJsRes(false, 'invoice Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
