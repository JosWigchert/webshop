<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping cart</title>
    
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <link rel="stylesheet" href="/css/flex.css" type="text/css">
    <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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

        <h2>Shopping cart</h2>
        <h3>My items</h3>


    <ul class="category">
        <?php
            
            $shoppingCart = $shop->getShoppingCart($_SESSION['username']);
            foreach($shoppingCart as $row)
            {
                product::printShoppingCartItem($row);
            }
            echo '<hr>';
        ?>
    </ul>

    <form action="/pages/updateShoppingCart.php" method="post">
        <button class="checkout" type="submit" name="checkout" value="1">Checkout</button>
    </form>

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
</body>
</html>