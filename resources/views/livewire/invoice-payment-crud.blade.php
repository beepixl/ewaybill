<div id="form-create">
    <div class="md:grid md:grid-cols-2" id="invSection">
        <div class=" md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 bg-white sm:p-6">
                    <div class="col-auto md:grid grid-cols-4 gap-2">
                        <div class="form-group" wire:ignore>
                            <pre>Customer: <strong>{{ optional($inv->customer)->toTrdName }}</strong></pre>
                        </div>
                        <div class="form-group" wire:ignore>
                            <pre>Total Amount: <strong>{{ number_format($inv->totInvValue, 2) }}</strong></pre>
                        </div>
                        <div class="form-group" wire:ignore>
                            <pre>Paid Amount: <strong class="text-success">{{ number_format($paymentSum, 2) }}</strong></pre>
                        </div>
                        <div class="form-group" wire:ignore>
                            <pre >Penidng Amount: <strong class="text-danger">{{ number_format($inv->totInvValue-$paymentSum, 2) }}</strong></pre>
                        </div>
                        <div class="form-group" wire:ignore>
                            <pre>Status: <strong>@if ($inv->status == 0){{ __('Pending') }}@elseif($inv->status == 2){{ __('Partial') }}@else{{ __('Paid') }}@endif</strong></pre>
                        </div>
                        <div class="form-group" wire:ignore>
                            <pre>INV No: <strong>{{ $inv->invNo }}</strong></pre>
                        </div>
                        <div class="form-group" wire:ignore>
                            <pre>INV Date: <strong>{{ date('d M Y', strtotime($inv->invDate)) }}</strong></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-jet-section-border></x-jet-section-border>

    <div id="form-create">

    @if($this->paymentSum != $this->inv->totInvValue)
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
    @endif

        <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
    </div>
