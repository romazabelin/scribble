{{ Form::open(['url' => route('transfer.import_data_from_xls'), 'class' => 'form-horizontal', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}

{{ Form::file('file_to_upload') }}

{{ Form::radio('checked_table', 1) }} {{ trans('translations.check_clients_table') }}

{{ Form::radio('checked_table', 2) }} {{ trans('translations.check_products_table') }}

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

{{ Form::submit(trans('translations.import_submit_btn'), ['class' => 'btn btn-primary', 'type'=>'submit']) }}

{{ Form::close() }}


<table class="table table-bordered" id="products-table">
    <thead>
    <tr>
        <th>{{ trans('translations.table.heading.client') }}</th>
        <th>{{ trans('translations.table.heading.product') }}</th>
        <th>{{ trans('translations.table.heading.total') }}</th>
        <th>{{ trans('translations.table.heading.date') }}</th>
        <th>{{ trans('translations.table.heading.actions') }}</th>
    </tr>
    </thead>
</table>

<div id="modal-product-edit" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('translations.edit_product.modal_title') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => '#', 'id' => 'form-update-product', 'class' => 'form-horizontal', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}
                <div class="form-group">
                    <label>
                        {{ trans('translations.edit_product.client') }}
                    </label>
                    {{ Form::select('client_id', $clients, '', ['class' => 'form-control', 'id' => 'edit-product-client']) }}
                </div>
                <div class="form-group">
                    <label>
                        {{ trans('translations.edit_product.name') }}
                    </label>
                    {{ Form::text('name', '', ['class' => 'form-control', 'id' => 'edit-product-name'])}}
                </div>
                <div class="form-group">
                    <label>
                        {{ trans('translations.edit_product.total') }}
                    </label>
                    {{ Form::text('total', '', ['class' => 'form-control', 'id' => 'edit-product-total'])}}
                </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-update-product">{{ trans('translations.edit_product.modal_save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('translations.edit_product.modal_close') }}</button>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        var listing = $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.list') }}",
            columns: [
                { data: 'client.name', name: 'client_id' },
                { data: 'name', name: 'name' },
                { data: 'total', name: 'total', orderable: false },
                { data: 'date_formatted', name: 'date',
                    render: {
                        _: 'display',
                        sort: 'timestamp'
                    }
                },
                { data: 'actions', name: 'actions', orderable: false }
            ],
            searching: false
        });

        $('body').on('click', '#btn-update-product', function() {
            $.ajax({
                type: 'PUT',
                url: $('#form-update-product').attr('action'),
                data: {
                    client_id: $('#edit-product-client').val(),
                    name: $('#edit-product-name').val(),
                    total: $('#edit-product-total').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.isSaved) {
                        alert(response.msg);
                        listing.ajax.reload();
                    } else
                        alert(response.msg);
                }
            })
        });

        $('body').on('click', '.load-product-data', function() {
            var url = $(this).attr('href');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    var product = response.product;

                    $('#edit-product-client').val(product.client_id);
                    $('#edit-product-name').val(product.name);
                    $('#edit-product-total').val(product.total);
                    $('#modal-product-edit').modal('show');
                    $('#form-update-product').attr('action', response.updateUrl);
                }
            })

            return false;
        })
    })
</script>