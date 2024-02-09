<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
<style>
    /* Style for the coupon code form container */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}

label {
    font-weight: bold;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 10px 20px;
    background-color: #007BFF; /* Change this to your preferred button color */
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3; /* Change this to your preferred button color on hover */
}

/* Style for the message displayed after applying a coupon */
p {
    padding: 10px;
    text-align: center;
    background-color: #4CAF50; /* Change this to your preferred success message background color */
    color: #fff;
    border-radius: 4px;
}

/* Style for the error message when the coupon is not valid or doesn't qualify */
.error-message {
    background-color: #FF5733; /* Change this to your preferred error message background color */
}


.container {
    margin-left: 430px;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 300px;
    width: 100%;
}

.total-amount {
    font-size: 18px;
    margin-bottom: 20px;
}

.coupon-form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
}

.coupon-input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 12px;
}

.apply-coupon-btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.apply-coupon-btn:hover {
    background-color: #0056b3;
}


</style>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">shopping cart</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $new_total=0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
  
  <form action="" method="post" class="box">
    <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
    <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
    <div class="name"><?= $fetch_cart['name']; ?></div>
    <div class="flex">
        <div class="price">₹ <?= $fetch_cart['price']; ?>/-</div>
        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
        <button type="submit" class="fas fa-edit" name="update_qty"></button>
    </div>
    <div class="sub-total">Sub Total: <span>₹ <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span></div>
    <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
</form>













   <?php
   $grand_total += $sub_total;
   $new_total = $grand_total;
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>









<?php
// Database connection
$db_name = 'mysql:host=localhost;dbname=shop_db';
$user_name = 'root';
$user_password = '';

try {
    $pdo = new PDO($db_name, $user_name, $user_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if a coupon code is submitted

$coupon_applied = false; // Variable to track whether the coupon is applied

if (isset($_POST['coupon_code'])) {
    $coupon_code = $_POST['coupon_code'];

    // Query the database to check if the coupon code is valid and active
    $sql = "SELECT * FROM coupons WHERE code = ? AND expiry_date >= NOW() AND active = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$coupon_code]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon) {
        // Check if the order total is within the specified price range
        $min_price_range = 50; // Replace with your minimum price range
        $max_price_range = 100000000000; // Replace with your maximum price range

        if ($grand_total >= $min_price_range && $grand_total <= $max_price_range) {
            // Apply the percentage discount to the order total
            $discount_percentage = $coupon['discount']; // Assuming the 'discount' field in the database contains the percentage

            $discount = $grand_total * ($discount_percentage / 100);
            $new_total = $grand_total - $discount;

            $coupon_applied = true; // Set the variable to true if the coupon is applied
        } else {
            // Inform the user that the order total doesn't qualify for the coupon
            $new_total = $grand_total;
            $message = "Coupon code can only be applied for orders within the specified price range.";
        }
    } else {
        // Inform the user that the coupon code is invalid
        $new_total = $grand_total;
        $message = "Invalid or expired coupon code.";
    }
}
?>







<!-- Display the coupon application result message -->
<?php if (isset($message)): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

















   <?php
// Database connection
$db_name = 'mysql:host=localhost;dbname=shop_db';
$user_name = 'root';
$user_password = '';

try {
    $pdo = new PDO($db_name, $user_name, $user_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Query the database to retrieve all active coupons
$sql = "SELECT * FROM coupons WHERE expiry_date >= NOW() AND active = 1";
$stmt = $pdo->query($sql);
$coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!--
    <h1>Available Coupons</h1>
    <ul>
        <?php foreach ($coupons as $coupon): ?>
            <li>
                <strong>Coupon Code:</strong> <?php echo $coupon['code']; ?><br>
                <strong>Discount:</strong> $<?php echo $coupon['discount']; ?><br>
                <strong>Expiry Date:</strong> <?php echo $coupon['expiry_date']; ?><br>
            </li>
        <?php endforeach; ?>
    </ul>

        -->






   


   
    







   

   <div class="cart-total">
   
   

<!-- Form for entering the coupon code -->
<style>
    .bu {
  display: flex; /* Use flexbox to align items horizontally */
  gap: 10px; /* Adjust the gap between buttons as needed */
}

.option-btn,
.delete-btn {
  display: inline-block; /* Ensure each button is on the same line */
  padding: 10px 15px; /* Adjust padding as needed */
  text-decoration: none; /* Remove default underline styling for links */
  color: #ffffff; /* Set text color */
  border-radius: 5px; /* Add rounded corners */
  cursor: pointer; /* Change cursor on hover */
}

.delete-btn.disabled {
  pointer-events: none; /* Disable click events for disabled button */
  opacity: 0.5; /* Reduce opacity for a disabled look */
}

</style>
<div class="bu">
  <a href="shop.php" class="option-btn">Continue Shopping</a>
  <a href="cart.php?delete_all" class="delete-btn <?= ($new_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all items from the cart?');">Delete All Items</a>
</div>
<style>
    .spacing-class {
    margin-bottom: 20px; /* Adjust the value as needed */
}

</style>
<style>
        .form-wrapper {
            text-align: center;
        }

        .coupon-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .total-amount {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .coupon-applied-message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .coupon-input {
            font-size: 16px;
            padding: 8px;
            margin-bottom: 15px;
        }

        .apply-coupon-btn,
        .remove-coupon-btn {
            background-color: #4caf50;
            color: #fff;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .spacing-class {
            margin-top: 15px;
            border: 1px solid black;
            background-color: white;
            color: red !important;
        }

    </style>
<style>
    .coupon-applied-message {
        background-color: white; /* Add this line to set the background color to white */
        padding: 10px; /* You can adjust the padding as needed */
        border: 1px solid #ccc; /* Add a border for better visibility */
    }
</style>

<div class="form-wrapper">
    <form class="coupon-form" method="post" action="">
        <p class="total-amount">Items Total: ₹ <?php echo $grand_total; ?>/-</p>
        <?php if ($coupon_applied): ?>
            <p class="coupon-applied-message">Coupon Applied!</p>
        <?php else: ?>
            <label for="coupon_code" style="font-size: 20px;">Enter Coupon Code:</label>
            <input type="text" name="coupon_code" id="coupon_code" class="coupon-input" />
        <?php endif; ?>
        <?php if ($coupon_applied): ?>
            <button type="submit" class="remove-coupon-btn">Remove Coupon</button>
        <?php else: ?>
            <button type="submit" class="apply-coupon-btn">Apply Coupon</button>
        <?php endif; ?>
        <p class="total-amount spacing-class">Grand Total: ₹ <?php echo $new_total; ?>/-</p>
    </form>
</div>





      <form action="checkout.php" method="post">
    <!-- Hidden input field to store the new total -->
    <input type="hidden" name="new_total" value="<?= $new_total; ?>">
    <!-- Add other form fields as needed -->
    <input type="submit" value="Proceed to Checkout" style="
    background-color: #4CAF50; /* Green background color */
    color: white; /* White text color */
    padding: 10px 20px; /* Padding */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    text-align: center; /* Center text */
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Display as inline-block for proper spacing */
    font-size: 16px; /* Font size */
    margin: 10px 0; /* Margin */
    cursor: pointer; /* Cursor on hover */
    transition: background-color 0.3s; /* Smooth transition for background color */
">


</form>



   </div>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>