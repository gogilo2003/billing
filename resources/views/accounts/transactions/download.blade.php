<html>

<head>
    <title>Receipt</title>
    <style>
        {{ file_get_contents(public_path('css/receipt.css')) }}

    </style>
</head>

<body>
    <div class="receipt">
        <div class="logo">
            <img src="data:image/png;base64,{{ file_get_contents(public_path('logo.txt')) }}" alt="logo" />
        </div>
        <div class="address">
            <div class="email">{{ config('app.email') }}</div>
            <div class="phone">{{ config('app.phone') }}</div>
            <div class="postal_address">{{ config('app.address') }}</div>
        </div>
        <div class="text-center title">RECEIPT</div>
        <div class="from">
            <div class="caption">FROM</div>
            <div class="value">{{ $transaction->account->client->name }}</div>
        </div>
        <div class="amount">
            <div class="number">Kshs {{ number_format($transaction->amount, 2) }}</div>
            <div class="word">Kenya shillings {{ $transaction->amount_word }}</div>
            <div class="method">{{ $transaction->method }}</div>
        </div>
        <div class="particulars">
            <div class="caption">Being payment for</div>
            <div class="value">{{ $transaction->particulars }}</div>
        </div>
        <div class="receipt_number">
            <div class="number">
                <div class="caption">Receipt Number</div>
                <div class="value">#{{ $transaction->id }}</div>
            </div>
            <div class="barcode"><img src="{{ $transaction->barcode }}" /></div>
        </div>
    </div>
</body>

</html>
