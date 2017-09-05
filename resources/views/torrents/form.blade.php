<form action="{{ route('torrents.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="btn-group">
            <label class="btn btn-default btn-wide btn-text-left" for="file">
                <span>Choose file...</span>
                <input class="hide" name="file" id="file" type="file">
            </label>
            <button class="btn btn-default btn-primary">
                <span>Cache</span>
            </button>
        </div>
    </div>
</form>