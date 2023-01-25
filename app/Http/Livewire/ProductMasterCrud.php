<?php

namespace App\Http\Livewire;

use App\Models\ProductMaster;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ProductMasterCrud extends Component
{
    public $productMaster;
    public $productMasterId;
    public $action;
    public $button;

    protected function getRules()
    {
        $rules =  [
            'productMaster.productName' => 'required',
            'productMaster.productPrice' => 'required|numeric',
            'productMaster.hsnCode' => 'required|numeric',
            'productMaster.productDesc' => 'required',
            'productMaster.cgst' => 'numeric',
            'productMaster.sgst' => 'numeric',
            'productMaster.igst' => 'numeric',
        ];

        return array_merge([], $rules);
    }

    public function createProductMaster()
    {
        $this->resetErrorBag();
        $this->validate();

        ProductMaster::create($this->productMaster);

        $this->emit('saved');
        $this->reset('productMaster');
        return redirect()->route('product-master.index');
    }


    public function updateProductMaster()
    {
        $this->resetErrorBag();
        $this->validate();

        ProductMaster::find($this->productMasterId)->update([
            'productName' => $this->productMaster->productName,
            'productPrice' => $this->productMaster->productPrice,
            'productDesc' => $this->productMaster->productDesc,
            'hsnCode' => $this->productMaster->hsnCode,
            'cgst' => $this->productMaster->cgst,
            'sgst' => $this->productMaster->sgst,
            'igst' => $this->productMaster->igst,
        ]);

        $this->emit('saved');
        return redirect()->route('product-master.index');
    }


    public function mount()
    {
        if (!$this->productMaster && $this->productMasterId) {
            $this->productMaster = ProductMaster::find($this->productMasterId);
        }

        $this->button = create_button($this->action, "productMaster");
    }

    public function render()
    {

        return view('livewire.product-master-crud');
    }
}
