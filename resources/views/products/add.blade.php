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
                <div class="form-group">
                    <label for="price">Product Price</label>
                    <input id="price" class="form-control" type="number" name="price">
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success rounded-pill" type="href" id="addProductButton"><i class="far fa-save"></i> Save</a>
                <button class="btn btn-danger rounded-pill" data-dismiss="modal" type="button"><i class="far fa-times-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
<!-- products.add -->
<script type="text/javascript">
    $('#addProductModal').on('show.bs.modal',function(){
        $.get('{{ url('api/categories') }}').then(function(response){
            let list = document.querySelector('#addProductModal #category')
            list.innerHTML = null
            // console.log(response)
            response.categories.forEach(function(item,index) {
                let option = document.createElement('option')
                option.value = item.id
                option.appendChild(document.createTextNode(item.name))
                list.appendChild(option)
            })
        })
    })

    document.getElementById('addProductButton').addEventListener('click',function (e) {

        let code = document.querySelector('#addProductModal #code').value
        let name = document.querySelector('#addProductModal #name').value
        let category = document.querySelector('#addProductModal #category').value
        let price = document.querySelector('#addProductModal #price').value

        let data = {
            'code':code,
            'name':name,
            'category':category,
            'price':price,
            '_token':token
        }

        $.post('{{ route('products-create') }}',data).then(function(response){
            // console.log(productsDataTable)

            $('#productsDataTable').DataTable().ajax.reload()

            document.querySelector('#addProductModal #code').value = null
            document.querySelector('#addProductModal #name').value = null
            document.querySelector('#addProductModal #category').value = null
            document.querySelector('#addProductModal #price').value = null

            $('#addProductModal').modal('hide')
        },function(error){
            console.log(error.responseJSON.message)
        })
    })
</script>
@endpush
