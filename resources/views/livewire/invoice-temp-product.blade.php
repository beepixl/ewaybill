<div class="productsPage">
    <div class="md:grid md:grid-cols-2">
        <div class=" md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 bg-white sm:p-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-sm text-gray-600">
                                <thead>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Notes</th>
                                    <th>Hsn Code</th>
                                    <th>Sub Tot</th>
                                </thead>
                                <tbody>

                                    @php
                                        $fTot = 0;
                                        $cGstVal = 0;
                                        $sGstVal = 0;
                                    @endphp

                                    @foreach ($products as $product)
                                        @php
                                            $subTot = $product['productPrice'] * $product['qty'];
                                            $fTot += $subTot;
                                            
                                            $cGstVal += ($subTot * $product['cgst']) / 100;
                                            $sGstVal += ($subTot * $product['sgst']) / 100;
                                            // $fTot += $subTot+$cGstVal+$sGstVal;
                                        @endphp

                                        <tr>
                                            <td>{{ $product['productName'] }}</td>
                                            <td>{{ $product['productPrice'] }}</td>
                                            <td><input type="number" name="productQty" onfocusout="updateTbl(this)"
                                                    productId="{{ $product['productId'] }}"
                                                    productPrice="{{ $product['productPrice'] }}"
                                                    productNote="{{ $product['notes'] }}"
                                                    productUnit="{{ $product['unit'] }}" class="form-control"
                                                    value="{{ $product['qty'] }}" id=""></td>
                                            <td>{{ $product['unit'] }}</td>
                                            <td>{{ $product['notes'] }}</td>
                                            <td>{{ $cGstVal ?? '' }}</td>
                                            <td>{{ number_format($subTot, 2) }}</td>
                                        </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="1" class="font-bold">CGST %</td>
                                        <td colspan="1" class="font-bold">₹ {{ number_format($cGstVal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="1" class="font-bold">SGST %</td>
                                        <td colspan="1" class="font-bold">₹ {{ number_format($sGstVal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="1" class="font-bold">Final Total</td>
                                        <td colspan="1" class="font-bold">₹ {{ $fTot + $cGstVal + $sGstVal }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="1" class="font-bold"></td>
                                        <td colspan="1" class="font-bold">
                                            <button type="submit" class="inline-flex items-center px-2 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                                <i class="fas fa-check" aria-hidden="true"></i>Create Invoice</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
