<?php
include 'components/connect.php';

if (isset($_POST['delete_review'])) {
    $review_id = $_POST['review_id'];

    try {
        // Implement code to delete the review with $review_id from the database
        // Execute a DELETE statement here
        $sql = "DELETE FROM reviews WHERE id = :review_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
        $stmt->execute();
        

        // After deletion, you can redirect the user back to the product page or the review section
        header("Location: quick_view.php?pid=" . $_POST['pid']);

        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
