<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\InvoicePerforma;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class InvoicePerformaCrud extends Component
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
    }

    public function mount()
    {
        if (!$this->invoice && $this->invoiceId) {
            //dd(Cache::get("2-invProducts"));
            $this->invoice = InvoicePerforma::with(['billProducts'=> function ($q) {
                $q->type(2);
            }])->find($this->invoiceId);
        } else {
            $customerId = Session::get('invSelectedCustomer');
            if (Cache::has("$customerId-pInvProducts")) {
                Cache::delete("$customerId-pInvProducts");
            }
            //  Artisan::call('optimize:clear');
        }

        $this->customers =  Customer::get()->toArray();
        $this->button = create_button($this->action, "Invoice");
    }



    public function render()
    {
        if (Route::currentRouteName() == 'showInv') {
            return view('livewire.invoice-performa-crud', ['show' => true]);
        }

        return view('livewire.invoice-performa-crud');
    }
}
