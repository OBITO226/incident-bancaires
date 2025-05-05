<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "incidents_bancaires";

// Connexion à la base
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Requête SQL avec jointure (pour voir aussi le nom de l'entreprise si tu veux l'afficher plus tard)
$sql = "SELECT * FROM Equipement ORDER BY ID_Equipement DESC";
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
