@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.heading')

        @auth
            <div class="text-right">
                <a href="{{ route('torrents.index') }}" class="btn btn-default">
                    <span>All Torrents</span>
                </a>
            </div>
        @endauth

        <div>
            <h3>@lang('cache.accessing_cached_torrents')</h3>

            <p>@lang('cache.no_search')</p>
            <p>@lang('cache.access_url_structure')</p>

            <blockquote class="ellipsis">{{ url('torrents/{torrent_hash}') }}</blockquote>

        </div>

        <div>
            <h3>@lang('cache.cache_torrent')</h3>

            @include('torrents._form')
        </div>
    </div>
@endsection