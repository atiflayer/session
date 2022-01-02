<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Product Out Form</title>
</head>

<body>
    <div class="container" style="margin-top:16px">

        <?php if(session()->getFlashdata('status')){
                echo "<h5>".session()->getFlashdata('status'). "</h4>";} ?>

        <?php if(session()->getFlashdata('errors')){
             foreach (session()->getFlashdata('errors') as $field => $error): ?><h4<?= $error ?>< /h4>
            <?php endforeach ;}?>

            <h4>Sell Your Product</h4>

            <form action="<?= base_url('inout/postsubmit')?>" method="POST">

                <div class="mb-3">
                    <p>Product Name : <?= $post['productname']?></p>
                </div>
                <div class="mb-3">
                    <p>Product Code : <?= $post['productcode']?></p>
                </div>
                <div class="mb-3">
                    <p>Product Price : <?= $post['productprice']?></p>
                </div>
                <div class="mb-3">
                    <label for="product_inout_date" class="form-label">Product-Out Date</label>
                    <input type="number" class="form-control" name="product_inout_date" value="0">
                </div>
                <div class="mb-3">
                    <label for="product_inout_quantity_out" class="form-label">Product Quantity Out</label>
                    <input type="number" class="form-control" name="product_inout_quantity_out" value="0">
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
            <div></br>
                <a href="<?= base_url('product_list_dtable')?>" class="btn btn-secondary">Product List DataTable</a>
            </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script> -->

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

</body>

</html>