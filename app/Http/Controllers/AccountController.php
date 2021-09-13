<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App;
use PDF;

use App\Models\Account;
use App\Models\Client;
use App\Models\Transaction;

class AccountController extends Controller
{
    public function index($client_id = null)
    {
    	$accounts = [];
        $client = null;

        // dd($client_id);

    	if ($client_id) {
            $client = Client::with('accounts')->find($client_id);
            $accounts = $client->accounts;
    	} else {
    		$accounts = Account::with(['client'])->get()->sortBy('balance');
    	}
    	// dd($accounts);
    	return view('accounts.index',compact('accounts','client'));
    }

    public function getCreate($client_id = null)
    {
        return view('accounts.new');
    }

    public function postCreate(Request $request)
    {

        $validator = Validator::make($request->all(),[
                'client'=>'required|integer',
                'name'=>'required|unique:accounts,name,null,id,client_id,'.$request->input('client')
            ]);

        if ($validator->fails()) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('global-warning','Some fields failed validation. Please check and try again');
        }

        $client = Client::find($request->input('client'));

        // dd($client);

        $account = new Account;
        $account->name = $request->input('name');

        $client->accounts()->save($account);

        return redirect()
                ->route('accounts',$request->input('client'))
                ->with('global-success','Account created successfully');
    }

    public function getTransaction($account_id = null)
    {
        return view('accounts.transaction',compact('account_id'));
    }

    public function postTransaction(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(),[
                'type'=>'required',
                'account'=>'required|integer',
                'particulars'=>'required',
                'amount'=>'required|numeric',
            ]);

        if ($validator->fails()) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('global-warning','Some fields failed validation. Please check and try again');
        }

        $account = Account::find($request->account);

        $this->transact($account,$request->particulars,$request->type,$request->amount,$request->method);

        return redirect()
                ->route('accounts-view',$account->id)
                ->with('global-success','Transaction posted successfully');
    }

    public function getView($account_id)
    {
        $account = Account::with(['transactions'=>function($query){
            return $query->orderBy('created_at','DESC');
        }])->find($account_id);
        return view('accounts.view',compact('account'));
    }

    public function getEdit($account_id)
    {
        $account = Account::with('transactions')->find($account_id);
        return view('accounts.edit',compact('account'));
    }

    public function postUpdate(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'client'=>'required|integer',
                'name'=>'required|unique:accounts,name,'.$request->input('client').',client_id'
            ]);

        if ($validator->fails()) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('global-warning','Some fields failed validation. Please check and try again');
        }

        $account = Account::find($request->input('id'));

        $account->name = $request->input('name');
        $account->client_id = $request->input('client');

        $account->save();

        return redirect()
                ->route('accounts',$request->input('client'))
                ->with('global-success','Account updated successfully');
    }

    public static function transact($account, $particulars, $type, $amount, $method=null){

        $transaction = new Transaction;

        $transaction->particulars   = $particulars;
        $transaction->type          = $type;
        $transaction->amount        = $amount;
        $transaction->method        = $method;

        $account->transactions()->save($transaction);
    }

    public function downloadAccount($id)
    {
        try {
            $account = Account::with(['client','transactions'=>function($query){
                return $query->orderBy("created_at","DESC");
            }])->find($id);
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadView('accounts.download',compact('account'));
            return $pdf->setOption('no-outline',true)
                        ->setOption('margin-left',0)
                        ->setOption('margin-right',0)
                        ->setOption('margin-top',48)
                        ->setOption('margin-bottom',13)
                        ->setOption('header-html', public_path('pdf/header.html'))
                        ->setOption('footer-html', public_path('pdf/footer.html'))
                        ->download("Account#".str_pad($account->id, 4,'0',0).'.pdf');
        } catch (\Exception $e) {
            return response($e);
        }

    }
}
