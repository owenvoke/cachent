<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Sharing</h4>
    </div>

    <div class="panel-body">
        <div class="panel-group">
            <label for="direct-link">Direct Link</label>
            <input id="direct-link" class="form-control" onclick="this.select()"
                   value="{{ route('torrents.show', ['torrent' => $torrent->hash]) }}">
        </div>

        <div class="panel-group">
            <label for="direct-link">Markdown Link</label>
            <input id="direct-link" class="form-control" onclick="this.select()"
                   value="[{{ $torrent->hash }}]({{ route('torrents.show', ['torrent' => $torrent->hash]) }})">
        </div>

        <div class="panel-group">
            <label for="direct-link">BBCode Link</label>
            <input id="direct-link" class="form-control" onclick="this.select()"
                   value="[url]{{ route('torrents.show', ['torrent' => $torrent->hash]) }}[/url]">
        </div>
    </div>
</div>