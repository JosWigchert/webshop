<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItemManager</title>
    
    <link rel="stylesheet" href="/css/master.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php session_start(); include_once $_SERVER['DOCUMENT_ROOT'] . "/common/header.html"; ?>


    <?php
    
    echo 'hoi';
    print_r($_FILES['imga']);
    ?>


    <form action="/admin/additems.php" method="post" enctype="multipart/form-data">
    <label for="exampleFormControlFile1">Select Small Image</label>
    <input type="file" name="imga"  id="imga">
    <input type="submit" value="">

    </form>
    





    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/common/footer.html"; ?>


</body>
</html>