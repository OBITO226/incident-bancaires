<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'incidents_bancaires';
$username = 'root'; // remplace par ton utilisateur MySQL
$password = '';     // et ton mot de passe

// Connexion à la base
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur de connexion à la base de données."]);
    exit;
}

// Récupération des alertes
$stmt = $pdo->query("SELECT * FROM alertes ORDER BY Date_Envoi DESC");
$alertes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourne les données au format JSON
header('Content-Type: application/json');
echo json_encode($alertes);
?>
