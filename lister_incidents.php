<?php
$host = "localhost";
$dbname = "incidents_bancaires";
$username = "root"; // à adapter si besoin
$password = "";     // à adapter si besoin

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$sql = "SELECT * FROM incidents ORDER BY id DESC";
$result = $conn->query($sql);

$incidents = [];

while ($row = $result->fetch_assoc()) {
    $incidents[] = $row;
}

header('Content-Type: application/json');
echo json_encode($incidents);

$conn->close();
?>
