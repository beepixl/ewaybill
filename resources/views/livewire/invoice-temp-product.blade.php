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
                                    <th> Action</th>
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
                                            <td><input type="number" @if (!isset($show)) onfocusout="updateTbl(this)" @endif
                                                    productId="{{ $product['productId'] }}"
                                                    productPrice="{{ $product['productPrice'] }}"
                                                    productNote="{{ nl2br($product['notes']) }}"
                                                    productUnit="{{ $product['unit'] }}" class="form-control"
                                                    value="{{ $product['qty'] }}" id=""></td>
                                            <td>{{ $product['unit'] }}</td>
                                            <td>{!! nl2br($product['notes']) !!}</td>
                                            <td>{{ $product['hsnCode'] ?? '' }}</td>
                                            <td>{{ number_format($subTot, 2) }}</td>
                                            <td>
                                                @if (!isset($show))
                                                    <button type="button"
                                                        onclick="removeItem({{ $product['productId'] }})"
                                                        class="inline-flex items-center px-2 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                                        <i class="fas fa-trash" aria-hidden="true"></i></button>
                                                @endif
                                            </td>
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
                                        <td colspan="1" class="font-bold">₹
                                            {{ number_format($fTot + $cGstVal + $sGstVal, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                        @if (!isset($show))
                            <div class="form-group col-span-2 sm:col-span-2">
                                <button type="button" onclick="submitInvForm();"
                                    class="inline-flex items-center px-2 py-2 bg-green-500 border border-transparent  rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-check" aria-hidden="true"></i> Create Invoice</button>

                                <button type="button" onclick="submitInvForm('print');"
                                    class="inline-flex items-center px-2 py-2 bg-yellow-500 border border-transparent  rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-print" aria-hidden="true"></i> Create & Print Invoice</button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
