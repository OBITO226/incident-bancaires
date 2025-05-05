<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "incidents_bancaires";

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Requête pour récupérer toutes les connexions
$sql = "SELECT * FROM Journal_Connexion ORDER BY Date_Connexion DESC";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Retourner les données en JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
