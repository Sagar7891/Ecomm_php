<?php
include 'components/connect.php'; // Include the database connection file

// Your success message or any other PHP logic can go here

?>
<?php
// Start the session (if not already started)
session_start();

// Check if the user is logged in and their user ID is stored in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect the user to the login page or handle the case where the user is not logged in
    // For example:
    // header("Location: login.php");
    // exit();
}

// Now $user_id is defined and can be used in user_header.php
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <!-- Link to your custom CSS file -->
    <!-- You can also include Bootstrap or other CSS frameworks here if desired -->
    <style>
        /* Add any additional styles here */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .success-message {
            text-align: center;
            margin-top: 50px;
        }
        .container {
    text-align: center;
    margin-top: 50px;
}

.success-icon {
    font-size: 48px;
    color: green;
}

h1 {
    font-size: 32px;
}

p {
    font-size: 18px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <?php include './components/user_header.php'; ?>

    <div class="container">
    <span class="success-icon">&#10004;</span>
    <h1>Order Successfully Placed</h1>
    <p>Thank you for your order!</p>
    <a class="btn" href="home.php">Continue Shopping</a>
</div>


    <?php include './components/footer.php'; ?>
</body>
</html>
