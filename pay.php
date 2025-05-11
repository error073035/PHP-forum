
 <!-- <?php include 'partials/_dbconnect.php'; ?> -->
 
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome to Organic Store</title>
</head>

<body>

    <?php include 'partials/_header.php'; ?>
 
    <!DOCTYPE html>
    <html lang="en">



    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--  <link rel="stylesheet" href="partials/_style.css"> -->
        <title>MyBank</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    </head>


    <body>

        <div class="container my-2 py-4">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h2 class="display-4">Enter Your Bank Details</h2><br>
                    <form action="#" method="post">
                        <div class="container">

                            Enter Your Name :
                            <input type="text" autocomplete="on" name="name" class="input"
                                placeholder="Same name as on card" Required><br><br>

                            Enter Your Card No :
                            <input type="text" autocomplete="on" name="cardNo" class="input" placeholder="Card Number" minlength="16" maxlength="20"
                                 Required><br><br>


                            Enter CVV Code :
                            <input type="text" autocomplete="on" name="cvv" class="input" placeholder="CVV Number"
                                maxlength="3" Required><br><br>

                            Enter Last Date:
                            <input type="number" name="date" class="input" placeholder="Only Year" Required><br><br>

                            Enter Amount:
                            <input type="number" name="bal" class="input" placeholder="Pay Amount" Required><br><br>

                            Enter Merchant Name:
                            <input type="text" name="mer" class="input" placeholder="Name of Merchant" Required>

                            <br><br>
                            <button type="submit" name="pay">
                                <span><i class="fa-solid fa-cart-shopping"
                                        style="font-size: 36px;    margin-right: 13px;"></i></span>Pay Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>
    <?php
$db = new PDO('mysql:host=localhost;dbname=organic_store', 'root', '');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


if (isset($_POST['pay'])) {

    //fetch merchant balance ------------
    $Mstmt = $db->prepare('SELECT bal FROM merchant WHERE name = :Mname');
    $Mstmt->bindParam(':Mname', $Mname);
    $Mname = $_REQUEST['mer'];
    $Mstmt->execute();
    $Mresult = $Mstmt->fetch();
    $Mbalance = $Mresult['bal'];

    //fetch merchant name ------------
    $Mnstmt = $db->prepare('SELECT name FROM merchant WHERE name = :Mnname');
    $Mnstmt->bindParam(':Mnname', $Mnname);
    $Mnname = $_REQUEST['mer'];
    $Mnstmt->execute();
    $Mnresult = $Mnstmt->fetch();
    $Mnbalance = $Mnresult['name'];

    //fetch customer -------------
    $stmt = $db->prepare('SELECT * FROM customer WHERE name = :name');
    $stmt->bindParam(':name', $name);

    $cname = $_REQUEST['name'];
    $cardNo = $_REQUEST['cardNo'];
    $cvv = $_REQUEST['cvv'];
    $date = $_REQUEST['date'];
    $bal = $_REQUEST['bal'];
    $name = $cname;

    //$email = $_POST['loginEmail'];

    // Execute the query
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll();
    if ($results) {
        foreach ($results as $row) {
            //     echo $row['name'] . ' ' . $row['bal'] . '<br>';
            if ($cname == $row['name'] && $Mnname == $_REQUEST['mer']) {
                if ($cvv == $row['cvv']) {
                    if ($cardNo == $row['cardNo']) {
                        if ($date == $row['endDate']) {
                            if ($bal - 2000 < $row['bal']) {

                                //Update Customer -------------------------
                                $stmt = $db->prepare('UPDATE customer SET bal = :balance WHERE name = :name');
                                $stmt->bindParam(':balance', $balance);
                                $stmt->bindParam(':name', $name);
                                $balance = $row['bal'] - $bal;
                                $stmt->execute();

                                //Update Marchant -------------------------
                                $stmtt = $db->prepare('UPDATE merchant SET bal = :baalance WHERE name = :namme');
                                $stmtt->bindParam(':baalance', $Mubalance);
                                $stmtt->bindParam(':namme', $namme);
                                $namme = $_REQUEST['mer'];
                                $Mubalance = $Mbalance + $bal;
                                $stmtt->execute();

                                if ($stmt->rowCount() > 0 && $stmt->rowCount() > 0) {

                                    $mail = new PHPMailer(true);
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'oorganicstoore@gmail.com'; //Your web email
                                    $mail->Password = 'jqlyjzmjzqjgzdim'; //security code
                                    $mail->SMTPSecure = 'ssl';
                                    $mail->Port = 465;

                                    $mail->setFrom('oorganicstoore@gmail.com'); //Your website email

                                    $mail->addAddress('kahanhirani073@gmail.com'); //User email 

                                    $mail->isHTML(true);
                                    $b = "Your payment for has been successful!"; // Subject of mail
                                    $mail->Subject = $b; // Main mail start from here as a fromat of html    ***** LINE : 173 for username dynamic ****
                                    $a = "  <center>  
      <table style='font-family: 'Montserrat', sans-serif'>
        <tr>
          <td style='font-size: 30px'>$cname,</td>
        </tr>
        <tr>
          <td>
            <br />
            Congratulations! We're happy to inform you that your payment for order number has been successful. Your order will be shipped out within 30 Minutes.
 <br /><br />
         Here are the details of your order: <br/>
 Category id: [id]<br/>
  Order total: [desc]<br/>
 Shipping address: [address] <br />
            <br />
          </td>
        </tr>
        <tr>
          <td>
            Thank you for your order! We hope you will visit again.
            <br /><br /><br />
            Sincerely, <br />
            Organic Store
          </td>
        </tr>
        <tr>
          <td></td>
        </tr>
      </table>
    </center>
  ";
                                    $mail->Body = $a;

                                    $mail->send(); // this line send mail.
                                    echo '<script>alert("Payment Completed Successfully!")
                                  </script>'; //window.location = "index.php";
                                 


                                } else {
                                    echo '<script>alert("Something Went Wrong!")
                                  </script>';
                                }
                            } else {
                                echo '<script>alert("Balance not Sufficient!")
                                  </script>';
                            }
                        } else {
                            echo "Date Doesn't Match";
                            echo '<script>alert("Card Year Invalid!")
                                  </script>';
                        }
                    } else {
                        echo '<script>alert("Card Number InValid!")
                                  </script>';
                    }
                } else {
                    echo '<script>alert("CVV Wrong !")
                                  </script>';
                }
            }
        }
    } else {
        echo "<br>Name Incorrect";
        echo '<script>alert("Either Merchant or Customer name not Valid! ".<br>."        Please Try Again !")
                                  </script>';
    }

}
?>

    <!-- footer -->
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