@extends('layouts.auth')

@section('content')
    <div class="flex min-h-full flex-col px-6 py-12 lg:px-8">
        <div class="overflow-x-auto">


            Edit


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
        });
    </script>
@endsection
