<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $db_name = 'shop_db';
    $user_name = 'root';
    $user_password = '';
    $conn = new mysqli("localhost", "$user_name", "$user_password", "$db_name");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the form
    $product_id = $_POST['product_id'];
    // echo($product_id);
    $reviewer_name = $_POST['reviewer_name'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    // Insert the review into the database
    $sql = "INSERT INTO reviews (product_id, reviewer_name, review_text, rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issi", $product_id, $reviewer_name, $review_text, $rating);

    
 if ($stmt->execute()) {
        echo "Review submitted successfully!";
        
        // Redirect to another page after a brief delay
        header("Refresh: 1; URL=quick_view.php?pid=$product_id"); // Redirect to success_page.php after 2 seconds
        exit; // Make sure to exit to prevent further script execution
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
}
?>
