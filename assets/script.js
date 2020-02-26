$(document).ready(function () {
    $('#account_table').DataTable({
        "order": [
            [4, "desc"]
        ],
        "paging": false,
        "info": false,
        "autoWidth": false
    });
    $("#btn").click(function () {
        var formData = new FormData($('#account_form')[0]);
        $.ajax({
            url: 'vendor/save_account_handler.php',
            dataType: 'text',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                result = $.parseJSON(response);

                if (result.error === 0) {
                    var table = $('#account_table').DataTable();
                    var row = table.row.add([
                        result.name,
                        result.comment,
                        '<a href="/accounts/' + result.file_hash + '.' + result.file_ext + '" download>' + result.file_name + '</a>',
                        result.status,
                        result.date
                    ]).draw(false).node();
                    $(row).css('background', 'green').animate({
                        color: 'black'
                    });
                    $('#error_data').empty();
                } else {
                    $('#error_data').html('<p>' + result.error + '</p>');
                }
            },
            error: function (response) {
                $('#error_data').append('Ошибка. Данные не отправлены!');
            }
        });
    });
});
