<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Session</title>
</head>

<body>
    <div class="container" style="margin-top:16px">
        <h4>Insert Your Product</h4>

        <form action="<?= base_url('postdata')?>" method="POST">

            <div class="mb-3">
                <label for="productcode" class="form-label">Product Code</label>
                <!-- <input type="text" class="form-control" name="productcode" value="" id="productcode"> -->
                <select id="productcode" class="form-select" name="productcode" id="productcode">
                    <option selected>Select Product Code</option>

                      <!-- Inserted Product Code in Options   -->

                    <?php
                        foreach($products as $product){?>
                        <option value="<?php echo $product['product_id']; ?>">
                        <?php echo $product['productcode']; ?>
                    </option>
                    <?php } ?>  

                </select>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Product ID</label>
                <input type="text" class="form-control" name="product_id" value="" id="product_id">
            </div>
            <div class="mb-3">
                <label for="productname" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="productname" value="" id="productname">
            </div>
            <div class="mb-3">
                <label for="productprice" class="form-label">Product Price</label>
                <input type="number" class="form-control" name="productprice" value="0" id="productprice">
            </div>
            <div class="mb-3">
                <label for="product_inout_quantity_in" class="form-label">Product Quantity In</label>
                <input type="text" class="form-control" name="product_inout_quantity_in" value="0">
            </div>
            <div class="mb-3">
                <label for="product_inout_quantity_out" class="form-label">Product Quantity Out</label>
                <input type="text" class="form-control" name="product_inout_quantity_out" value="0">
            </div>
            <!--            <div class="form-check">
                <input class="form-check-input" type="radio" name="in_out" id="in_out" value="">
                <label class="form-check-label" for="income">Product In</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="in_out" id="in_out" value="">
                <label class="form-check-label" for="income">Product Out</label>
            </div>
            </br>-->
            <button type="submit" class="btn btn-success">Add to Cart</button>
        </form>
    </div>
    <div class="container" style="margin-top:16px">

        <?php if(session()->getFlashdata('status')){
                echo "<h5>".session()->getFlashdata('status'). "</h4>";} ?>

        <?php if(session()->getFlashdata('errors')){
             foreach (session()->getFlashdata('errors') as $field => $error): ?>
        <h4<?= $error ?>< /h4>
            <?php endforeach ;}?>

            <form action="<?= base_url('inout/postsubmit')?>" method="POST">
                <h4>Products in Cart</h4>
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <!-- <th>Product Purchase Price</th> -->
                            <th>Product Date</th>
                            <th>Product Quantity In</th>
                            <th>Product Quantity Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serial=1; foreach($data as $row): ?>
                        <tr>
                            <th><?= $serial++ ?></th>
                            <td><?= $row['productcode'] ?></td>
                            <td><?= $row['productname'] ?></td>
                            <td><?= $row['productprice'] ?></td>
<!--                            <td></?= $row['product_inout_date'] ?></td>
                            <td></?= $row['product_inout_quantity_in'] ?></td>
                            <td></?= $row['product_inout_quantity_out'] ?></td>-->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Submit to Product In Out List</button>
            </form></br>
            <div>
                <a href="<?= base_url('product_list_dtable')?>" class="btn btn-secondary">List of Products</a>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script type='text/javascript'>
    $(document).ready(function() {
        // Initialize
        $("#productcode").autocomplete({

            source: function(request, response) {

                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('productcode'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                // Fetch data
                $.ajax({
                    url: "<?=site_url('getProducts')?>",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term,
                        [csrfName]: csrfHash // CSRF Token
                    },
                    success: function(data) {
                        // Update CSRF Token
                        $('.txt_csrfname').val(data.token);

                        response(data.data);
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#productcode').val(ui.item.productcode); // display the selected text
                $('#product_id').val(ui.item.product_id); // save selected id to input
                $('#productname').val(ui.item.productname); // save selected id to input
                $('#productprice').val(ui.item.productprice); // save selected id to input
                return false;
            },
            focus: function(event, ui) {
                $("#productcode").val(ui.item.productcode);
                $("#product_id").val(ui.item.product_id);
                $("#productname").val(ui.item.productname);
                $("#productprice").val(ui.item.productprice);
                return false;
            },
        });
    });
    </script>

</body>

</html>