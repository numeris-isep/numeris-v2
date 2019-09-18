<?php

namespace App\Http\Controllers;

use App\Calculator\InvoiceCalculator;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectInvoiceController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $project_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id, InvoiceCalculator $calculator)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('update-invoice', $project);

        $result = $calculator->calculate($project);
        $invoice = Invoice::updateOrCreate(['project_id' => $result['project_id']], $result);

        return response()->json(InvoiceResource::make($invoice->load('project')));
    }
}
