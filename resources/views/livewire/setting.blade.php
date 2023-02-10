<div id="form-create">

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Default Settings') }}
        </x-slot>

        <x-slot name="form">

            <div class="form-group">
                <x-jet-label for="invPrefix" value="{{ __('Invoice Prefix') }}" />
                <x-jet-input id="invPrefix" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.invPrefix" />
                <x-jet-input-error for="setting.invPrefix" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="invNoStart" value="{{ __('Invoice No Start') }}" />
                <x-jet-input id="invNoStart" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.invNoStart" />
                <x-jet-input-error for="setting.invNoStart" class="mt-2" />
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
