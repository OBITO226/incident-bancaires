<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journal des Connexions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
        }
        input[type="text"] {
            width: 50%;
            padding: 8px;
            margin: 20px auto;
            display: block;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Journal des Connexions</h2>

    <input type="text" id="searchInput" placeholder="Rechercher par ID utilisateur, adresse IP ou date...">

    <table>
        <thead>
            <tr>
                <th>ID Journal</th>
                <th>ID Utilisateur</th>
                <th>Date de Connexion</th>
                <th>Adresse IP</th>
            </tr>
        </thead>
        <tbody id="journalTable">
            <!-- Données chargées dynamiquement -->
        </tbody>
    </table>

    <script>
        async function loadData() {
            const response = await fetch('journal.php');
            const data = await response.json();
            const tableBody = document.getElementById('journalTable');
            const searchInput = document.getElementById('searchInput');

            function displayData(filteredData) {
                tableBody.innerHTML = "";
                filteredData.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.ID_Journal}</td>
                        <td>${row.ID_Utilisateur}</td>
                        <td>${row.Date_Connexion}</td>
                        <td>${row.Adresse_IP}</td>
                    `;
                    tableBody.appendChild(tr);
                });
            }

            searchInput.addEventListener("input", () => {
                const search = searchInput.value.toLowerCase();
                const filtered = data.filter(item =>
                    item.ID_Utilisateur.toString().includes(search) ||
                    item.Date_Connexion.toLowerCase().includes(search) ||
                    item.Adresse_IP.toLowerCase().includes(search)
                );
                displayData(filtered);
            });

            displayData(data);
        }

        window.onload = loadData;
    </script>
</body>
</html>
