<div id="productCategoriesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-product-categories-title" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-product-categories-title">Product Categories</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12 p-md-1">
                        <label for="name">Product Category Name</label>
                    </div>
                    <div class="form-group col-md-9 p-md-1">
                        <input id="name" class="form-control" type="text" name="name">
                    </div>
                    <div class="col-md-3 p-md-1">
                        <button id="saveCategoryButton" class="btn btn-primary btn-sm rounded-pill w-100" type="button"><i class="far fa-save"></i> SAVE</button>
                    </div>
                    <div class="col-md-12 p-md-1">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="categories_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger rounded-pill" data-dismiss="modal" type="button"><i class="far fa-times-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
<script>
    let editCategory = 0;
    let editCategoryId = null;
    let pUrl = ['{{ route('product_categories-create') }}','{{ route('product_categories-update') }}']
    let categoriesList = document.getElementById('categories_list')

    $('#productCategoriesModal').on('show.bs.modal',function(){
        $.get('{{ url('api/categories') }}').then(function(response){
            if (response.success) {
                categoriesList.innerHTML = null
                response.categories.forEach(function(item,index) {
                    setCategoryItem(item,index)
                })
            }

        })
    })

    $('#saveCategoryButton').click(function(){
        let formData = {
            name : $('#productCategoriesModal #name').val(),
            _token : token
        }
        $.ajax({
            url: pUrl[editCategory],
            type: 'post',
            data: formData
        }).then(function(response){
            if (response.success) {
                showNotification(response.message)
                setCategoryItem(response.category)
                $('#productCategoriesModal #name').val(null)
                editCategory = 0;
                editCategoryId = null
            }else{
                showNotification(response.message,'fas fa-exclamation-triangle',4)
            }
        })
    })

    function setCategoryItem(category,index = null) {
        index = index ? index : categoriesList.childNodes.length
        let row = document.createElement('tr')

        let c0 = document.createElement('td')
        c0.appendChild(document.createTextNode(index))
        row.appendChild(c0)

        let c1 = document.createElement('td')
        c1.appendChild(document.createTextNode(category.name))
        row.appendChild(c1)

        let c2 = document.createElement('td')
        c2.className = 'text-right'

        let btnEdit = document.createElement('a')
        btnEdit.setAttribute('href','JavaScript:')
        btnEdit.className = 'btn btn-success btn-sm rounded-pill'
        btnEdit.appendChild(document.createTextNode('EDIT'))
        btnEdit.setAttribute('data-id',category.id)
        btnEdit.addEventListener('click', function(e){
            editCategoryId = this.getAttribute('data-id')
            editCategory = 1
        })
        c2.appendChild(btnEdit)

        let btnDelete = document.createElement('a')
        btnDelete.setAttribute('href','JavaScript:')
        btnDelete.className = 'btn btn-danger btn-sm rounded-pill'
        btnDelete.appendChild(document.createTextNode('DELETE'))
        btnDelete.setAttribute('data-id',category.id)
        btnDelete.setAttribute('id','deleteButton_'+category.id)
        btnDelete.addEventListener('click', function(e){
            editCategoryId = this.getAttribute('data-id')
            $.ajax({
                url: '{{ route('product_categories-delete') }}',
                type: 'post',
                data: {
                    _token: token,
                    id: editCategoryId
                }
            }).then(function(response){
                if (response.success) {
                    showNotification(response.message)
                    let row = document.getElementById('deleteButton_'+editCategoryId).parentNode.parentNode
                    $('#productCategoriesModal #name').val(null)
                    editCategory = 0;
                    editCategoryId = null
                }else{
                    showNotification(response.message,'fas fa-exclamation-triangle',4)
                }
            })
        })
        c2.appendChild(btnDelete)

        row.appendChild(c2)

        categoriesList.appendChild(row)
    }
</script>
@endpush
