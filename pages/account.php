<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    
    <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>

    <?php
        if(NULL !== $_POST['logout'])
        {
            $_SESSION['LoggedIn'] = false;
            $_SESSION['username'] = "";
        }
    ?>

    <?php 
        if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']):
    ?>
    <!-- IF LOGGED IN -->
    <h2>Account</h2>
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.users.php";
        $users = new WebshopUser();
        $userinfo = $users->getUserInfo($_SESSION['username']);
    ?>

    <h3> Welcome <?php echo $userinfo['firstname'] . " " .  $userinfo['lastname']; ?></h3>

    <p><strong>Your email: </strong><br><?php echo $userinfo['email']; ?></p>
    <p><strong>Your username:</strong><br><?php echo $userinfo['username']; ?></p>

    <?php
        if ($userinfo['isAdmin'])
        {
    ?>
    
    <h3>Admin panel</h3>

    <p>
        <a class="a" href="/admin/addProduct.php">Add a Product</a><br>
        <a class="a" href="/admin/manageProduct.php">Manage all Product</a><br>
        <a class="a" href="/admin/addCategory.php">Add a Category</a><br>
        <a class="a" href="/admin/manageCategory.php">Manage all Categories</a><br>
    </p>

    <?php
        } else {
    ?>

    <p><a class="a" href="mailto:contact@joswigchert.nl">Contact Webshop</a></p>

    <?php
        } 
    ?>

    <p>
    <form action="/pages/account.php" method="post">
        <button class="logout" type="submit" name="logout" value="1">Logout</button>
    </form>
    </p>

    <?php
    else:
    ?>


    <!-- IF NOT LOGGED IN -->
    <form action="/pages/account.php" method="post">
        <h2>Login</h2>
        <ul class="login">
            <li>
                <input type="text" name="username" id="username" placeholder="Username">
                <div class="wrongParams">
                    <?php
                    if(isset($_POST['username'])):
                        if($_POST['username']): 
                            $username = $_POST['username']; 
                        else: 
                            $isGood = false; 
                            echo "No username"; 
                        endif; 
                    endif; 
                    ?>
                </div>
            </li>
            <li>
                <input type="password" name="password" id="password" placeholder="Password">
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['password'])):
                        if($_POST['password']): 
                            $password = hash('whirlpool', $_POST['password']); 
                        else: 
                            $isGood = false; 
                            echo "No password"; 
                        endif; 
                    endif; 
                    ?>
                </div>
            </li>
            <li><input type="submit" value="Login"></li>
            <li><hr></li>
            <li>No account yet? <a href="/pages/createAccount.php">create account</a> here</li>
        </ul>
    </form>

    <?php
    $isGood = True;

    echo "<p class=\"wrongParams\">";
    if($isGood):
        if(isset($username) && isset($password)):
            include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.users.php";
            $users = new WebshopUser();
            $outputStmt = $users->login($username, $password);
            switch ($outputStmt) {
                case -3:
                    echo "Error in database, contact database owner";
                    break;
                case -2:
                    echo "Username does not exist.<br>Try <a href=\"/pages/createAccount.php\">creating</a> an account";
                    break;
                case -1:
                    echo "Wrong password";
                    break;
                case 1:
                    $_SESSION['LoggedIn'] = True;
                    $_SESSION['username'] = $username;
                    header("Refresh:0");
                    break;
            } 
        endif;
    endif;
    echo "</p>";
    ?>


    <?php
    endif;
    ?>



    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>
</body>
</html>