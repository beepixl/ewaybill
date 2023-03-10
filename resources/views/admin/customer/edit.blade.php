<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit Customer') }}</h1>

        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render('customer.edit',request()->customer) }}
        </div>
    </x-slot>

    <div>
        <livewire:customer-crud  action="updateCustomer"  :customerId="request()->customer"/>
    </div>

</x-app-layout>