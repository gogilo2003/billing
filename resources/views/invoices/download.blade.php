@extends('layouts.pdf')

@section('title')
	Invoice
@endsection

@section('content')
	<div>
		<div>
			<table style="width: 100%">
				<tr>
					<td valign="top" width="50%">
						<p class="category">
						    <b style="color: #116AC3">INVOICE TO:</b><br>
						    {{ $invoice->client->name }}<br>
						    P.O. Box {{ $invoice->client->box_no.($invoice->client->post_code? ' - '.$invoice->client->post_code : '').($invoice->client->town ? ', '.$invoice->client->town : '') }}<br>
						    {{ $invoice->client->email }}, {{ $invoice->client->phone }}
					    </p>
					</td>
					<td valign="top" width="50%">
						<p class="category">
                            <b style="color: #116AC3">FOR:</b>
                            <br>{{ $invoice->name }}
                        </p>
					</td>
				</tr>
			</table>
			<hr>
		</div>

		<div class="">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th style="width: 400px">Particulars</th>
						<th class="text-right">Price</th>
						<th class="text-center">Quantity</th>
						<th class="text-right">Amount</th>
					</tr>
				</thead>
				<tbody>
				@foreach($invoice->items as $item)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $item->particulars }}</td>
						<td class="text-right">KES {{ number_format($item->price,2) }}</td>
						<td class="text-center">{{ $item->quantity }}</td>
						<td class="text-right">KES {{ number_format($item->amount(),2) }}</td>
					</tr>
				@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td class="text-right" colspan="4" style="font-weight:bold;">
							TOTAL
						</td>
						<td style="font-weight: bold; font-size: 1.1em" class="text-right">KES {{ number_format($invoice->amount(),2) }}</td>
					</tr>
				</tfoot>
			</table>
			<div class="invoice-footer">
				<p class="category">Make all cheques payable to {{ config("app.name") }}.
				<br>All prices inclusive of {{ config("app.vat") }} VAT</p>
			</div>
		</div>
	</div>
@endsection

@push('styles')
	<style>
		.card{
			box-shadow: 0 0px 0px #fff, 0 0 0 0px #fff;
			border-color: #fff;
		}
		.card .card-footer{
		    font-size: 11px;
		}
	</style>
@endpush
