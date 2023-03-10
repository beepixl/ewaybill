<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InvoicePerforma;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InvoicePerformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.invoice-performa.list', ['invoicePerforma' => InvoicePerforma::class]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $customers = Customer::get()->toArray();

        return view('admin.invoice-performa.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customerId' => 'required|numeric',
            'invNo' => "required|unique:invoice_performa" . $request->type == 'update' ? ',' . $request->invId : '',
            'invDate' => 'required|date',
            'supplyType' => 'required',
            'subSupplyType' => 'required',
            'docType' => 'required',
        ]);

        if ($validator->fails())
            return comJsRes(true, $validator->messages()->first());

        try {


            $customerId = $request->customerId;
            $type = $request->type;
            $invId = $request->invId;
            $request->request->remove('type');
            $request->request->remove('invId');

            //  dd(Cache::get("$customerId-pInvProducts"));

            if (Cache::has("$customerId-pInvProducts")) {

                $customer =   Customer::find($customerId);
                $setting = settingData();
                $products = Cache::get("$customerId-pInvProducts");

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
                $data['invNo'] = settingData()->invPrefix . '/PI-' . 75  + InvoicePerforma::count();
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


                if (is_numeric($invId)) {
                    $inv  =  InvoicePerforma::find($invId);
                    $orgInv = $inv;
                    $inv->update($data);
                    Product::where([['invID', $invId], ['type', 2]])->delete();;
                } else {
                    $inv  =  InvoicePerforma::create($data);
                }

                // dd($orgInv);

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
                    $newProduct->type = 2;
                    $newProduct->save();
                }

                Cache::forget("$customerId-pInvProducts");
            } else {
                return comJsRes(true, 'No Products Found In Cart');
            }
        } catch (Exception $e) {

            return comJsRes(true, $e->getMessage());
        }

        return comJsRes(false, 'invoice Created Successfully', $inv->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicePerforma  $invoicePerforma
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $invoice =  InvoicePerforma::with(['billProducts' => function ($q) {
            $q->type(2);
        }, 'customer' => function ($q) {
            $q->with('currencySymbol:name,code,symbol');
        }, 'bank'])->find($id)->toArray();


        $svg = view('admin.invoice.payments.signimg')->render();
        $sign = '<img src="https://soft.rajeshwariinternational.in/sign.png"  width="250"  />';

        // dd($invoice);

        // dd( storage_path('fonts/pdf-fonts.ttf'));
        return view('admin.invoice-performa.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData(),  'sign' => $sign]);


        $pdf = Pdf::loadView('admin.invoice-performa.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData(),  'sign' => $sign]);
        return $pdf->stream('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicePerforma  $invoicePerforma
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $invoice =  InvoicePerforma::with(['billProducts' => function ($q) {
            $q->type(2);
        }])->find($id);

        Session::put('invSelectedCustomer', $invoice->customerId);
        $customerId = Session::get('invSelectedCustomer');

        if (Cache::has("$customerId-pInvProducts")) {
            Cache::delete("$customerId-pInvProducts");
        }

        if (isset($invoice->billProducts) && count($invoice->billProducts) > 0) {
            foreach ($invoice->billProducts as $product) {
                $subTot = $product->taxableAmount * $product->quantity;
                if (Cache::has("$customerId-pInvProducts")) {
                    $customerProducts = Cache::get("$customerId-pInvProducts");
                    $customerProducts->put($product->productId, ['productId' => $product->productId, 'productName' => $product->productName, 'productPrice' => $product->taxableAmount, 'qty' => $product->quantity, 'unit' => $product->qtyUnit, 'notes' => $product->productNotes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgstRate, 'sgst' => $product->sgstRate, 'igst' => $product->igstRate, 'subTot' => ($product->taxableAmount * $product->quantity), 'cGstVal' => (($subTot * $product->cgstRate) / 100), 'sGstVal' => (($subTot * $product->sgstRate) / 100), 'iGstVal' => (($subTot * $product->igstRate) / 100)]);
                    Cache::put("$customerId-pInvProducts", $customerProducts, 6000);
                } else {
                    $customerProducts = collect();
                    $customerProducts->put($product->productId, ['productId' => $product->productId, 'productName' => $product->productName, 'productPrice' => $product->taxableAmount, 'qty' => $product->quantity, 'unit' => $product->qtyUnit, 'notes' => $product->productNotes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgstRate, 'sgst' => $product->sgstRate, 'igst' => $product->igstRate, 'subTot' => ($product->taxableAmount * $product->quantity), 'cGstVal' => (($subTot * $product->cgstRate) / 100), 'sGstVal' => (($subTot * $product->sgstRate) / 100), 'iGstVal' => (($subTot * $product->igstRate) / 100)]);
                    Cache::put("$customerId-pInvProducts", $customerProducts, 6000);
                }
            }
        }

        return view('admin.invoice-performa.create', ['invoice' => $invoice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicePerforma  $invoicePerforma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicePerforma $invoicePerforma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicePerforma  $invoicePerforma
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicePerforma $invoicePerforma)
    {
        //
    }
}
