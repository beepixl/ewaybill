<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit Bank') }}</h1>

        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render('banks.edit',request()->bank) }}
        </div>
    </x-slot>

    <div>
        <livewire:banks-crud action="updateBank"  :bankId="request()->bank"/>
    </div>

</x-app-layout>