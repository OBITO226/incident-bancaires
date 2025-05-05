<?php
header("Content-Type: application/json");

// Configuration de la base de données
$host = "localhost";
$dbname = "incidents_bancaires";
$username = "root";
$password = "";

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erreur de connexion : " . $conn->connect_error]);
    exit;
}

// Lecture des données reçues
$data = json_decode(file_get_contents("php://input"), true);

// Optionnel : enregistrer les données reçues dans un fichier log
file_put_contents("log.txt", print_r($data, true));

if (
    isset($data["entreprise"], $data["gravite"], $data["type"], $data["date"], $data["statut"])
) {
    $entreprise = $data["entreprise"];
    $gravite = $data["gravite"];
    $type = $data["type"];
    $date = $data["date"];
    $statut = $data["statut"];

    // Préparation et exécution de la requête
    $stmt = $conn->prepare("INSERT INTO entreprise (entreprise, gravite, type_incident, date_incident, statut) VALUES (?, ?, ?, ?, ?)");

    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur préparation : " . $conn->error]);
        exit;
    }

    $stmt->bind_param("sssss", $entreprise, $gravite, $type, $date, $statut);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Incident enregistré avec succès"]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur SQL : " . $stmt->error]);
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Données incomplètes"]);
}

$conn->close();
?>
