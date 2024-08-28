@extends('layouts.auth')

@section('content')
    <div class="flex min-h-full flex-col px-6 py-12 lg:px-8">
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
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">John</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Doe</td>
                        <td class="px-6 py-4 text-sm text-gray-500">john.doe@example.com</td>
                        <td class="px-6 py-4 text-sm text-gray-500">01/15/1990</td>
                        <td class="px-6 py-4 text-sm text-gray-500">34</td>
                        <td class="px-6 py-4 text-sm font-medium text-blue-600 hover:text-blue-500">
                            <a href="/customers/1/edit" class="hover:underline">Edit</a>
                        </td>
                    </tr>
                </tbody>
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

            //fetch all customers

            //render customer in table pls
        });
    </script>
@endsection
