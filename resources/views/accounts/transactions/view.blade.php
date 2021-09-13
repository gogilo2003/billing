<div id="viewTransactionModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger">Close</button>
                <a href="{{ route('accounts-transactions-download',1) }}" class="btn btn-primary">Download</a>
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
    <script>
        $('#viewTransactionModal').on('show.bs.modal',function(e){
            let transaction = JSON.parse(e.relatedTarget.getAttribute('data-transaction'))
            $('#viewTransactionModal .modal-footer a').attr('href','/accounts/transactions/download/'+transaction.id)

            let body = `
                <div class="text-right">RECEIPT</div>
                <div class="my-3">
                    <div style="width: 49%" class="d-inline-block"><b>Date: </b> ${transaction.receipt_date}</div>
                    <div style="width: 49%" class="d-inline-block text-right"><b>Receipt No: </b> ${transaction.receipt_no}</div>
                </div>
                <p><b>Received From </b><span class="underline">${transaction.account.client.name}</span> the amount of <span class="underline">Kenya shillings ${transaction.amount_word} only(Kshs ${transaction.amount}/-)</span> being payment for <span class="underline">${transaction.particulars}</span></p>

                <p><b>Payment method: </b>${transaction.method}</p>
            `
            $('#viewTransactionModal .modal-body').html(body)

        })
    </script>
@endpush

@push('styles')
    <style>
        .underline{
            border-bottom: 1px solid #000;
        }
    </style>
@endpush
