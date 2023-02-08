<?php

namespace App\Http\Livewire;

use App\Models\Banks;
use Livewire\Component;

class BanksCrud extends Component
{
    public $bank;
    public $bankId;
    public $action;
    public $button;

    protected function getRules()
    {

        $rules =  [
            'bank.account_name' => 'required',
            'bank.account_no' => 'required|max:15',
            'bank.ifsc_code' => 'required|max:11',
            'bank.branch_name' => 'required',
        ];

        return $rules;
    }

    public function createBank()
    {

        // dd($this->customer);

        $this->resetErrorBag();
        $this->validate();

        Banks::create($this->bank);

        $this->emit('saved');
        $this->reset('bank');
        return redirect()->route('banks.index');
    }

    public function updateBank()
    {
        $this->resetErrorBag();
        $this->validate();
        Banks::find($this->bankId)->update($this->bank->toArray());
        $this->emit('saved');
        return redirect()->route('banks.index');
    }

    public function mount()
    {

        if (!$this->bank && $this->bankId) {
            $this->bank = Banks::find($this->bankId);
        }

        $this->button = create_button($this->action, "bank");
    }

    public function render()
    {
        return view('livewire.banks-crud');
    }
}
