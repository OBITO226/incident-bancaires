<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'incidents_bancaires';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mesure'], $_POST['id_vulnerabilite'])) {
    $mesure = trim($_POST['mesure']);
    $id_vuln = (int) $_POST['id_vulnerabilite'];

    if (!empty($mesure)) {
        $stmt = $pdo->prepare("INSERT INTO recommandation (Mesure, ID_Vulnerabilite) VALUES (?, ?)");
        if ($stmt->execute([$mesure, $id_vuln])) {
            $message = "<p style='color: green;'>Recommandation ajoutée avec succès !</p>";
        } else {
            $message = "<p style='color: red;'>Erreur lors de l'ajout.</p>";
        }
    }
}

// Récupération des recommandations existantes
$recommandations = $pdo->query("SELECT * FROM recommandation ORDER BY ID_Recommandation DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Recommandations - UEMOA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #003366;
            --accent: #0059b3;
            --light: #f4f4f9;
            --white: #ffffff;
            --blue-soft: #e0e7ff;
            --text-dark: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light);
        }

        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            font-size: 24px;
            color: white;
            cursor: pointer;
            z-index: 1000;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background-color: var(--primary);
            padding-top: 60px;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 1rem;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: var(--accent);
        }

        header {
            background-color: var(--primary);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .main-content {
            margin-left: 220px;
            padding: 2rem;
        }

        .recommendation, .form-container {
            background-color: var(--blue-soft);
            margin: 1.5rem 0;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 6px solid var(--accent);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .recommendation h2, .form-container h2 {
            color: var(--primary);
        }

        form label {
            display: block;
            margin: 1rem 0 0.5rem;
        }

        form textarea, form input {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            margin-top: 1rem;
            padding: 0.7rem 1.2rem;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            background-color: var(--primary);
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.shifted {
                margin-left: 220px;
            }
        }
    </style>
</head>
<body>

    <div class="menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>

    <nav class="sidebar" id="sidebar">
        <a href="#ajout"><i class="fas fa-plus-circle"></i> Ajouter</a>
        <a href="#liste"><i class="fas fa-list"></i> Recommandations</a>
    </nav>

    <header>
        <h1>Recommandations Cyber - UEMOA</h1>
        <p>Sécurisons nos systèmes ensemble</p>
    </header>

    <main class="main-content" id="mainContent">
        <!-- Formulaire d'ajout -->
        <div class="form-container" id="ajout">
            <h2><i class="fas fa-plus-circle"></i> Ajouter une recommandation</h2>
            <?= $message ?>
            <form method="POST">
                <label for="mesure">Mesure :</label>
                <textarea name="mesure" id="mesure" required></textarea>

                <label for="id_vulnerabilite">ID Vulnérabilité :</label>
                <input type="number" name="id_vulnerabilite" id="id_vulnerabilite" required>

                <button type="submit">Enregistrer</button>
            </form>
        </div>

        <!-- Liste des recommandations -->
        <div id="liste">
            <h2><i class="fas fa-list"></i> Recommandations enregistrées</h2>
            <?php foreach ($recommandations as $rec): ?>
                <div class="recommendation">
                    <h3><i class="fas fa-shield-alt"></i> Recommandation #<?= $rec['ID_Recommandation'] ?></h3>
                    <p><strong>Mesure :</strong><br><?= nl2br(htmlspecialchars($rec['Mesure'])) ?></p>
                    <p><strong>ID Vulnérabilité :</strong> <?= $rec['ID_Vulnerabilite'] ?? 'N/A' ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        &copy; 2025 UEMOA - Sécurité Informatique
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('mainContent').classList.toggle('shifted');
        }
    </script>

</body>
</html>
