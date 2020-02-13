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
    </tr>
    </thead>
</table>

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#products-table').DataTable({
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
                }
            ],
            searching: false
        });
    })
</script>