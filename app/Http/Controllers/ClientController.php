<?php

namespace App\Http\Controllers;

use App;

use PDF;
use Validator;
use App\Models\Client;
use Illuminate\Http\Request;
use Ogilo\ApiResponseHelpers;
use App\Services\ClientService;
use App\Http\Resources\ClientResource;
use App\Http\Requests\V1\ClientViewRequest;
use App\Http\Requests\V1\ClientStoreRequest;
use App\Http\Requests\V1\ClientUpdateRequest;

class ClientController extends Controller
{
    use ApiResponseHelpers;

    public function index()
    {
        $clients = Client::with('accounts.transactions', 'invoices.items')->get()->sortBy('balance');
        return view('clients.index', compact('clients'));
    }

    public function getCreate()
    {
        return view('clients.new');
    }

    public function postCreate(ClientStoreRequest $request, ClientService $clientService)
    {

        // return response()->json($request->all());

        $client = $clientService->store(
            $request->name,
            $request->email,
            $request->phone,
            $request->box_no,
            $request->post_code,
            $request->town,
            $request->address
        );

        if ($request->wantsJson()) {
            return $this->storeSuccess("Client has been created", ['client' => ClientResource::make($client)]);
        }

        return redirect()
            ->route('clients')
            ->with('global-success', 'Client has been created');
    }

    public function getEdit($id)
    {
        if ($client = Client::find($id)) {
            return view('clients.edit', compact('client'));
        } else {
            return abort(404, 'Client not found');
        }
    }

    public function postUpdate(ClientUpdateRequest $request, ClientService $clientService)
    {

        $client = $clientService->update(
            $request->id,
            $request->name,
            $request->email,
            $request->phone,
            $request->box_no,
            $request->post_code,
            $request->town,
            $request->address
        );

        if ($request->wantsJson()) {
            return $this->updateSuccess("Client has been updated", ['client' => ClientResource::make($client)]);
        }
        return redirect()
            ->back()
            ->with('global-success', 'Client has been updated');
    }

    public function getView(ClientViewRequest $request)
    {
        $client = Client::with(['accounts.transactions', 'invoices.items', 'accounts'])->find($request->id);

        if (request()->wantsJson()) {
            return ClientResource::make($client);
        }

        return view('clients.view', compact('client'));
    }

    public function postDelete(Request $request)
    {
        $client = Client::find($request->input('id'));

        $client->delete();

        if ($request->wantsJson()) {
            return $this->deleteSuccess();
        }

        return redirect()
            ->route('clients')
            ->with('global-success', 'Client Deleted');
    }

    public function downloadClient($id)
    {
        $client = Client::with('accounts.transactions')->find($id);
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('clients.download', compact('client'))->setOption('no-outline', true);
        return $pdf->setOption('margin-left', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-top', 48)
            ->setOption('margin-bottom', 13)
            ->setOption('header-html', public_path('pdf/header.html'))
            ->setOption('footer-html', public_path('pdf/footer.html'))
            ->download(str_slug($client->name) . '.pdf');
    }

    public function downloadClients()
    {
        $clients = Client::with('accounts.transactions')->orderBy('name', 'ASC')->get();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOrientation('landscape');
        $pdf->loadView('clients.clients-download', compact('clients'));
        return $pdf->setOption('margin-left', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-top', 48)
            ->setOption('margin-bottom', 13)->setOption('header-html', public_path('pdf/header.html'))
            ->setOption('footer-html', public_path('pdf/footer.html'))
            ->download('clients_' . time() . '.pdf');
    }
}
