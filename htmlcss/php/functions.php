<?php

function calculateSubtotal($cart) {
    global $conn;

    $subtotal = 0;

    foreach ($cart as $productId => $quantity) {
        $stmt = $conn->prepare("SELECT price FROM product WHERE productid = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        $product = $stmt->get_result()->fetch_assoc();

        if ($product) {
            $productPrice = $product['price'];
            $subtotal += $productPrice * $quantity;
        } else {
            echo "Product not found in the database for product ID: $productId";
        }
    }

    return $subtotal;
}


function sanitizeInput($input) {
    $input = trim($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
   

    return $input;
}
?>