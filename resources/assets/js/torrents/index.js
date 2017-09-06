$('div.soft-delete div').click(function () {
    axios.delete('/torrents/' + $(this).parent().parent().parent().data('id'))
        .then(function (response) {
            if (response.status === 200) {
                location.reload();
            } else {
                alert('An unknown error occurred.');
            }
        });
});