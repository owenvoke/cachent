<div class="panel panel-default">
    <div class="panel-body">
        <table class="table">
            <colgroup>
                <col>
                <col>
            </colgroup>

            <tr>
                <th>Hash</th>
                <td>{{ $torrent->hash }}</td>
            </tr>
            <tr>
                <th>Size</th>
                <td>{{ \Rych\ByteSize\ByteSize::formatMetric($file->getSize()) }}</td>
            </tr>
            <tr>
                <th>Updated at</th>
                <td>{{ date('jS M Y, H:i') }}</td>
            </tr>
        </table>
    </div>
</div>