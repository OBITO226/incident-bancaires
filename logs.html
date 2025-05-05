<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journal des Incidents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        h2 {
            text-align: center;
        }
        input[type="text"] {
            width: 60%;
            padding: 8px;
            margin: 20px auto;
            display: block;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Journal des Logs d'Incidents</h2>

    <input type="text" id="searchInput" placeholder="Rechercher par type, détails ou date...">

    <table>
        <thead>
            <tr>
                <th>ID Log</th>
                <th>ID Incident</th>
                <th>Horodatage</th>
                <th>Type de Log</th>
                <th>Détails</th>
            </tr>
        </thead>
        <tbody id="logTable">
            <!-- Exemple visible sans base -->
            <tr>
                <td>1</td>
                <td>12</td>
                <td>2025-04-08 11:30:00</td>
                <td>Alerte</td>
                <td>Détection d'une tentative d'accès non autorisé sur le pare-feu.</td>
            </tr>
            <tr>
                <td>2</td>
                <td>12</td>
                <td>2025-04-08 11:45:00</td>
                <td>Action</td>
                <td>Blocage automatique de l'adresse IP source via le système de sécurité.</td>
            </tr>
            <tr>
                <td>3</td>
                <td>15</td>
                <td>2025-04-09 09:15:00</td>
                <td>Analyse</td>
                <td>Analyse post-incident : aucune donnée sensible compromise.</td>
            </tr>
        </tbody>
    </table>

    <script>
        async function loadData() {
            const response = await fetch('log_incident.php');
            const data = await response.json();
            const tableBody = document.getElementById('logTable');
            const searchInput = document.getElementById('searchInput');

            function displayData(filteredData) {
                tableBody.innerHTML = "";
                filteredData.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.ID_Log}</td>
                        <td>${row.ID_Incident}</td>
                        <td>${row.Horodatage}</td>
                        <td>${row.Type_Log}</td>
                        <td>${row.Détails}</td>
                    `;
                    tableBody.appendChild(tr);
                });
            }

            searchInput.addEventListener("input", () => {
                const search = searchInput.value.toLowerCase();
                const filtered = data.filter(item =>
                    item.Type_Log.toLowerCase().includes(search) ||
                    item.Détails.toLowerCase().includes(search) ||
                    item.Horodatage.toLowerCase().includes(search)
                );
                displayData(filtered);
            });

            displayData(data);
        }

        window.onload = loadData;
    </script>
</body>
</html>
