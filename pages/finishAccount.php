<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    
    <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="/css/flex.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; 
        $isGood = true;
    ?>

    <?php
    if (isset($_GET['validateID']) && strlen($_GET['validateID']) == 128)
    {
    ?>

    <h2>Finish Account</h2>

<p>To finish your account fill in the inputs below and click the create account button</p>
    <?php
        echo '<form action="/pages/finishAccount.php?validateID=' . $_GET['validateID'] . '" method="post">'
    ?>
        <ul class="login">          
            <li>
                <input type="text" name="firstName" id="firstName" placeholder="First name" maxlength="50">    
                <div class="wrongParams">
                    <?php
                    if(isset($_POST['firstName'])):
                        if($_POST['firstName']): 
                            $firstName = $_POST['firstName']; 
                        else: 
                            $isGood = false; 
                            echo "No first name<br>"; 
                        endif; 
                    endif;  
                    ?>
                </div>
            </li>
            <li>
                <input type="text" name="lastName" id="lastName" placeholder="Last name" maxlength="50">   
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['lastName'])):
                        if($_POST['lastName']): 
                            $lastName = $_POST['lastName']; 
                        else: 
                            $isGood = false; 
                            echo "No last name<br>"; 
                        endif; 
                    endif;
                    ?>
                </div>
            </li>
            <li>
                <input class="item-70" type="text" name="street" id="street" placeholder="Street name" maxlength="50">
                <input class="item-30" type="number" name="streetnr" id="streetnr" min=1 placeholder="NR">
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['street'])):
                        if($_POST['street']): 
                            $street = $_POST['street']; 
                        else: 
                            $isGood = false; 
                            echo "No street name<br>"; 
                        endif; 
                    endif;
                    if (isset($_POST['streetnr'])):
                        if($_POST['streetnr']): 
                            $streetnr = $_POST['streetnr']; 
                        else: 
                            $isGood = false; 
                            echo "No street nummer<br>"; 
                        endif; 
                    endif;
                    ?>
                </div>
            </li>
            <li>
                <input class="item-20" type="number" name="postcodeNummer" class="postcodeNummer" pattern="[0-9]{4}" placeholder="1234" style='-moz-appearance: textfield'> 
                <input class="item-20" type="text" name="postcodeLetter" class="postcodeLetter" pattern="[A-Z]{2}" placeholder="AB">
                <input class="item-60" type="text" name="city" id="city" placeholder="City" maxlength="50">
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['postcodeNummer'])):
                        if($_POST['postcodeNummer']): 
                            $postcodeNummer = $_POST['postcodeNummer']; 
                        else: 
                            $isGood = false; 
                            echo "No postcode nummer<br>"; 
                        endif; 
                    endif;
                    if(isset($_POST['postcodeLetter'])):
                        if($_POST['postcodeLetter']): 
                            $postcodeLetter = $_POST['postcodeLetter']; 
                        else: 
                            $isGood = false; 
                            echo "No postcode letter<br>"; 
                        endif; 
                    endif;
                    if (isset($_POST['city'])):
                        if($_POST['city']): 
                            $city = $_POST['city']; 
                        else: 
                            $isGood = false; 
                            echo "No city<br>"; 
                        endif; 
                    endif;
                    ?>
                </div>
            </li>
            <li>
                <input type="text" name="land" id="land" placeholder="Land" maxlength="50">
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['land'])):
                        if($_POST['land']): 
                            $land = $_POST['land']; 
                        else: 
                            $isGood = false; 
                            echo "No land<br>"; 
                        endif; 
                    endif;
                    ?>
                </div>
            </li>
            <li>
                <input type="text" name="username" id="username" placeholder="Username" maxlength="50">
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['username'])):
                        if($_POST['username']): 
                            $username = $_POST['username']; 
                        else: 
                            $isGood = false; 
                            echo "No username<br>"; 
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
                            echo "No password<br>"; 
                        endif; 
                    endif; 
                    ?>
                </div>
            </li>
            <li>
                <input type="password" name="passwordCheck" id="passwordCheck" placeholder="Confirm Password">
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['passwordCheck'])):
                        if($_POST['passwordCheck']): 
                            $passwordCheck = hash('whirlpool', $_POST['passwordCheck']); 
                        else: 
                            $isGood = false; 
                            echo "No confirm password<br>"; 
                        endif; 
                    endif; 
                    ?>
                </div>
            </li>
            <li>
                
                <input type="submit" value="Create Account">
            </li>
        </ul>
    </form>

    <?php
    $isGood = True;

    echo "<p class=\"wrongParams\">";
    if($isGood):
        if(isset($firstName) && isset($lastName) && isset($street) && isset($streetnr) && isset($postcodeNummer) && isset($postcodeLetter) && isset($city) && isset($land) && isset($username) && isset($password) && isset($passwordCheck)):
            if($password == $passwordCheck):
                include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.users.php";
                $users = new WebshopUser();
                $outputStmt = $users->finishUser($username, $firstName, $lastName, $street, $streetnr, ($postcodeNummer . $postcodeLetter), $city, $land, $password, $_GET['validateID']);
                switch ($outputStmt) {
                    case -3:
                        echo "Error in database, contact database owner";
                        break;
                    case -2:
                        echo "Username already in use";
                        break;
                    case -1:
                        echo "Invalid verification ID";
                        break;
                    case 1:
                        header("Location: https://joswigchert.nl/pages/account.php");
                        break;
                }

            else:
                echo "Passwords do not match<br>";  
            endif;   
        endif;
    endif;
    echo "<p>";
    ?>

        <?php
    } else {
    ?>

    <h1>invalid url</h1>

    <?php
    }
    ?>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>
</body>
</html>