<div>
    <x-data-table :data="$data" :model="$invoices">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('invNo')" role="button" href="#">
                        Customer
                        @include('components.sort-icon', ['field' => 'invNo'])
                    </a></th>

                <th><a wire:click.prevent="sortBy('transactionType')" role="button" href="#">
                        Total Amount
                        @include('components.sort-icon', ['field' => 'transactionType'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('invDate')" role="button" href="#">
                        Inv date
                        @include('components.sort-icon', ['field' => 'invDate'])
                    </a></th>
                <th>Action</th>
            </tr>
        </x-slot>

        <x-slot name="body">
            @foreach ($invoices as $invoice)
                <tr x-data="window.__controller.dataTableController({{ $invoice->id }})">
                    <td>{{ $invoice->invNo }}</td>
                    <td>{{ optional($invoice->customer)->toTrdName }}</td>
                 
                    <td>{{ number_format($invoice->totInvValue, 2) }}</td>
                
                    <td>{{ date('d M Y', strtotime($invoice->invDate)) }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" class="btn btn-sm btn-primary" title="Print" target="_blank"
                        href="{{ route('invoice-performa.show', [$invoice->id]) }}" class="mr-3 text-black"><i
                            class="fa fa-16px fa-print"></i></a>
                        <a role="button" class="btn btn-sm btn-warning" title="Edit"
                            href="{{ route('invoice-performa.edit', [$invoice->id]) }}"><i class="fa fa-16px fa-edit"></i></a>
                        <a role="button" class="btn btn-sm btn-danger" title="Trash"
                            x-on:click.prevent="deleteItem"><i class="fa fa-16px fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
