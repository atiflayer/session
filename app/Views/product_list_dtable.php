<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/datatables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container" style="margin-top:16px">
        <table id="tableid" class="table table-bordered display responsive nowrap" style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</body>
<script>
function callServer() {
    $('#tableid').dataTable({
        "order": [],
        "destroy": true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            url: "<?php echo base_url('getdata'); ?>",
            type: 'POST',
            // data: {}
        },
        "columns": [{
                "data": null,
                className: "text-right",
                render: function(data, type, row) {
                    return data[0];
                }
            },
            {
                "data": null,
                className: "text-left",
                render: function(data, type, row) {
                    return data[1];
                }
            },
            {
                "data": null,
                className: "text-right",
                render: function(data, type, row) {
                    return data[2];
                }
            },
            {
                "data": null,
                className: "text-right",
                render: function(data, type, row) {
                    return data[3];
                }
            },
            {
                "data": null,
                className: "text-right",
                render: function(data, type, row, meta) {
                    return '<a href="edit/' + data[4] + '"class="btn btn-primary btn-sm">Edit</a> '+
                           '<a href="delete/' + data[4] + '"class="btn btn-danger btn-sm">Delete</a>';
                }
            }
        ]
    });
}
</script>
<script>
$(document).ready(function() {
    callServer();

});
</script>

</html>