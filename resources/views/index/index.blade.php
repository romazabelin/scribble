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
