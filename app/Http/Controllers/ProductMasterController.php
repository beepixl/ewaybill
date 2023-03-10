<?php

namespace App\Http\Controllers;

use App\Models\ProductMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product-master.list', ['productMaster' => ProductMaster::class]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product-master.create');
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
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $search)
    {
        if ($request->term) {
            try {
                return response()->json(['error' => false, 'message' => 'Data Fetched', 'data' => ProductMaster::where('productName', 'like', '%' . $request->term . '%')->toBase()->get(['id', 'productName as text'])]);
            } catch (Exception $e) {
                return response()->json(['error' => false, 'message' => $e->getMessage(), 'data' => NULL]);
            }
        }

        return response()->json(['error' => false, 'message' => 'NULL', 'data' => NULL]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.product-master.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductMaster $productMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductMaster $productMaster)
    {
        //
    }

    public function productDetail(Request $request)
    {

        if ($request->ajax()) {
            $product =  ProductMaster::find($request->productId);

            if (!Session::has('invSelectedCustomer')) {
                return response()->json(['error' => true, 'message' => 'Please Select Customer', 'data' => NULL]);
            }

            if ($product)
                return response()->json(['error' => false, 'message' => 'Data Fetched', 'data' => $product]);
            else
                return response()->json(['error' => true, 'message' => 'No Product', 'data' => NULL]);
        }
    }

    public function addItem(Request $request)
    {

        if ($request->ajax()) {
            $product =  ProductMaster::find($request->productId);
            $customerId = Session::get('invSelectedCustomer');

            if (!Session::has('invSelectedCustomer')) {
                return comJsRes(true, 'Please Select Customer');
            }

            $validator = Validator::make($request->all(), [
                'productId' => 'required|numeric',
                'qty' => 'required|numeric',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails())
                return comJsRes(true, $validator->messages()->first());

            $subTot = $request->price * $request->qty;

            $products = collect();

            if ($request->type == 'performa') {
                if (Cache::has("$customerId-pInvProducts")) {
                    $customerProducts = Cache::get("$customerId-pInvProducts");
                    $customerProducts->put($request->productId, ['productId' => $request->productId, 'productName' => $product->productName, 'productPrice' => $request->price, 'qty' => $request->qty, 'unit' => $request->unit, 'notes' => $request->notes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgst, 'sgst' => $product->sgst, 'igst' => $product->igst, 'subTot' => $subTot, 'sGstVal' => (($subTot * $product->sgst) / 100), 'cGstVal' => (($subTot * $product->cgst) / 100), 'iGstVal' => (($subTot * $product->igst) / 100)]);
                    Cache::put("$customerId-pInvProducts", $customerProducts, 6000);
                } else {
                    $customerProducts = collect();
                    $customerProducts->put($request->productId, ['productId' => $request->productId, 'productName' => $product->productName, 'productPrice' => $request->price, 'qty' => $request->qty, 'unit' => $request->unit, 'notes' => $request->notes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgst, 'sgst' => $product->sgst, 'igst' => $product->igst, 'subTot' => $subTot, 'sGstVal' => (($subTot * $product->sgst) / 100), 'cGstVal' => (($subTot * $product->cgst) / 100), 'iGstVal' => (($subTot * $product->igst) / 100)]);
                    Cache::put("$customerId-pInvProducts", $customerProducts, 6000);
                }

                if (Cache::has("$customerId-pInvProducts")) {
                    $products = Cache::get("$customerId-pInvProducts");
                }
            } else {
                if (Cache::has("$customerId-invProducts")) {
                    $customerProducts = Cache::get("$customerId-invProducts");
                    $customerProducts->put($request->productId, ['productId' => $request->productId, 'productName' => $product->productName, 'productPrice' => $request->price, 'qty' => $request->qty, 'unit' => $request->unit, 'notes' => $request->notes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgst, 'sgst' => $product->sgst, 'igst' => $product->igst, 'subTot' => $subTot, 'sGstVal' => (($subTot * $product->sgst) / 100), 'cGstVal' => (($subTot * $product->cgst) / 100), 'iGstVal' => (($subTot * $product->igst) / 100)]);
                    Cache::put("$customerId-invProducts", $customerProducts, 6000);
                } else {
                    $customerProducts = collect();
                    $customerProducts->put($request->productId, ['productId' => $request->productId, 'productName' => $product->productName, 'productPrice' => $request->price, 'qty' => $request->qty, 'unit' => $request->unit, 'notes' => $request->notes, 'hsnCode' => $product->hsnCode, 'cgst' => $product->cgst, 'sgst' => $product->sgst, 'igst' => $product->igst, 'subTot' => $subTot, 'sGstVal' => (($subTot * $product->sgst) / 100), 'cGstVal' => (($subTot * $product->cgst) / 100), 'iGstVal' => (($subTot * $product->igst) / 100)]);
                    Cache::put("$customerId-invProducts", $customerProducts, 6000);
                }

                if (Cache::has("$customerId-invProducts")) {
                    $products = Cache::get("$customerId-invProducts");
                }
            }

            $data = view('livewire.invoice-temp-product', ['products' => $products->all()])->render();
            //  return response()->json(['error' => false, 'message' => 'Item Added', 'data' => $data]);
            return comJsRes(false, 'Item Added Successfully', $data);
        }
    }

    public function removeItem(Request $request)
    {
  
        if ($request->ajax()) {
            if (!Session::has('invSelectedCustomer')) {
                return comJsRes(true, 'Please Select Customer');
            }

            $validator = Validator::make($request->all(), [
                'productId' => 'required|numeric',
            ]);

            if ($validator->fails())
                return comJsRes(true, $validator->messages()->first());

            $customerId = Session::get('invSelectedCustomer');
            $products = collect();
           
            if ($request->type == 'performa') {
                if (Cache::has("$customerId-pInvProducts")) {
                    $customerProducts = Cache::get("$customerId-pInvProducts");
                    $customerProducts->forget($request->productId);
                    Cache::put("$customerId-pInvProducts", $customerProducts, 6000);
                }
                if (Cache::has("$customerId-pInvProducts")) {
                    $products = Cache::get("$customerId-pInvProducts");
                }
            } else {
                if (Cache::has("$customerId-invProducts")) {
                    $customerProducts = Cache::get("$customerId-invProducts");
                    $customerProducts->forget($request->productId);
                    Cache::put("$customerId-invProducts", $customerProducts, 6000);
                }
                if (Cache::has("$customerId-invProducts")) {
                    $products = Cache::get("$customerId-invProducts");
                }
            }

           // dd($products);

            $data = view('livewire.invoice-temp-product', ['products' => $products->all()])->render();

            return comJsRes(false, 'Item Removed Successfully', $data);
        }
    }

    public function reloadProductsTbl(Request $request)
    {

        $customerId = Session::get('invSelectedCustomer');
        $products = collect();

        if ($request->type == 'performa') {
            if (Cache::has("$customerId-pInvProducts")) {
                $products = Cache::get("$customerId-pInvProducts");
            }
        } else {
            // dd($customerId);
            if (Cache::has("$customerId-invProducts")) {
                $products = Cache::get("$customerId-invProducts");
            }
        }

        $data = view('livewire.invoice-temp-product', ['products' => $products->all()])->render();
        //  return response()->json(['error' => false, 'message' => 'Item Added', 'data' => $data]);
        return comJsRes(false, 'Products Refreshed Successfully', $data);
    }
}
