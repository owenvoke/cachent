@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <a href="{{ route('home') }}">
                <h1 class="text-4xl font-bold text-gray-900">{{ config('app.name') }}</h1>
            </a>
        </div>
    </div>
@endsection
