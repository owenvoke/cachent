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
            <tr>
                <th>Clear All Torrents</th>
                <td class="ellipsis">
                    <form id="purgeForm" action="">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-default btn-danger btn-wide btn-text-left">
                            <span id="purgeButton">Purge</span>
                        </button>
                    </form>
                    <script>
                    console.log('Page loaded');
                    document.getElementById('purgeForm').addEventListener('submit', function(e) {
                        e.preventDefault(); //Prevents default submit
                        console.log('Purge Form Activated');
                        var form = $(this); 
                        var post_data = form.serialize(); //Serialized the form data for process.php
                        $('#purgeButton', form).text('Purging...')
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('statistics.purge') }}', // Your form script
                            data: post_data,
                            success: function(result) {
                                $('#purgeButton', form).fadeOut(500, function(){
                                    form.html(result.message).fadeIn();
                                });
                            }
                        });
                    });
                    </script>
                </td>
            </tr>
        </table>
    </div>
</div>