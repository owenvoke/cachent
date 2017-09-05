@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.heading')

        @include('torrents._info')

        @include('torrents._sharing')
    </div>
@endsection