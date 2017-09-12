@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.heading')

        <div class="panel panel-default">
            <div class="panel-body">
                @include('statistics._info')
            </div>
        </div>
    </div>
@endsection