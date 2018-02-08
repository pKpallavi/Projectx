<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') '
            . $conn->connect_error);
}
echo '<p>Connection OK '. $conn->host_info.'</p>';
echo '<p>Server '.$conn->server_info.'</p>';
$conn->close();
?>
