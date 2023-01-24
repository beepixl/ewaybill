<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Product Master') }}</h1>

        <div class="section-header-breadcrumb">

        </div>

    </x-slot>

    <div>
        <livewire:customer-crud action="createCustomer" />
    </div>
</x-app-layout>