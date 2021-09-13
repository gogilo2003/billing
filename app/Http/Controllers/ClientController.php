<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use Validator;
use App;
use PDF;

class ClientController extends Controller
{
    public function index()
    {
    	$clients = Client::with('accounts.transactions','invoices.items')->get()->sortBy('balance');
    	return view('clients.index',compact('clients'));
    }

    public function getCreate()
    {
    	return view('clients.new');
    }

    public function postCreate(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    			'name'=>'required|unique:clients',
    			'phone'=>'unique:clients',
    			'email'=>'required|email|unique:clients',
    		]);

    	if ($validator->fails()) {
    		return redirect()
    				->back()
    				->withErrors($validator)
    				->withInput()
    				->with('global-warning','Some fields failed validation. Please check and try again');
    	}

    	$client = new Client;

    	$client->name 		= $request->input('name');
    	$client->email 		= $request->input('email');
    	$client->phone 		= $request->input('phone');
    	$client->box_no 	= $request->input('box_no');
    	$client->post_code 	= $request->input('post_code');
    	$client->town 		= $request->input('town');
    	$client->address 	= $request->input('address');

    	$client->save();

    	return redirect()
    			->route('clients')
    			->with('global-success','Account has been created');
    }

    public function getEdit($id)
    {
    	if ($client = Client::find($id)) {
    		return view('clients.edit',compact('client'));
    	}else{
    		return abort(404,'Client not found');
    	}

    }

    public function postUpdate(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    			'name'=>'required|unique:clients,name,'.$request->input('id'),
    			'phone'=>'unique:clients,phone,'.$request->input('id'),
    			'email'=>'required|email|unique:clients,email,'.$request->input('id'),
    		]);

    	if ($validator->fails()) {
    		return redirect()
    				->back()
    				->withErrors($validator)
    				->withInput()
    				->with('global-warning','Some fields failed validation. Please check and try again');
    	}

    	$client = Client::find($request->input('id'));

    	$client->name 		= $request->input('name');
    	$client->email 		= $request->input('email');
    	$client->phone 		= $request->input('phone');
    	$client->box_no 	= $request->input('box_no');
    	$client->post_code 	= $request->input('post_code');
    	$client->town 		= $request->input('town');
    	$client->address 	= $request->input('address');

    	$client->save();

    	return redirect()
    			->back()
    			->with('global-success','Account has been updated');
    }

    public function getView($id)
    {
    	$client = Client::with(['accounts.transactions','invoices.items', 'accounts'])->find($id);
    	return view('clients.view',compact('client'));
    }

    public function postDelete(Request $request)
    {
    	$client = Client::find($request->input('id'));

    	$client->delete();

    	return redirect()
    			->route('clients')
    			->with('global-success','Client Deleted');
    }

    public function downloadClient($id)
    {
        $client = Client::with('accounts.transactions')->find($id);
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('clients.download',compact('client'))->setOption('no-outline',true);
        return $pdf->setOption('margin-left',0)
                    ->setOption('margin-right',0)
                    ->setOption('margin-top',48)
                    ->setOption('margin-bottom',13)
                    ->setOption('header-html', public_path('pdf/header.html'))
                    ->setOption('footer-html', public_path('pdf/footer.html'))
                    ->download(str_slug($client->name).'.pdf');
    }

    public function downloadClients()
    {
        $clients = Client::with('accounts.transactions')->orderBy('name','ASC')->get();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOrientation('landscape');
        $pdf->loadView('clients.clients-download',compact('clients'));
        return $pdf->setOption('margin-left',0)
                    ->setOption('margin-right',0)
                    ->setOption('margin-top',48)
                    ->setOption('margin-bottom',13)->setOption('header-html', public_path('pdf/header.html'))
                    ->setOption('footer-html', public_path('pdf/footer.html'))
                    ->download('clients_'.time().'.pdf');
    }

}
