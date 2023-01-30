<div id="form-create">

    <div class="md:grid md:grid-cols-2" id="invSection">
        <div class=" md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 bg-white sm:p-6">
                    <div class="col-auto md:grid grid-cols-2 gap-2">
                        
                        <div class="form-group" wire:ignore>
                            <x-jet-label for="name" value="{{ __('Select Customer') }}" />
                            <select name="customerId" id=""
                                class="mt-1 block w-full form-control shadow-none select2">
                                <option value="">Select Customer</option>
                                @foreach (Cache::get('customers') as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ Session::has('invSelectedCustomer') ? (Session::get('invSelectedCustomer') == $customer->id ? 'selected' : 0) : 0 }}>
                                        {{ $customer->toTrdName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="name" value="{{ __('Invoice No') }}" />
                            <x-jet-input type="text" class="mt-1 block w-full form-control shadow-none" name="invNo" />
                        </div>

                        <div class="form-group">
                            <x-jet-label for="name" value="{{ __('Invoice Date') }}" />
                            <input type="date" name="invoice_date" class="mt-1 block w-full form-control shadow-none"
                                value="{{ date('Y-m-d') }}" id="invoice_date">
                        </div>

                        <div class="form-group">
                            <x-jet-label for="supplyType" value="{{ __('Select Supply Type') }}" />
                            <select name="supplyType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Supply Type</option>
                                <option value="I">Inward</option>
                                <option value="O">Outward</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="subSupplyType" value="{{ __('Select Sub Supply Type') }}" />
                            <select name="subSupplyType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Sub Supply Type</option>
                                <option value="1">Supply</option>
                                <option value="2">Import</option>
                                <option value="3">Export</option>
                                <option value="4">Job Work</option>
                                <option value="5">For Own Use</option>
                                <option value="6">Job work Returns</option>
                                <option value="7">Sales Return</option>
                                <option value="8">Others</option>
                                <option value="9">SKD/CKD/Lots</option>
                                <option value="10">Line Sales</option>
                                <option value="11">Recipient Not Known</option>
                                <option value="12">Exhibition or Fairs</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="subSupplyDesc" value="{{ __('Sub Supply Desc') }}" />
                            <textarea name="subSupplyDesc" id="" class="mt-1 block w-full form-control shadow-none" cols="5"
                                rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="docType" value="{{ __('Select Document Type') }}" />
                            <select name="docType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Document Type</option>
                                <option value="INV">Tax Invoice</option>
                                <option value="BIL">Bill of Supply</option>
                                <option value="BOE">Bill of Entry</option>
                                <option value="CHL">Delivery Challan</option>
                                <option value="OTH">Others</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="docNo" value="{{ __('Document No') }}" />
                            <x-jet-input type="text" class="mt-1 block w-full form-control shadow-none"
                                name="docNo" />
                        </div>

                        <div class="form-group">
                            <x-jet-label for="docDate" value="{{ __('Document Date') }}" />
                            <x-jet-input type="date" class="mt-1 block w-full form-control shadow-none"
                                value="{{ date('Y-m-d') }}" name="docDate" />
                        </div>

                        <div class="form-group">
                            <x-jet-label for="transMode" value="{{ __('Select Transportation Type') }}" />
                            <select name="transMode" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Transportation Mode</option>
                                <option value="1">Road</option>
                                <option value="2">Rail</option>
                                <option value="3">Air</option>
                                <option value="4">Ship</option>
                                <option value="5">inTransit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="transactionType" value="{{ __('Select Transaction Type') }}" />
                            <select name="transactionType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Transaction Type</option>
                                <option value="1">Regular</option>
                                <option value="2">Bill To - Ship To</option>
                                <option value="3">Bill From - Dispatch From</option>
                                <option value="4">Combination of 2 and 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <x-jet-label for="vehicleNo" value="{{ __('Vehicle No') }}" />
                            <x-jet-input type="text" class="mt-1 block w-full form-control shadow-none"
                                name="vehicleNo" />
                        </div>

                        <div class="form-group">
                            <x-jet-label for="vehicleType" value="{{ __('Select Vehicle Type') }}" />
                            <select name="vehicleType" class="mt-1 block w-full form-control shadow-none">
                                <option value="">Select Vehicle Type</option>
                                <option value="R">Regular</option>
                                <option value="O">ODC(Over Dimentional Cargo)</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-jet-section-border></x-jet-section-border>

        <div class="md:grid md:grid-cols-2">
            <div class=" md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 bg-white sm:p-6">
                        <div class="col-auto md:grid grid-cols-2 gap-2">

                            <div class="form-group  productDiv" wire:ignore>
                                <x-jet-label for="name" value="{{ __('Select Product') }}" />
                                <select name="productId" id=""
                                    class="mt-1 block w-full form-control shadow-none">
                                    <option value="">Search Product</option>
                                </select>
                                <span class="help-text" id="productPrice"></span>
                                <x-jet-input-error for="productId" class="mt-2" />
                            </div>

                            <div class="form-group md:col-1">
                                <x-jet-label for="price" value="{{ __('Price') }}" />
                                <x-jet-input min="1" type="text" id="pPrice"
                                    class="mt-1 block w-full form-control shadow-none" />
                            </div>

                            <div class="form-group md:col-1">
                                <x-jet-label for="qty" value="{{ __('Quantity') }}" />
                                <x-jet-input id="qty" value="1" min="1" type="number" class="mt-1 block w-full form-control shadow-none" />
                            </div>

                            <div class="form-group col-span-1 sm:col-span-1" wire:ignore>
                                <x-jet-label for="unit" value="{{ __('Unit') }}" />
                                <select name="unit" id=""
                                    class="mt-1 block w-full form-control shadow-none select2">
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
                                <x-jet-input id="notes" type="text"
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

    <x-jet-section-border></x-jet-section-border>

    <x-jet-section-title>
        <x-slot name="title"> Products</x-slot>
    </x-jet-section-title>

    <livewire:invoice-temp-product />

</div>
