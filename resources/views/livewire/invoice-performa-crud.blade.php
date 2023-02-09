<div id="form-create">
    <div class="md:grid md:grid-cols-2" id="invSection">
        <div class=" md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 bg-white sm:p-6">
                    <div class="col-auto md:grid grid-cols-4 gap-2">

                        @isset($invoice)
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
                            <x-jet-label for="name" value="{{ __('Invoice Date') }}" />
                            <input type="date" name="invDate" class="mt-1 block w-full form-control shadow-none"
                                @isset($invoice) value="{{ $invoice->invDate }}" @else value="{{ date('Y-m-d') }}" @endisset
                                id="invDate">
                        </div>

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
                                <textarea id="notes" type="text" class="mt-1 block w-full form-control shadow-none"></textarea>
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

</div>
