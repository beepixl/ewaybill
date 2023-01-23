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

    public function storeSetting()
    {
        $this->resetErrorBag();
        $this->validate();

        ModelsSetting::updateOrCreate(['id'=>1],$this->user);

        $this->emit('saved');
        $this->reset('setting');

        return redirect()->route('setting.index');
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
