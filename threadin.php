<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome to Lets Discuss - Coding Forums</title>
</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id"; 
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result))
        {
            $title = $row['thread_title'];
            $desc = $row['thread_des'];
        }
    ?>

    <?php
    $showAlert=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST')
    {
    //insert thread into comment db
    $comment = $_POST['comment'];
    $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '0', current_timestamp())";
    $result = mysqli_query($conn,$sql);
    $showAlert=true;
    if($showAlert)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your Comment has been added.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    else
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>ERROR!</strong> Your Comment has not been added.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }

}
?>

    <!-- Category container starts here-->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"><?php echo $desc ;?></p>
            <hr class="my-4">
            <p>It use for peer to peer comunication only. </p>
            <p>No Spam / Advertising / Self-promote in the forums. </p>
            <p>Do not post copyright-infringing material. </p>
            <p>Do not post “offensive” posts, links or images. </p>
            <p>Do not cross post questions. </p>
            <p>Remain respectful of other members at all times.</p>
            <p>Posted By : <b>Kahan</b></p>
        </div>
    </div>

    <?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
{
  echo ' <div class="container">
  <h1 class="py-2">Post a Comment</h1>
  <form action="'. $_SERVER['REQUEST_URI'].'" method="post">
      <div class="form-group">
          <label for="exampleFormControlTextarea1">Type your comment</label>
          <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-success">Post Comment</button>
  </form>
</div>>';
}
    else{
        echo '
        <div class="container">
        <h1 class="py-2">Post a Comment</h1> 
           <p class="lead">You are not logged in. Please login to be able to post a comment</p>
        </div>
        ';
    }
    ?>

    <div class="container">
        <h1 class="py-2">Discussion</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id"; 
        $result = mysqli_query($conn,$sql);
        $noResult=true;
        while($row = mysqli_fetch_assoc($result))
        {
            $noResult=false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
         
  
        echo '<div class="media my-3">
            <img src="img/userimg.png" width=54px class="mr-3" alt="image not found">
            <div class="media-body">
            <p class="font-weight-bold my-0" >Anonymous User at '.$comment_time.'</p>
                '.$content.'
            </div>
        </div>';
}
if($noResult)
{
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <p class="display-4">No Threads found</p>
      <p class="lead">Be the first person to ask a question.</p>
    </div>
  </div>';
}
?>

        <?php include 'partials/_footer.php'; ?>

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