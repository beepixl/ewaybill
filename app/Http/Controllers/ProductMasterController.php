<?php

namespace App\Http\Controllers;

use App\Models\ProductMaster;
use Exception;
use Illuminate\Http\Request;

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

        return response()->json(['error' => false, 'message' =>'NULL', 'data' => NULL]);
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
}
