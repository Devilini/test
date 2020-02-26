$(document).ready(function() {
    $('#account_table').DataTable({
        "order": [
            [5, "desc"]
        ],
        "paging": false,
        "info": false,
        "autoWidth": false
    });
    var table = $('#account_table').DataTable();
    $('#account_table tbody').on('click', 'button.del-row', function() {
        var tr = table.row($(this).parents('tr'));
        var id = tr.data()['DT_RowId'];
        $.ajax({
            url: '../vendor/delete_account_handler.php',
            data: {
                id: id
            },
            type: 'POST',
            success: function(response) {
                
                if (response == 1) {
                    $('#error_data').empty();
                    table.row(tr).remove().draw();
                } else {
                    $('#error_data').html('Ошибка! попробуйте позже');
                }
            },
            error: function() {
                $('#error_data').html('Ошибка! попробуйте позже');
            }
        });
    });

    $('#account_table tr').on('click', '.btn-status', function() {
        var id = table.row($(this).parents('tr')).data()['DT_RowId'];
        var status = $(this).data('status');
        $.ajax({
            url: '../vendor/status_handler.php',
            data: {
                id: id,
                status: status
            },
            type: 'POST',
            success: function(response) {

                if (response == 0) {
                    $('#error_data').html('Ошибка! попробуйте позже');
                } else {
                    $('#' + id + ' span').html(response);
                    $('#error_data').empty();
                }
            },
            error: function() {
                $('#error_data').html('Ошибка! попробуйте позже');
            }
        });
    });
});
