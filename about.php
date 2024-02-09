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
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>



<style>
   /* Reset default margin and padding for the entire page */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Style the container for the "About Us" section */
.about-container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    margin-bottom: 60px;

}

/* Style the left side (image) */
.about-image {
    flex: 1;
    text-align: center;
}

/* Style the circular image */
.about-image img {
    border-radius: 50%; /* Creates an elliptical shape with a perfect circle */
    width: 200px; /* Adjust the size as needed */
    height: 200px; /* Adjust the size as needed */
}

/* Style the right side (content) */
.about-content {
    flex: 1;
    padding: 20px;
}

/* Style the heading */
.about-content h1 {
    font-size: 44px;
    margin-top: 10px;
    margin-bottom: 20px;
}

/* Style the paragraph */
.about-content p {
    font-size: 16px;
    line-height: 1.6;
}

/* Style the square image */
.about-image img {
    width: 250px; /* Adjust the width as needed */
    height: 250px; /* Set both width and height to create a square */
    border-radius: 0; /* Set border-radius to 0 to create a square shape */
    border: 2px solid #fff; /* Adds a white border around the image */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow */
    transition: transform 0.2s ease-in-out; /* Adds a smooth hover effect */

    /* Center the image within its container */
    display: block;
    margin: 0 auto;
}

/* Add a hover effect to scale the image on hover */
.about-image img:hover {
    transform: scale(1.1); /* Increase the size on hover */
}
/* Add viewport meta tag */
/* ... (existing code) ... */

/* Custom CSS for mobile responsiveness */
@media only screen and (max-width: 768px) {
   .about-container {
      flex-direction: column;
      align-items: center;
      margin-bottom: 30px;
   }

   .about-image img {
      width: 150px;
      height: 150px;
   }

   .about-content {
      text-align: center;
   }

   .about-content h1 {
      font-size: 28px;
      margin-bottom: 15px;
   }

   .about-content p {
      font-size: 14px;
   }

   /* Adjust other styles as needed for mobile */
}

@media only screen and (max-width: 600px) {
   /* Additional styles for smaller screens if necessary */
}



</style>


<div class="about-container">
        <div class="about-image">
            <img src="./images/wl.webp" alt="About Us Image">
        </div>
        <div class="about-content">
            <h1>About Us</h1>
            <p>'Ayurveda' is one of the branches that harnesses tremendous natural energies for human welfare. In today's environment, it is practically impossible to use these forces without aid, which is where "Shuddha Organic" comes in. Shuddha organic offers plant-based solutions for skin and hair care, allowing you to nurture your skin and hair organically and without adverse effects. We also make certain that we approach you directly by connecting with you so that our goal of supplying you with natural certified quality items that can heal your body and your soul is fulfilled.</p>
        </div>
</div>





<section class="about">

   <div class="row">

      

      <div class="content">
         <h3>Why Choose Us?</h3>
         <p>At our e-commerce haven, we're dedicated to handcrafting natural products for skin, hair, and body care. Your well-being is our top priority. Contact us for any questions, suggestions, or personalized orders. Let us guide you on your path to embracing the beauty of nature's gifts. Reach out now, and let's begin your journey towards a healthier and more radiant you.</p>
         <a href="contact.php" class="btn">Contact Us</a>
      </div>
      <div class="image">
         <img src="./images/aunt.png" alt="">
      </div>

   </div>

</section>










<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>