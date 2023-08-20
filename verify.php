<?php
session_start();
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']); 
}
$config = require 'config.php';
require __DIR__ . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['code'];

    $currentDateTime = date('Y-m-d H:i:s');
    // Check database
    $db = new PDO($config['database']['dsn']);
    $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND validity = 1 AND expires_at > ?");
    $stmt->execute([$enteredCode, $currentDateTime]);

    if ($row = $stmt->fetch()) {
        // Set the validity of the code to invalid (0) in the database
        $updateStmt = $db->prepare("UPDATE users SET validity = 0 WHERE code = ?");
        $updateStmt->execute([$enteredCode]);
        $ap = $row['ap'];
        $mac = $row['id'];
        $_SESSION["url"] = $row["url"];
        
        // UniFi API logic
        $duration = $config['api']['duration']; 
        $site_id = $config['api']['site_id']; 
        $controlleruser = $config['api']['controlleruser'];
        $controllerpassword = $config['api']['controllerpassword'];
        $controllerurl = $config['api']['controllerurl'];
        $controllerversion = $config['api']['controllerversion'];
        $debug = $config['api']['debug'];

        $unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
        //$unifi_connection->login();
        //$unifi_connection->authorize_guest($mac, $duration, $up = null, $down = null, $MBytes = null, $ap);
        
        header("Location: " . $config['verification']['success_redirect']);
        exit;
    } else {
        $error = $config['verification']['error_message'];
    }
}
?>

<form method="post" action="verify.php">
    Enter the code sent to your email:
    <input type="text" name="code" required>
    <input type="submit" value="Verify">
</form>

<?php if (isset($error)) echo $error; ?>
