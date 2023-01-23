<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Update Setting') }}</h1>

        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render('setting.index') }}
        </div>
    </x-slot>

    <div>
        <livewire:setting action="setting.update" :settingId="1" />
    </div>

</x-app-layout>