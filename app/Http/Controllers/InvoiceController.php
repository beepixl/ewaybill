<?php

namespace App\Http\Controllers;

use App\Exports\TaxInvoiceExport;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayments;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;


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
        //dd( time());
        // $pdf = Pdf::loadView('admin.invoice.invoice-pdf');

        // return $pdf->stream('invoice.pdf');

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
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'customerId' => 'required|numeric',
            'invNo' => "required",
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

            //  dd(Cache::get("$customerId-invProducts"));

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
                //$data['invNo'] = settingData()->invPrefix.'/INV-'.settingData()->invNoStart  + Invoice::count();
                $data['totalValue'] = $productsSubTot;
                $data['cgstValue'] = $productscgstValue;
                $data['sgstValue'] = $productssGstVal;
                $data['igstValue'] = $productsigstValue;

                $data['totInvValue'] = $productsSubTot + $productscgstValue + $productssGstVal + $productsigstValue;

                // $data['fromGstin'] = $setting->fromGstin;
                // $data['fromTrdName'] = $setting->fromTrdName;
                // $data['fromAddr1'] = $setting->fromAddr1;
                // $data['fromAddr2'] = $setting->fromAddr2;
                // $data['fromPlace'] = $setting->fromPlace;
                // $data['fromPincode'] = $setting->fromPincode;
                // $data['actFromStateCode'] = $setting->actFromStateCode;
                // $data['fromStateCode'] = $setting->fromStateCode;

                $data['toGstin'] = $customer->toGstin;
                $data['toTrdName'] = $customer->toTrdName;
                $data['toAddr1'] = $customer->toAddr1;
                $data['toAddr2'] = $customer->toAddr2;
                $data['toPlace'] = $customer->toPlace;
                $data['toPincode'] = $customer->toPincode;
                $data['actToStateCode'] = $customer->actToStateCode;
                $data['toStateCode'] = $customer->toStateCode;
                // $data['transMode'] = $customer->transMode;
                // $data['transDistance'] = $customer->transDistance;
                // $data['transporterName'] = $customer->transporterName;
                // $data['transDocNo'] = $customer->transDocNo;
                // $data['transporterId'] = $customer->transporterId;
                // dd($request->all());


                if (is_numeric($invId)) {
                    $inv  =  Invoice::find($invId);
                    $orgInv = $inv;
                    $inv->update($data);
                    Product::where([['invID', $invId], ['type', 1]])->delete();;
                } else {
                    $inv  =  Invoice::create($data);
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
                    $newProduct->type = 1;
                    $newProduct->save();
                }

                Cache::forget("$customerId-invProducts");
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
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        $invoice =  Invoice::with(['billProducts' => function ($q) {
            $q->type(1);
        }, 'customer' => function ($q) {
            $q->with('currencySymbol:name,code,symbol');
        }, 'bank'])->find($id)->toArray();

     //  dd($invoice);

        $paidAmt =  InvoicePayments::where('order_id', $id)->sum('amount');
        $status = 'Pending';

        if ($invoice['status'] == 0) {
            $status =  'Pending';
        } elseif ($invoice['status'] == 1) {
            $status =    'Paid';
        } else {
            $status =  'Partial';
        }

        $svg = view('admin.invoice.payments.signimg')->render();
        $sign = '<img src="https://soft.rajeshwariinternational.in/sign.png"  width="250"  />';

        // dd($invoice);

        // dd( storage_path('fonts/pdf-fonts.ttf'));
        return view('admin.invoice.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData(), 'status' => $status, 'paidAmt' => $paidAmt, 'sign' => $sign]);


        $pdf = Pdf::loadView('admin.invoice.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData(), 'status' => $status, 'paidAmt' => $paidAmt, 'sign' => $sign]);
        return $pdf->stream('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $invoice =  Invoice::with(['billProducts' => function ($q) {
            $q->type(1);
        }])->find($id);
        Session::put('invSelectedCustomer', $invoice->customerId);
        $customerId = Session::get('invSelectedCustomer');

        if (Cache::has("$customerId-invProducts")) {
            Cache::delete("$customerId-invProducts");
        }

        if (isset($invoice->billProducts) && count($invoice->billProducts) > 0) {
            foreach ($invoice->billProducts as $product) {
                $subTot = $product->taxableAmount * $product->quantity;
                if (Cache::has("$customerId-invProducts")) {
                    $customerProducts = Cache::get("$customerId-invProducts");
                    $customerProducts->put($product->productId, ['productId' => $product->productId, 'productName' => $product->productName, 'productPrice' => $product->taxableAmount, 'qty' => $product->quantity, 'unit' => $product->qtyUnit, 'notes' => $product->productNotes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgstRate, 'sgst' => $product->sgstRate, 'igst' => $product->igstRate, 'subTot' => ($product->taxableAmount * $product->quantity), 'cGstVal' => (($subTot * $product->cgstRate) / 100), 'sGstVal' => (($subTot * $product->sgstRate) / 100), 'iGstVal' => (($subTot * $product->igstRate) / 100)]);
                    Cache::put("$customerId-invProducts", $customerProducts, 6000);
                } else {
                    $customerProducts = collect();
                    $customerProducts->put($product->productId, ['productId' => $product->productId, 'productName' => $product->productName, 'productPrice' => $product->taxableAmount, 'qty' => $product->quantity, 'unit' => $product->qtyUnit, 'notes' => $product->productNotes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgstRate, 'sgst' => $product->sgstRate, 'igst' => $product->igstRate, 'subTot' => ($product->taxableAmount * $product->quantity), 'cGstVal' => (($subTot * $product->cgstRate) / 100), 'sGstVal' => (($subTot * $product->sgstRate) / 100), 'iGstVal' => (($subTot * $product->igstRate) / 100)]);
                    Cache::put("$customerId-invProducts", $customerProducts, 6000);
                }
            }
        }

        // dd(Cache::get("$customerId-invProducts"));

        // $editInvoice = Invoice::with('billProducts')->find($id);
        return view('admin.invoice.create', ['invoice' => $invoice]);
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

    public function showInv($id)
    {
        $invoice =  Invoice::with(['billProducts' => function ($q) {
            $q->type(1);
        }])->find($id);

        if (!isset($invoice))
            return back();



        Session::put('invSelectedCustomer', $invoice->customerId);
        $customerId = Session::get('invSelectedCustomer');

        if (Cache::has("$customerId-invProducts")) {
            Cache::delete("$customerId-invProducts");
        }

        if (isset($invoice->billProducts) && count($invoice->billProducts) > 0) {
            foreach ($invoice->billProducts as $product) {
                $subTot = $product->taxableAmount * $product->quantity;
                if (Cache::has("$customerId-invProducts")) {
                    $customerProducts = Cache::get("$customerId-invProducts");
                    $customerProducts->put($product->productId, ['productId' => $product->productId, 'productName' => $product->productName, 'productPrice' => $product->taxableAmount, 'qty' => $product->quantity, 'unit' => $product->qtyUnit, 'notes' => $product->productNotes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgstRate, 'sgst' => $product->sgstRate, 'igst' => $product->igstRate, 'subTot' => ($product->taxableAmount * $product->quantity), 'cGstVal' => (($subTot * $product->cgstRate) / 100), 'sGstVal' => (($subTot * $product->sgstRate) / 100), 'iGstVal' => (($subTot * $product->igstRate) / 100)]);
                    Cache::put("$customerId-invProducts", $customerProducts, 6000);
                } else {
                    $customerProducts = collect();
                    $customerProducts->put($product->productId, ['productId' => $product->productId, 'productName' => $product->productName, 'productPrice' => $product->taxableAmount, 'qty' => $product->quantity, 'unit' => $product->qtyUnit, 'notes' => $product->productNotes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgstRate, 'sgst' => $product->sgstRate, 'igst' => $product->igstRate, 'subTot' => ($product->taxableAmount * $product->quantity), 'cGstVal' => (($subTot * $product->cgstRate) / 100), 'sGstVal' => (($subTot * $product->sgstRate) / 100), 'iGstVal' => (($subTot * $product->igstRate) / 100)]);
                    Cache::put("$customerId-invProducts", $customerProducts, 6000);
                }
            }
        }

        return view('admin.invoice.create', ['invoice' => $invoice]);
    }


    public function generateEwayBill($invId)
    {

        if (!is_numeric($invId) || $invId <= 0) {
            return back();
        }

        $invoice =  Invoice::with('billProducts', 'customer')->find($invId);

        $docdate  = date('d/m/Y', strtotime($invoice->docDate));
        $products = [];
        $setting = settingData();

        $cgstvalue = 0;
        $sgstvalue = 0;
        $igstvalue = 0;
        foreach ($invoice->billProducts as $product) {
            $subTot = $product->taxableAmount * $product->quantity;
            if ($setting->fromStateCode == $invoice->toStateCode) {
                $cgstrate =  $product->cgstRate;
                $sgstrate =  $product->sgstRate;
                $igstrate =  0;
                $cgst = (($subTot * $product->cgstRate) / 100);
                $sgst = (($subTot * $product->sgstRate) / 100);
                $igst = 0;
            } else {
                $cgstrate =  0;
                $sgstrate =  0;
                $igstrate =  $product->igstRate;
                $cgst = 0;
                $sgst = 0;
                $igst = (($subTot * $product->igstRate) / 100);
            }


            $taxamt = $subTot;
            $cgstvalue = $cgstvalue + $cgst;
            $sgstvalue = $sgstvalue + $sgst;
            $igstvalue = $igstvalue + $igst;
            $products[] = [
                "productName" => "$product->productName",
                "productDesc" => "$product->productName",
                "hsnCode" => $product->hsnCode,
                "quantity" => $product->quantity,
                "qtyUnit" => "$product->qtyUnit",
                "cgstRate" => $cgstrate,
                "sgstRate" => $sgstrate,
                "igstRate" => $igstrate,
                "cessRate" => $product->cessRate,
                "cessAdvol" => $product->cessNonadvol,
                "taxableAmount" => $taxamt
            ];
        }

        $postdata = [
            "supplyType" => "$invoice->supplyType",
            "subSupplyType" => "$invoice->subSupplyType",
            "subSupplyDesc" => "$invoice->subSupplyDesc",
            "docType" => "$invoice->docType",
            "docNo" => "$invoice->docNo",
            "docDate" => "$docdate",
            "fromGstin" => $invoice->fromGstin,
            "fromTrdName" => "$invoice->fromTrdName",
            "fromAddr1" => "$invoice->fromAddr1",
            "fromAddr2" => "$invoice->fromAddr2",
            "fromPlace" => "$invoice->fromPlace",
            "fromPincode" => $invoice->fromPincode,
            "actFromStateCode" => $invoice->actFromStateCode,
            "fromStateCode" => $invoice->fromStateCode,
            "toGstin" => $invoice->toGstin,
            "toTrdName" => "$invoice->toTrdName",
            "toAddr1" => "$invoice->toAddr1",
            "toAddr2" => "$invoice->toAddr2",
            "toPlace" => "$invoice->toPlace",
            "toPincode" => $invoice->toPincode,
            "actToStateCode" => $invoice->actToStateCode,
            "toStateCode" => $invoice->toStateCode,
            "totalValue" => $invoice->totalValue,
            "cgstValue" => $cgstvalue,
            "sgstValue" => $sgstvalue,
            "igstValue" => $igstvalue,
            "cessValue" => $invoice->cessValue,
            "totInvValue" => $invoice->totalValue + $cgstvalue + $sgstvalue + $igstvalue,
            "transporterId" => "$invoice->transporterId",
            "transporterName" => "$invoice->transporterName",
            "transDocNo" => "$invoice->transDocNo",
            "transMode" => "$invoice->transMode",
            "transDistance" => "$invoice->transDistance",
            "transDocDate" => "$invoice->transDocDate",
            "vehicleNo" => "$invoice->vehicleNo",
            "vehicleType" => "$invoice->vehicleType",
            "transactionType" => "$invoice->transactionType",
            "itemList" => $products

        ];


        //  
        $postfields = json_encode($postdata);
        //  dd(json_encode($postfields));
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gstapi.digital18.in/ewb/v1EWBGen.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array(
                //    'aspid : 191920',
                //    'clientid : 1991',
                //    'ewbuser : 05AAACG2115R1ZN',
                //    'ewbpwd : abc123@@',
                //    'gstin : 05AAACG2115R1ZN',
                //    'ttype : test',
                'aspid: 51362911',
                'clientid: rajeshwariinternational',
                'ewbuser: karanjagan_API_rji',
                'ewbpwd: Rji@2411',
                'gstin: 24AUTPJ3310R1Z6',
                'ttype: live',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $jsonResponse = json_decode($response);

        if ($jsonResponse->success) {
            $invoice->ewayBillNo = $jsonResponse->result->ewayBillNo;
            $invoice->ewayBillDate = $jsonResponse->result->ewayBillDate;
            $invoice->validUpto = $jsonResponse->result->validUpto;
            $invoice->alert = $jsonResponse->result->alert;
            $invoice->update();

            Session::flash('message', "$jsonResponse->message for ewayBillNo {$jsonResponse->result->ewayBillNo}");
        } else {
            Session::flash('message', "$jsonResponse->message");
        }

        curl_close($curl);

        Session::flash('status', $jsonResponse->success ? 'success' : 'error');
        return redirect()->route('invoice.index');
    }

    public function downloadEwayBill($ewayBillNo)
    {

        $ewayBillNo = $ewayBillNo;
        $filename = $ewayBillNo . ".pdf";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://gstapi.digital18.in/ewbpdf/e/getPDFEINV.php?1=' . time(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'aspid: 51362911',
                'clientid: rajeshwariinternational',
                'ewbuser: karanjagan_API_rji',
                'ewbpwd: Rji@2411',
                'gstin: 24AUTPJ3310R1Z6',
                'ttype: live',
                'data: ' . $ewayBillNo,
                'Content-Type: application/pdf'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if (File::exists(public_path('ewaybill/$filename'))) {
            File::delete(public_path('ewaybill/$filename'));
        }
        file_put_contents("ewaybill/$filename", $response);

        return redirect()->to("https://soft.rajeshwariinternational.in/ewaybill/$filename");
    }

    public function exportInvoices()
    {
        return Excel::download(new TaxInvoiceExport, 'invoices.xlsx');
    }

    public function getTransporterDeatil(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'from_gst' => 'required|min:15|max:15',
            'transporterId' => 'required|min:15|max:15',
        ]);

        if ($validator->fails())
            return comJsRes(true, $validator->messages()->first());

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://gstapi.digital18.in/ewb/v1GSTSearch.php?1=' . time(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'aspid: 51362911',
                    'clientid: rajeshwariinternational',
                    "FGSTIN:$request->from_gst",
                    "SGSTIN:$request->transporterId",
                ),
            ));

            $response = curl_exec($curl);
            $jsonResponse = json_decode($response);
            // dd($jsonResponse->success);
            curl_close($curl);

            if (!$jsonResponse->success)
                return comJsRes(true, $jsonResponse->message);

        } catch (Exception $e) {
            return comJsRes(true, $e->getMessage());
        }

        return comJsRes(false, 'Transporter Data Fetched Successfully', $jsonResponse->result);
    }

    public function getDistanceFromPincodes(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'from_pincode' => 'required|min:6|max:6',
            'customerId' => 'required|numeric'
        ]);

        if ($validator->fails())
            return comJsRes(true, $validator->messages()->first());

        try {
            $curl = curl_init();
            $customer =   Customer::find($request->customerId);

            if (empty($customer))
                return comJsRes(true, 'Customer Not Exists');

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://gstapi.digital18.in/ewb/v1P2PDist.php?1=" . time(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'aspid: 51362911',
                    'clientid: rajeshwariinternational',
                    'ttype:live',
                    "CLIENTGSTIN:$customer->toGstin",
                    "P1:$request->from_pincode",
                    "P2:$customer->toPincode",
                ),
            ));

            $response = curl_exec($curl);
            $jsonResponse = json_decode($response);
        // dd($jsonResponse);
            if (!$jsonResponse->success)
                return comJsRes(true, $jsonResponse->message);

            curl_close($curl);
        } catch (Exception $e) {
            return comJsRes(true, $e->getMessage());
        }

        return comJsRes(false, 'Transporter Data Fetched Successfully', $jsonResponse->result);
    }
}
