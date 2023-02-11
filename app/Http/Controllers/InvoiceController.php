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
            'invNo' => "required|unique:invoices" . $request->type == 'update' ? ',' . $request->invId : '',
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
                $data['invNo'] = settingData()->invPrefix.'/INV-'.settingData()->invNoStart  + Invoice::count();
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
                // $data['transMode'] = $customer->transMode;
                // $data['transDistance'] = $customer->transDistance;
                // $data['transporterName'] = $customer->transporterName;
                // $data['transDocNo'] = $customer->transDocNo;
                // $data['transporterId'] = $customer->transporterId;

   
                if (is_numeric($invId)) {
                    $inv  =  Invoice::find($invId);
                    $orgInv = $inv;
                    $inv->update($data);
                    Product::where([['invID',$invId],['type',1]])->delete();;
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
        }, 'customer'=>function($q){
            $q->with('currencySymbol:name,code,symbol');
        }, 'bank'])->find($id)->toArray();

     //   dd($invoice);

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
        $sign = '<img src="https://phplaravel-615318-3229789.cloudwaysapps.com/sign.png"  width="250"  />';

        // dd($invoice);

        // dd( storage_path('fonts/pdf-fonts.ttf'));
         return view('admin.invoice.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData(), 'status' => $status, 'paidAmt' => $paidAmt,'sign'=>$sign]);


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

        $invoice =  Invoice::with('billProducts','customer')->find($invId);
        
        $docdate  = date('d/m/Y',strtotime($invoice->docDate));
        $products = [];
        // dd($invoice->billProducts);
        foreach($invoice->billProducts as $product){
            $taxamt = $product->taxableAmount*$product->quantity + $product->cgstRate + $product->sgstRate + $product->sgstRate;
            $products[] = ["productName" => "$product->productName", 
            "productDesc" => "$product->productName", 
            "hsnCode" => $product->hsnCode, 
            "quantity" => $product->quantity, 
            "qtyUnit" => "$product->qtyUnit", 
            "cgstRate" => $product->cgstRate, 
            "sgstRate" => $product->sgstRate, 
            "igstRate" => $product->igstRate, 
            "cessRate" => $product->cessRate, 
            "cessAdvol" => $product->cessNonadvol, 
            "taxableAmount" => $taxamt ];
        }

        $postdata = [
          "supplyType" => "$invoice->supplyType", 
          "subSupplyType" => "$invoice->subSupplyType", 
          "subSupplyDesc" => "$invoice->subSupplyDesc", 
          "docType" => "$invoice->docType", 
          "docNo" => "$invoice->docNo", 
          "docDate" => "$docdate", 
          "fromGstin" => "05AAACG2115R1ZN", 
          "fromTrdName" => "$invoice->fromTrdName", 
          "fromAddr1" => "$invoice->fromAddr1", 
          "fromAddr2" => "$invoice->fromAddr2", 
          "fromPlace" => "$invoice->fromPlace", 
          "fromPincode" => $invoice->fromPincode, 
          "actFromStateCode" => $invoice->actFromStateCode, 
          "fromStateCode" => $invoice->fromStateCode, 
          "toGstin" => "05AAACG2140A1ZL", 
          "toTrdName" => "$invoice->toTrdName", 
          "toAddr1" => "$invoice->toAddr1", 
          "toAddr2" => "$invoice->toAddr2", 
          "toPlace" => "$invoice->toPlace", 
          "toPincode" => $invoice->toPincode, 
          "actToStateCode" => $invoice->actToStateCode, 
          "toStateCode" => $invoice->toStateCode, 
          "totalValue" => $invoice->totalValue, 
          "cgstValue" => $invoice->cgstValue, 
          "sgstValue" => $invoice->sgstValue, 
          "igstValue" => $invoice->igstValue, 
          "cessValue" => $invoice->cessValue, 
          "totInvValue" => $invoice->totInvValue, 
          "transporterId" => "$invoice->transporterId", 
          "transporterName" => "$invoice->transporterName", 
          "transDocNo" => "$invoice->transDocNo", 
          "transMode" => "$invoice->transMode", 
          "transDistance" => "$invoice->transDistance", 
          "transDocDate" => "$invoice->transDocDate", 
          "vehicleNo" => "$invoice->vehicleNo", 
          "vehicleType" => "$invoice->vehicleType", 
          "itemList" => $products
             
       ]; 
        
        
//  
  $postfields = json_encode($postdata);
  dd(json_encode($postfields));
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
               'aspid : 191920',
               'clientid : 1991',
               'ewbuser : 05AAACG2115R1ZN',
               'ewbpwd : abc123@@',
               'gstin : 05AAACG2115R1ZN',
               'ttype : test',
                // 'aspid: 51362911',
                // 'clientid: rajeshwariinternational',
                // 'ewbuser: karanjagan_API_rji',
                // 'ewbpwd: Rji@2411',
                // 'gstin: 24AUTPJ3310R1Z6',
                // 'ttype: live',
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

    public function exportInvoices()
    {
      

        return Excel::download(new TaxInvoiceExport, 'invoices.xlsx');
    }
}
