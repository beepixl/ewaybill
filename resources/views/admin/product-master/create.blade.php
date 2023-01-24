<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Product Master') }}</h1>

        <div class="section-header-breadcrumb">

        </div>

    </x-slot>

    <div>
        <livewire:product-master-crud action="createProductMaster" />
    </div>
</x-app-layout>