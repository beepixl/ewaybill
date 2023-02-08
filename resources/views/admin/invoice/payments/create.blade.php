<x-app-layout>

    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Payment') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('invoice.index') }}">Invoices</a></div>
            <div class="breadcrumb-item"><a href="{{ route('showInv',[request()->invId]) }}">View Invoice</a></div>
            <div class="breadcrumb-item active">Add Payment</div>
        </div>
    </x-slot>

    <div>
        <livewire:invoice-payment-crud action="createPayment" />
    </div>

</x-app-layout>
