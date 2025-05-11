<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
    <style>
    .maincontainer {
        min-height: 100vh;
    }
    </style>
    <title>Welcome to Organic Store</title>
</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <div class="container">
    <h1 class="py-3">Search results for <em>"<?php echo $_GET['search'] ?>"</em></h1>
    </div>

    <?php 
        $noresults = true;
        $query = $_GET["search"];
        $sql = "select * from categories where match (category_name) against ('$query')"; 
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $cat = $row['category_name'];
            $id = $row['category_id'];
            $url = "threads.php?catid=". $id;
            $noresults = false;

            // Display the search result
            echo '<div class="container my-4">
            <div class="result">
                        <h3><a href="'. $url. '" class="text-dark">'. $cat. '</a> </h3>
                    </div>
                  </div>'; 
            }
        if ($noresults){
            echo '<div class="container my-4">
            <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <p class="display-4">No Results Found</p>
                        <p class="lead"> Suggestions: <ul>
                                <li>Make sure that all words are spelled correctly.</li>
                                <li>Try different keywords.</li>
                                <li>Try more general keywords. </li></ul>
                        </p>
                    </div>
                    </div>
                 </div>';
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