<?php
session_start();
require_once(__DIR__.'/../php/db_connection.php');
require_once(__DIR__.'/../php/functions.php'); 

$isLoggedIn = isset($_SESSION['email']);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$productId = 1; 

$stmt = $conn->prepare("SELECT * FROM product WHERE productid = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$productResult = $stmt->get_result();

if ($productResult->num_rows > 0) {
    $productData = $productResult->fetch_assoc();
} else {
    die("Product not found");
}

if (isset($_POST['add_to_cart']) && $isLoggedIn) {
    $quantity = 1;

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 0;
    }
    $_SESSION['cart'][$productId] += $quantity;
}

$totalItems = array_sum($_SESSION['cart']);
$subtotal = calculateSubtotal($_SESSION['cart']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/fancyCookies.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Fancy Cookies</title>
</head>

<body>

    <div class="heading">
        <h1 class="violetWhiteShadow"><a href="../test1.php">Tea Business E-Commerce Store</a></h1>
    </div>

    <ul>
        <li><a href="../test1.php">Home</a></li>
        <li>
            <div class="dropdown">
                <button class="dropbtn" onclick="window.location.href='../product.php'">Products
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="./organicCoffee.php">Organic Coffee</a>
                    <a href="./premiumTea.php">Premium Tea</a>
                    <a href="./fancyCookies.php">Fancy Cookies</a>
                </div>
            </div>
        </li>
        <li><a href="../services.php">Services</a></li>
        <li>
            <div class="dropdown">
                <button class="dropbtn">About Us
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="../aboutOurCompany.php">About Our Company</a>
                    <a href="../managementTeam.php">Management Team</a>
                    <a href="../careers.php">Careers</a>
                </div>
            </div>
        </li>
        <li><a href="../contactUs.php">Contact Us</a></li>

        <li class="search-container">
            <input type="text" placeholder="Search...">
            <button type="submit">Search</button>
        </li>

        <?php
        if (!$isLoggedIn) {
            echo '<li><a href="../login.html">Log In</a></li>';
        } else {
            echo '<li><a href="../php/logout.php">Log Out</a></li>';
        }
        ?>

    </ul>

    <div class="maindivContainer">
        <div class="div1">
            <div class="productImage">
                <h2><?php echo $productData['productname']; ?></h2>
                <img src="../images/cookies.jpg" alt="cookies">
                <p><?php echo $productData['description']; ?></p>
                <?php
                if ($isLoggedIn) {
                    echo '<form method="post" action="">';
                    echo '<input type="hidden" name="add_to_cart" value="1">';
                    echo '<button class="addtocart-button" type="submit">Add to cart</button>';
                    echo '</form>';
                } else {
                    echo '<p>Login required to add to cart</p>';
                }
                ?>
            </div>
        </div>


        <div class="div2">
            <h2 class="purchasesH2">Purchases</h2>
            <table>
                <tr>
                    <td><?php echo $totalItems; ?> items</td>
                    <td>Cart sub-total: $<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button class="checkout-button">Go to Checkout</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Copyright © 2023 Karlo Geo Abesamis</p>
    </div>

</body>

</html>
