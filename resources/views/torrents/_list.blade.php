@forelse ($torrents as $torrent)
    <div class="row" data-id="{{ $torrent->hash }}">
        <div class="col-md-10">
            <a href="{{ route('torrents.show', $torrent->hash) }}">
                <strong class="ellipsis">{{ $torrent->hash }}</strong>
            </a>
        </div>
        <div class="col-md-2">
            <div class="soft-delete">
                @if ($torrent->trashed())
                    <div title="Restore" class="btn btn-success btn-xs">
                        <span class="glyphicon glyphicon-ok-circle"></span>
                        <span>Restore</span>
                    </div>
                @else
                    <div title="Soft Delete" class="btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-ban-circle"></span>
                        <span>Soft Delete</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <hr>
@empty
    <div class="alert alert-warning">
        <p>No torrent files found in the cache.</p>
    </div>
@endforelse