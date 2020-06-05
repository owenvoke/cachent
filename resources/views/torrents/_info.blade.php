<div class="panel panel-default">
    <div class="panel-heading">
        <h4>
            <span>Info</span>
            <a href="{{ route('torrents.show', ['torrent' => $torrent]) }}"
               class="btn btn-primary btn-xs pull-right">Download</a>
        </h4>
    </div>

    <div class="panel-body">
        <table class="table table-fixed">
            <colgroup>
                <col>
                <col>
            </colgroup>

            <tr>
                <th>Hash</th>
                <td class="ellipsis">{{ $torrent->hash }}</td>
            </tr>
            <tr>
                <th>Original File Name</th>
                <td class="ellipsis">{{ $torrent->filename }}</td>
            </tr>
            <tr>
                <th>Size</th>
                <td class="ellipsis">{{ \Rych\ByteSize\ByteSize::formatMetric($file->getSize() ?? $file->size()) }}</td>
            </tr>
            <tr>
                <th>First added</th>
                <td class="ellipsis">{{ $torrent->created_at ?? date('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <th>Updated at</th>
                <td class="ellipsis">{{ $torrent->updated_at ?? date('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <th>Downloads</th>
                <td class="ellipsis">{{ $torrent->downloads ?? 0 }}</td>
            </tr>
        </table>
    </div>
</div>
