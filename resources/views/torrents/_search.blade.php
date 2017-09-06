<form action="{{ route('torrents.index') }}">
    <div class="form-group">
        <div class="input-group">
            <input class="form-control" name="hash" title="Search query..." placeholder="Torrent hash...">
            <div class="input-group-btn">
                <button class="btn btn-default btn-primary">
                    <span>Search</span>
                </button>
            </div>
        </div>
    </div>
</form>