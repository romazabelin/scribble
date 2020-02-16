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
