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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script src="/js/quantity.js"></script>
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>

    <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
        $shop = new WebshopShop();

        if (isset($_GET['product']))
        {
            $productInfo = $shop->getProduct($_GET['product']);

            echo '<h2>' . $productInfo['name'] . '</h2>';

            echo '<p><img class="pic-container" alt="Responsive image" src="data:image/jpeg;base64, ' . base64_encode($productInfo['picLarge']) . '" alt="' . $productInfo['name'] . '"></p>';

            echo '<p class="description">' . $productInfo['descrLarge'] . '</p>';
    ?>

    <div class="container">
        <form class="flex-box-container" action="/pages/updateShoppingCart.php" method="post">
            <?php
                if ($productInfo['sale'])
                {
                    echo '<div class="flex-item-20 price">' . $productInfo['newPrice'] . '</div>';
                    echo '<div class="old-price flex-item-20">' . $productInfo['price'] . '</div>';
                }
                else
                {
                    echo '<div class="price flex-item-40">' . $productInfo['price'] . '</div>';
                }

                echo '<div class="flex-item-40">';
                echo '<div class="quantity">
                        <button class="plus-btn item-30" type="button" name="button">
                            <img class="img-fluid" src="/img/plus.png" alt="" />
                        </button>
                            <input class="quantity-input item-40" type="text" name="amount" value="1">
                        <button class="minus-btn item-30" type="button" name="button">
                            <img class="img-fluid" src="/img/minus.png" alt="" />
                        </button>
                    </div>';
                echo '</div>';
            ?>
                <button class="flex-item-20" type="submit" name="product" value="<?php echo $_GET['product']?>">Add to cart</button>
            </form>
        </div>
    </div>
    



    <?php
        } else {
    ?>

        <h2>No Product to display</h2>

        <p>404.2 Product not found</p>

    <?php
        }
    ?>
        

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>
</body>
</html>