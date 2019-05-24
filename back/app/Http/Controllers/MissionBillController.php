<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Http\Resources\MissionResource;
use App\Models\Application;
use App\Models\Bill;
use App\Models\Mission;

class MissionBillController extends Controller
{
    /**
     * Store or update the specified resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(BillRequest $request, $mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $this->authorize('update', [Bill::class, $mission]);

        $applications_request = $request->only('applications')['applications'];

        foreach ($applications_request as $application_request) {
            $application = Application::find($application_request['application_id']);

            if ($application && $mission->applicationsWhoseStatusIs('accepted')->contains($application)) {
                foreach ($application_request['bills'] as $bill_request) {
                    if ($bill_request['id']) {
                        // If bill exists, update it
                        $bill = Bill::find($bill_request['id']);

                        if ($bill && $bill->application_id == $application->id) {
                            $bill->update($bill_request);
                        }
                    } else {
                        // If bill does not exist, create it
                        $bill = Bill::create($bill_request);
                        $application->bills()->save($bill);
                    }
                }
            }
        }

        return response()->json(MissionResource::make($mission->load('applications.bills')));
    }
}
