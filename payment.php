<?php session_start();
include_once('includes/config.php');
if(strlen($_SESSION['id'])==0)
{   header('location:logout.php');
}else{
if($_SESSION['address']==0):
    echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
endif;    



//Order details
if(isset($_POST['submit']))
{
$orderno= mt_rand(100000000,999999999);
$userid=$_SESSION['id'];
$address=$_SESSION['address'];
$totalamount=$_SESSION['gtotal'];
$txntype=$_POST['paymenttype'];
$txnno=$_POST['txnnumber'];
$query=mysqli_query($con,"insert into orders(orderNumber,userId,addressId,totalAmount,txnType,txnNumber) values('$orderno','$userid','$address','$totalamount','$txntype','$txnno')");
if($query)
{

$sql="insert into ordersdetails (userId,productId,quantity) select userID,productId,productQty from cart where userID='$userid';";
$sql.="update ordersdetails set orderNumber='$orderno' where userId='$userid' and orderNumber is null;";
$sql.="delete from  cart where userID='$userid'";
$result = mysqli_multi_query($con, $sql);
if ($query) {
unset($_SESSION['address']);
unset($_SESSION['gtotal']);    
echo '<script>alert("Your order successfully placed. Order number is "+"'.$orderno.'")</script>';
    echo "<script type='text/javascript'> document.location ='my-orders.php'; </script>";
} } else{
echo "<script>alert('Something went wrong. Please try again');</script>";
    echo "<script type='text/javascript'> document.location ='payment.php'; </script>";
} }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>কিনবো.com | Payment</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/fav.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery.min.js"></script>
    <!--  <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
</head>
<style type="text/css"></style>

<body>
    <?php include_once('includes/header.php');?>
    <!-- Header-->
    <header class="bgtheme py-3">
        <div class="container px-4 px-lg-5 my-5">


            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Payment</h1>
                <p>পেমেন্ট সম্পন্ন হবার পর আপনার প্রোডাক্ট আপনার কাছে পাঠিয়ে দেয়া হবে।</p>
            </div>

        </div>
    </header>
    <!-- Section-->
    <section class="py-5 my-5">
        <div class="container px-4  mt-5">


            <form method="post" name="signup">
                <div class="row">
                    <div class="col-2">Total Payment</div>
                    <div class="col-6"><input type="text" name="totalamount" value="<?php echo  $_SESSION['gtotal'];?>"
                            class="form-control" readonly></div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">Payment Type</div>
                    <div class="col-6">

                        <select class="form-control" name="paymenttype" id="paymenttype" required>
                            <option value="">পেমেন্ট অপশন সিলেক্ট করুন</option>
                            <option value="Rocket">DBBL- Rocket</option>
                            <option value="Bkash">Bkash</option>
                            <option value="NAGAD">NAGAD</option>
                            <option value="Internet Banking">Internet Banking</option>
                            <option value="Debit/Credit Card">Debit/Credit Card</option>
                            <option value="Cash on Delivery">পন্য হাতে পেয়ে টাকা পরিশোধ করবো</option>
                        </select>
                    </div>

                </div>


                <!-- Payment option when select Rocket  -->

                <div class="row mt-3" id="txnno_r">

                    <div class="row align-items-center">
                        <div class="col-2"></div>
                        <div class="col-3"><img class="my-2" src="assets/rocket.png" width="200px" alt=""
                                style="border-radius:150px"></div>
                        <div class="col-7">
                            <h2>018188575871</h2>
                            এই রকেট নাম্বারে আপনার পেমেন্ট সেন্ড মানি করুন <br>
                            এবং আপনার ট্রানজেকশন নাম্বার টি নিচে লেখুন <br>
                        </div>
                    </div>
                </div>


                <!-- Payment option when select Bkash  -->

                <div class="row mt-3" id="txnno_b">

                    <div class="row align-items-center">
                        <div class="col-2"></div>
                        <div class="col-3"><img class="m-2" src="assets/bkash.png" width="300px" alt=""></div>
                        <div class="col-7">
                            <h2>01818857587</h2>
                            এই বিকাশ নাম্বারে আপনার পেমেন্ট সেন্ড মানি করুন <br>
                            এবং আপনার ট্রানজেকশন নাম্বার টি নিচে লেখুন <br>
                        </div>
                    </div>


                </div>

                <!-- Payment option when select Nagad  -->

                <div class="row mt-3" id="txnno_n">

                    <div class="row align-items-center">
                        <div class="col-2"></div>
                        <div class="col-3"><img class="m-2" src="assets/nagad.png" width="300px" alt=""></div>
                        <div class="col-7">
                            <h2>01818857587</h2>
                            এই নগদ নাম্বারে আপনার পেমেন্ট সেন্ড মানি করুন <br>
                            এবং আপনার ট্রানজেকশন নাম্বার টি নিচে লেখুন <br>
                        </div>
                    </div>




                </div>


                <!-- Payment option when select Internet Banking  -->

                <div class="row mt-3" id="txnno_i">

                    <div class="row align-items-center">
                        <div class="col-2"></div>
                        <div class="col-3"><img class="m-2" src="assets/ibanking.png" width="300px" alt=""></div>
                        <div class="col-7">
                            <h2>9990987637829029</h2>
                            এই একাউন্টে আপনার ব্যালেন্স ট্রান্সফার করুন <br>
                            এবং আপনার ট্রানজেকশন নাম্বার টি নিচে লেখুন <br>
                        </div>
                    </div>
                </div>
                <!-- Payment option when select card  -->

                <div class="row mt-3" id="txnno_c">

                    <div class="row align-items-center">
                        <div class="col-2"></div>
                        <div class="col-3"><img class="m-2" src="assets/card.png" width="300px" alt=""></div>
                        <div class="col-7">
                            <h2>939098999122223</h2>
                            এই একাউন্টে আপনার ব্যালেন্স ট্রান্সফার করুন <br>
                            এবং আপনার ট্রানজেকশন নাম্বার টি নিচে লেখুন <br>
                        </div>
                    </div>

                </div>
                <div class="row mt-3" id="tf">
                    <div class="col-2">Transaction Number</div>
                    <div class="col-6">
                        <input type="text" name="txnnumber" id="txnnumber" class="form-control" maxlength="50">
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-4">&nbsp;</div>
                    <div class="col-6"><input type="submit" name="submit" id="submit" value="জমা দিন"
                            class="btn btn-success px-5" required></div>
                </div>
            </form>

        </div>


        </div>
    </section>
    <!-- Footer-->
    <?php include_once('includes/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>


<script type="text/javascript">
    //For report file
    $('#tf').hide();
    $('#txnno_b').hide();
    $('#txnno_b').hide();
    $('#txnno_r').hide();
    $('#txnno_n').hide();
    $('#txnno_i').hide();
    $('#txnno_c').hide();
    $(document).ready(function () {
        $('#paymenttype').change(function () {
            if ($('#paymenttype').val() == 'Bkash') {
                $('#txnno_b').show();
                jQuery("#txnnumber").prop('required', true);
            } else if ($('#paymenttype').val() == '') {
                $('#txnno_b').hide();
            } else {
                $('#txnno_b').hide();

            }
        });

        $('#paymenttype').change(function () {
            if ($('#paymenttype').val() == 'Rocket') {
                $('#txnno_r').show();
                jQuery("#txnnumber").prop('required', true);
            } else if ($('#paymenttype').val() == '') {
                $('#txnno_r').hide();
            } else {
                $('#txnno_r').hide();

            }
        });


        $('#paymenttype').change(function () {
            if ($('#paymenttype').val() == 'NAGAD') {
                $('#txnno_n').show();
                jQuery("#txnnumber").prop('required', true);
            } else if ($('#paymenttype').val() == '') {
                $('#txnno_n').hide();
            } else {
                $('#txnno_n').hide();

            }
        });

        $('#paymenttype').change(function () {
            if ($('#paymenttype').val() == 'Internet Banking') {
                $('#txnno_i').show();
                jQuery("#txnnumber").prop('required', true);
            } else if ($('#paymenttype').val() == '') {
                $('#txnno_i').hide();
            } else {
                $('#txnno_i').hide();

            }
        });

        $('#paymenttype').change(function () {
            if ($('#paymenttype').val() == 'Debit/Credit Card') {
                $('#txnno_c').show();
                jQuery("#txnnumber").prop('required', true);
            } else if ($('#paymenttype').val() == '') {
                $('#txnno_c').hide();
            } else {
                $('#txnno_c').hide();

            }
        });

        $('#paymenttype').change(function () {
            if ($('#paymenttype').val() == 'Cash on Delivery') {
                $('#tf').hide();
            } else if ($('#paymenttype').val() == '') {
                $('#tf').hide();
            } else {
                $('#tf').show();
                jQuery("#txnnumber").prop('required', true);


            }
        });
    })
</script>






<?php } ?>