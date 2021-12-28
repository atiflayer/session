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
<!--                <tr>
                     <th rowspan="1">Name</th> 
                    <th colspan="4">Inventory</th>
                    <th colspan="2">User</th>
                    <th colspan="3">Order</th>
                </tr>-->
                <tr>
                    <th>ID</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
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

        "ajax": {
            url: "<?php echo base_url('fetch'); ?>",
            type: 'POST',
            data: {
            }
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
            // {
            //     "data": null,
            //     className: "text-right",
            //     render: function(data, type, row) {
            //         return data[4];
            //     }
            // },
            // {
            //     "data": null,
            //     className: "text-right",
            //     render: function(data, type, row) {
            //         return data[5];
            //     }
            // },
            // {
            //     "data": null,
            //     className: "text-right",
            //     render: function(data, type, row) {
            //         return data[6];
            //     }
            // },
            // {
            //     "data": null,
            //     className: "text-right",
            //     render: function(data, type, row) {
            //         return data[7];
            //     }
            // },
            // {
            //     "data": null,
            //     className: "text-right",
            //     render: function(data, type, row) {
            //         return data[8];
            //     }
            // },

        // "columnDefs": [{
        //     "visible": false,
        //     "targets": -1
        // }],

        // "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
        // "order": [],
        // "destroy": true,
        // "responsive": true,
        // "processing": true,
        // "serverSide": true,
        // "scrollX": true,
        // "pageLength": 50,
        // "pagingType": "full_numbers",
        // "scrollY": "800px",     
        // "scrollCollapse": true,

        // stateSave: true,
        // "paging": false,
        // "ordering": false,

        // "language": {
        //     "infoFiltered": "",
        //     // "thousands" : ","
        // },
        // search: {
        //     return: true
        // },
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