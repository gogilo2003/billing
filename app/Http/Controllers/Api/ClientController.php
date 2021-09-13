<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function creatClient(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    			'name' => 'required',
    			'email' => 'email|unique:clients',
    		]);

    	if ($validator->fails()) {
    		return redirect()
    				->back()
    				->withErrors($validator)
    				->withInput()
    				->with('message');
    	}
    }


    function updateNotification(Request $request){
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:clients'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $account = Client::find($request->id);
        $account->notification = $account->notification ? 0 : 1;
        $account->save();

        return response()->json([
            'success'=>true,
            'notification'=>$account->notification,
            "message"=>'Notification changed successfuly'
        ]);
    }

    function showNotification(Request $request){
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:clients'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $account = Client::find($request->id);

        return response()->json([
            'success'=>true,
            'notification'=>$account->notification,
            "message"=>'Current nottification status'
        ]);
    }
}
