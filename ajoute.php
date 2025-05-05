<?php
$host = "localhost";
$dbname = "incidents_bancaires";
$username = "root"; // adapte si besoin
$password = "";     // adapte si besoin

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["entreprise"], $data["gravite"], $data["type"], $data["date"], $data["statut"])) {
    $stmt = $conn->prepare("INSERT INTO entreprise (entreprise, gravite, type_incident, date_incident, statut) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data["entreprise"], $data["gravite"], $data["type"], $data["date"], $data["statut"]);
    $stmt->execute();
    echo json_encode(["message" => "Incident enregistré avec succès"]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Données incomplètes"]);
}

$conn->close();
?>
