<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">

        <!-- Logo centré -->
        <div class="flex justify-center mb-4">
            <img src="photo/R (1).jpeg" alt="Logo UEMOA" class="h-20">
        </div>

        <h2 class="text-2xl font-bold text-center mb-6 text-blue-600">Connexion à l’espace sécurisé</h2>

        <!-- Message d'alerte (à remplir dynamiquement avec PHP si besoin) -->
        <?php if (isset($_GET['erreur'])): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
                <?= htmlspecialchars($_GET['erreur']) ?>
            </div>
        <?php endif; ?>

        <form action="connexion.php" method="POST" class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur</label>
                <input type="text" name="nom_utilisateur" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="mot_de_passe" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Se souvenir de moi</span>
                </label>
                <a href="#" class="text-blue-600 hover:underline">Mot de passe oublié ?</a>
            </div>

            <div class="text-center">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-xl hover:bg-blue-700 transition duration-200">
                    Se connecter
                </button>
            </div>
        </form>

        <p class="text-sm text-center mt-4 text-gray-500">
            Pas encore de compte ? Contactez l’administrateur.
        </p>
    </div>

</body>
</html>
