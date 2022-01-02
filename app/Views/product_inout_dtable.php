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

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
</head>

<body>

    <div class="container" style="margin-top:16px">
        <?php if(session()->getFlashdata('status')){
                echo "<h2>".session()->getFlashdata('status'). "</h2>";} ?>

        <?php if(session()->getFlashdata('errors')){
             foreach (session()->getFlashdata('errors') as $field => $error): ?>
        <h1><?= $error ?></h1>
        <?php endforeach ;}?>

        <h4>Product In Out List</h4>
        <table id="tableid" class="table table-bordered display responsive nowrap" style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>ID</th>
                    <!-- <th>Product Code</th> -->
                    <!-- <th>Product Name</th> -->
                    <!-- <th>Product Price</th> -->
                    <th>Product InOut Price</th>
                    <th>Product InOut Date</th>
                    <th>Product InOut Quantity</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="container" style="margin-top:16px">
            <a href="<?= base_url('home/index')?>" class="btn btn-secondary">Create a Product</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

</body>
<script>
function callServer() {
    $('#tableid').dataTable({
        "order": [],
        "destroy": true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "pageLength": 5,
        "ajax": {
            url: "<?php echo base_url('inout/getdata'); ?>",
            type: 'POST',
            data: {}
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
                className: "text-right",
                render: function(data, type, row) {
                    return data[1];
                }
            },
            {
                "data": null,
                className: "text-left",
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