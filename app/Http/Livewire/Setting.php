<?php

namespace App\Http\Livewire;

use App\Models\Setting as ModelsSetting;
use Livewire\Component;

class Setting extends Component
{
    public $setting;
    public $settingId;
    public $action;
    public $button;

    protected function getRules()
    {
        $rules =  [
            'setting.appName' => 'required',
        ];

        return  $rules;
    }

    public function mount()
    {
        $this->setting = ModelsSetting::find($this->settingId);
        $this->button = create_button($this->action, "Setting");
    }


    public function render()
    {
        return view('livewire.setting');
    }
}
