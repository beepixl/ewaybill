<?php

namespace App\Traits;

use App\Models\Banks;
use App\Models\Invoice;


trait WithDataTable
{

    public function get_pagination_data()
    {
        switch ($this->name) {
            case 'user':
                $users = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.user',
                    "users" => $users,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('users.create'),
                            'create_new_text' => 'Create New User',
                        ]
                    ])
                ];
                break;
            case 'role':
                $roles = $this->model::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.roles',
                    "roles" => $roles,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('roles.create'),
                            'create_new_text' => 'Create Role',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;
            case 'product_masters':
                $productMasters = $this->model::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.product-master-list',
                    "productMasters" => $productMasters,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('product-master.create'),
                            'create_new_text' => 'Create Product Master',
                        ]
                    ])
                ];
                break;
            case 'customers':
                $customers = $this->model::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.customers-list',
                    "customers" => $customers,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('customer.create'),
                            'create_new_text' => 'Create Customer',
                        ]
                    ])
                ];
                break;
            case 'invoices':
                $invoices = $this->model::with('customer', 'payments')->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.invoice-list',
                    "invoices" => $invoices,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('invoice.create'),
                            'create_new_text' => 'Create Invoice',
                            'export' => route('export-invoices'),
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;
            case 'invoicePayments':
                $payments = $this->model::where('order_id', $this->orderId)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                if ((float)$payments->sum('amount') < (float)Invoice::find($this->orderId)->totInvValue) {
                    return [
                        "view" => 'livewire.table.invoice-payments-list',
                        "payments" => $payments,
                        "data" => array_to_object([
                            'href' => [
                                'create_new' => route('inv-payment.create', ['invId' => $this->orderId]),
                                'create_new_text' => 'Add Payment',
                            ]
                        ])
                    ];
                } else {
                    return [
                        "view" => 'livewire.table.invoice-payments-list',
                        "payments" => $payments,
                        "data" => array_to_object([])
                    ];
                }

                break;
            case 'banks':
                $banks = Banks::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.banks-list',
                    "banks" => $banks,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('banks.create'),
                            'create_new_text' => 'Add Bank',
                        ]
                    ])
                ];
                break;
            case 'performa-invoices':
                $invoices = $this->model::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
                return [
                    "view" => 'livewire.table.invoice-performa',
                    "invoices" => $invoices,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('invoice-performa.create'),
                            'create_new_text' => 'Create Invoice',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;
            default:
                # code...
                break;
        }
    }
}
