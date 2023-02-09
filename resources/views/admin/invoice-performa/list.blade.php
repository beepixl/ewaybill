<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Proforma Invoices') }} {{ __('cruds.lists') }}</h1>
        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>
    </x-slot>

    <div>
        <livewire:table.invoice-performa name="performa-invoices" :model="$invoicePerforma" />
    </div>

</x-app-layout>
