<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Ogilo\ApiResponseHelpers;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AccountController;

class InvoiceController extends Controller
{
    use ApiResponseHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('client', 'items')->orderBy('created_at', 'DESC')->paginate(5);
        return InvoiceResource::collection($invoices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = Account::find($request->account);
        $client_id = $account->client_id;
        $validator = Validator::make($request->all(), [
            'account' => 'required|integer|exists:accounts,id',
            'name' => ['required', Rule::unique('invoices', 'name')->where(function ($query) use ($client_id) {
                return $query->where('client_id', $client_id);
            })],
            'details' => 'required|min:1',
            'details.*.particulars' => 'required',
            'details.*.price' => 'required|numeric',
            'details.*.quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $invoice = new Invoice;

        $invoice->name = $request->name;
        $invoice->client_id = $account->client_id;

        $invoice->save();

        foreach ($request->details as $detail) {

            $item = new InvoiceDetail();

            $item->particulars = $detail['particulars'];
            $item->price = $detail['price'];
            $item->quantity = $detail['quantity'];

            $invoice->items()->save($item);
        }

        AccountController::transact($account, $invoice->name, 'DR', $invoice->amount());

        $invoice->load('items');

        return $this->storeSuccess('Invoice Stored', ['invoice' => new InvoiceResource($invoice)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|exists:invoices']);
        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        return new InvoiceResource(Invoice::with('items', 'client')->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $account = Account::find($request->account);
        $client_id = $account->client_id;
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:invoices,id',
            'account' => 'required|integer|exists:accounts,id',
            'name' => ['required', Rule::unique('invoices', 'name')->where(function ($query) use ($client_id) {
                return $query->where('client_id', $client_id);
            })->ignore($request->id)],
            'details' => 'required|min:1',
            'details.*.id' => 'nullable|integer|exists:invoice_details,id',
            'details.*.particulars' => 'required',
            'details.*.price' => 'required|numeric',
            'details.*.quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $account = Account::find($request->account);

        $invoice = Invoice::find($request->id);
        $old_name = $invoice->name;

        $invoice->name = $request->name;
        $invoice->client_id = $account->client_id;

        $invoice->save();

        foreach ($request->details as $detail) {
            $item = null;
            if (isset($detail['id'])) {
                $item = InvoiceDetail::find($detail['id']);
            } else {
                $item = new InvoiceDetail();
            }

            $item->particulars = $detail['particulars'];
            $item->price = $detail['price'];
            $item->quantity = $detail['quantity'];

            $invoice->items()->save($item);
        }

        AccountController::transact($account, $invoice->name, 'DR', $invoice->amount());

        $invoice->load('items');

        return $this->storeSuccess('Invoice Stored', ['invoice' => new InvoiceResource($invoice)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|exists:invoices']);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $invoice = Invoice::with();
    }
}
