<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['entreprise'], $data['pays'], $data['type'], $data['date'], $data['statut'])) {
    echo json_encode(["success" => false, "message" => "Données manquantes"]);
    exit;
}

$entreprise = $data['entreprise'];
$pays = $data['pays'];
$type = $data['type'];
$date = $data['date'];
$statut = $data['statut'];

$conn = new mysqli("localhost", "root", "", "incidents_bancaires");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connexion échouée"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO incidents (entreprise, pays, type_incident, date_incident, statut) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $entreprise, $pays, $type, $date, $statut);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Incident ajouté avec succès"]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout"]);
}

$stmt->close();
$conn->close();
?>
