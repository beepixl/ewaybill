<?php

namespace App\Http\Livewire\Table;

use App\Traits\WithDataTable;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class InvoicePaymentsList extends Component
{
    use WithPagination, WithDataTable;

    public $model;
    public $name;
    public $orderId;

    public $perPage = 10;
    public $sortField = "id";
    public $sortAsc = false;
    public $search = '';

    protected $listeners = ["deleteItem" => "delete_item"];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function delete_item($id)
    {
        $data = $this->model::find($id);

        if (!$data) {
            $this->emit("deleteResult", [
                "status" => false,
                "message" => "No Such Record Found In " . $this->name
            ]);
            return;
        }

        $data->delete();
        // $this->emit("deleteResult", [
        //     "status" => true,
        //     "message" => "Record Deleted Successfull !"
        // ]);
    }

    public function render()
    {
        // Cache::rememberForever('currentPaymentsOrderId',);
        $data = $this->get_pagination_data();

        return view($data['view'], $data);
    }

}

