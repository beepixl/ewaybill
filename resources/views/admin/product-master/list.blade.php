<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Products Master') }} {{ __('cruds.lists') }}</h1>
        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>
    </x-slot>

    <div>
        <livewire:table.product-m name="product_masters" :model="$productMaster" />
    </div>
    
</x-app-layout>