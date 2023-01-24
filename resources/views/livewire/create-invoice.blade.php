<div id="form-create">

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Invoice') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="name" value="{{ __('Select Customer') }}" />
                <select name="customerId" id="" x-on:change="deleteItem" class="mt-1 block w-full form-control shadow-none select2">
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->toTrdName }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="role.name" class="mt-2" />
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
