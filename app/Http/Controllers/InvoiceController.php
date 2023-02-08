<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayments;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;

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
                $data['invNo'] = settingData()->invNoStart  + Invoice::count();
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

                if (is_numeric($invId)) {
                    $inv  =  Invoice::find($invId);
                    $orgInv = $inv;
                    $inv->update($data);
                    Product::where('invID', $invId)->delete();;
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

        $invoice =  Invoice::with('billProducts', 'customer','bank')->find($id)->toArray();
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
        $sign = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '"  width="350"  />';

        // dd($invoice);

        // dd( storage_path('fonts/pdf-fonts.ttf'));
        // return view('admin.invoice.invoice-pdf', ['invoice' => $invoice, 'setting' => settingData(), 'status' => $status, 'paidAmt' => $paidAmt,'sign'=>$sign]);


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

        $invoice =  Invoice::with('billProducts')->find($id);
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
        $invoice =  Invoice::with('billProducts')->find($id);

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

        $invoice =  Invoice::find($invId);
        // dd($invoice);
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
            CURLOPT_POSTFIELDS => '{"supplyType":"' . $invoice->supplyType . '","subSupplyType":' . $invoice->subSupplyType . ',"subSupplyDesc":"' . $invoice->subSupplyDesc . '","docType":"INV","docNo":"INV/' . $invoice->docNo . '","docDate":"' . date('d/m/Y', strtotime($invoice->docDate)) . '","fromGstin":"05AAACG2115R1ZN","fromTrdName":"","fromAddr1":"","fromAddr2":"","fromPlace":"SURAT","fromPincode":395002,"actFromStateCode":24,"fromStateCode":24,"toGstin":"05AAACG2140A1ZL","toTrdName":"MAGHALAKSHMI PLAAZAA","toAddr1":"NO-716 NEHRUJI ROAD","toAddr2":"PIN CODE 605602","toPlace":"VILUPURAM","toPincode":605602,"actToStateCode":33,"toStateCode":33,"transactionType":"1","dispatchFromGSTIN":"","dispatchFromTradeName":"","shipToGSTIN":"","shipToTradeName":"","otherValue":0,"totalvalue":17029,"cgstValue":0,"sgstValue":0,"igstValue":810.8999999999999772626324556767940521240234375,"cessValue":0,"cessNonAdvolValue":0,"totInvValue":17839.9000000000014551915228366851806640625,"transporterId":"05AAACG2140A1ZL","transporterName":"LAXMI CARGO MOVERS PVT LTD","transDocNo":"","transMode":"","transDistance":1527,"transDocDate":"","vehicleNo":"","vehicleType":"R","itemList":[{"productName":"KAMALINE.","productDesc":"KAMALINE.","hsnCode":5407,"quantity":3,"qtyUnit":"NOS","cgstRate":0,"sgstRate":0,"igstRate":5,"cessRate":0,"cessAdvol":0,"taxableAmount":1980},{"productName":"KANCHAN.","productDesc":"KANCHAN.","hsnCode":5407,"quantity":20,"qtyUnit":"NOS","cgstRate":0,"sgstRate":0,"igstRate":5,"cessRate":0,"cessAdvol":0,"taxableAmount":13800},{"productName":"KATRINA.","productDesc":"KATRINA.","hsnCode":5407,"quantity":4,"qtyUnit":"NOS","cgstRate":0,"sgstRate":0,"igstRate":5,"cessRate":0,"cessAdvol":0,"taxableAmount":2640},{"productName":"KOSTUB SILK","productDesc":"KOSTUB SILK","hsnCode":5407,"quantity":1,"qtyUnit":"NOS","cgstRate":0,"sgstRate":0,"igstRate":5,"cessRate":0,"cessAdvol":0,"taxableAmount":660}]} ',
            CURLOPT_HTTPHEADER => array(
                'aspid: 191920',
                'clientid: 1991',
                'ewbuser: 05AAACG2115R1ZN',
                'ewbpwd: abc123@@',
                'gstin: 05AAACG2115R1ZN',
                'ttype: test',
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
}
