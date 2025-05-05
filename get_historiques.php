<?php
$host = 'localhost';
$dbname = 'incidents_bancaires';
$username = 'root';
$password = ''; // mets ton mot de passe MySQL si tu en as un

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$sql = "SELECT ID_Historique, ID_Incident, Date_Modification, Statut_Avant, Statut_Après, Commentaire FROM historique_incident ORDER BY Date_Modification DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$historiques = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($historiques);
?>
