<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Invoice') }}</h1>
        <div class="section-header-breadcrumb">
        </div>
    </x-slot>

    <form id="invoiceForm" method="post">
        @csrf

        <div>
            <livewire:create-invoice action="createInvoice" />
        </div>

    </form>

    @push('additional-sctipt')
        <script>
            const path = "{{ url('/') }}";

            $(document).ready(function() {

                $('select[name="customerId"]').on('change', function(e) {
                    livewire.emit('setCustomerId', e.target.value, 0)
                });

                $('select[name="productId"]').select2({
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

                $('select[name="productId"]').on('change', function(e) {
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
                        url: "{{ route('invoice.store') }}",
                        data: new FormData(this),
                        dataType: "json",
                        success: function(response) {
                            notyf['success'](response.message);
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
                        var productId = $('select[name="productId"]').val();
                        var price = $('input[id="pPrice"]').val();
                        var qty = $('input[id="qty"]').val();
                        var notes = $('input[id="notes"]').val();
                        var unit = $('select[name="unit"]').val();
                        //  console.log(productId);
                    } else {
                        console.log('else');
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
                        },
                        dataType: "json",
                        success: function(response) {
                            $('.productsPage').html(response.data);
                           // $('#maiForm')[0].reset();

                            $('select[name="productId"]').val(null).trigger('change');
                            $('select[name="unit"]').val(null).trigger('change');
                            $('input[id="pPrice"]').val();
                            $('input[id="qty"]').val();
                            $('input[id="notes"]').val();
                            notyf['success'](response.message);
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            notyf['error'](response.message);
                            location.hash = 'invSection'
                        }
                    });

                }, 200);
            }
        </script>
    @endpush

</x-app-layout>
