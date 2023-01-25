<div id="form-create">

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Invoice') }}
        </x-slot>

        <x-slot name="form">

            <div class="form-group col-span-6 sm:col-span-3" wire:ignore>
                <x-jet-label for="name" value="{{ __('Select Customer') }}" />
                <select name="customerId" id="" class="mt-1 block w-full form-control shadow-none select2">
                    <option value="">Select Customer</option>
                    @foreach (Cache::get('customers') as $customer)
                        <option value="{{ $customer->id }}"
                            {{ Session::has('invSelectedCustomer') ? (Session::get('invSelectedCustomer') == $customer->id ? 'selected' : 0) : 0 }}>
                            {{ $customer->toTrdName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="name" value="{{ __('Invoice Date') }}" />
                <input type="date" name="invoice_date" class="mt-1 block w-full form-control shadow-none"
                    value="{{ date('Y-m-d') }}" id="invoice_date">
            </div>

            <div class="form-group col-span-2 sm:col-span-2 productDiv" wire:ignore>
                <x-jet-label for="name" value="{{ __('Select Product') }}" />
                <select name="productId" id="" class="mt-1 block w-full form-control shadow-none">
                    <option value="">Search Product</option>
                </select>
                <span class="help-text" id="productPrice"></span>
                <x-jet-input-error for="productId" class="mt-2" />
            </div>

            <div class="form-group col-span-1 sm:col-span-1">
                <x-jet-label for="price" value="{{ __('Price') }}" />
                <x-jet-input min="1" type="text" id="pPrice"
                    class="mt-1 block w-full form-control shadow-none" />
            </div>

            <div class="form-group col-span-1 sm:col-span-1">
                <x-jet-label for="qty" value="{{ __('Quantity') }}" />
                <x-jet-input id="qty" value="1" min="1" type="number"
                    class="mt-1 block w-full form-control shadow-none" />
            </div>

            <div class="form-group col-span-1 sm:col-span-1" wire:ignore>
                <x-jet-label for="unit" value="{{ __('Unit') }}" />
                <select name="unit" id="" class="mt-1 block w-full form-control shadow-none select2">
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
                <x-jet-input id="notes" type="text" class="mt-1 block w-full form-control shadow-none" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <button type="button" id="addItemToCart"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-plus" aria-hidden="true"></i> Add To Order</button>
        </x-slot>

    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />

    <x-jet-section-title>
        <x-slot name="title"> Products</x-slot>
    </x-jet-section-title>

    <div class="productsPage">
        <livewire:invoice-temp-product />
    </div>

</div>
