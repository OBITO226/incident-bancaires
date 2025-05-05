<?php
$pdo = new PDO("mysql:host=localhost;dbname=incidents_bancaires;charset=utf8", "root", "");

$recommandations = [
    ["Activer le chiffrement des données sensibles.", 2],
    ["Former les employés à la cybersécurité.", 5],
    ["Surveiller les journaux système régulièrement.", 3],
];

$stmt = $pdo->prepare("INSERT INTO recommandation (Mesure, ID_Vulnérabilité) VALUES (?, ?)");

foreach ($recommandations as $rec) {
    $stmt->execute([$rec[0], $rec[1]]);
}

echo "Recommandations insérées sans liaison avec la table vulnérabilité.";
