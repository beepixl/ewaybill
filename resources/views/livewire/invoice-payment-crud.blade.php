<div id="form-create">
    
    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Invoice Payment') }}
        </x-slot>

        <x-slot name="form">

            <div class="form-group ">
                <x-jet-label for="amount" value="{{ __('Amount') }}" />
                <x-jet-input id="amount" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="amount" />
                <x-jet-input-error for="amount" class="mt-2" />
            </div>
            <div class="form-group ">
                <x-jet-label for="rec_date" value="{{ __('Date') }}" />
                <x-jet-input id="rec_date" type="date" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="rec_date" />
                <x-jet-input-error for="rec_date" class="mt-2" />
            </div>

            <div class="form-group ">
                <x-jet-label for="remarks" value="{{ __('Remarks') }}" />
                <x-jet-input id="remarks" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="remarks" />
                <x-jet-input-error for="remarks" class="mt-2" />
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
