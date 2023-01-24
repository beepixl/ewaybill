<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Products Master') }} {{ __('cruds.lists') }}</h1>
        <div class="section-header-breadcrumb">

        </div>
    </x-slot>

    <div>
        <livewire:table.invoice-list name="invoices" :model="$invoice" />
    </div>
    
</x-app-layout>