<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    

    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <link rel="stylesheet" href="/css/flex.css" type="text/css">
        <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


</head>
<body>

    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>

<?php 
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.products.php";
        $shop = new WebshopShop();
        if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']):
    ?>
    <!-- IF LOGGED IN -->

        <h2>Orders</h2>

    <ul class="category">
        <?php
            
            $shoppingCart = $shop->getOrders($_SESSION['username']);
            foreach($shoppingCart as $row)
            {
                product::printOrderItem($row);
            }
            echo '<hr>';
        ?>
    </ul>

    

    <?php 
        else:
    ?>
    <!-- IF NOT LOGGED IN -->

        <h3>Not logged in</h3>
        <p>You can login <a href="/pages/account.php">here</a></p>

    <?php 
        endif;
    ?>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>
    <script src="/js/quantity.js"></script>
</body>
</html>