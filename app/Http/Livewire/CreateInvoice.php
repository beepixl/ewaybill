<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\Cache;
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
    public $pPrice;

    protected $listeners = [
        'setCustomerId',
    ];

    protected function getRules()
    {

        $rules = [
            'productId' => 'required'
        ];

        return $rules;
    }

    public function setCustomerId($id, $productId)
    {

        if ($id !== 0) {
            Session::put('invSelectedCustomer', $id);
            $customerId = Session::get('invSelectedCustomer');
            if (Cache::has("$customerId-invProducts")) {
               Cache::delete("$customerId-invProducts");
            }
        }

        if ($productId !== 0) {
            $this->pPrice = $productId;
        }
    }

    public function createInvoice()
    {

        $this->emit('failed');

        exit;
        // dd($this->req);

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

        if (!Cache::has('customers')) {
            Cache::add('customers', Customer::toBase()->get(), 5000);
        }

        $this->button = create_button($this->action, "Invoice");
    }


    public function render()
    {
        return view('livewire.create-invoice');
    }
}
