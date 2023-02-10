<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaxInvoiceExport implements FromCollection
{

    public function headings(): array
    {

  
        $columns = Schema::getColumnListing('invoices');

        $array = '';
        foreach ($columns as $col) {
            $array .= ",'".$col."'";
        }


        return [ $array ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Invoice::all();
    }
}
