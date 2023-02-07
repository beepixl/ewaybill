<div>
    <x-data-table :data="$data" :model="$payments">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('order_id')" role="button" href="#">
                        Invoice No
                        @include('components.sort-icon', ['field' => 'order_id'])
                    </a></th>
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
                    <td>{{ settingData()->invPrefix }}-{{ $payment->order_id }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->remarks }}</td>
                    <td>{{ date('M d,Y', strtotime($payment->rec_date)) }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i
                                class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
