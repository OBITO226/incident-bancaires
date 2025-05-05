<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des cyberattaques - UEMOA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">📊 Statistiques des cyberattaques dans l'espace UEMOA</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">🔒 Types d'attaques les plus fréquentes</h2>
            <canvas id="barChart"></canvas>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📌 Répartition des cyberattaques (2024)</h2>
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <script>
        
        // Graphique en barres
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Phishing ciblé', 'SIM Swap', 'Ransomware', 'DDoS', 'Fraude Mobile Banking', 'Fraude SWIFT', 'Skimming', 'Jackpotting'],
                datasets: [{
                    label: 'Nombre estimé d’incidents (par gravité)',
                    data: [70, 55, 50, 53, 65, 30, 25, 20],
                    backgroundColor: [
                        '#6366F1', '#3B82F6', '#10B981', '#F59E0B',
                        '#EF4444', '#8B5CF6', '#EC4899', '#22D3EE'
                    ],
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Attaques les plus fréquentes dans le secteur bancaire UEMOA'
                    }
                }
            }
        });

        // Graphique camembert
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Ransomware (50%)', 'DDoS (53%)', 'Phishing (70%)', 'Fraude Mobile (65%)', 'Fraude SWIFT (30%)'],
                datasets: [{
                    data: [50, 53, 70, 65, 30],
                    backgroundColor: [
                        '#EF4444', '#F59E0B', '#3B82F6', '#10B981', '#8B5CF6'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        
    </script>


</body>
</html>
