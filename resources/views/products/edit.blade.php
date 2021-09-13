<div id="addProductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-product-title" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-product-title">Add Product</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="code">Product Code</label>
                    <input id="code" class="form-control" type="text" name="">
                </div>
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input id="name" class="form-control" type="text" name="name">
                </div>
                <div class="form-group">
                    <label for="category">Product Category</label>
                    <select id="category" class="custom-select" name="category">
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success rounded-pill" type="href"><i class="far fa-save"></i> Save</a>
                <button class="btn btn-danger rounded-pill" data-dismiss="modal" type="button"><i class="far fa-times-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
<script>
    $('#addProductModal').on('show.bs.modal',function(){
        $.get('{{ url('api/categories') }}').then(function(response){
            response.forEach(function(item,index) {
                console.log(index)
            })
        })
    })
</script>
@endpush
