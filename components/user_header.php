
    
<style>
   .logo-heading {
    color: #000; /* Set the color of the heading */
    margin-left: 10px; /* Adjust the margin as needed */
    font-size:15px;
}
#pqw {
    display: flex;
    align-items: center; /* Center vertically */
}



</style>

<style>
    /* Resetting some default styles for better consistency */
    

  

    /* Styles for the delivery message */
    .delivery-message {
    font-size: 20px;
    color: #333;
    text-align: center;
    background: linear-gradient(to right, #2ecc71, #3498db, #9b59b6); /* Three shades of color */
    border: 1px solid #fff; /* Light white border */
    padding: 6px; /* Add some padding for better visual */
}
.logo {
    width: 55px; /* Adjust the width as needed */
    height: auto; /* Maintain the aspect ratio */
}
.logo1 {
    width: 83px; /* Adjust the width as needed */
    height: auto; /* Maintain the aspect ratio */
}

/* Optional: Add some spacing between the images */
.logo-link {
    margin-right: 20px; /* Adjust the margin as needed */
}



/* Styles for smaller screens (768 pixels or less) */
@media (max-width: 768px) {
    .average-rating {
        float: none;
        text-align: center;
        font-size: 16px; /* Adjust font size for smaller screens */
    }

    .review {
        padding: 10px;
    }

    .star-ratings {
        text-align: center;
    }

    form {
        text-align: center;
        margin-top: 10px;
    }

    /* Additional styles for mobile responsiveness */
    .logo {
        width: 40px; /* Adjust logo size for smaller screens */
    }

    .logo1 {
        width: 60px; /* Adjust logo size for smaller screens */
    }

    .logo-link {
        margin-right: 10px; /* Adjust margin for smaller screens */
    }

    .linkk {
        font-size: 14px; /* Adjust font size for smaller screens */
    }

    .fa-bars,
    .fa-magnifying-glass,
    .fa-heart,
    .fa-cart-shopping,
    .fa-user {
        font-size: 18px; /* Adjust icon size for smaller screens */
    }

    .btn,
    .option-btn,
    .delete-btn {
        font-size: 12px; /* Adjust button font size for smaller screens */
        padding: 5px 8px; /* Adjust button padding for smaller screens */
    }
}

</style>


   
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">
   <div id="pqw">
    <a href="home.php" class="logo-link" id="logo"><img src="./lll.png" alt="" class="logo"></a>
    <a href="home.php" class="logo-link" id="logo"><img src="./lll1.png" alt="" class="logo1"></a>
</div>


    <nav class="navbar">
        <a href="home.php" class="linkk">Home</a>
        <a href="shop.php" class="linkk">Shop</a>
        <a href="orders.php" class="linkk">Orders</a>
        <a href="about.php" class="linkk">About</a>
        <a href="contact.php" class="linkk">Contact</a>
    </nav>
   
      <div class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-magnifying-glass"></i></a>
         <a href="wishlist.php"><i class="fa-regular fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-cart-shopping"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fa-regular fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["name"]; ?></p>
         <a href="update_user.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">register</a>
            <a href="user_login.php" class="option-btn">login</a>
         </div>
         <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
         <?php
            }else{
         ?>
         <p>please login or register first!</p>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">register</a>
            <a href="user_login.php" class="option-btn">login</a>
         </div>
         <?php
            }
         ?>   
         
         
         
      </div>

   </section>

</header>
<h4 class="delivery-message">FREE SHIPPING ON ALL ORDERS ABOVE ₹ 999/-</h4>