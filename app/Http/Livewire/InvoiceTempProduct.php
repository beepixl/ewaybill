<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class InvoiceTempProduct extends Component
{

    public function render()
    {
        $customerId = Session::get('invSelectedCustomer');

        $products = collect();

        if (Route::currentRouteName() == 'invoice-performa.edit') {
            if (Cache::has("$customerId-pInvProducts")) {
                $products = Cache::get("$customerId-pInvProducts");
            }
        } else {
            if (Cache::has("$customerId-invProducts")) {
                $products = Cache::get("$customerId-invProducts");
            }
        }

        if (Route::currentRouteName() == 'showInv') {
            return view('livewire.invoice-temp-product', ['products' => $products->all(), 'show' => true]);
        }

        return view('livewire.invoice-temp-product', ['products' => $products->all()]);
    }
}
