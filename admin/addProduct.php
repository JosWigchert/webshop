<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add a product</title>
    
    <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>

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
        
    ?>

    <?php
        if ($userinfo['isAdmin'])
        {
    ?>

    <form action="/admin/addProduct.php" method="post" enctype="multipart/form-data"> 
    <ul class="pic-container">
        <li>
            <span for="productName">Product Name</span>
            <input type="text" name="name" id="name" placeholder="Product name">
            <div class="wrongParams">
                <?php
                if(isset($_POST['name'])):
                    if($_POST['name']): 
                        $name = $_POST['name']; 
                    else: 
                        $isGood = false; 
                        echo "No product name"; 
                    endif; 
                endif; 
                ?>
            </div>
        </li>
        <li>
            <span for="productImage">Product Image</span>
            <input type="file" name="img" id="img">
            <div class="wrongParams">
                <?php
                if(isset($_FILES['img'])):
                    if($_FILES['img']['error'] == 0): 
                        $img = $_FILES['img']; 
                        echo $_FILES['img']['size'];
                    else: 
                        $isGood = false; 
                        echo "Invalid image"; 
                    endif; 
                endif; 
                ?>
            </div>
        </li>
        <li>
            <span for="productCategory">Product Category</span>
            <select name="category" id="category">
                <?php
                    $categories = $shop->getAllCategories();
                    foreach($categories as $row)
                    {
                        echo '<option value="' . $row['ID'] . '">' . $row['name'] . ' -> ' . $row['parentName'] . '</option>';
                    }
                ?>
            </select>
            <div class="wrongParams">
                <?php
                if(isset($_POST['category'])):
                    if($_POST['category']): 
                        $categoryID = $_POST['category'];
                    else: 
                        $isGood = false; 
                        echo "No product category selected"; 
                    endif; 
                endif; 
                ?>
            </div>
        </li>
        <li>
            <span for="description">Description</span>
            <textarea name="description" id="description" cols="60%" rows='5'></textarea>
            <div class="wrongParams">
                <?php
                if(isset($_POST['description'])):
                    if($_POST['description']): 
                        $description = $_POST['description'];
                    else: 
                        $isGood = false; 
                        echo "No product description"; 
                    endif; 
                endif; 
                ?>
            </div>
        </li>
        <li>
            <span for="price">Price</span>
            <input type="number" name="price" id="price" placeholder="price" min="0" step=".01">
            <div class="wrongParams">
                <?php
                if(isset($_POST['price'])):
                    if($_POST['price']): 
                        $price = $_POST['price']; 
                    else: 
                        $isGood = false; 
                        echo "Original price not set"; 
                    endif; 
                endif; 
                ?>
            </div>
        </li>
        <li>
            <span for="inSale">Is in sale</span>
            <input type="checkbox" class="justify-left" name="inSale" id="inSale">
            <?php
                if(isset($_POST['inSale'])):
                    $inSale = $_POST['inSale']; 
                endif; 
                ?>
        </li>
        <li>
            <span for="salePrice">Price in sale</span>
            <input type="number" name="salePrice" id="salePrice" placeholder="sales price" min="0" step=".01">
            <div class="wrongParams">
                <?php
                if(isset($_POST['salePrice'])):
                    if($_POST['salePrice']): 
                        $salePrice = $_POST['salePrice'];
                    else:
                        if (isset($_POST['inSale'])):
                            $isGood = false; 
                            echo "Sales price not set"; 
                        endif;
                    endif; 
                endif; 
                ?>
            </div>
        </li>
        <li>
            <input type="submit" value="Upload">
        </li>
    </ul>

    <?php 
    
        if ($isGood && isset($_POST['name']) && isset($_FILES['img']) && isset($_POST['description']) && isset($_POST['price']))
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


            $shop->addProduct($name, file_get_contents('upload/pic-tumb.'.$fileExtention), file_get_contents('upload/pic-tumb.'.$fileExtention), $categoryID, $description, $price, ($inSale == "on") ? 1 : 0, $salePrice);
        }

    ?>
    <input type="hidden" name="updateType" value="Product">
    </form>

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