@extends('layouts.auth')

@section('content')
    <div class="flex min-h-full flex-col px-6 py-12 lg:px-8">

        <div class="text-right mb-4">
            <a href="{{ route('customers.create') }}" class="rounded-md bg-indigo-600 px-3 py-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-500">
                        <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">First Name</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Last Name</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Date of Birth</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Age</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="customer-table-body"></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const authToken = localStorage.getItem('authToken');

            if (!authToken) {
                window.location.href = '/login';
            }

            axios.get('/api/customers')
            .then(response => {
                populateTable(response.data)
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something wen wrong!');
            });
        });

        const populateTable = (response) => {
            const tableBody = document.getElementById('customer-table-body');
            const customers = response.data;

            const tableRow = (data) => {
                // Correctly access data.dob
                const dobDate = new Date(data.dob);
                const dobFormatted = `${dobDate.getMonth() + 1}/${dobDate.getDate()}/${dobDate.getFullYear()}`;

                return `
                    <tr id="customer-${data.id}">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">${data.first_name}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${data.last_name}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${data.email}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${dobFormatted}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${data.age}</td>
                        <td class="px-6 py-4 text-sm font-medium text-blue-600 hover:text-blue-500 flex justify-between">
                            <a href="/customers/${data.id}/edit" class="hover:underline">Details</a>
                            <button class="delete-btn hover:underline text-red-600" data-id="${data.id}">Delete</button>
                        </td>
                    </tr>
                `;
            };

            tableBody.innerHTML = customers.map(customer => tableRow(customer)).join('');
            attachDeleteEventListeners();
        };

        const attachDeleteEventListeners = () => {

            const deleteButtons = document.querySelectorAll('.delete-btn');

            const deleteCustomer = (id) => {

                let text = "Are you sure you want to delete this customer?";

                if (confirm(text) == true) {
                    axios.delete(`/api/customers/${id}`)
                    .then(response => {
                        const row = document.getElementById(`customer-${id}`);

                        if (row) {
                            row.remove();
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting customer:', error);
                    });
                }
            };

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    deleteCustomer(this.getAttribute('data-id'))
                });
            });
        };
    </script>
@endsection
