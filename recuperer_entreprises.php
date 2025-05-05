<?php
$host = "localhost";
$dbname = "incidents_bancaires";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM entreprise ORDER BY id DESC");
$entreprises = [];

while ($row = $result->fetch_assoc()) {
    $entreprises[] = $row;
}

header("Content-Type: application/json");
echo json_encode($entreprises);

$conn->close();
?>
