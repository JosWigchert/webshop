<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    
    <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <link rel="stylesheet" href="/css/flex.css" type="text/css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>

    <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.products.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
        $shop = new WebshopShop();
        $isGood = true;

        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.users.php";
        $users = new WebshopUser();
        if (isset($_SESSION['username']))
        {
            $userinfo = $users->getUserInfo($_SESSION['username']);
        }
        else
        {
            $userinfo['isAdmin'] = false;
        }
        
    ?>
    
    <?php
        if ($userinfo['isAdmin'])
        {
    ?>

    <ul class="category">
        <?php
            $categories = $shop->getAllCategories();
            foreach($categories as $row)
            {
                product::printCategoryUpdate($row);
            }
            echo '<hr>';
        ?>
    </ul>


    <?php
        } else
        {
    ?>

    <h2>You do not have access to this page</h2>
        

    <?php
        }
    ?>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>
</body>
</html>