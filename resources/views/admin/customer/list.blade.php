<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Customers') }} {{ __('cruds.lists') }}</h1>
        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>
    </x-slot>

    <div>
        <livewire:table.customers-list name="customers" :model="$customer" />
    </div>

</x-app-layout>
