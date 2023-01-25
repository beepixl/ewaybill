<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('cruds.create') }} {{ __('cruds.new') }} {{ __('Invoice') }}</h1>

        <div class="section-header-breadcrumb">

        </div>

    </x-slot>

    <div>
        <livewire:create-invoice action="createInvoice" />

    </div>

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

                    const productId = $('select[name="productId"]').val();
                    const price = $('input[id="pPrice"]').val();
                    const qty = $('input[id="qty"]').val();
                    const notes = $('input[id="notes"]').val();
                    const unit = $('select[name="unit"]').val();

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
                            // console.log(response);
                            $('.productsPage').html(response.data);
                            $('#maiForm')[0].reset();
                            $('select[name="productId"]').val(null).trigger('change');
                            $('select[name="unit"]').val(null).trigger('change');
                        }
                    });

                });

            });
        </script>
    @endpush

</x-app-layout>
