<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add a category</title>
    
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
    if (isset($_POST['name']) && isset($_POST['category']))
    {
        $shop->addCategory($_POST['name'], $_POST['category']);
    }
    ?>

    <?php
        if ($userinfo['isAdmin'])
        {
    ?>

    <form action="/admin/addCategory.php" method="post"> 
        <ul class="pic-container">
            <li>
                <span for="categoryName">Category Name</span>
                <input type="text" name="name" id="name" placeholder="Category name">
                <div class="wrongParams">
                    <?php
                    if(isset($_POST['name'])):
                        if($_POST['name']): 
                            $name = $_POST['name']; 
                        else: 
                            $isGood = false; 
                            echo "No category name"; 
                        endif; 
                    endif; 
                    ?>
                </div>
            </li>
            <li>
                <span for="productCategory">Parent Category</span>
                <select name="category" id="category">
                    <?php
                        $categories = $shop->getAllCategories();
                        echo '<option value="-1">None</option>';
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
                            echo "No parent category selected"; 
                        endif; 
                    endif; 
                    ?>
                </div>
            </li>
            <li>
                <input type="submit" value="Upload">
            </li>
        </ul>
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