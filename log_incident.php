<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "incidents_bancaires";

// Connexion
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$sql = "SELECT * FROM Log_Incident ORDER BY Horodatage DESC";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
