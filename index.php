<?php

session_start();

//Get the MAC addresses of AP and user
// Check if essential parameters are set
if (!isset($_GET['ap']) || !isset($_GET['id'])) {
    die("Essential parameters missing. Cannot proceed with registration.");
}

$_SESSION["ap"] = $_GET["ap"];
$_SESSION["id"] = $_GET["id"];

// Optionally capture other parameters if they exist
if (isset($_GET['t'])) {
    $_SESSION["t"] = $_GET["t"];
}

if (isset($_GET['url'])) {
    $_SESSION["url"] = $_GET["url"];
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>WiFi Portal</title>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    </head>
    <body>
		<p>Welcome!<br>
		Please login to our Wifi service</p>

		<form method="post" action="register.php">
			Email: <input type="email" name="email" placeholder="Insert Email" required><br>
            <input type="checkbox" id="termsCheckbox" name="terms" value="agree" required>
            <label for="termsCheckbox">I agree to <a href="terms.php" target="_blank">terms and conditions</a>.</label><br><br>
			<input type="submit" value="Sign up">
		</form>
    </body>
</html>