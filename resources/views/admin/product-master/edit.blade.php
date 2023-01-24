<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit User') }}</h1>

        <div class="section-header-breadcrumb">
        </div>
    </x-slot>

    <div>
        <livewire:product-master-crud action="updateProductMaster"  :productMasterId="request()->product_master"/>
    </div>

</x-app-layout>