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
     * @api {get} /api/customers Get List of Customers
     * @apiName GetCustomers
     * @apiGroup Customers
     *
     * @apiSuccess {Object[]} customers List of customer objects.
     * @apiSuccess {Number} customers.id Customer ID.
     * @apiSuccess {String} customers.first_name Customer's first name.
     * @apiSuccess {String} customers.last_name Customer's last name.
     * @apiSuccess {String} customers.dob Customer's date of birth.
     * @apiSuccess {String} customers.email Customer's email address.
     * @apiSuccess {Number} customers.age Customer's age.
     * @apiSuccess {String} customers.creation_date Customer creation date.
     *
     * @apiError {String} error Error message if retrieval fails.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *       "error": "Could not retrieve customers."
     *     }
     */
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * @api {post} /api/customers Create a New Customer
     * @apiName CreateCustomer
     * @apiGroup Customers
     *
     * @apiBody {String} first_name Customer's first name.
     * @apiBody {String} last_name Customer's last name.
     * @apiBody {String} dob Customer's date of birth (format: YYYY-MM-DD).
     * @apiBody {String} email Customer's email address.
     *
     * @apiSuccess {Object} customer Created customer object.
     * @apiSuccess {Number} customer.id Customer ID.
     * @apiSuccess {String} customer.first_name Customer's first name.
     * @apiSuccess {String} customer.last_name Customer's last name.
     * @apiSuccess {String} customer.dob Customer's date of birth.
     * @apiSuccess {String} customer.email Customer's email address.
     * @apiSuccess {Number} customer.age Customer's age.
     * @apiSuccess {String} customer.creation_date Customer creation date.
     *
     * @apiError {Object} error Validation errors.
     * @apiErrorExample {json} Validation Error:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "error": {
     *         "email": ["The email has already been taken."],
     *         "dob": ["The dob field is required."]
     *       }
     *     }
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
     * @api {get} /api/customers/:id Get Customer Details
     * @apiName GetCustomer
     * @apiGroup Customers
     *
     * @apiParam {Number} id Customer's unique ID.
     *
     * @apiSuccess {Object} customer Customer object.
     * @apiSuccess {Number} customer.id Customer ID.
     * @apiSuccess {String} customer.first_name Customer's first name.
     * @apiSuccess {String} customer.last_name Customer's last name.
     * @apiSuccess {String} customer.dob Customer's date of birth.
     * @apiSuccess {String} customer.email Customer's email address.
     * @apiSuccess {Number} customer.age Customer's age.
     * @apiSuccess {String} customer.creation_date Customer creation date.
     *
     * @apiError {String} error Error message if customer not found.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "Customer not found."
     *     }
     */
    public function show(Customer $customer)
    {
        // Return the specific customer as a resource
        return new CustomerResource($customer);
    }

    /**
     * @api {put} /api/customers/:id Update Customer Details
     * @apiName UpdateCustomer
     * @apiGroup Customers
     *
     * @apiParam {Number} id Customer's unique ID.
     * @apiBody {String} first_name Customer's first name.
     * @apiBody {String} last_name Customer's last name.
     * @apiBody {String} dob Customer's date of birth (format: YYYY-MM-DD).
     * @apiBody {String} email Customer's email address.
     *
     * @apiSuccess {Object} customer Updated customer object.
     * @apiSuccess {Number} customer.id Customer ID.
     * @apiSuccess {String} customer.first_name Customer's first name.
     * @apiSuccess {String} customer.last_name Customer's last name.
     * @apiSuccess {String} customer.dob Customer's date of birth.
     * @apiSuccess {String} customer.email Customer's email address.
     * @apiSuccess {Number} customer.age Customer's age.
     *
     * @apiError {Object} error Validation errors.
     * @apiErrorExample {json} Validation Error:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "error": {
     *         "email": ["The email must be a valid email address."]
     *       }
     *     }
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
     * @api {delete} /api/customers/:id Delete a Customer
     * @apiName DeleteCustomer
     * @apiGroup Customers
     *
     * @apiParam {Number} id Customer's unique ID.
     *
     * @apiSuccess {Null} null No content indicating successful deletion.
     *
     * @apiError {String} error Error message if customer not found or deletion fails.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "Customer not found."
     *     }
     */
    public function destroy(Customer $customer)
    {
        DB::transaction(function () use ($customer) {
            $customer->delete();
        });

        return response()->json(null, 204);
    }
}
