<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Banks') }} {{ __('cruds.lists') }}</h1>
        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>
    </x-slot>

    <div>
        <livewire:table.banks-list name="banks" :model="$banks" />
    </div>
    
</x-app-layout>