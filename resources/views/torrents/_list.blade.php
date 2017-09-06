@forelse ($torrents as $torrent)
    <div class="row">
        <div class="col-lg-11">
            <a href="{{ route('torrents.show', $torrent->hash) }}">
                <strong class="ellipsis">{{ $torrent->hash }}</strong>
            </a>
        </div>
        <div class="col-lg-1">
            @if ($torrent->trashed())
                <a><span class="glyphicon glyphicon-trash"></span></a>
            @else
                <a><span class="glyphicon glyphicon-dashboard"></span></a>
            @endif
            <a><span class="glyphicon glyphicon-remove"></span></a>
        </div>
    </div>
    <hr>
@empty
    <div class="alert alert-warning">
        <p>No torrent files found in the cache.</p>
    </div>
@endforelse