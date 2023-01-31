<div id="form-create">

    <x-jet-form-section :submit="$action" class="mb-4">

        <x-slot name="title">
            {{ __('Default Settings') }}
        </x-slot>

        <x-slot name="form">

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="logoPath" value="{{ __('Logo') }}" />
                <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                    <!-- Profile Photo File Input -->
                    <input type="file" class="hidden" wire:model="photo" x-ref="photo"
                        x-on:change="
                                            photoName = $refs.photo.files[0].name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($refs.photo.files[0]);
                                    " />
                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="!photoPreview">
                        <img src="{{ optional($this->setting)->logoPath }}"
                            alt="{{ optional($this->setting)->logoPath }}" class="rounded-full h-20 w-20 object-cover">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview">
                        <span class="block rounded-full w-20 h-20"
                            x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                            photoPreview + '\');'">
                        </span>
                    </div>

                    <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </x-jet-secondary-button>

                    @if (optional($this->setting)->logoPath)
                        <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                            {{ __('Remove Photo') }}
                        </x-jet-secondary-button>
                    @endif

                    <x-jet-input-error for="setting.logoPath" class="mt-2" />
                </div>
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="appName" value="{{ __('App Name') }}" />
                <x-jet-input id="appName" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.appName" />
                <x-jet-input-error for="setting.appName" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="timezone" value="{{ __('Timezone') }}" />
                <x-jet-input id="timezone" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.timezone" />
                <x-jet-input-error for="setting.timezone" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="appEnv" value="{{ __('App Enviorment') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.appEnv"
                    id="">
                    <option value="production">Production</option>
                    <option value="staging">Staging</option>
                    <option value="local" selected>Local</option>
                </select>
                <x-jet-input-error for="setting.appEnv" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="appDebug" value="{{ __('App Debug') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.appDebug"
                    id="">
                    <option value="1" selected>True</option>
                    <option value="0">False</option>
                </select>
                <x-jet-input-error for="setting.appDebug" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="dbConn" value="{{ __('App DB Conn') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.dbConn"
                    id="">
                    <option value="mysql">Mysql</option>
                    <option value="mysqlLocal" selected>mysqlLocal</option>
                    <option value="sqlsrv">sqlsrv</option>
                </select>
                <x-jet-input-error for="setting.dbConn" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="storageDisk" value="{{ __('App Storage Disk') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.storageDisk"
                    id="">
                    <option value="local" selected>local</option>
                    <option value="public">public</option>
                    <option value="s3">S3</option>
                </select>
                <x-jet-input-error for="setting.storageDisk" class="mt-2" />
            </div>


            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="invPrefix" value="{{ __('Invoice Prefix') }}" />
                <x-jet-input id="invPrefix" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.invPrefix" />
                <x-jet-input-error for="setting.invPrefix" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="invNoStart" value="{{ __('Invoice No Start') }}" />
                <x-jet-input id="invNoStart" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.invNoStart" />
                <x-jet-input-error for="setting.invNoStart" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="mailHost" value="{{ __('Mail Host') }}" />
                <x-jet-input id="mailHost" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailHost" />
                <x-jet-input-error for="setting.mailHost" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="mailPort" value="{{ __('Mail Port') }}" />
                <x-jet-input id="mailPort" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailPort" />
                <x-jet-input-error for="setting.mailPort" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="mailEnc" value="{{ __('Mail Encryption') }}" />
                <select class="mt-1 block w-full form-control shadow-none" wire:model.defer="setting.mailEnc"
                id="">
                <option value="tls" selected>TLS</option>
                <option value="ssl">SSL</option>
            </select>
                <x-jet-input-error for="setting.mailEnc" class="mt-2" />
            </div>

            
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="mailUnm" value="{{ __('Mail User Name') }}" />
                <x-jet-input id="mailUnm" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailUnm" />
                <x-jet-input-error for="setting.mailUnm" class="mt-2" />
            </div>
            
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="mailPwd" value="{{ __('Mail Password') }}" />
                <x-jet-input id="mailPwd" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailPwd" />
                <x-jet-input-error for="setting.mailPwd" class="mt-2" />
            </div>
            
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="mailFrom" value="{{ __('Mail From Address') }}" />
                <x-jet-input id="mailFrom" type="text" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.mailFrom" />
                <x-jet-input-error for="setting.mailFrom" class="mt-2" />
            </div>
            
            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="mailName" value="{{ __('Mail From Name') }}" />
                <x-jet-input id="mailName" type="text" class="mt-1 block w-full form-control shadow-none" />
            </div>


            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="pColor" value="{{ __('Primary Color') }}" />
                <input type="color" class="mt-1 block w-full form-control shadow-none"
                    wire:model.defer="setting.pColor" id="">
                <x-jet-input-error for="setting.pColor" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
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
