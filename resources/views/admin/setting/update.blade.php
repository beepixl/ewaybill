<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Update Setting') }}</h1>

        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render('setting.index') }}
        </div>
    </x-slot>

    <div>
        <livewire:setting action="storeSetting"  :settingId="1"/>

        <x-jet-section-border></x-jet-section-border>
        
        <livewire:setting-inv action="storeSetting" :settingId="1" />

    </div>

</x-app-layout>
