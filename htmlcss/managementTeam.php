<?php
session_start(); 


function calculateSubtotal($cart) {
    
    $pdo = new PDO("mysql:host=localhost;dbname=teastore", "root", "");

    
    $subtotal = 0;

    
    foreach ($cart as $productId => $quantity) {
        
        $stmt = $pdo->prepare("SELECT price FROM product WHERE productid = :productid");
        $stmt->bindParam(":productid", $productId, PDO::PARAM_INT);
        $stmt->execute();
        
        
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $productPrice = $product['price'];

       
        $subtotal += $productPrice * $quantity;
    }

    return $subtotal;
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


$isLoggedIn = isset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/managementTeam.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Management Team</title>
</head>


<body>
   
    <div class="heading">
        <h1 class="violetWhiteShadow"><a href="../test1.php">Tea Business E-Commerce Store</a></h1>
    </div>

    <ul>
        <li><a href="../htmlcss/test1.php">Home</a></li>
        <li>
            <div class="dropdown">
                <button class="dropbtn"onclick="window.location.href='/htmlcss/product.php'">Products
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                        <a href="./products/fancyCookies.php">Organic Coffee</a>
                        <a href="./products/premiumTea.php">Premium Tea</a>
                        <a href="./products/fancyCookies.php">Fancy Cookies</a>
                </div>
            </div>
        </li>
        <li><a href="../htmlcss/services.php">Services</a></li>
        <li>
            <div class="dropdown">
                <button class="dropbtn">About Us
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="./aboutOurCompany.php">About Our Company</a>
                    <a href="./managementTeam.php">Management Team</a>
                    <a href="./careers.php">Careers</a>    
                </div>
            </div>
        </li>    
        <li><a href="./contactUs.php">Contact Us</a></li>

        <li class="search-container">
            <input type="text" placeholder="Search...">
            <button type="submit">Search</button>
        </li>

    

        <?php
        if (!$isLoggedIn) {
            echo '<li><a href="./login.html">Log In</a></li>';
        } else {
            echo '<li><a href="php/logout.php">Log Out</a></li>';
        }
        ?>

    </ul>


<div class="maindivContainer">
    <div class="div1">
        <div class="productImage">
            <h2>Management Team</h2>
            <img src="./images/managementTeam.jpg" alt="managementTeam">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta repellendus voluptatibus, unde ratione praesentium numquam possimus earum voluptas. Sapiente voluptate dolorum porro eum architecto, doloribus maiores eligendi ratione et laudantium.</p>
            
        </div>
    </div>
 
   
    <div class="div2">
            <h2 class="purchasesH2">Purchases</h2>
            <table>
                <tr>
                    <td><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?> items</td>
                    <td>Cart sub-total: $<?php echo isset($_SESSION['cart']) ? number_format(calculateSubtotal($_SESSION['cart']), 2) : 0; ?></td>
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