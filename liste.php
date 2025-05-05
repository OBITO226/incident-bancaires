<?php
$host = "localhost";
$dbname = "incidents_bancaires";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM entreprise ORDER BY id DESC");
$incidents = [];

while ($row = $result->fetch_assoc()) {
    $incidents[] = $row;
}

header("Content-Type: application/json");
echo json_encode($incidents);

$conn->close();
?>
