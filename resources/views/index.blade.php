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

            <form action="{{ route('torrents.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="btn-group">
                        <label class="btn btn-default btn-wide btn-text-left" for="file">
                            <span>Choose files...</span>
                            <input class="hide" name="file" id="file" type="file">
                        </label>
                        <button class="btn btn-default btn-primary">
                            <span>Cache</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection