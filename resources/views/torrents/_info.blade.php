<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Info</h4>
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
                <th>Size</th>
                <td class="ellipsis">{{ \Rych\ByteSize\ByteSize::formatMetric($file->getSize()) }}</td>
            </tr>
            <tr>
                <th>Updated at</th>
                <td class="ellipsis">{{ date('jS M Y, H:i') }}</td>
            </tr>
        </table>
    </div>
</div>