<?php
session_start();

$url = isset($_SESSION["url"]) && !empty($_SESSION["url"]) ? $_SESSION["url"] : null;

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>WiFi Portal</title>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php
        // Conditionally include the meta refresh tag
        if ($url) {
            echo '<meta http-equiv="refresh" content="5;url=' . $url . '" />';
        }
        ?>
    </head>
    <body>
        <p>You're online! <br>
           Thanks for visiting us!</p>
        <?php   if ($url) {
            echo '<p>You will be redirected to <a href="' . $url . '">' . $url . '</a> in 5 seconds.</p>';
        } ?>
    </body>
</html>