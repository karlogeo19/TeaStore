<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productid']) && isset($_POST['quantity'])) {
        $productid = $_POST['productid'];
        $quantity = $_POST['quantity'];
        
        $product = fetchProductDetails($productid);

        addToCart($productid, $product['productname'], $product['price'], $quantity);

        header("Location: fancyCookies.php");
        exit();
    }
}

function fetchProductDetails($productid) {
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "teastore";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

  
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $sql = "SELECT * FROM product WHERE productid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $product;
    } else {
        
        $stmt->close();
        $conn->close();
        return null;
    }
}

function addToCart($productid, $productname, $price, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productid'] == $productid) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $item = array(
            'productid' => $productid,
            'productname' => $productname,
            'price' => $price,
            'quantity' => $quantity
        );
        $_SESSION['cart'][] = $item;
    }
}
?>
