<?php

include 'components/connect.php';

session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

$sql = "SELECT name FROM users WHERE id = :user_id";
$stmt = $conn->prepare($sql);

if ($stmt) {
   $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
   $stmt->execute();
   $user_name_from_database = $stmt->fetchColumn(); // Fetch the result directly
   // You can also use $stmt->fetch(PDO::FETCH_ASSOC); to fetch as an associative array
}

// Close the database connection


include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/stylesss.css">
   <link rel="stylesheet" href="css/style.css">


<script>
   const starInputs = document.querySelectorAll('.star-rating input');
const starLabels = document.querySelectorAll('.star-rating label');

// Attach a click event listener to each star label
starLabels.forEach((label, index) => {
    label.addEventListener('click', () => {
        // Set the checked state of star inputs up to the clicked index
        for (let i = 0; i <= index; i++) {
            starInputs[i].checked = true;
        }
    });
});
</script>


</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="heading">quick view</h1>

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   



  
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>" style="font-weight: bold !important;">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <div class="row">
         <div class="image-container">
            
            
            <div class="main-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_04']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_05']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name" id="name"><?= $fetch_product['name']; ?></div>
            <div class="flex">
               <div class="price" id="price"><span>₹ </span><?= $fetch_product['price']; ?><span>/-</span></div>
               <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
           <div class="flex-btn">
           

        

<div id="cart-container">
  <input type="submit" value="Add to Cart" class="form-button btn" name="add_to_cart">
  <input class="form-button option-btn" type="submit" name="add_to_wishlist" value="Add to Wishlist">
</div>


</div>

            
         </div>
      </div>
   </form>









<!-- Your existing HTML code -->
<div class="description-features-container">
  <form class="description-form">
    <h1 class="heading">Description</h1>
    <div class="details"><?= $fetch_product['details']; ?></div>
  </form>

  <div class="features-form">
    <h3>Product Features:</h3>
    <ul>
      <?php
      // Get features from the database and explode them using commas
      $features = explode(',', $fetch_product['features']);

      // Iterate through features and display as bullet points
      foreach ($features as $feature) {
        // Trim each feature to remove leading/trailing whitespaces
        $trimmedFeature = trim($feature);

        // Display the feature as a list item
        echo '<li>' . $trimmedFeature . '</li>';
      }
      ?>
    </ul>
  </div>
</div>












<?php
// Function to generate star ratings
function generateStarRatings($rating) {
    $stars = "";
    for ($i = 1; $i <= 5; $i++) {
        $starClass = ($i <= $rating) ? 'yellow' : 'white';
        $stars .= '<span class="star ' . $starClass . '">&#9733</span>';
    }
    return $stars;
}

?>

<!-- Add Review Form -->
<?php if (isset($user_name_from_database)) : ?>
   <script>
      const starInputs = document.querySelectorAll('.star-rating input');

      starInputs.forEach((input) => {
          input.addEventListener('click', () => {
              const rating = input.value;
              for (let i = 0; i < starInputs.length; i++) {
                  starInputs[i].checked = i < rating;
              }
          });
      });
   </script>

   

   <form action="submit_reviews.php" method="post" class="review-form">
      <h3 style="color: black;">Add Review</h3>
      <input type="hidden" name="product_id" value="<?php echo $_GET['pid']; ?>">
      <input class="plo" type="text" name="reviewer_name" value="<?php echo $user_name_from_database; ?>" readonly>

      <h3 style="color: orange;">Ratings</h3>

      <div class="star-rating">
          <input type="radio" name="rating" value="1" id="1-stars">
          <label for="1-stars"></label>
          <input type="radio" name="rating" value="2" id="2-stars">
          <label for="2-stars"></label>
          <input type="radio" name="rating" value="3" id="3-stars">
          <label for="3-stars"></label>
          <input type="radio" name="rating" value="4" id="4-stars">
          <label for="4-stars"></label>
          <input type="radio" name="rating" value="5" id="5-stars">
          <label for="5-stars"></label>
      </div>
      <textarea name="review_text" class="box" placeholder="Enter your review" cols="30" rows="5" required></textarea>

      <input type="submit" value="Submit Review" name="submit" style="font-size: 12px; padding: 5px 10px; margin-right: 10px;">

   </form>
<?php else : ?>
   <p>You must be logged in to add a review.</p>
<?php endif; ?>
<!-- End Add Review Form -->
<style>
   @media (max-width: 768px) {
    .average-rating-container,
    .reviews-heading,
    .delete-form {
        text-align: center;
    }

    .average-rating {
        margin-top: 10px;
    }

    .review {
        padding: 10px;
    }

    .star-ratings {
        text-align: center;
    }

    .delete-button {
        margin-top: 10px;
    }
}
</style>

<?php

if (isset($_GET['pid'])) {
    $product_id = $_GET['pid'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM reviews WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    echo '<div class="review-section">';

    // Display average rating
    if ($rowCount > 0) {
        // Calculate and display the average rating
        $totalRating = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $totalRating += $row["rating"];
        }

        $averageRating = ($totalRating > 0) ? round($totalRating / $rowCount, 1) : 0;

        // Style the average rating
        echo '<p class="average-rating" style="float: right; font-size: 19px; color: #FFA500; margin-top: -10px;">';
        echo 'Average Rating: ' . generateStarRatings($averageRating);
        echo '</p>';
        echo "<h2>Product Reviews</h2>";

        $stmt->execute(); // Reset the statement to fetch reviews again

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="review">';
            echo '<h3>' . $row["reviewer_name"] . '</h3>';
            // Display star ratings using the generateStarRatings function
            echo '<div class="star-ratings">';
            echo generateStarRatings($row["rating"]);
            echo '</div>';
            echo '<p>' . $row["review_text"] . '</p>';

            // Add a Delete button with a form to delete the review
            echo '<form action="delete_review.php" method="post">';
            echo '<input type="hidden" name="review_id" value="' . $row["id"] . '">';
            echo '<input type="hidden" name="pid" value="' . $_GET['pid'] . '">';
            echo '<input type="submit" value="Delete Review" name="delete_review" style="font-size: 12px; padding: 5px 10px; margin-right: 10px; border-radius: 5px; cursor: pointer; color: #1e0702 !important;">';
            echo '</form>';

            echo '</div>';
        }
    } else {
        echo '<p class="no-reviews">No reviews available.</p>';
    }

    echo '</div>';
} else {
    echo "Product ID (pid) not provided.";
}
?>




   <?php
     }
   } else {
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>


</body>
</html>