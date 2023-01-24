<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CreateInvoice extends Component
{
    public $invoice;
    public $customers;
    public $invoiceId;
    public $action;
    public $button;

    protected $listeners = ["setCustomer" => "setCustomerId"];

    protected function getRules()
    {
        $rules = [];

        // foreach ($this->columns as $col) {
        //     if (!in_array($col, ['id', 'created_at', 'updated_at'])) {
        //         $rules["customer.$col"] =  in_array(DB::getSchemaBuilder()->getColumnType('invoices', $col), ['integer']) ?  'required|numeric' : 'required';
        //     }
        // }

        return $rules;
    }

    public function setCustomerId()
    {
        Session::put('invSelectedCustomer',1);
    }

    public function createUser()
    {
        $this->resetErrorBag();
        $this->validate();

        Invoice::create($this->invoice);

        $this->emit('saved');
        $this->reset('user');
        return redirect()->route('invoice.index');
    }

    public function updateUser()
    {
        $this->resetErrorBag();
        $this->validate();

        Invoice::find($this->invoiceId)->update([
            "name" => $this->invoice->name,
            "email" => $this->invoice->email,
        ]);

        $this->emit('saved');
        return redirect()->route('invoice.index');
    }

    public function mount()
    {
        if (!$this->invoice && $this->invoiceId) {
            $this->invoice = Invoice::find($this->invoiceId);
        }

        $this->customers = Customer::toBase()->get();
        $this->button = create_button($this->action, "Invoice");
    }


    public function render()
    {
        return view('livewire.create-invoice');
    }
}
