<?php
$host = 'localhost';
$dbname = 'incidents_bancaires';
$user = 'root';  // Change si nécessaire
$pass = '';      // Change si nécessaire

$conn = new mysqli($host, $user, $pass, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hashage du mot de passe
    $role = $_POST['role'];

    // Préparer la requête pour insérer un utilisateur dans la base de données
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom_utilisateur, $mot_de_passe, $role);

    if ($stmt->execute()) {
        echo "Utilisateur créé avec succès. <a href='index.php'>Se connecter</a>";
    } else {
        echo "Erreur lors de la création de l'utilisateur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un utilisateur</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

  <form action="ajouter_utilisateur.php" method="POST" class="bg-white p-8 rounded-xl shadow-md w-full max-w-lg">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Créer un nouvel utilisateur</h2>

    <div class="mb-4">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Nom d'utilisateur</label>
      <input type="text" name="nom_utilisateur" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
    </div>

    <div class="mb-4">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Mot de passe</label>
      <input type="password" name="mot_de_passe" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
    </div>

    <div class="mb-6">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Rôle</label>
      <select name="role" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="utilisateur">Utilisateur</option>
        <option value="admin">Admin</option>
      </select>
    </div>

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-md transition duration-200">
      Créer le compte
    </button>

    <p class="text-center text-sm mt-4"><a href="index.php" class="text-blue-600 hover:underline">Retour à la connexion</a></p>
  </form>

</body>
</html>
