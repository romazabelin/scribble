@extends('layouts.app')

@section('content')
    <div>
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
    </div>
    <div class="card mb-5 mt-5">
        <div class="card-body">
            {{ Form::open(['url' => route('transfer.import_data_from_xls'), 'class' => 'form-horizontal', 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}
            <div class="row">
                <div class="col-md-5">
                    {{ Form::file('file_to_upload') }}
                </div>
                <div class="col-md-5">
                    {{ Form::radio('checked_table', 1) }} {{ trans('translations.check_clients_table') }}

                    {{ Form::radio('checked_table', 2) }} {{ trans('translations.check_products_table') }}
                </div>
                <div class="col-md-2">
                    {{ Form::submit(trans('translations.import_submit_btn'), ['class' => 'btn btn-primary', 'type'=>'submit']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-7">
                    {{ Form::text('', '', ['placeholder' => Lang::get("translations.filter.description"), 'class' => 'form-control', 'id' => 'filter-val']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('', $filterOptions, '', ['class' => 'form-control', 'id' => 'filter-key']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::button(trans('translations.filter_btn'), ['class' => 'btn btn-info', 'id' => 'btn-apply-filter']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5">
        {{ Html::link(route('transfer.export_data_to_xls'), trans('translations.email_report'), ['class' => 'btn  btn-info', 'id' => 'link-email-report']) }}
    </div>

    <div class="mb-5">
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
    </div>

    @include('modals.product_edit')

    @include('modals.delete_product')

    <canvas id="canvas"></canvas>
@endsection

@section('scripts')
    @include('js.scripts')
@endsection

