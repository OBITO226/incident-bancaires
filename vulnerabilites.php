<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "incidents_bancaires";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement de l'ajout d'une vulnérabilité
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cve = $_POST['cve'];
    $description = $_POST['description'];
    $niveau_risque = $_POST['niveau_risque'];
    $id_attaque = $_POST['id_attaque'];

    $sql = "INSERT INTO Vulnérabilité (CVE, Description, Niveau_Risque, ID_Attaque) 
            VALUES ('$cve', '$description', '$niveau_risque', '$id_attaque')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvelle vulnérabilité ajoutée avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Récupération des vulnérabilités existantes
$sql = "SELECT * FROM Vulnérabilité";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Vulnérabilités</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Gestion des Vulnérabilités</h1>

        <!-- Formulaire pour ajouter une vulnérabilité -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Ajouter une Vulnérabilité</h2>
            <form action="vulnerabilites.php" method="POST">
                <div class="mb-4">
                    <label for="cve" class="block text-gray-700">CVE</label>
                    <input type="text" id="cve" name="cve" class="w-full p-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Description</label>
                    <textarea id="description" name="description" class="w-full p-2 border rounded" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="niveau_risque" class="block text-gray-700">Niveau de Risque</label>
                    <select id="niveau_risque" name="niveau_risque" class="w-full p-2 border rounded" required>
                        <option value="Faible">Faible</option>
                        <option value="Moyenne">Moyenne</option>
                        <option value="Élevée">Élevée</option>
                        <option value="Critique">Critique</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="id_attaque" class="block text-gray-700">ID Attaque</label>
                    <input type="number" id="id_attaque" name="id_attaque" class="w-full p-2 border rounded" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
            </form>
        </div>

        <!-- Tableau des vulnérabilités -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Liste des Vulnérabilités</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">CVE</th>
                        <th class="p-2 border">Description</th>
                        <th class="p-2 border">Niveau de Risque</th>
                        <th class="p-2 border">ID Attaque</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='p-2 border'>" . $row['CVE'] . "</td>";
                            echo "<td class='p-2 border'>" . $row['Description'] . "</td>";
                            echo "<td class='p-2 border'>" . $row['Niveau_Risque'] . "</td>";
                            echo "<td class='p-2 border'>" . $row['ID_Attaque'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='p-2 text-center'>Aucune vulnérabilité enregistrée.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

<?php
// Fermeture de la connexion
$conn->close();
?>
