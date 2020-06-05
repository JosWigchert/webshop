
<input type="date" name="" id="">

<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
$shop = new WebshopShop();

include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.users.php";
$users = new WebshopUser();

if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'])
{    
    if (NULL !== $_POST['product'] && NULL !== $_POST['amount'])
    {
        $shop->addToShoppingCart($_SESSION['username'], $_POST['product'], $_POST['amount']);
        header("Location: https://joswigchert.nl/pages/shopCart.php?" . $_SESSION['username'] . "_Updated_His/Hers_ShoppingCart");
    }
    else if (NULL !== $_POST['checkout'])
    {
        $shop->checkout($_SESSION['username']);
        $userinfo = $users->getUserInfo($_SESSION['username']);

        $to = $userinfo['email'];
                
        $subject = "Order";

        $message = '
        <html>
        <head>
            <title>Order Received</title>
        </head>
        <body>
            <p>Order info</p>
            
            <p>The order is send to ' . $userinfo['street'] . " " . $userinfo['streetNR'] . " " .  $userinfo['postcode'] . " " . $userinfo['city'] . '</p> 
        </body>
        </html>
        '; 

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:no-reply@joswigchert.nl";

        mail($to, $subject, $message, $headers);
        $message = "Mail sent to e-mail address, see mail for order information";
        echo "<script type='text/javascript'>alert('$message');</script>";

        header("Location: https://joswigchert.nl/pages/shopCart.php?" . $_SESSION['username'] . "_Checked_Out_His/Hers_ShoppingCart");
    }
    else
    {
        header("Location: https://joswigchert.nl/pages/shopCart.php?" . $_SESSION['username'] . "_Could_Not_Update_ShoppingCart");
    }
}
else
{
    header("Location: https://joswigchert.nl/pages/shopCart.php?Could_Not_Update_ShoppingCart_Not_Logged_In");
}

?>