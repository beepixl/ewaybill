<?php

namespace App\Http\Livewire;

use App\Models\ProductMaster;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class InvoiceTempProduct extends Component
{
    

    

    public function render()
    {
        $customerId = Session::get('invSelectedCustomer');

        $products = collect();

        if (Cache::has("$customerId-invProducts")) {
            $products = Cache::get("$customerId-invProducts");
        }

        return view('livewire.invoice-temp-product', ['products' => $products->all()]);
    }
}
