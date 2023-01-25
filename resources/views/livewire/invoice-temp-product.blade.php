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
                                        <td>{{ $product['qty'] }}</td>
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
                                    <td colspan="1" class="font-bold">₹ {{ number_format($cGstVal,2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5"></td>
                                    <td colspan="1" class="font-bold">SGST %</td>
                                    <td colspan="1" class="font-bold">₹ {{ number_format($sGstVal,2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5"></td>
                                    <td colspan="1" class="font-bold">Final Total</td>
                                    <td colspan="1" class="font-bold">₹ {{ $fTot+$cGstVal+$sGstVal }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
