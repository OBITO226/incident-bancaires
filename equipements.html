<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Équipements</title>
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
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Liste des Équipements Informatiques</h2>

    <input type="text" id="searchInput" placeholder="Rechercher par nom, type ou entreprise...">

    <table>
        <thead>
            <tr>
                <th>ID Équipement</th>
                <th>Nom</th>
                <th>Type</th>
                <th>ID Entreprise</th>
            </tr>
        </thead>
        <tbody id="equipementTable">
            <!-- Exemples visibles sans PHP -->
            <tr>
                <td>1</td>
                <td>Serveur-Finance</td>
                <td>Serveur</td>
                <td>3</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Firewall-Sophos</td>
                <td>Firewall</td>
                <td>2</td>
            </tr>
            <tr>
                <td>3</td>
                <td>PosteAgent001</td>
                <td>Poste de travail</td>
                <td>1</td>
            </tr>
        </tbody>
    </table>

    <script>
        async function loadData() {
            const response = await fetch('equipement.php');
            const data = await response.json();
            const tableBody = document.getElementById('equipementTable');
            const searchInput = document.getElementById('searchInput');

            function displayData(filteredData) {
                tableBody.innerHTML = "";
                filteredData.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.ID_Equipement}</td>
                        <td>${row.Nom}</td>
                        <td>${row.Type}</td>
                        <td>${row.ID_Entreprise}</td>
                    `;
                    tableBody.appendChild(tr);
                });
            }

            searchInput.addEventListener("input", () => {
                const search = searchInput.value.toLowerCase();
                const filtered = data.filter(item =>
                    item.Nom.toLowerCase().includes(search) ||
                    item.Type.toLowerCase().includes(search) ||
                    item.ID_Entreprise.toString().includes(search)
                );
                displayData(filtered);
            });

            displayData(data);
        }

        window.onload = loadData;
    </script>
</body>
</html>
