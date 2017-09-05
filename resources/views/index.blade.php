@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div>
            <h3>@lang('cache.accessing_cached_torrents')</h3>

            <p>@lang('cache.no_search')</p>
            <p>@lang('cache.access_url_structure')</p>

            <blockquote>{{ url('torrents/{torrent_hash}') }}</blockquote>

        </div>

        <div>
            <h3>@lang('cache.cache_torrent')</h3>

            @include('torrents.form')
        </div>
    </div>
@endsection