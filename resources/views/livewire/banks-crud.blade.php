<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group ">
                <x-jet-label for="account_name" value="{{ __('Account Name') }}" />
                <x-jet-input id="account_name" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="bank.account_name" />
                <x-jet-input-error for="bank.account_name" class="mt-2" />
            </div>
            <div class="form-group ">
                <x-jet-label for="account_no" value="{{ __('Account No') }}" />
                <x-jet-input id="account_no" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="bank.account_no" />
                <x-jet-input-error for="bank.account_no" class="mt-2" />
            </div>
            
            <div class="form-group ">
                <x-jet-label for="bank_name" value="{{ __('Bank Name') }}" />
                <x-jet-input id="bank_name" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="bank.bank_name" />
                <x-jet-input-error for="bank.bank_name" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="ifsc_code" value="{{ __('IFSC Code') }}" />
                <x-jet-input id="ifsc_code" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="bank.ifsc_code" />
                <x-jet-input-error for="bank.ifsc_code" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="branch_name" value="{{ __('Branch Name') }}" />
                <x-jet-input id="branch_name" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="bank.branch_name" />
                <x-jet-input-error for="bank.branch_name" class="mt-2" />
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
