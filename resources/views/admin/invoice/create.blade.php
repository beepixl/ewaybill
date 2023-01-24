<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Invoice') }}</h1>

        <div class="section-header-breadcrumb">

        </div>

    </x-slot>

    <div>
        <livewire:create-invoice action="createInvoice" />
    </div>
</x-app-layout>