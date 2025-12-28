<?php
$host = "database-5019015271.webspace-host.com";
$user = "dbu1065673";
$pass = "Robertwim1947!";
$db   = "dbu1065673";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database-verbinding mislukt: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM guestbook WHERE id = $id");
}

header("Location: index.php");
exit;
?>
