<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="text-black/50">

            <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                    <main class="mt-6">

                        <div class="bg-white">
                            <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">
                                <!-- Off-canvas menu code here -->
                            </div>

                            <header class="relative bg-white">
                                <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                                    <div class="border-b border-gray-200">
                                        <div class="flex h-16 items-center">
                                            <div class="ml-4 flex lg:ml-0">
                                                <a href="/customers">
                                                    Customers
                                                </a>
                                            </div>

                                            <div class="ml-auto flex items-center">
                                                <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                                                    <form id="logoutForm" method="POST" action="/api/logout">
                                                        @csrf
                                                        <button type="submit" class="text-sm font-medium text-gray-700 hover:text-gray-800">Logout</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </nav>
                            </header>
                        </div>

                    </main>

                    @yield('content')

                </div>
            </div>

        </div>
    </body>

    @yield('scripts')

    <script type="module">
        document.getElementById('logoutForm').addEventListener('submit', function(event) {
            event.preventDefault();

            axios.post(this.action)
            .then(response => {
                localStorage.removeItem("authToken");
                console.log('Logout successful:', response.data);
                window.location.href = '/login'; // Redirect to login page or another appropriate page
            })
            .catch(error => {
                console.error('Error during logout:', error.response);
            });
        });
    </script>

</html>
