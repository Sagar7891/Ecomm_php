<style>
   .total-box {
  display: flex;
  flex-direction: column; /* Display items in a column */
  background-color: #f8f8f8;
  padding: 20px;
  border-radius: 8px;
  border: 1px solid #ddd;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin: 0 auto; /* Center the total-box */
  margin-bottom: 20px;
  max-width: 600px;
}


.left-section {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

.total-amount,
.total-amount-value {
  margin-bottom: 5px;
  font-size: 15px; /* Adjust the font size as needed */
}

/* Additional styling for the grand total */
.total-amount-value#p {
  font-size: 13px; /* Adjust the font size for the grand total */
}



}

/* Styles for the form */
.flex {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.inputBox {
    flex: 1 1 calc(50% - 10px); /* Two columns on larger screens, adjust as needed */
}

.inputBox span {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

/* Adjustments for smaller screens */
@media only screen and (max-width: 768px) {
    .inputBox {
        flex: 1 1 100%; /* Full width on smaller screens */
    }

    .inputBox span {
        text-align: left; /* Align text to the left */
        margin-bottom: 5px; /* Maintain some space between the span and input */
    }
}

/* Styles for the submit button */
.btn {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

/* Disabled button style */
.disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
.img{
         max-width: 100px; /* Set the maximum width for the product image */
  height: auto; 
  margin-left: 30%; 
      }
      p{
         display: inline-block;
         color: #333; 
         font-weight: bold; 
  
      }
      .container
      {
         display: inline-block;
         width: 48%; 
         padding: 10px;
         box-sizing: border-box; 
      }
         .display-orders p{
      display: inline-block;
      padding:1rem 2rem;
      margin:1rem .5rem;
      font-size: 2rem;
      text-align: center;
      border:var(--border);
      background-color: var(--white);
      box-shadow: var(--box-shadow);
      border-radius: .5rem;
   }

</style>

<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      // Retrieve the auto-generated order_id
    $order_id = generateOrderId();

      $insert_order = $conn->prepare("INSERT INTO `orders` (order_id, user_id, name, number, email, address, total_products, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $insert_order->execute([$order_id, $user_id, $name, $number, $email, $address, $total_products, $total_price]);

    

    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);

    $message[] = 'Order placed successfully! Your Order ID is ' . $order_id;

    header('Location: success.php');
    exit(); // Make sure to exit after redirecting to prevent further script execution
   }else{
      $message[] = 'your cart is empty';
   }

}

function generateOrderId() {
   $timestamp = time(); // Get the current timestamp
   $random_component = mt_rand(10000, 99999); // Generate a random component

   // Combine timestamp and random component to create a unique numeric order ID
   $order_id = $timestamp . $random_component;

   return $order_id;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">



   <script>
  function validateMobileNumber() {
    var mobileNumber = document.getElementsByName("number")[0].value;
    
    if (mobileNumber.length < 10) {
      alert("Mobile number should be at least 10 digits.");
      return false; // Prevent form submission
    }
    return true; 
  }
</script>
   
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">
<form action="" method="POST" onsubmit="return validateMobileNumber();">



   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
$new_total = 0; // Initialize $new_total to 0
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the grand total is provided in the form
    if (isset($_POST['new_total'])) {
        $new_total = $_POST['new_total'];
    } else {
        // Handle the case where the grand total is not provided
        // You can show an error message or redirect the user back to the cart page.
    }
}
?>
      <?php
         
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               
      ?>
      
      <div class="container">
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '₹ '.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
         <img class="img" src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      </div>
      
         
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
      </div>

      





<div class="total-box">
    

    <?php
    $neww_total = 0;
    if ($new_total < 999) {
        $shipping_charges = 69;
        $neww_total = $new_total + $shipping_charges;
        $shipping_message = "Shipping Charges: ₹ " . $shipping_charges;
    } else {
        $neww_total = $new_total;
        $shipping_charges = 0;
        $shipping_message = "Shipping Charges: 0";
    }
    ?>

<h4 style="font-size: 22px; text-align: center; font-weight: bold;">PRICE DETAILS</h4>

<div class="left-section">
  <p class="total-amount">Items Total:</p>
  <p class="total-amount-value" id="p">₹ <?php echo $new_total; ?></p>
</div>
<div class="left-section">
<p class="total-amount" id="po">Shipping Charges:</p>
  <p class="total-amount-value" id="p">+ ₹ <?php echo $shipping_charges; ?></p>
</div>
<div class="left-section">
<p class="total-amount" id="p">Grand Total:</p>
  <p class="total-amount-value" id="p">₹ <?php echo $neww_total; ?></p>
  <input type="hidden" name="total_products" value="<?= $total_products; ?>">
  <input type="hidden" name="total_price" value="<?= $neww_total; ?>" value="">
</div>




</div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Name :</span>
            <input type="text" name="name" placeholder="Enter Your Name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Number :</span>
            <input type="number" name="number" placeholder="Enter Your Number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" placeholder="Enter Your Email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Address Line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Address Line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="e.g. Mumbai" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>State :</span>
            <input type="text" name="state" placeholder="e.g. Maharashtra" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" placeholder="e.g. India" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Pin Code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>
      <input type="submit" name="order" class="btn <?= ($new_total > 1)?'':'disabled'; ?>" value="place order">
      
      
   </form>
   
</section>
<!-- <a href="payscript.php?amount=<?php echo $grand_total; ?>">Proceed to Payment</a> -->














<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>