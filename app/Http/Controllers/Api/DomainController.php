<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
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
        $expired = Domain::where('expires_on', '<', now())
                    ->orderBy('expires_on', 'ASC');

        $domains = Domain::where('expires_on', '>=', now())
                    ->orderBy('expires_on', 'DESC')
                    ->union($expired)
                    ->paginate(5);

        return response()->json($domains);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain' => 'required|unique:domains,domain',
            'registered_on' => 'required|date',
            'expires_on' => 'required|date',
            'client_id' => 'required|exists:clients,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'details' => $validator->errors(),
            ], 415);
        }
        $domain = new Domain();
        $domain->domain = $request->domain;
        $domain->registered_on = $request->registered_on;
        $domain->expires_on = $request->expires_on;
        if ($request->remarks) {
            $domain->remarks = $request->remarks;
        }
        $domain->client_id = $request->client_id;
        $domain->status = $request->status;
        $domain->save();

        return response()->json([
            'success' => true,
            'message' => 'Domain Created',
            'domain' => $domain,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:domains',
            'domain' => 'required|unique:domains,domain,'.$request->id,
            'registered_on' => 'required|date',
            'expires_on' => 'required|date',
            'client_id' => 'required|exists:clients,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'details' => $validator->errors(),
            ], 415);
        }

        $domain = Domain::find($request->id);
        $domain->domain = $request->domain;
        $domain->registered_on = $request->registered_on;
        $domain->expires_on = $request->expires_on;
        if ($request->remarks) {
            $domain->remarks = $request->remarks;
        }
        $domain->client_id = $request->client_id;
        $domain->status = $request->status;
        $domain->save();

        return response()->json([
            'success' => true,
            'message' => 'Domain Updated',
            'domain' => $domain,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function status()
    {
        return response()->json(['active', 'expired']);
    }
}
