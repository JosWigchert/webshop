
<?php session_start(); ?>
<?php

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

if ($userinfo['isAdmin'] && isset($_POST['updateType']))
{

    if ($_POST['updateType'] == 'Category')
    {
        $shop->updateCategory($_POST['categoryID'], $_POST['categoryName'], $_POST['parentID']);

        header("Location: https://joswigchert.nl/admin/manageCategory.php?category_updated_by_" . $_SESSION['username']);
    }
    else if ($_POST['updateType'] == 'Product')
    {
        if (isset($_FILES['img']))
        {

            $fileExtention = strtolower(explode('.', $_FILES['img']['name'], 2)[1]);
            $fileDestination = 'upload/pic.' . $fileExtention;
            $fileTempLocation = $_FILES['img']['tmp_name'];

            move_uploaded_file($fileTempLocation, $fileDestination);

            $imgSrc = $fileDestination;

            list($width, $height) = getimagesize($imgSrc);

            if ($width > $height) 
            {
                $y = 0;
                $x = ($width - $height) / 2;
                $smallestSide = $height;
            } 
            else 
            {
                $x = 0;
                $y = ($height - $width) / 2;
                $smallestSide = $width;
            }

            $thumbSize = 200;
            $thumb = imagecreatetruecolor($thumbSize, $thumbSize);

            
            if ($fileExtention == "jpg" || $fileExtention == "jpeg")
            {
                $myImage = imagecreatefromjpeg($imgSrc);
                imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
                imagejpeg($thumb, 'upload/pic-tumb.'.$fileExtention);
            }
            else if ($fileExtention == "png")
            {
                $myImage = imagecreatefrompng($imgSrc);
                imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
                imagepng($thumb, 'upload/pic-tumb.'.$fileExtention);
            }
        }

        if (isset($_POST['inSale']))
        {
            $inSale = $_POST['inSale'];
        }

        $shop->updateProduct($_POST['productID'], $_POST['productName'], file_get_contents('upload/pic.'.$fileExtention), file_get_contents('upload/pic-tumb.'.$fileExtention),  $_POST['categoryID'], $_POST['description'], $_POST['price'], ($inSale == "on") ? 1 : 0, $_POST['salePrice']);
    
        header("Location: https://joswigchert.nl/admin/manageProduct.php?product_updated_by_" . $_SESSION['username']);
    }

}
else
{
    header("Location: https://joswigchert.nl/pages/account.php?" . $_SESSION['username']) . "_Tried_To_Acces_Page";
}


?>