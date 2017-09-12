@forelse ($torrents as $torrent)
    <div class="row" data-id="{{ $torrent->hash }}">
        <div class="col-md-9">
            <a href="{{ route('torrents.show', $torrent->hash) }}">
                <strong class="ellipsis">{{ $torrent->hash }}</strong>
            </a>
        </div>
        <div class="col-md-3">
            <ul class="list-inline list-unstyled">
                <li>
                    <a href="{{ route('statistics.show', ['hash'=>$torrent->hash]) }}"
                       title="Statistics" class="btn btn-primary btn-xs">
                        <span class="glyphicon glyphicon-stats"></span>
                        <span>Statistics</span>
                    </a>
                </li>
                <li>
                    <div class="soft-delete">
                        @if ($torrent->trashed())
                            <div title="Restore" class="btn btn-success btn-xs">
                                <span class="glyphicon glyphicon-ok-circle"></span>
                                <span>Restore</span>
                            </div>
                        @else
                            <div title="Soft Delete" class="btn btn-danger btn-xs">
                                <span class="glyphicon glyphicon-ban-circle"></span>
                                <span>Delete</span>
                            </div>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <hr>
@empty
    <div class="alert alert-warning">
        <p>No torrent files found in the cache.</p>
    </div>
@endforelse