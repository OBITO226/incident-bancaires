<?php
$host = 'localhost';
$dbname = 'incidents_bancaires';
$username = 'root';
$password = ''; // Mets ton mot de passe si besoin

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

$query = "SELECT message, date_notification FROM notification ORDER BY date_notification DESC LIMIT 10";
$stmt = $pdo->query($query);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($notifications);
?>
