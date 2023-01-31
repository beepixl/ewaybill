<div>
    <x-data-table :data="$data" :model="$invoices">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('invNo')" role="button" href="#">
                        Inv No
                        @include('components.sort-icon', ['field' => 'invNo'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('supplyType')" role="button" href="#">
                        Supply Type
                        @include('components.sort-icon', ['field' => 'supplyType'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('vehicleNo')" role="button" href="#">
                    Vehicle No
                        @include('components.sort-icon', ['field' => 'vehicleNo'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Registered Date
                        @include('components.sort-icon', ['field' => 'created_at'])
                    </a></th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($invoices as $invoice)
                <tr x-data="window.__controller.dataTableController({{ $invoice->id }})">
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->invNo }}</td>
                    <td>{{ $invoice->supplyType }}</td>
                    <td>{{ $invoice->vehicleNo }}</td>
                    <td>{{ $invoice->created_at->format('d M Y h:i') }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="{{ route('invoice.show', [$invoice->id]) }}" class="mr-3"><i class="fa fa-16px fa-print"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem"><i
                                class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
