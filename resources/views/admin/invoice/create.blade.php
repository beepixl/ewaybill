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

                $('select[name="productId"]').on('change', function(e) {
                    livewire.emit('setCustomerId', 0, e.target.value)
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

                // $('select[name="productId"]').on('change', function() {

                //     var cat_id = $(this).val();
                //     const categoryEle = $(this);

                //     $.ajax({
                //         url: `${path}/product-master/${cat_id}`,
                //         success: function(data) {

                //             var subCatEle = categoryEle.closest('div').next('div').children(
                //                 'select[name="sub_category_id"]');
                //             if (subCatEle.length == 0)
                //                 var subCatEle = categoryEle.closest('div').next('div').children(
                //                     'select[id="sub_category_id"]');
                //             //  console.log(subCatEle);

                //             subCatEle.empty().trigger('change');
                //             subCatEle.select2({
                //                 allowClear: true,
                //                 placeholder: "Select a Sub Category",
                //                 data: JSON.parse(data),
                //                 width: "100%"
                //             }).trigger('change');
                //         }
                //     });

                // });
            });
        </script>
    @endpush

</x-app-layout>
