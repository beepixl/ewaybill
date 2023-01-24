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
            'settings.fromGstin' => 'required',
        ];

        return  $rules;
    }

    public function storeSetting()
    {
        $this->resetErrorBag();
        $this->validate();

        
        ModelsSetting::find(1)->upadte([$this->setting]);

        $this->emit('saved');
        //  return redirect()->route('setting.index');
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
