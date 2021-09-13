@extends('layouts.pdf')

@section('title')
	RECEIPT
@endsection

@section('content')
    <div class="mb-3">
        <div style="width: 49%" class="d-inline-block"><b>Date: </b> {{ $transaction->receipt_date }}</div>
        <div style="width: 49%" class="d-inline-block text-right"><b>Receipt No: </b> #{{ $transaction->receipt_no }}</div>
    </div>
    <p><b>Received From </b><span class="underline">{{ $transaction->account->client->name }}</span> the amount of <span class="underline">Kenya shillings {{ $transaction->amount_word }} only(Kshs {{ number_format($transaction->amount,2) }}/-)</span> being payment for <span class="underline">{{ $transaction->particulars }}</span></p>

    <p><b>Payment method: </b>{{ $transaction->method }}</p>
@endsection


@push('styles')
    <style>
        .underline{
            border-bottom: 1px solid #000;
            font-style: italic;
        }
        .receipt-title{
            width: 100px;
            margin: 0 auto;
            text-align: center;
            padding: .5rem 1rem;
        }
    </style>
@endpush

