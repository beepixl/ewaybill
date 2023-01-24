<div>
    <x-data-table :data="$data" :model="$productMasters">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('productName')" role="button" href="#">
                    Product Name
                        @include('components.sort-icon', ['field' => 'productName'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('productDesc')" role="button" href="#">
                    Product Desc
                        @include('components.sort-icon', ['field' => 'productDesc'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('hsnCode')" role="button" href="#">
                    Hsn Code
                        @include('components.sort-icon', ['field' => 'hsnCode'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Registered Date
                        @include('components.sort-icon', ['field' => 'created_at'])
                    </a></th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($productMasters as $productMaster)
            <tr x-data="window.__controller.dataTableController({{ $productMaster->id }})">
                <td>{{ $productMaster->id }}</td>
                <td>{{ $productMaster->productName }}</td>
                <td>{{ $productMaster->productDesc }}</td>
                <td>{{ $productMaster->hsnCode }}</td>
                <td>{{ $productMaster->created_at->format('d M Y h:i') }}</td>
                <td class="whitespace-no-wrap row-action--icon">
                    <a role="button" href="{{ route('product-master.edit',[$productMaster->id]) }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                    <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>