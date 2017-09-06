@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.heading')

        <div class="panel panel-default">
            <div class="panel-body">
                @include('torrents._search')
            </div>
        </div>
        <hr>

        @include('torrents._list')

        {{ $torrents->links() }}
    </div>
@endsection