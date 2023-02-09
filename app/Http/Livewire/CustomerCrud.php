<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class CustomerCrud extends Component
{
    public $customer;
    public $customerId;
    public $action;
    public $button;
    public $columns;

    protected function getRules()
    {
        $rules = [];

        // foreach ($this->columns as $col) {
        //     if (!in_array($col, ['id', 'created_at', 'updated_at'])) {
        //         $rules["customer.$col"] =  in_array(DB::getSchemaBuilder()->getColumnType('customers', $col), ['integer']) ?  'required' : 'required';
        //     }
        // }

        $rules =  [
            'customer.toGstin' => 'nullable',
            'customer.toTrdName' => 'required',
            'customer.toAddr1' => 'required',
            'customer.toAddr2' => 'nullable',
            'customer.toPlace' => 'required',
            'customer.toPincode' => 'required',
            'customer.actToStateCode' => 'nullable',
            'customer.toStateCode' => 'nullable',
            'customer.swift_code' => 'nullable',
            'customer.customer_type' => 'nullable',
        ];

        return $rules;
    }

    public function createCustomer()
    {

        // dd($this->customer);

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
        Customer::find($this->customerId)->update($this->customer->toArray());
        $this->emit('saved');
        return redirect()->route('customer.index');
    }


    public function mount()
    {
        $this->columns = Schema::getColumnListing('customers');
// dd($this->columns);
        if (!$this->customer && $this->customerId) {
            $this->customer = Customer::find($this->customerId);
        }

        $this->button = create_button($this->action, "customer");
    }


    public function render()
    {

        // dd(Schema::getColumnListing('customers'));
        // dd(DB::getSchemaBuilder()->getColumnType('customers', 'toGstin'));

        return view('livewire.customer-crud');
    }
}
