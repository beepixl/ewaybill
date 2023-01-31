<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Invoices') }} {{ __('cruds.lists') }}</h1>
        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>
    </x-slot>

    <div>
        <livewire:table.invoice-list name="invoices" :model="$invoice" />
    </div>
    
</x-app-layout>