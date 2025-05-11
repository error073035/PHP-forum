<?php include 'partials/_header.php'; ?>
<?php include 'partials/_dbconnect.php'; ?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome to Organic Store Seller Panel</title>
</head>

<body>
    <br>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
      echo '
        
    <div class="container alert-secondary">
        <form action="#" method="post" enctype="multipart/form-data"
            style="display: flex; flex-direction: column; align-items: center;">
            <div class="form-group">
                <label for="exampleInputEmail1">Product ID</label>
                <input type="text" name="product_id" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Product Name</label>
                <input type="text" name="product_name" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Product Price</label>
                <input type="number" name="product_price" class="form-control" id="exampleInputPassword1" required>
            </div>

            <div class="form-group">
            <label for="exampleInputPassword1">Merchant Name</label>
            <input type="text" name="merchant_name" class="form-control" id="exampleInputPassword1" required>
            </div>

            <div class="form-group">
            <label for="exampleInputPassword1">Merchant Id</label>
            <input type="text" name="merchant_id" class="form-control" id="exampleInputPassword1" required>
            </div>

            <div class="form-group">
            <label for="exampleInputPassword1">Merchant Mo.</label>
            <input type="number" name="merchant_mo" class="form-control" id="exampleInputPassword1" required>
            </div>
        
            <button type="submit" name="add" class="btn btn-success">Add</button>
        </form>
    </div><br>';
    }
    else{
      echo '
      <div class="container">
      <h1 class="py-2">Add a product</h1> 
         <p class="lead">You are not logged in. Please login to be able to add a product</p>
      </div>
      ';
  }
?>

    <!-- insert product  -->
    <?php
    
    $showAlert=false;
    $method = $_SERVER['REQUEST_METHOD'];
  
    if($method=='POST')
    {
      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_id = $_POST['product_id'];
      $merchant_id = $_POST['merchant_id'];
      $merchant_name = $_POST['merchant_name'];
      $merchant_mo = $_POST['merchant_mo'];
      
    $sql = "INSERT INTO `categories` (`category_id`, `category_name`, `category_price`, `created`) VALUES ('$product_id', '$product_name', '$product_price', current_timestamp())";
    $result = mysqli_query($conn,$sql);

    $sql = "INSERT INTO `merchant` (`id`, `name`, `payid`, `payno`, `bal`) VALUES ('$product_id', '$merchant_name', '$merchant_id', '$merchant_mo', '0');";
    $result = mysqli_query($conn,$sql);

    $showAlert=true;
    if($showAlert)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your Product has been added.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    else
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>ERROR!</strong> Your Product has not been added.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    } 

}

?>






    <div class="container-fluid bg-dark text-light fixed-bottom">
        <p class="text-center py-3 mb-0">Copyright Organic Store 2023 | All rights reserved</p>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>