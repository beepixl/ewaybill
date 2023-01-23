<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Update Setting') }}</h1>

        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render('setting.index') }}
        </div>
    </x-slot>

    <div>
        <livewire:setting action="storeSetting" />

        <x-jet-section-border></x-jet-section-border>

        <livewire:invoice-setting action="storeSetting" />
    </div>

</x-app-layout>
