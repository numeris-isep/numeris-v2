<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Client;
use App\Models\Invoice;

class ClientInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index($client_id)
    {
        $client = Client::findOrFail($client_id);
        $this->authorize('index', Invoice::class);

        return response()->json(InvoiceResource::collection($client->invoices->load('project')));
    }
}
