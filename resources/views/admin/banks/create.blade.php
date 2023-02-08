<x-app-layout>
    
    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Bank') }}</h1>

        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>

    </x-slot>

    <div>
        <livewire:banks-crud action="createBank" />
    </div>

</x-app-layout>