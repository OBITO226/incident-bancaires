<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: index.php");
    exit;
}
?>

<!-- Entête avec message de bienvenue -->
<div class="bg-gradient-to-r from-indigo-100 to-white px-6 py-4 shadow-md rounded-b-xl mb-4">
  <h2 class="text-2xl font-bold text-indigo-800">Bienvenue, <span class="text-black"><?= $_SESSION['utilisateur'] ?></span> !</h2>
  <p class="text-gray-700 mt-1">Vous êtes connecté en tant que <strong class="text-indigo-700"><?= $_SESSION['role'] ?></strong></p>
  <a href="deconnexion.php" class="inline-block mt-2 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">Déconnexion</a>
</div>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Alertes et Statistiques</title>
  <link rel="icon" type="image/png" href="favicon.png" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-white text-black">

  <!-- SIDEBAR -->
  <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-black text-white p-6 transform -translate-x-full transition-transform duration-300 z-50">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold">Menu</h2>
      <button aria-label="Fermer le menu" onclick="closeSidebar()" class="text-white text-xl"><i class="fas fa-times"></i></button>
    </div>
    <ul class="space-y-3">
      <li><a href="historique.php" class="block hover:text-gray-300">Historique_Incident</a></li>
      <li><a href="vulnerabilites.php" class="block hover:text-gray-300">Vulnérabilité</a></li>
      <li><a href="equipements.php" class="block hover:text-gray-300">Équipement touché</a></li>
      <li><a href="logs.php" class="block hover:text-gray-300">Log_Incident</a></li>
      <li><a href="deconnexion.php" class="block hover:text-red-400 font-semibold" id="logout-btn">Déconnexion</a></li>
    </ul>
  </div>

  <!-- OVERLAY -->
  <div id="overlay" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden"></div>

  <!-- HEADER -->
  <header role="navigation" class="bg-white shadow-md py-3">
    <div class="flex items-center justify-between px-4 md:px-8">
      <!-- MENU -->
      <button id="menu-toggle" aria-label="Ouvrir le menu" class="text-black text-2xl focus:outline-none">
        <i class="fas fa-bars"></i>
      </button>

      <!-- NAVIGATION CENTRALE -->
      <div class="hidden md:flex flex-wrap justify-center items-center gap-3 text-sm">
        <a href="tableau.php" class="nav-btn border border-black hover:bg-black hover:text-white py-2 px-3 rounded transition">Tableau de bord</a>
        <a href="incident.php" class="nav-btn border border-black hover:bg-black hover:text-white py-2 px-3 rounded transition">Incident</a>
        <a href="entreprise.php" class="nav-btn border border-black hover:bg-black hover:text-white py-2 px-3 rounded transition">Entreprises</a>
        <a href="attaque.php" class="nav-btn border border-black hover:bg-black hover:text-white py-2 px-3 rounded transition">Attaque</a>
        <a href="recommandation.php" class="nav-btn border border-black hover:bg-black hover:text-white py-2 px-3 rounded transition">Récommandation</a>
        <a href="historique.php" class="nav-btn border border-black hover:bg-black hover:text-white py-2 px-3 rounded transition">Historique</a>
        <a href="alerte.php" class="nav-btn border border-black hover:bg-black hover:text-white py-2 px-3 rounded transition">Alerte</a>
      </div>

      <!-- NOTIFICATIONS -->
      <div class="relative">
        <button id="notification-btn" aria-label="Voir les notifications" class="text-2xl text-black focus:outline-none">
          <i class="fas fa-bell"></i>
        </button>
        <span id="notification-count" class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-bounce">5</span>
      </div>
    </div>
  </header>

  <!-- CARTES -->
  <section class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 animate-fade-in">
    <a href="incident.php" class="bg-white p-5 rounded-lg shadow-md block hover:bg-gray-100 transition">
      <h3 class="text-xl font-bold mb-2 text-black">🔍 Consulter les incidents</h3>
      <p class="text-gray-700">Accédez à une base de données mise à jour avec les derniers incidents de sécurité.</p>
    </a>
    <a href="statistiques.php" class="bg-white p-5 rounded-lg shadow-md block hover:bg-gray-100 transition">
      <h3 class="text-xl font-bold mb-2 text-black">📊 Statistiques & tendances</h3>
      <p class="text-gray-700">Visualisez l’évolution des menaces à travers des graphiques et tableaux interactifs.</p>
    </a>
    <div class="bg-white p-5 rounded-lg shadow-md">
      <h3 class="text-xl font-bold mb-2 text-black">🚨 Signaler un incident</h3>
      <p class="text-gray-700">Contribuez à la communauté en signalant un nouvel incident détecté.</p>
    </div>
  </section>

  <!-- GRAPHIQUE -->
  <section class="mt-10 bg-white p-6 mx-6 rounded-lg shadow-md border border-gray-200">
    <h2 class="text-xl font-semibold mb-4 text-black">📈 Évolution des incidents (2024)</h2>
    <canvas id="incidentChart" height="100"></canvas>
  </section>

  <!-- ALERTE -->
  <section class="mt-10 mx-6 bg-red-100 border-l-4 border-red-600 text-red-800 p-5 rounded-lg shadow-sm animate-pulse">
    <p class="font-semibold">⚠️ Alerte actuelle : Campagne active de phishing ciblant les services bancaires en ligne. Soyez vigilants !</p>
  </section>

  <!-- NOTIFICATIONS -->
  <div id="notifications" class="absolute top-16 right-8 bg-white shadow-2xl rounded-xl w-72 p-4 hidden transition-all duration-300 border border-gray-200">
    <h3 class="text-lg font-bold mb-4">Notifications</h3>
    <ul>
      <li class="text-gray-700 mb-2">Nouvel incident signalé à 10h30</li>
      <li class="text-gray-700 mb-2">Phishing détecté sur un compte bancaire</li>
      <li class="text-gray-700 mb-2">Vulnérabilité critique trouvée dans un serveur</li>
      <li class="text-gray-700 mb-2">Mise à jour de sécurité requise</li>
      <li class="text-gray-700 mb-2">Attaque par ransomware sur un client</li>
    </ul>
  </div>

  <!-- SCRIPTS -->
  <script>
    // ChartJS
    const ctx = document.getElementById('incidentChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
        datasets: [{
          label: 'Nombre d’incidents',
          data: [12, 70, 80, 95, 125, 23, 18, 25, 22, 200, 175, 135],
          backgroundColor: 'rgba(79, 70, 229, 0.2)',
          borderColor: 'rgba(79, 70, 229, 1)',
          borderWidth: 2,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: { display: false }
        }
      }
    });

    // Sidebar toggle
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    });

    window.closeSidebar = () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    };

    overlay.addEventListener('click', closeSidebar);

    document.querySelectorAll('#sidebar a').forEach(link => {
      link.addEventListener('click', () => {
        closeSidebar();
      });
    });

    // Notifications
    const notificationBtn = document.getElementById('notification-btn');
    const notifications = document.getElementById('notifications');
    const notificationList = notifications.querySelector('ul');

    notificationBtn.addEventListener('click', () => {
      notifications.classList.toggle('hidden');
      document.getElementById('notification-count').style.display = 'none';

      fetch('fetch_notifications.php')
        .then(response => response.json())
        .then(data => {
          notificationList.innerHTML = '';
          if (data.length === 0) {
            notificationList.innerHTML = '<li class="text-gray-500">Aucune notification.</li>';
          } else {
            data.forEach(n => {
              const li = document.createElement('li');
              li.className = 'text-gray-700 mb-2';
              li.textContent = `${n.message}`;
              notificationList.appendChild(li);
            });
          }
        })
        .catch(error => {
          console.error('Erreur de récupération des notifications :', error);
        });
    });

    // Fermer les notifications quand on clique en dehors
document.addEventListener('click', function(event) {
  const isClickInside = notifications.contains(event.target) || notificationBtn.contains(event.target);
  if (!isClickInside && !notifications.classList.contains('hidden')) {
    notifications.classList.add('hidden');
  }
});


    // Déconnexion
    const logoutBtn = document.getElementById('logout-btn');
    logoutBtn.addEventListener('click', function (e) {
      if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        e.preventDefault();
      }
    });
  </script>

  <!-- Animation CSS -->
  <style>
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
      animation: fade-in 0.6s ease-out both;
    }
  </style>
</body>
</html>
