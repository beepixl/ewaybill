<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Product Master') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group ">
                <x-jet-label for="productName" value="{{ __('Product Name') }}" />
                <x-jet-input id="productName" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="productMaster.productName" />
                <x-jet-input-error for="productMaster.productName" class="mt-2" />
            </div>
            <div class="form-group ">
                <x-jet-label for="productPrice" value="{{ __('Product Price') }}" />
                <x-jet-input id="productPrice" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="productMaster.productPrice" />
                <x-jet-input-error for="productMaster.productPrice" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="productDesc" value="{{ __('Product Desc') }}" />
                <x-jet-input id="productDesc" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="productMaster.productDesc" />
                <x-jet-input-error for="productMaster.productDesc" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="hsnCode" value="{{ __('Hsn Code') }}" />
                <x-jet-input id="hsnCode" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="productMaster.hsnCode" />
                <x-jet-input-error for="productMaster.hsnCode" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="cgst" value="{{ __('CGST') }}" />
                <x-jet-input id="cgst" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="productMaster.cgst" />
                <x-jet-input-error for="productMaster.cgst" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="sgst" value="{{ __('SGST') }}" />
                <x-jet-input id="sgst" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="productMaster.sgst" />
                <x-jet-input-error for="productMaster.sgst" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="igst" value="{{ __('IGST') }}" />
                <x-jet-input id="igst" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="productMaster.igst" />
                <x-jet-input-error for="productMaster.igst" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __($button['submit_text']) }}
            </x-jet-button>
        </x-slot>

    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
