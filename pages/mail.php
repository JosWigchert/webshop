
<form action="/pages/mail.php" method="post">
    <input type="email" name="mail" id="mail">
</form>

<?php

if (isset($_POST['mail']))
{
    $to = $_POST['mail'];
    while(true)
    {
        $to = "no-reply@joswigchert.nl";

        $subject = "this is a test";

        $message = "test from PHP script";

        $headers = "From:Test@Test.com";

        $time = time();

        mail($to, $subject, $message, $headers);

        print "Script Ran $time";
    }
}
?>
