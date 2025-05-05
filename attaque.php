<?php
$host = "localhost";
$dbname = "incidents_bancaires";
$user = "root";
$pass = ""; // Mets ton mot de passe si nécessaire

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("INSERT INTO attaques (Nom, Description, Faille_Exploitee, Impact, Mode_Operationnel)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST["nom"],
        $_POST["description"],
        $_POST["faille"],
        $_POST["impact"],
        $_POST["mode"]
    ]);
}

$attaques = $conn->query("SELECT * FROM attaques ORDER BY ID_Attaque DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attaques Informatiques - Incidents Bancaires</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f8f8f8;
        }
        h1 {
            color: #333;
        }
        .form-section, .table-section {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            vertical-align: top;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .long-text {
            max-width: 300px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

    <h1>Table des Attaques Informatiques</h1>

    <!-- Tableau -->
    <div class="table-section">
        <h2>Attaques enregistrées</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Faille</th>
                    <th>Impact</th>
                    <th>Mode Opérationnel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attaques as $attaque): ?>
                    <tr>
                        <td><?= $attaque["ID_Attaque"] ?></td>
                        <td><?= htmlspecialchars($attaque["Nom"]) ?></td>
                        <td class="long-text"><?= nl2br(htmlspecialchars($attaque["Description"])) ?></td>
                        <td class="long-text"><?= nl2br(htmlspecialchars($attaque["Faille_Exploitee"])) ?></td>
                        <td class="long-text"><?= nl2br(htmlspecialchars($attaque["Impact"])) ?></td>
                        <td class="long-text"><?= nl2br(htmlspecialchars($attaque["Mode_Operationnel"])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Formulaire -->
    <div class="form-section">
        <h2>Ajouter une nouvelle attaque</h2>
        <form method="POST" action="attaque.php">
            <input type="text" name="nom" class="form-input" placeholder="Nom de l'attaque" required>
            <textarea name="description" class="form-input" placeholder="Description" required></textarea>
            <textarea name="faille" class="form-input" placeholder="Faille exploitée" required></textarea>
            <textarea name="impact" class="form-input" placeholder="Impact" required></textarea>
            <textarea name="mode" class="form-input" placeholder="Mode opératoire" required></textarea>
            <button type="submit">Ajouter l'attaque</button>
        </form>
    </div>

</body>
</html>
