@extends('layouts.app', ['pageSlug' => 'clients'])

@section('title')
	Clients
@endsection

@section('sidebar_left')
	@parent
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
	        <div class="card">
	            <div class="card-header">
	                <h4 class="cart-title">Clients</h4>
	                <p class="category">List of all registered clients</p>
	            </div>
	            <div class="card-body">
	                <table class="table table-hover table-striped" id="clientsDataTable">
	                    <thead>
                            <tr class="d-sm-table-row d-none">
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Balance</th>
                                <th></th>
                            </tr>
	                    </thead>
	                    <tbody>
	                        @foreach($clients as $client)
	                        <tr class="d-sm-table-row d-flex flex-column">
	                        	<td>{{ $loop->iteration }}</td>
	                        	<td>{{ strtoupper($client->name) }}</td>
	                        	<td>{{ $client->phone }}</td>
	                        	<td>Kshs {{ number_format($client->balance,2) }}</td>
	                        	<td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary rounded-pill dropdown-toggle btn-sm" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-tools"></i>
                                            Manage
                                        </button>
                                        <div class="dropdown-menu dropdown-primary">
                                            <a href="{{ route('clients-edit',$client->id) }}" class="dropdown-item"><i class="fas fa-edit"></i>&nbsp;Edit</a>
                                            <a href="{{ route('clients-view',$client->id) }}" class="dropdown-item"><i class="fas fa-th"></i>&nbsp;View</a>
                                            <a href="{{ route('clients-download',$client->id) }}" class="dropdown-item"><i class="fas fa-file-download"></i>&nbsp;Download</a>
                                            <a href="{{ route('accounts',$client->id) }}" class="dropdown-item"><i class="fas fa-university"></i>&nbsp;Accounts</a>
                                            <a href="{{ route('invoices',$client->id) }}" class="dropdown-item"><i class="fas fa-file-invoice"></i>&nbsp;Invoices</a>
                                            <a href="javascript:deleteClient" class="dropdown-item"><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                        </div>
                                    </div>

	                        	</td>
	                        </tr>
	                        @endforeach
	                    </tbody>
	                </table>

	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('navbar')
	@parent
	<li class="nav-item">
        <a class="nav-link" href="{{ route('clients-create') }}">
            <i class="fas fa-plus-circle"></i>
			New Client
		</a>
	</li>
	<li class="nav-item">
        <a class="nav-link" href="{{ route('accounts') }}">
            <i class="fas fa-university"></i>
			Accounts
		</a>
	</li>
	<li class="nav-item">
        <a class="nav-link" href="{{ route('invoices') }}">
            <i class="fas fa-file-invoice"></i>
			Invoices
		</a>
	</li>
	<li class="nav-item">
        <a class="nav-link" href="{{ route('clients-clients-download') }}">
            <i class="fas fa-file-download"></i>
			Download
		</a>
	</li>
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
	<script type="text/javascript">
		$('#clientsDataTable').dataTable()
	</script>
@endpush
