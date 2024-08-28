@extends('layouts.auth')

@section('content')
    <div class="flex min-h-full flex-col px-6 py-12 lg:px-8">

        <div class=" mb-4">
            Edit Customer
        </div>

        <div class="overflow-x-auto">

            <form id="editCustomerForm" class="space-y-6">
                @csrf

                <div>
                  <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                  <div class="mt-2">
                    <input id="first_name" name="first_name" type="text" autocomplete="first_name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div>
                  <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                  <div class="mt-2">
                    <input id="last_name" name="last_name" type="text" autocomplete="last_name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                    <div class="mt-2">
                      <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                  </div>

                <div>
                  <label for="dob" class="block text-sm font-medium leading-6 text-gray-900">Date of Birth</label>
                  <div class="mt-2">
                    <input id="dob" name="dob" max="{{ date('Y-m-d') }}" type="date" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div class="flex gap gap-2">
                  <button type="submit" class="flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold border-solid leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Save
                  </button>

                  <a href="{{ route('customers.index') }}" class="inline-block rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                  </a>
                </div>
              </form>

        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">

        let customerId = 0;
        let first_name = document.getElementById('first_name');
        let last_name = document.getElementById('last_name');
        let email = document.getElementById('email');
        let dob = document.getElementById('dob');

        document.addEventListener('DOMContentLoaded', function() {
            const authToken = localStorage.getItem('authToken');

            if (!authToken) {
                window.location.href = '/login';
            }

            const path = window.location.pathname;

            const pathSegments = path.split('/');

            customerId = pathSegments[pathSegments.length - 2];

            axios.get(`/api/customers/${customerId}`)
            .then(response => {
                const customer = response.data.data;

                first_name.value = customer.first_name;
                last_name.value = customer.last_name;
                email.value = customer.email;

                const dobDate = new Date(customer.dob);
                const dobFormatted = dobDate.toISOString().split('T')[0]; // Convert to YYYY-MM-DD
                dob.value = dobFormatted;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong!');
            });
        });

        document.getElementById('editCustomerForm').addEventListener('submit', function(event) {
            event.preventDefault();

            axios.put(`/api/customers/${customerId}`, {
                first_name: first_name.value,
                last_name: last_name.value,
                email: email.value,
                dob: dob.value,
            })
            .then(response => {
                console.log('Success:', response.data);

                alert('Customer successfully added!');

                window.location.href = '/customers';

            })
            .catch(error => {
                console.error('Error:', error.response);
            });
        });
    </script>
@endsection
