<div id="form-create">

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Customer') }}
        </x-slot>

        <x-slot name="form">
            @foreach ($columns as $col)
                @if (!in_array($col, ['id', 'created_at', 'updated_at', 'customer_type']))
                    <div class="form-group">
                        <x-jet-label for="" value="{{ ucfirst(str_replace('to', ' ', $col)) }}" />
                        <x-jet-input id="" type="text" class="mt-1 block w-full form-control shadow-none"
                            wire:model.defer="customer.{{ $col }}" />
                        <x-jet-input-error for="customer.{{ $col }}" class="mt-2" />
                    </div>
                @elseif($col == 'customer_type')
                <div class="form-group">
                    <x-jet-label for="customer_type" value="Type" />
                        <select wire:model.defer="customer.customer_type" class="mt-1 block w-full form-control shadow-none" id="">
                            <option value="local" @isset($customer) {{ $customer->customer_type == 'local' ? 'selected' : '' }} @endisset >Local</option>
                            <option value="global" @isset($customer) {{ $customer->customer_type == 'global' ? 'selected' : '' }} @endisset>Global</option>
                        </select>
                    <x-jet-input-error for="customer.customer_type" class="mt-2" />
                </div>

                @endif
            @endforeach
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
