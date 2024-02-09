<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
    form {
  display: inline-block; /* Make the form and button inline */
}




   </style>

</head>
<body>
<?php include 'components/user_header.php'; ?>
<style>
   #bb {
        background-color: #2980b9;
        font-size:20px;
        
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        float: right;
        margin-top: 10px; /* Adjust the margin-top as needed */
    }

    #bb:hover {
        background-color: #1c6fa3; /* Change color on hover if desired */
        color:#FFFFFF;
    }
</style>

<section class="orders">
    <h1 class="heading">Placed Orders</h1>
    <div class="box-container">
        <?php
        if ($user_id == '') {
            echo '<p class="empty">Please login to see your orders</p>';
        } else {


            $select_orders = $conn->prepare("SELECT o.*, p.image_01 AS product_image
            FROM `orders` AS o
            INNER JOIN `products` AS p ON o.product_id = p.id
            WHERE o.user_id = ?
            ORDER BY o.placed_on DESC");

$select_orders->execute([$user_id]);




            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);

            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                    <button id="bb">
                        <a href="https://ecomexpress.in/tracking/" style="color: white !important; text-decoration: none;">Track Order</a>
                    </button>


                        <p>Order ID: <span><?= $fetch_orders['order_id']; ?></span></p>
                        
                        <p>Tracking ID: <span><?= $fetch_orders['delivery_id']; ?></span></p>
                        <p>Placed on: <span><?= $fetch_orders['placed_on']; ?></span></p>
                        







                        <p>Name: <span><?= $fetch_orders['name']; ?></span></p>
                        <p>Email: <span><?= $fetch_orders['email']; ?></span></p>
                        <p>Number: <span><?= $fetch_orders['number']; ?></span></p>
                        <p>Address: <span><?= $fetch_orders['address']; ?></span></p>
                        <p>Your Orders: <span><?= $fetch_orders['total_products']; ?></span></p>
                        <p>Total Price: <span>₹ <?= $fetch_orders['total_price']; ?>/-</span></p>
                        <p>Delivery Status: <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                            echo 'red';
                        } else {
                            echo 'green';
                        } ?>"><?= $fetch_orders['payment_status']; ?></span></p>
                    </div>


                    




                    <?php
                }
            } else {
                echo '<p class="empty">No orders placed yet!</p>';
            }
        }
        ?>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>