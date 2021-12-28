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
        <h4>Session / Cart</h4>

        <form action="<?= base_url('postdata')?>" method="POST">

            <div class="mb-3">
                <label for="productname" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="productname">
            </div>
            <div class="mb-3">
                <label for="productquantity" class="form-label">Product Quantity</label>
                <input type="number" class="form-control" name="productquantity">
            </div>
             <div class="mb-3">
                <label for="productcode" class="form-label">Product Code</label>
                <input type="text" class="form-control" name="productcode">
            </div>
             <div class="mb-3">
                <label for="productprice" class="form-label">Product Price</label>
                <input type="number" class="form-control" name="productprice">
            </div> 


            <button type="submit" class="btn btn-primary">Add To Cart</button>
        </form>
    </div>
    <div class="container" style="margin-top:16px">

        <?php if(session()->getFlashdata('status')){
                echo "<h5>".session()->getFlashdata('status'). "</h4>";} ?>

        <?php if(session()->getFlashdata('errors')){
             foreach (session()->getFlashdata('errors') as $field => $error): ?>
        <h4 style="color:red"><?= $error ?></h4>
        <?php endforeach ;}?>

        <form action="<?= base_url('postsubmit')?>" method="POST">
            <h4>Product Create Table</h4>
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Product Quantity</th>
                        <th>Product Price</th>
                        <th>Sum Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $serial=1; foreach($data as $row): ?>
                    <tr>
                        <th><?= $serial++ ?></th>
                        <td><?= $row['productcode'] ?></td>
                        <td><?= $row['productname'] ?></td>
                        <td><?= $row['productquantity'] ?></td>
                        <td><?= $row['productprice'] ?></td>
                        <td></td>
                        <!--</?= $row['sumprice'] ?>-->
                    </tr>
                    <?php endforeach; ?>
                </tbody>
               <tfoot>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>  
                        <td></td>  
                    </tr>
                </tfoot>
            </table>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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