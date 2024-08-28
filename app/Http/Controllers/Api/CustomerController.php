<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        // Using DB transaction to ensure atomicity
        $customer = DB::transaction(function () use ($request) {
            return Customer::create([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'dob'           => $request->dob,
                'email'         => $request->email,
                'age'           => Carbon::parse($request->dob)->age,
                'creation_date' => Carbon::now()
            ]);
        });

        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Return the specific customer as a resource
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        DB::transaction(function () use ($request, $customer) {
            $customer->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'dob'           => $request->dob,
                'email'         => $request->email,
                'age'           => Carbon::parse($request->dob)->age,
            ]);
        });

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        DB::transaction(function () use ($customer) {
            $customer->delete();
        });

        return response()->json(null, 204);
    }
}
