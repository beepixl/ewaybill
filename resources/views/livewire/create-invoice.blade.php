<div id="form-create">
    <div class="md:grid md:grid-cols-2" id="invSection">
        <div class=" md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 bg-white sm:p-6">
                    <div class="col-auto md:grid grid-cols-4 gap-2">

                        @isset($invoice)
                            <input type="hidden" name="type" value="update">
                            <input type="hidden" name="invId" value="{{ $invoice->id }}">
                        @endisset

                        <div class="form-group" wire:ignore>
                            <x-jet-label for="name" value="{{ __('Select Customer') }}" />
                            <select @if (!isset($show)) name="customerId" @endif id=""
                                class="mt-1 block w-full form-control shadow-none select2">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer['id'] }}"
                                        @isset($invoice) {{ $invoice->customerId == $customer['id'] ? 'selected' : '' }}  @endisset>
                                        {{ $customer['toTrdName'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="invNo" value="{{ __('Invoice No') }}" />
                            <input type="number" name="invNo" class="mt-1 block w-full form-control shadow-none"
                                readonly
                                @isset($invoice) value="{{ $invoice->invNo }}" @else value="{{ $invNo }}" @endif id="invNo">
                        </div>

                        <div class="form-group">
                            <x-jet-label for="name" value="{{ __('Invoice Date') }}" />
                            <input type="date" name="invDate" class="mt-1 block w-full form-control shadow-none"
                            @isset($invoice) value="{{ $invoice->invDate }}" @else value="{{ date('Y-m-d') }}" @endisset
                                id="invDate">
                        </div>

                        <div class="form-group">
                            <x-jet-label for="supplyType" value="{{ __('Select Supply Type') }}" />
                            <select name="supplyType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Supply Type</option>
                                <option value="I"
                                    @isset($invoice) {{ $invoice->supplyType == 'I' ? 'selected' : '' }}  @endisset>
                                    Inward</option>
                                <option value="O"
                                    @isset($invoice)  {{ $invoice->supplyType == 'O' ? 'selected' : '' }} @endisset>
                                    Outward</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="bankId" value="{{ __('Select Bank') }}" />
                            <select name="bankId" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Bank</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank['id'] }}" @isset($invoice) {{ $invoice->bankId == $bank['id'] ? 'selected' : '' }}  @endisset>{{ $bank['account_name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="subSupplyType" value="{{ __('Select Sub Supply Type') }}" />
                            <select name="subSupplyType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Sub Supply Type</option>
                                <option value="1"
                                    @isset($invoice) {{ $invoice->subSupplyType == 1 ? 'selected' : '' }}  @endisset>
                                    Supply</option>
                                <option value="2"
                                    @isset($invoice) {{ $invoice->subSupplyType == 2 ? 'selected' : '' }}  @endisset>
                                    Import</option>
                                <option value="3"
                                    @isset($invoice) {{ $invoice->subSupplyType == 3 ? 'selected' : '' }}  @endisset>
                                    Export</option>
                                <option value="4"
                                    @isset($invoice) {{ $invoice->subSupplyType == 4 ? 'selected' : '' }}  @endisset>
                                    Job Work</option>
                                <option value="5"
                                    @isset($invoice) {{ $invoice->subSupplyType == 5 ? 'selected' : '' }}  @endisset>
                                    For Own Use</option>
                                <option value="6"
                                    @isset($invoice) {{ $invoice->subSupplyType == 6 ? 'selected' : '' }}  @endisset>
                                    Job work Returns</option>
                                <option value="7"
                                    @isset($invoice) {{ $invoice->subSupplyType == 7 ? 'selected' : '' }}  @endisset>
                                    Sales Return</option>
                                <option value="8"
                                    @isset($invoice) {{ $invoice->subSupplyType == 8 ? 'selected' : '' }}  @endisset>
                                    Others</option>
                                <option value="9"
                                    @isset($invoice) {{ $invoice->subSupplyType == 9 ? 'selected' : '' }}  @endisset>
                                    SKD/CKD/Lots</option>
                                <option value="10"
                                    @isset($invoice) {{ $invoice->subSupplyType == 10 ? 'selected' : '' }}  @endisset>
                                    Line Sales</option>
                                <option value="11"
                                    @isset($invoice) {{ $invoice->subSupplyType == 11 ? 'selected' : '' }}  @endisset>
                                    Recipient Not Known</option>
                                <option value="12"
                                    @isset($invoice) {{ $invoice->subSupplyType == 12 ? 'selected' : '' }}  @endisset>
                                    Exhibition or Fairs</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="subSupplyDesc" value="{{ __('Sub Supply Desc') }}" />
                            <textarea name="subSupplyDesc" id=""
                                class="mt-1 block w-full form-control shadow-none"cols="5"rows="1">
@isset($invoice)
{{ $invoice->subSupplyDesc }}
@endisset
</textarea>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="docType" value="{{ __('Select Document Type') }}" />
                            <select name="docType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Document Type</option>
                                <option value="INV"
                                    @isset($invoice) {{ $invoice->docType == 'INV' ? 'selected' : '' }}  @endisset>
                                    Tax Invoice</option>
                                <option value="BIL"
                                    @isset($invoice) {{ $invoice->docType == 'BIL' ? 'selected' : '' }}  @endisset>
                                    Bill of Supply</option>
                                <option value="BOE"
                                    @isset($invoice) {{ $invoice->docType == 'BOE' ? 'selected' : '' }}  @endisset>
                                    Bill of Entry</option>
                                <option value="CHL"
                                    @isset($invoice) {{ $invoice->docType == 'CHL' ? 'selected' : '' }}  @endisset>
                                    Delivery Challan</option>
                                <option value="OTH"
                                    @isset($invoice) {{ $invoice->docType == 'OTH' ? 'selected' : '' }}  @endisset>
                                    Others</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="docNo" value="{{ __('Document No') }}" />
                            <input type="text" class="mt-1 block w-full form-control shadow-none"
                                @isset($invoice) value="{{ $invoice->docNo }}"  @endisset
                                name="docNo" />
                        </div>

                        <div class="form-group">
                            <x-jet-label for="docDate" value="{{ __('Document Date') }}" />
                            <input type="date" class="mt-1 block w-full form-control shadow-none"
                                @isset($invoice) value="{{ $invoice->docDate }}"  @else value="{{ date('Y-m-d') }}"  @endisset
                                name="docDate" />
                        </div>

                        <div class="form-group">
                            <x-jet-label for="transMode" value="{{ __('Select Transportation Type') }}" />
                            <select name="transMode" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Transportation Mode</option>
                                <option value="1"
                                    @isset($invoice) {{ $invoice->transMode == 1 ? 'selected' : '' }}  @endisset>
                                    Road</option>
                                <option value="2"
                                    @isset($invoice) {{ $invoice->transMode == 2 ? 'selected' : '' }}  @endisset>
                                    Rail</option>
                                <option value="3"
                                    @isset($invoice) {{ $invoice->transMode == 3 ? 'selected' : '' }}  @endisset>
                                    Air</option>
                                <option value="4"
                                    @isset($invoice) {{ $invoice->transMode == 4 ? 'selected' : '' }}  @endisset>
                                    Ship</option>
                                <option value="5"
                                    @isset($invoice) {{ $invoice->transMode == 5 ? 'selected' : '' }}  @endisset>
                                    inTransit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="transactionType" value="{{ __('Select Transaction Type') }}" />
                            <select name="transactionType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Transaction Type</option>
                                <option value="1"
                                    @isset($invoice) {{ $invoice->transactionType == 1 ? 'selected' : '' }}  @endisset>
                                    Regular</option>
                                <option value="2"
                                    @isset($invoice) {{ $invoice->transactionType == 2 ? 'selected' : '' }}  @endisset>
                                    Bill To - Ship To</option>
                                <option value="3"
                                    @isset($invoice) {{ $invoice->transactionType == 3 ? 'selected' : '' }}  @endisset>
                                    Bill From - Dispatch From</option>
                                <option value="4"
                                    @isset($invoice) {{ $invoice->transactionType == 4 ? 'selected' : '' }}  @endisset>
                                    Combination of 2 and 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="vehicleNo" value="{{ __('Vehicle No') }}" />
                            <input type="text" class="mt-1 block w-full form-control shadow-none"
                                @isset($invoice) value="{{ $invoice->vehicleNo }}"  @endisset
                                name="vehicleNo" />
                        </div>

                        <div class="form-group">
                            <x-jet-label for="vehicleType" value="{{ __('Select Vehicle Type') }}" />
                            <select name="vehicleType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Vehicle Type</option>
                                <option value="R"
                                    @isset($invoice) {{ $invoice->vehicleType == 'R' ? 'selected' : '' }}  @endisset>
                                    Regular</option>
                                <option value="O"
                                    @isset($invoice) {{ $invoice->vehicleType == 'O' ? 'selected' : '' }}  @endisset>
                                    ODC(Over Dimentional Cargo)</option>
                            </select>
                        </div>

                        @isset($invoice->ewayBillNo)
                            <div class="form-group">
                                &nbsp
                                <pre> EWayBill No: <br> <strong>{{ $invoice->ewayBillNo }}</strong></pre>
                            </div>
                        @endisset

                        @isset($invoice->ewayBillDate)
                            <div class="form-group">
                                &nbsp
                                <pre> EWayBill Date: <br> <strong>{{ $invoice->ewayBillDate }}</strong></pre>
                            </div>
                        @endisset

                        @isset($invoice->validUpto)
                            <div class="form-group">
                                &nbsp
                                <pre> EWayBill Valid Upto: <br> <strong>{{ $invoice->validUpto }}</strong></pre>
                            </div>
                        @endisset

                        @isset($invoice->alert)
                            <div class="form-group cols-6">
                                &nbsp
                                <pre> EWayBill Alert: <br> <strong>{{ $invoice->alert }}</strong></pre>
                            </div>
                        @endisset

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!isset($show))
        <x-jet-section-border></x-jet-section-border>

        <div class="md:grid md:grid-cols-2">
            <div class=" md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">

                    <div class="px-4 bg-white sm:p-6">
                        <div class="col-auto md:grid grid-cols-3 gap-2">

                            <div class="form-group  productDiv" wire:ignore>
                                <x-jet-label for="name" value="{{ __('Select Product') }}" />
                                <select id="productId" class="mt-1 block w-full form-control shadow-none select2">
                                    <option value="">Search Product</option>
                                </select>
                                <span class="help-text" id="productPrice"></span>
                                <input-error for="productId" class="mt-2" />
                            </div>

                            <div class="form-group md:col-1">
                                <x-jet-label for="price" value="{{ __('Price') }}" />
                                <input min="1" type="text" id="pPrice"
                                    class="mt-1 block w-full form-control shadow-none productPrice" />
                            </div>

                            <div class="form-group md:col-1">
                                <x-jet-label for="qty" value="{{ __('Quantity') }}" />
                                <input id="qty" value="1" min="1" type="number"
                                    class="mt-1 block w-full form-control shadow-none" />
                            </div>

                            <div class="form-group col-span-1 sm:col-span-1" wire:ignore>
                                <x-jet-label for="unit" value="{{ __('Unit') }}" />
                                <select id="unit" class="mt-1 block w-full form-control shadow-none select2">
                                    <option value="">Select Unit</option>
                                    <option value="BAG">Bag</option>
                                    <option value="BDL">Bundles</option>
                                    <option value="BAL">Bale</option>
                                    <option value="BKL">Buckles</option>
                                    <option value="BOU">Billions Of Units</option>
                                    <option value="BOX">Box</option>
                                    <option value="BTL">Bottles</option>
                                    <option value="BUN">Bunches</option>
                                    <option value="CAN">Cans</option>
                                    <option value="CTN">Cartons</option>
                                    <option value="DOZ">Dozen</option>
                                    <option value="DRM">Drum</option>
                                    <option value="GGR">Great Gross</option>
                                    <option value="GRS">Gross</option>
                                    <option value="NOS">Numbers</option>
                                    <option value="PAC">Packs</option>
                                    <option value="PCS">Pieces</option>
                                    <option value="PRS">Pairs</option>
                                    <option value="ROL">Rolls</option>
                                    <option value="SET">Sets</option>
                                    <option value="TBS">Tablets</option>
                                    <option value="TGM">Ten Gross</option>
                                    <option value="THD">Thousands</option>
                                    <option value="TUB">Tubes</option>
                                    <option value="UNT">Units</option>
                                    <option value="CBM">Cubic Meter</option>
                                    <option value="CCM">Cubic Centimeter</option>
                                    <option value="KLR">Kilo Liter</option>
                                    <option value="MLT">Milliliter</option>
                                    <option value="UGS">US Gallons</option>
                                    <option value="SQF">Square Feet</option>
                                    <option value="SQM">Square Meters</option>
                                    <option value="SQY">Square Yards</option>
                                    <option value="GYD">Gross Yards</option>
                                    <option value="KME">Kilo Meter</option>
                                    <option value="MTR">Meters</option>
                                    <option value="YDS">Yards</option>
                                    <option value="CMS">Centimeter</option>
                                    <option value="TON">Tonnes</option>
                                    <option value="QTL">Quintal</option>
                                    <option value="GMS">Grams</option>
                                    <option value="KGS">Kilo Grams</option>
                                    <option value="OTH">Others</option>


                                </select>
                            </div>

                            <div class="form-group col-span-1 sm:col-span-1">
                                <x-jet-label for="notes" value="{{ __('Notes') }}" />
                                <input id="notes" type="text"
                                    class="mt-1 block w-full form-control shadow-none" />
                            </div>

                            <div class="form-group col-span-2 sm:col-span-2">
                                <button type="button" id="addItemToCart"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-plus" aria-hidden="true"></i> Add To Order</button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <x-jet-section-border></x-jet-section-border>

    <x-jet-section-title>
        <x-slot name="title"> Products</x-slot>
    </x-jet-section-title>

    <livewire:invoice-temp-product />

    <x-jet-section-border></x-jet-section-border>


    <x-jet-section-title>
        <x-slot name="title"> Payments</x-slot>
    </x-jet-section-title>

    @if (Route::currentRouteName() == 'showInv')
        <livewire:table.invoice-payments-list name="invoicePayments" :model="$payments" :orderId="request()->invoice" />
    @endif

</div>
