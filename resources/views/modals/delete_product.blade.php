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
