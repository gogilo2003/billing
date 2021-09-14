<?php

namespace App\Http\Controllers\Api;

use App\Models\Domain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::all();
        return response()->json($domains);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'domain'=>'required|unique:domains,domain',
            "registered_on"=>"required|date",
            "expires_on"=>"required|date",
        ]);
        if($validator->fails()){
            return response()->json([
                "success"=>false,
                "message"=>"Validation Error",
                "details"=>$validator->errors()
            ],415);
        }
        $domain = new Domain;
        $domain->domain = $request->domain;
        $domain->registered_on = $request->registered_on;
        $domain->expires_on = $request->expires_on;
        $domain->remarks = $request->remarks;
        $domain->save();

        return response()->json([
            "success"=>true,
            "message"=>"Domain Created",
            "domain"=>$domain
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $domain = Domain::find($request->id);
        $domain->domain = $request->domain;
        $domain->registered_on = $request->registered_on;
        $domain->expires_on = $request->expires_on;
        $domain->remarks = $request->remarks;
        $domain->save();

        return response()->json([
            "success"=>true,
            "message"=>"Domain Updated",
            "domain"=>$domain
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
