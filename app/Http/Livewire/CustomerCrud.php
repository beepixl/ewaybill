<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;

class CustomerCrud extends Component
{
    public $customer;
    public $customerId;
    public $action;
    public $button;

    protected function getRules()
    {
        $rules =  [
            'customer.toGstin' => 'required',
            'customer.toTrdName' => 'required',
            'customer.toAddr1' => 'required',
            'customer.toAddr2' => 'required',
            'customer.toPlace' => 'required',
            'customer.toPincode' => 'required',
            'customer.actToStateCode' => 'required',
            'customer.actToStateCode' => 'required',
            'customer.toStateCode' => 'required',
        ];

        return $rules;
    }

    public function createCustomer()
    {
        $this->resetErrorBag();
        $this->validate();

        Customer::create($this->customer);

        $this->emit('saved');
        $this->reset('customer');
        return redirect()->route('customer.index');
    }


    public function updateCustomer()
    {
        $this->resetErrorBag();
        $this->validate();

        Customer::find($this->customerId)->update([
            'productName' => $this->customer->productName,
            'productDesc' => $this->customer->productDesc,
            'hsnCode' => $this->customer->hsnCode,
            'cgst' => $this->customer->cgst,
            'sgst' => $this->customer->sgst,
            'igst' => $this->customer->igst,
        ]);

        $this->emit('saved');
        return redirect()->route('customer.index');
    }


    public function mount()
    {
        if (!$this->customer && $this->customerId) {
            $this->customer = Customer::find($this->customerId);
        }

        $this->button = create_button($this->action, "customer");
    }


    public function render()
    {
        return view('livewire.customer-crud');
    }
}
