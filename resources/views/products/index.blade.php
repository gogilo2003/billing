@extends('layouts.app', ['pageSlug' => 'products'])

@section('title')
	Products
@endsection

@section('sidebar_left')
	@parent
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Products</h4>
			<p class="category">List of Products</p>
		</div>
		<div class="card-body">
			<table class="table table-hover table-striped" id="productsDataTable">
				<thead>
					<tr class="d-sm-table-row d-none">
						<th>#</th>
						<th>Category</th>
						<th>Name</th>
						<th class="text-right">Price</th>
						<th></th>
					</tr>
                </thead>
                <tbody>
                    <tr class="d-sm-table-row d-flex flex-column"></tr>
                </tbody>
			</table>
		</div>
    </div>
    @include('products.add')
    @include('products.categories')
@endsection

@section('navbar')
	<li class="nav-item"><a class="nav-link" href="JavaScript:" data-toggle="modal" data-target="#addProductModal"><i class="fas fa-plus-circle"></i> New Product</a></li>
	<li class="nav-item"><a class="nav-link" href="JavaScript:" data-toggle="modal" data-target="#productCategoriesModal"><i class="fas fa-folder-open"></i> Categories</a></li>
@endsection

@push('styles')
	<style>

	</style>
@endpush

@push('scripts_top')
	<script type="text/javascript">

	</script>
@endpush

@push('scripts_bottom')
    <!-- products.index -->
    <script type="text/javascript">
    let productsDataTable = null;
    $(document).ready(function(){
        productsDataTable = $('#productsDataTable').dataTable({
            ajax: '/api/products',
            "columns":[
                {"data":"id"},
                {"data":"category"},
                {"data":"name"},
                {"data":"price"}
            ],
            "columnDefs": [ {
                "targets":4,
                "data": null,
                "render": function(data, type, row){
                    let btnEdit = '<button class="btn btn-primary btn-sm rounded-pill editProductButton" data-row="'+row.id+'">EDIT</button>'
                    return btnEdit
                }
            } ]
        });

        $('#productsDataTable tbody').on( 'click', 'button.editProductButton', function (e) {
            console.log($(this).data('row'));
        } );
    })
	</script>
@endpush
