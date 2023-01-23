<div id="form-create">

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('App Settings') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="invPrefix" value="{{ __('Invoice Prefix') }}" />
                <x-jet-input id="invPrefix" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.invPrefix" />
                <x-jet-input-error for="setting.invPrefix" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="invNoStart" value="{{ __('Invoice No Start') }}" />
                <x-jet-input id="invNoStart" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.invNoStart" />
                <x-jet-input-error for="setting.invNoStart" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="logoPath" value="{{ __('Logo') }}" />
                <x-jet-input id="logoPath" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.invNoStart" />
                <x-jet-input-error for="setting.logoPath" class="mt-2" />
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

    <x-jet-section-border></x-jet-section-border>

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Invoice Settings') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="fromGstin" value="{{ __('Gstin') }}" />
                <x-jet-input id="fromGstin" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.fromGstin" />
                <x-jet-input-error for="setting.fromGstin" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="fromTrdName" value="{{ __('Trade Name') }}" />
                <x-jet-input id="fromTrdName" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.fromTrdName" />
                <x-jet-input-error for="setting.fromTrdName" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="fromAddr1" value="{{ __('Address 1') }}" />
                <x-jet-input id="fromAddr1" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.fromAddr1" />
                <x-jet-input-error for="setting.fromAddr1" class="mt-2" />
            </div>
            
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="fromAddr2" value="{{ __('Address 2') }}" />
                <x-jet-input id="fromAddr2" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.fromAddr2" />
                <x-jet-input-error for="setting.fromAddr2" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="fromPlace" value="{{ __('Place') }}" />
                <x-jet-input id="fromPlace" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.fromPlace" />
                <x-jet-input-error for="setting.fromPlace" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="fromPincode" value="{{ __('Pincode') }}" />
                <x-jet-input id="fromPincode" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.fromPincode" />
                <x-jet-input-error for="setting.fromPincode" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="actFromStateCode" value="{{ __('Act StateCode') }}" />
                <x-jet-input id="actFromStateCode" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.actFromStateCode" />
                <x-jet-input-error for="setting.actFromStateCode" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="fromStateCode" value="{{ __('StateCode') }}" />
                <x-jet-input id="fromStateCode" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.fromStateCode" />
                <x-jet-input-error for="setting.fromStateCode" class="mt-2" />
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
