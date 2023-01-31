<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Product Master') }}</h1>

        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>

    </x-slot>

    <div>
        <livewire:customer-crud action="createCustomer" />
    </div>
</x-app-layout>