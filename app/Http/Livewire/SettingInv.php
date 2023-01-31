<?php

namespace App\Http\Livewire;

use App\Models\Setting as ModelsSetting;
use Livewire\Component;

class SettingInv extends Component
{
    public $setting;
    public $settingId;
    public $action;
    public $button;

    protected function getRules()
    {
        $rules =  [
            'setting.fromGstin' => 'required|numeric',
            'setting.fromTrdName' => 'required',
            'setting.fromAddr1' => 'required',
            'setting.fromAddr2' => 'required',
            'setting.fromPlace' => 'required',
            'setting.fromPincode' => 'required|numeric',
            'setting.actFromStateCode' => 'required|numeric',
            'setting.fromStateCode' => 'required',
        ];

        return  $rules;
    }

    public function storeSetting()
    {
        $this->resetErrorBag();
        $this->validate();

       // dd($this->setting->toArray());
        ModelsSetting::updateOrCreate(['id' => 1],$this->setting->toArray());

        $this->emit('saved');
     // return redirect()->route('setting.index');
    }

    public function mount()
    {
        if (!$this->setting && $this->settingId) {
            $this->setting = ModelsSetting::find(1);
        }

        $this->button = create_button($this->action, "Setting");
    }


    public function render()
    {
        return view('livewire.setting-inv');
    }
}
