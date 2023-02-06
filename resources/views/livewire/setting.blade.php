<div id="form-create">

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Default Settings') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group">
                <x-jet-label for="appName" value="{{ __('App Name') }}" />
                <x-jet-input id="appName" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.appName" />
                <x-jet-input-error for="setting.appName" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="timezone" value="{{ __('Timezone') }}" />
                <x-jet-input id="timezone" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.timezone" />
                <x-jet-input-error for="setting.timezone" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="appEnv" value="{{ __('App Enviorment') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.appEnv"
                    id="">
                    <option value="production">Production</option>
                    <option value="staging">Staging</option>
                    <option value="local" selected>Local</option>
                </select>
                <x-jet-input-error for="setting.appEnv" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="appDebug" value="{{ __('App Debug') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.appDebug"
                    id="">
                    <option value="1" selected>True</option>
                    <option value="0">False</option>
                </select>
                <x-jet-input-error for="setting.appDebug" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="dbConn" value="{{ __('App DB Conn') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.dbConn"
                    id="">
                    <option value="mysql">Mysql</option>
                    <option value="mysqlLocal" selected>mysqlLocal</option>
                    <option value="sqlsrv">sqlsrv</option>
                </select>
                <x-jet-input-error for="setting.dbConn" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="storageDisk" value="{{ __('App Storage Disk') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.storageDisk"
                    id="">
                    <option value="local" selected>local</option>
                    <option value="public">public</option>
                    <option value="s3">S3</option>
                </select>
                <x-jet-input-error for="setting.storageDisk" class="mt-2" />
            </div>


            <div class="form-group">
                <x-jet-label for="invPrefix" value="{{ __('Invoice Prefix') }}" />
                <x-jet-input id="invPrefix" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.invPrefix" />
                <x-jet-input-error for="setting.invPrefix" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="invNoStart" value="{{ __('Invoice No Start') }}" />
                <x-jet-input id="invNoStart" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.invNoStart" />
                <x-jet-input-error for="setting.invNoStart" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="mailHost" value="{{ __('Mail Host') }}" />
                <x-jet-input id="mailHost" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailHost" />
                <x-jet-input-error for="setting.mailHost" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="mailPort" value="{{ __('Mail Port') }}" />
                <x-jet-input id="mailPort" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailPort" />
                <x-jet-input-error for="setting.mailPort" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="mailEnc" value="{{ __('Mail Encryption') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.mailEnc"
                id="">
                <option value="tls" selected>TLS</option>
                <option value="ssl">SSL</option>
            </select>
                <x-jet-input-error for="setting.mailEnc" class="mt-2" />
            </div>

            
            <div class="form-group">
                <x-jet-label for="mailUnm" value="{{ __('Mail User Name') }}" />
                <x-jet-input id="mailUnm" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailUnm" />
                <x-jet-input-error for="setting.mailUnm" class="mt-2" />
            </div>
            
            <div class="form-group">
                <x-jet-label for="mailPwd" value="{{ __('Mail Password') }}" />
                <x-jet-input id="mailPwd" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailPwd" />
                <x-jet-input-error for="setting.mailPwd" class="mt-2" />
            </div>
            
            <div class="form-group">
                <x-jet-label for="mailFrom" value="{{ __('Mail From Address') }}" />
                <x-jet-input id="mailFrom" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailFrom" />
                <x-jet-input-error for="setting.mailFrom" class="mt-2" />
            </div>
            
            <div class="form-group">
                <x-jet-label for="mailName" value="{{ __('Mail From Name') }}" />
                <x-jet-input id="mailName" type="text" class="mt-1 block w-full form-control shadow-none" />
            </div>


            <div class="form-group">
                <x-jet-label for="pColor" value="{{ __('Primary Color') }}" />
                <input type="color" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.pColor" id="">
                <x-jet-input-error for="setting.pColor" class="mt-2" />
            </div>

            <div class="form-group">
                <x-jet-label for="sColor" value="{{ __('Secondary Color') }}" />
                <input type="color" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.sColor" id="">
                <x-jet-input-error for="setting.sColor" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __($button['submit_text']) }}
            </x-jet-button>
        </x-slot>

    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
