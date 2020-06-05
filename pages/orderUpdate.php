





<?php session_start(); ?>
<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
$shop = new WebshopShop();
$isGood = true;



if (isset($_SESSION['username']))
{
    if(isset($_POST['orderID']))
    {
        $shop->updateOrderStatus($_SESSION['username'], $_POST['orderID']);
    }
    header("Location: https://joswigchert.nl/pages/orders.php");
}
else
{
    header("Location: https://joswigchert.nl/pages/orders.php");
}


?>