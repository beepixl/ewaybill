<?php

namespace App\Http\Livewire;

use App\Models\Banks;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayments;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CreateInvoice extends Component
{
    public $invoice;
    public $customers;
    public $payments;
    public $invoiceId;
    public $setting;
    public $banks;
    public $action;
    public $button;
    public $invNo;
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
            $this->invoice = Invoice::with(['billProducts'=> function ($q) {
                $q->type(1);
            }])->find($this->invoiceId);
            $this->payments =  InvoicePayments::class;
        } else {
            $customerId = Session::get('invSelectedCustomer');
            if (Cache::has("$customerId-invProducts")) {
                Cache::delete("$customerId-invProducts");
            }
            //  Artisan::call('optimize:clear');
        }


        // if (!Cache::has('customers')) {
        //     Cache::add('customers', Customer::toBase()->get(), 2000);
        // }

        $this->customers =  Customer::get()->toArray();
        $this->setting =  Setting::first()->toArray();
        $this->banks =  Banks::get()->toArray();
        $this->invNo  = settingData()->invPrefix."/INV-";
        $this->button = create_button($this->action, "Invoice");
    }


    public function render()
    {
        if (Route::currentRouteName() == 'showInv') {
            return view('livewire.create-invoice', ['show' => true]);
        }


        return view('livewire.create-invoice');
    }

}
