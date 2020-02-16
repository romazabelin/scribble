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
