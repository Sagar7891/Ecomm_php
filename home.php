<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <!--<link rel="stylesheet" href="css/styless.css">-->
   

</head>
<body>
   
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



<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/main_1.png" alt="">
         </div>
         <div class="content">
            <span>Flat 20% off</span>
            <h3>On All Products</h3>
            <a href="./hair.php" class="btn">shop now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/main1.png" alt="">
         </div>
         <div class="content">
            <span>Flat 20% off</span>
            <h3>Face Products</h3>
            <a href="./face.php" class="btn">shop now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/main_3.jpg" alt="">
         </div>
         <div class="content">
            <span>Flat 20% off</span>
            <h3>Oral Hygiene</h3>
            <a href="./body.php" class="btn">shop now</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <h1 class="heading">shop by category</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="./hair.php" class="swiper-slide slide">
      <img src="images/hair_logoo.png" alt="">
      <h3>Hair Care</h3>
   </a>
  

   <a href="./body.php" class="swiper-slide slide">
      <img src="images/body_logg.png" alt="">
      <h3>Body Care</h3>
   </a>

   <a href="./face.php" class="swiper-slide slide">
      <img src="images/face_logoo.png" alt="">
      <h3>Face Care</h3>
   </a>

   <a href="category.php?category=lip" class="swiper-slide slide" id="mii">
      <img src="images/lip_logooo.png" alt="">
      <h3>Lip Care</h3>
   </a>

   <a href="category.php?category=foot" class="swiper-slide slide">
      <img src="images/foot_logoo.png" alt="">
      <h3>Foot Care</h3>
   </a>

   <a href="category.php?category=tooth" class="swiper-slide slide">
      <img src="images/oral_logoo.png" alt="">
      <h3>Oral Care</h3>
   </a>

   <a href="category.php?category=welness" class="swiper-slide slide">
      <img src="images/welness_logo.png" alt="">
      <h3>Wellness Products</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">latest products</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id % 2 = 1 LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   
   <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input class="imgg" type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>₹ </span><?= $fetch_product['price']; ?><span>/-</span></div>
      </div>
   </form>
   </a>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>



<section class="home-products">

   <h1 class="heading">BestSeller</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id % 2 = 0 LIMIT 10"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
         <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>
   <form action="" method="post" class="swiper-slide slide">
         
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>₹ </span><?= $fetch_product['price']; ?><span>/-</span></div>
      </div>
   </form>
              </a>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>







<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
