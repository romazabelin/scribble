<div>
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
</div>

<div class="card">
    <div class="card-body">
        {{ Form::text('', '', ['class' => 'form-control', 'id' => 'filter-val']) }}
        {{ Form::select('', $filterOptions, '', ['class' => 'form-control', 'id' => 'filter-key']) }}
        {{ Form::button(trans('translations.filter_btn'), ['class' => 'btn btn-info', 'id' => 'btn-apply-filter']) }}
    </div>
</div>

<div>
    {{ Html::link(route('transfer.export_data_to_xls'), trans('translations.email_report'), ['id' => 'link-email-report']) }}
</div>

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

<div id="modal-product-destroy" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('translations.destroy_product.modal_title') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ trans('translations.destroy_product.confirmation') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn-destroy-product">{{ trans('translations.destroy_product.modal_save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('translations.destroy_product.modal_close') }}</button>
            </div>
        </div>
    </div>
</div>

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

<canvas id="canvas"></canvas>

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        /*------------------chart start-------------------*/
        function initChart(labels, dataset) {
            if (window.myLine != undefined) {
                window.myLine.destroy();
            }

            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'My First dataset',
                        data: dataset,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                }
            };

            var ctx = document.getElementById("canvas").getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            window.myLine = new Chart(ctx, config);
        }


        function loadChartData() {
            $.ajax({
                type: 'GET',
                async: false,
                url: "{{ route('product.get_chart_data') }}",
                data: {
                    filter_val: $("#filter-val").val(),
                    filter_key: $("#filter-key option:selected").val()
                },
                success: function(response) {
                    var revenueTotalData = response.revenueTotalData;
                    var labels  = [];
                    var dataset = [];

                    for (var key in revenueTotalData) {
                        labels.push(key);
                        dataset.push(revenueTotalData[key]);
                    }

                    initChart(labels, dataset)
                }
            })
        }
        /*------------------chart end-------------------*/

        function loadListingData() {
            if ( $.fn.DataTable.isDataTable('#products-table') ) {
                $('#products-table').DataTable().destroy();
            }

            var listing = $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    async: false,
                    type: 'GET',
                    url: "{{ route('product.list') }}",
                    data: {
                        filter_val: $("#filter-val").val(),
                        filter_key: $("#filter-key option:selected").val()
                    }
                },
                //ajax: "{{ route('product.list') }}",
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

            //listing.ajax.reload();
        }

        function reloadData() {
            loadListingData();
            loadChartData();
        }

        reloadData();

        $('body').on('click', '#link-email-report', function() {
            var that = $(this);

            $.ajax({
                url: that.attr('href'),
                type: 'POST',
                data: {
                    filter_val: $("#filter-val").val(),
                    filter_key: $("#filter-key option:selected").val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.msg);
                }
            })

            return false;
        })

        $('body').on('click', '#btn-apply-filter', function() {
            reloadData();
        });


        $('body').on('click', '.destroy-product', function() {
            var url = $(this).attr('href');

            $('#modal-product-destroy').modal('show');
            $('#btn-destroy-product').attr('data-url', url);

            return false;
        })

        $('body').on('click', '#btn-destroy-product', function() {
            var url = $(this).attr('data-url');

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('.modal').modal('hide');

                    if (response.isSaved) {
                        alert(response.msg);
                        reloadData();
                    } else
                        alert(response.msg);
                }
            })
        })

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
                    $('.modal').modal('hide');

                    if (response.isSaved) {
                        alert(response.msg);
                        reloadData();
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