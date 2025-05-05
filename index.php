<?php
session_start();
$host = 'localhost';
$dbname = 'incidents_bancaires';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
    $stmt->bind_param("s", $nom_utilisateur);
    $stmt->execute();
    $result = $stmt->get_result();
    $utilisateur = $result->fetch_assoc();

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        $_SESSION['utilisateur'] = $utilisateur['nom_utilisateur'];
        $_SESSION['role'] = $utilisateur['role'];
        header("Location: tableau.php");
        exit;
    } else {
        $message = "Identifiants incorrects.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - Portail IB BANK</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-black via-gray-900 to-yellow-400 min-h-screen flex items-center justify-center">

  <form method="POST" class="bg-white p-5 rounded-2xl shadow-2xl w-full max-w-md">

    <!-- Logo centré avec ombre -->
    <div class="flex justify-center mb-6">
      <img src="photo/logo_ib_bank-ok-reduc_1.png" alt="Logo IB Bank" class="h-24 drop-shadow-lg"> <!-- ombre ajoutée ici -->
    </div>

    <h2 class="text-2xl font-bold mb-6 text-center text-yellow-600">Connexion au Portail</h2>

    <?php if (!empty($message)) echo "<p class='text-red-500 mb-4 text-sm text-center'>$message</p>"; ?>

    <div class="mb-4">
      <label class="block text-sm font-semibold mb-1 text-gray-700">Nom d'utilisateur</label>
      <input type="text" name="nom_utilisateur" required class="w-full px-4 py-2 border border-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" />
    </div>

    <div class="mb-6">
      <label class="block text-sm font-semibold mb-1 text-gray-700">Mot de passe</label>
      <input type="password" name="mot_de_passe" required class="w-full px-4 py-2 border border-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" />
    </div>

    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded-md transition duration-200">
      Se connecter
    </button>
  </form>

</body>
</html>
