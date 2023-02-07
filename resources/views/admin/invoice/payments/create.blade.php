<x-app-layout>

    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Payment') }}</h1>

        <div class="section-header-breadcrumb">
       
        </div>
    </x-slot>

    <div>
        <livewire:invoice-payment-crud action="createPayment" />
    </div>

</x-app-layout>
