@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('partials.heading')

        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3>Error</h3>
            </div>
            <div class="panel-body">
                <p>@lang('validation.uploaded', ['attribute' => 'torrent'])</p>
                <a href="{{ route('index') }}">@lang('cache.click_try_again', ['attribute' => 'torrent'])</a>
            </div>
        </div>
    </div>
@endsection