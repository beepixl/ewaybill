<div>
    <x-data-table :data="$data" :model="$banks">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('account_name')" role="button" href="#">
                        Account Name
                        @include('components.sort-icon', ['field' => 'account_name'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('account_no')" role="button" href="#">
                        Account No
                        @include('components.sort-icon', ['field' => 'account_no'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('ifsc_code')" role="button" href="#">
                        Ifsc Code
                        @include('components.sort-icon', ['field' => 'ifsc_code'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('branch_name')" role="button" href="#">
                        Branch Name
                        @include('components.sort-icon', ['field' => 'branch_name'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Registered Date
                        @include('components.sort-icon', ['field' => 'created_at'])
                    </a></th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($banks as $bank)
                <tr x-data="window.__controller.dataTableController({{ $bank->id }})">
                    <td>{{ $bank->id }}</td>
                    <td>{{ $bank->account_name }}</td>
                    <td>{{ $bank->account_no }}</td>
                    <td>{{ $bank->ifsc_code }}</td>
                    <td>{{ $bank->branch_name }}</td>
                    <td>{{ $bank->created_at->format('d M Y h:i') }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="{{ route('banks.edit', [$bank->id]) }}" class="mr-3"><i
                                class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i
                                class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
