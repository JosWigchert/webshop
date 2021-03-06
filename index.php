<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Webshop</title>

  <link rel="stylesheet" href="/css/master.css" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>


    <h2>In sale this day</h2>

    <p>Home page</p>

    <div class="container">
        <div class="row" >
            <div class="col-sm-2">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php 
                            include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
                            include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.products.php";
                            $shop = new WebshopShop();
                            $rootCategories = $shop->getRootCategories();

                            $row;

                            if (isset($_GET['Category'])) 
                            { 
                                echo $shop->getCategory($_GET['Category']); 
                            }
                            else 
                            { 
                                echo 'Select category';     
                            } 
                        ?>
                    </button>
                    <form action="/index.php" method="get">
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                                foreach ($rootCategories as $row)
                                {
                                    echo '<button class="dropdown-item" type="submit" value="' . $row[0] . '" name="Category">' . $row[1] . '</button>';
                                }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
                <?php
                    $i = 0;
                    if (isset($_GET['Category'])) 
                    {
                        $categories = $shop->getChildCategories($_GET['Category']);
                        
                        if ($categories)
                        {
                            while ($categories != null)
                            {
                                $i = $i + 1;
                                
                                echo '
                                <div class="col-sm-2">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ';

                                if (isset($_GET['SubCat' . $i])) 
                                { 
                                    echo $shop->getCategory($_GET['SubCat' . $i]);
                                }
                                else 
                                { 
                                    echo 'Select category';     
                                }

                                echo '
                                        </button>
                                        <form action="/index.php" method="get">
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                ';

                                foreach ($categories as $row)
                                {
                                    echo '<button class="dropdown-item" type="submit" value="' . $row[0] . '" name="SubCat' . $i . '">' . $row[1] . '</button>';
                                }

                                for ($n = 1; $n < $i; $n++)
                                {
                                    echo '<input type="hidden" name="SubCat' . $n . '" value="' . $_GET['SubCat' . $n] . '" />';
                                }

                                echo '<input type="hidden" name="Category" value="' . $_GET['Category'] . '" />';

                                echo '
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                ';

                                if (isset($_GET['SubCat' . $i]))
                                {
                                    $categories = $shop->getChildCategories($_GET['SubCat' . $i]);
                                }
                                else
                                {
                                    break;
                                }

                            }
                        }
                        
                    }
                    ?>
            </div>
            <p></p>
            <div class="row">
                    <?php
                    $checkSubCat = 1;

                    while (isset($_GET['SubCat' . $checkSubCat]) && $_GET['SubCat' . $checkSubCat])
                    {
                        $checkSubCat = $checkSubCat + 1;
                    }

                    $checkSubCat = $checkSubCat - 1;

                    if ($checkSubCat > 0) 
                    { 
                        $products = $shop->getProductsFromCategoryInSale($_GET['SubCat' . $checkSubCat]);
                        foreach ($products as $row)
                        {
                            product::printProduct($row);
                        }
                    }
                    else if (isset($_GET['Category']) && $_GET['Category'])
                    {
                        $products = $shop->getProductsFromCategoryInSale($_GET['Category']);
                        foreach ($products as $row)
                        {
                            product::printProduct($row);
                        }
                    }
                    else
                    {
                        $products = $shop->getAllProductsInSale();
                        foreach ($products as $row)
                        {
                            product::printProduct($row);
                        }
                    }
                    
                ?>

            </div>
        </div>        
    </div>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>
</body>
</html>