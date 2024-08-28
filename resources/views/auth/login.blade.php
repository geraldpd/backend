@extends('layouts.default')

@section('content')
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form id="loginForm" class="space-y-6">
          @csrf
          <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
            <div class="mt-2">
              <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="mt-2">
              <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>

          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
          </div>
        </form>

        <div class="mt-4">
          <a href="/register" >Register</a>
      </div>
      </div>
  </div>
@endsection

@section('scripts')
    <script type="module">

        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('authToken')) {
                window.location.href = '/customers';
            }
        });

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('email');
            const password = document.getElementById('password');

            axios.post('/api/login', {
                email: email.value,
                password: password.value
            })
            .then(response => {
                console.log('Success:', response.data);

                if (!response.data.token) {
                    return alert('Something went wrong!');
                }

                localStorage.setItem('authToken', response.data.token);
                window.location.href = '/customers';

            })
            .catch(error => {

               if(error.status == 401) {
                  password.value = '';
                  alert('invalid Credentials');
               }

                console.error('Error:', error.response);
            });
        });
    </script>
@endsection
