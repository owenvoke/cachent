<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Statistics</h4>
    </div>

    <div class="panel-body">
        <table class="table table-fixed">
            <colgroup>
                <col>
                <col>
            </colgroup>

            <tr>
                <th>Total Downloads</th>
                <td class="ellipsis">{{ $totalDownloads }} (active only)</td>
            </tr>
            <tr>
                <th>Most Downloaded Torrent</th>
                <td class="ellipsis">
                    <a href="{{ route('statistics.show', ['hash'=>$mostDownloaded->hash ?? null]) }}">{{ str_limit($mostDownloaded->hash ?? 0, 12, '') }}</a>
                    <span>({{ $mostDownloaded->downloads or 0 }} downloads)</span>
                </td>
            </tr>
            <tr>
                <th>Total Torrents</th>
                <td class="ellipsis">{{ $totalTorrentsWithDeleted }} ({{ $totalTorrents }} active)</td>
            </tr>
        </table>
    </div>
</div>