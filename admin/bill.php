


<?php

include '../components/connect.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the database based on the order_id
    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
    $select_order->execute([$order_id]);

    if ($select_order->rowCount() > 0) {
        $fetch_order = $select_order->fetch(PDO::FETCH_ASSOC);

        // Generate and display the bill content
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Order Bill</title>';
        echo '<link rel="stylesheet" href="../css/bill_style.css">'; // Add your CSS file link
        echo '</head>';
        echo '<body>';

        echo '<div class="bill-container">';
        echo '<h2>Order Bill</h2>';
        echo '<p><strong>Order ID:</strong> ' . $fetch_order['order_id'] . '</p>';
        echo '<p><strong>Name:</strong> ' . $fetch_order['name'] . '</p>';
        echo '<p><strong>Number:</strong> ' . $fetch_order['number'] . '</p>';
        echo '<p><strong>Email:</strong> ' . $fetch_order['email'] . '</p>';
        echo '<p><strong>Address:</strong> ' . $fetch_order['address'] . '</p>';
        echo '<p><strong>Total Products:</strong> ' . $fetch_order['total_products'] . '</p>';
        echo '<p><strong>Total Price:</strong> Rs ' . $fetch_order['total_price'] . '/-</p>';

        // Display product details, you can loop through products if there are multiple
    
        // Add other product details based on your needs

        echo '<p><strong>Payment Method:</strong> ' . $fetch_order['method'] . '</p>';
        echo '<p><strong>Payment Status:</strong> ' . $fetch_order['payment_status'] . '</p>';
        echo '<p><strong>Delivery ID:</strong> ' . $fetch_order['delivery_id'] . '</p>';

        echo '</div>';

        echo '</body>';
        echo '</html>';
    } else {
        echo '<p>Order not found!</p>';
    }
} else {
    echo '<p>Invalid request! Order ID not provided.</p>';
}

?>
