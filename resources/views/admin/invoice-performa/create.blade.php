<x-app-layout>

    <x-slot name="header_content">
        <h1>
            @if (Route::currentRouteName() == 'showInv')
                {{ __('View') }}
            @elseif(Route::currentRouteName() == 'invoice-performa.edit')
                {{ __('Edit') }}
            @else
                {{ __('cruds.create') }} {{ __('cruds.new') }}
            @endif {{ __('Proforma Invoice') }} 
        </h1>
        <div class="section-header-breadcrumb">
            {{ Breadcrumbs::render() }}
        </div>
    </x-slot>

    <form id="invoiceForm" method="post">
        @csrf
        <input type="hidden" id="redirectType">

        <div>
            <livewire:invoice-performa-crud action="createInvoice" :invoiceId="request()->invoice_performa" />
        </div>

    </form>

    @push('additional-sctipt')
        <script>
            const path = "{{ url('/') }}";

            $(document).ready(function() {

                $('select[name="customerId"]').on('change', function(e) {
                    livewire.emit('setCustomerId', e.target.value, 0);
                    setTimeout(() => {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('reloadProductsTbl') }}",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                type: 'performa'
                            },
                            dataType: "json",
                            success: function(response) {
                                $('.productsPage').html(response.data);
                                // notyf['success'](response.message);
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                notyf['error'](response.message);
                                // location.hash = 'invSection'
                            }
                        });
                    }, 300)

                });

                $('select[id="productId"]').select2({
                    ajax: {
                        url: `${path}/product-master/0`,
                        dataType: 'json',
                        processResults: function(data) {
                            return {
                                results: data.data
                            };
                        }
                    }
                });

                $('select[id="productId"]').on('change', function(e) {
                    const productId = $(this).val();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('product-detail') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            productId: productId
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.error == false) {
                                // console.log(response);
                                $('input[id="pPrice"]').val(response.data.productPrice);
                            }

                        }
                    });

                });

                $('#addItemToCart').on('click', function() {
                    updateTbl(this, 1);
                });

                $('#invoiceForm').submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: "{{ route('invoice-performa.store') }}",
                        data: new FormData(this),
                        dataType: "json",
                        success: function(response) {
                            //  console.log(response);
                            notyf['success'](response.message);
                            // window.location.href = "{{ route('invoice.index') }}";

                            if ($('input[id="redirectType"]').val() == 'print') {
                                window.open(`${path}/invoice-performa/${response.data}`, '_blank');
                                window.location.href = `${path}/invoice-performa`;
                            } else
                                window.location.href = `${path}/invoice-performa`;

                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            notyf['error'](response.message);
                            window.location.hash = 'invSection'
                        }
                    });
                });

            });

            function updateTbl(ele, type = null) {

                setTimeout(() => {

                    if (type == 1) {
                        var productId = $('select[id="productId"]').val();
                        var price = $('input[id="pPrice"]').val();
                        var qty = $('input[id="qty"]').val();
                        var notes = $('textarea[id="notes"]').val();
                        var unit = $('select[id="unit"]').val();
                        //  console.log(productId);
                    } else {
                        //console.log('else');
                        var productId = $(ele).attr('productId');
                        var price = $(ele).attr('productPrice');
                        var qty = $(ele).val();
                        var notes = $(ele).attr('productNote');
                        var unit = $(ele).attr('productUnit');
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('addToCart') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            productId: productId,
                            qty: qty,
                            price: price,
                            unit: unit,
                            notes: notes,
                            type: 'performa'
                        },
                        dataType: "json",
                        success: function(response) {
                            $('.productsPage').html(response.data);
                            // $('#maiForm')[0].reset();
                            // console.log($('input[id="notes"]'));
                            $('select[id="productId"]').val(null).trigger('change');
                            $('select[id="unit"]').val(null).trigger('change');
                            $('.productPrice').val('');
                            $('input[id="qty"]').val(1);
                            $('textarea[id="notes"]').val('');

                            notyf['success'](response.message);
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            notyf['error'](response.message);
                            // location.hash = 'invSection'
                        }
                    });

                }, 200);
            }

            function removeItem(itemId) {
                //  alert(itemId);

                $.ajax({
                    type: "POST",
                    url: "{{ route('removeItem') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        productId: itemId,
                        type: 'performa'
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('.productsPage').html(response.data);
                        notyf['success'](response.message);
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        notyf['error'](response.message);
                        // location.hash = 'invSection'
                    }
                });


            }

            function submitInvForm(type = null) {
                $('#invoiceForm').submit();

                if (type == 'print') {
                    $('input[id="redirectType"]').val('print');
                } else {
                    $('input[id="redirectType"]').val('back');
                }

            }
        </script>
    @endpush

</x-app-layout>
