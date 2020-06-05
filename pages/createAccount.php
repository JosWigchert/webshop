<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <link rel="stylesheet" href="/css/flex.css" type="text/css">
        <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>

    <h2>Create Account</h2>

    <p>Enter an email </p>

    <form action="/pages/createAccount.php" method="post">
        <ul class="login">          
            <li>
                <div><input type="email" name="email" id="email" placeholder="example@mymail.com"><div id="email-valid"></div></div>
                <div class="wrongParams">
                    <?php 
                    if(isset($_POST['email'])):
                        if($_POST['email']): 
                            $email = $_POST['email']; 
                        else: 
                            $isGood = false; 
                            echo "No email"; 
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
    if($isGood)
    {
        if(isset($email))
        {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.users.php";
            $users = new WebshopUser();
            $validateID = hash('whirlpool', time());
            $outputStmt = $users->createUser($email, $validateID);
            switch ($outputStmt) {
            case -2:
                echo "Error in database, contact database owner";
                break;
            case -1:
                echo "Email already in use";
                break;
            case 1:
                $to = $email;
                
                $subject = "Validate email address";

                $message = '
                <html>
                <head>
                    <title>Validate email</title>
                </head>
                <body>
                    <p>Welcome to joswigchert.nl!</p>
                    
                    <p>To finish your account click on <a href="http://joswigchert.nl/pages/finishAccount.php?validateID=' . $validateID . '">this</a> link</p> 
                </body>
                </html>
                '; 

                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= "From:no-reply@joswigchert.nl";

                mail($to, $subject, $message, $headers);
                echo "mail sent";
                $message = "Mail sent to e-mail address, follow instructions in mail to finish your account";
                echo "<script type='text/javascript'>alert('$message');</script>";
                break;
            }
        }
    }
    
    echo "</p>";
    ?>
    <script src="/js/email.js"></script>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>
</body>
</html>