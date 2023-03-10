<div>
    <x-data-table :data="$data" :model="$payments">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('amount')" role="button" href="#">
                        Amount
                        @include('components.sort-icon', ['field' => 'amount'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('remarks')" role="button" href="#">
                        Remarks
                        @include('components.sort-icon', ['field' => 'remarks'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('rec_date')" role="button" href="#">
                        Date
                        @include('components.sort-icon', ['field' => 'rec_date'])
                    </a></th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($payments as $payment)
                <tr x-data="window.__controller.dataTableController({{ $payment->id }})">
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->remarks }}</td>
                    <td>{{ date('M d,Y', strtotime($payment->rec_date)) }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" class="btn btn-sm btn-danger" x-on:click.prevent="deleteItem" href="#"><i
                                class="fa fa-16px fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
