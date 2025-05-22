@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dashboard Kasir') }}
                    </h2>
                    {{ __("You're logged in!") }} <br>
                    <a href="{{ route('notifikasi') }}" class="inline-block bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                        Notifikasi
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
