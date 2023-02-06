<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
            'invNo' => 'required|unique:invoices',
            'invDate' => 'required|date',
            'supplyType' => 'required',
            'docType' => 'required',
        ]);

        if ($validator->fails())
            return comJsRes(true, $validator->messages()->first());

        try {

            $customerId = $request->customerId;

            if (Cache::has("$customerId-invProducts")) {

                $customer =   Customer::find($customerId);
                $setting = settingData();
                $products = Cache::get("$customerId-invProducts");
                $productsSubTot = $products->sum('subTot');

                $productsigstValue = 0;
                $productscgstValue =  0;
                $productssGstVal = 0;

                if ($customer->toStateCode == $setting->fromStateCode) {
                    $productscgstValue =  $products->sum('cGstVal');
                    $productssGstVal = $products->sum('sGstVal');
                } else {
                    $productsigstValue = $products->sum('iGstVal');
                }

                $data = $request->all();
                $data['totalValue'] = $productsSubTot;
                $data['cgstValue'] = $productscgstValue;
                $data['sgstValue'] = $productssGstVal;
                $data['igstValue'] = $productsigstValue;

                $data['totInvValue'] = $productsSubTot + $productscgstValue + $productssGstVal + $productsigstValue;

                $data['fromGstin'] = $setting->fromGstin;
                $data['fromTrdName'] = $setting->fromTrdName;
                $data['fromAddr1'] = $setting->fromAddr1;
                $data['fromAddr2'] = $setting->fromAddr2;
                $data['fromPlace'] = $setting->fromPlace;
                $data['fromPincode'] = $setting->fromPincode;
                $data['actFromStateCode'] = $setting->actFromStateCode;
                $data['fromStateCode'] = $setting->fromStateCode;

                $data['toGstin'] = $customer->toGstin;
                $data['toTrdName'] = $customer->toTrdName;
                $data['toAddr1'] = $customer->toAddr1;
                $data['toAddr2'] = $customer->toAddr2;
                $data['toPlace'] = $customer->toPlace;
                $data['toPincode'] = $customer->toPincode;
                $data['actToStateCode'] = $customer->actToStateCode;
                $data['toStateCode'] = $customer->toStateCode;

                // dd($data);

                $inv  =  Invoice::create($data);

                foreach ($products as $product) {
                    $newProduct =  new Product();
                    $newProduct->invID = $inv->id;
                    $newProduct->productId = $product['productId'];
                    $newProduct->productName = $product['productName'];
                    $newProduct->taxableAmount = $product['productPrice'];
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
    public function show($id)
    {

        $invoice =  Invoice::with('billProducts')->find($id)->toArray();
        // dd( storage_path('fonts/pdf-fonts.ttf'));
// return view('admin.invoice.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData()]);
        // dd($invoice);

        $pdf = Pdf::loadView('admin.invoice.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData()]);
        return $pdf->stream('invoice.pdf');
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
