@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2>Manajemen Kasir</h2>
                    <a href="{{ route('registerkasir') }}" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                        Tambah Kasir
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
