<div>
    <x-data-table :data="$data" :model="$customers">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                        GST NO
                        @include('components.sort-icon', ['field' => 'toGstin'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                        Trade Name
                        @include('components.sort-icon', ['field' => 'toTrdName'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                        Address 1
                        @include('components.sort-icon', ['field' => 'toAddr1'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                        Place
                        @include('components.sort-icon', ['field' => 'toPlace'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Registered Date
                        @include('components.sort-icon', ['field' => 'created_at'])
                    </a></th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($customers as $customer)
                <tr x-data="window.__controller.dataTableController({{ $customer->id }})">
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->toGstin }}</td>
                    <td>{{ $customer->toTrdName }}</td>
                    <td>{{ $customer->toAddr1 }}</td>
                    <td>{{ $customer->toPlace }}</td>
                    <td>{{ $customer->created_at->format('d M Y h:i') }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="{{ route('customer.edit', [$customer->id]) }}" class="mr-3"><i
                                class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i
                                class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
