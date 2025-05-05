<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historiques des Incidents Informatiques - UEMOA</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
    }

    header {
      background-color: #003366;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    main {
      padding: 2rem;
    }

    input[type="text"] {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 1rem 0;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 0.5rem;
      text-align: left;
    }

    th {
      background-color: #003366;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
  <header>
    <h1>Historiques des Incidents Informatiques</h1>
    <p>Recherche d'incidents dans l'espace UEMOA</p>
  </header>

  <main>
    <input type="text" id="search" placeholder="Recherchez par statut, date ou commentaire..." onkeyup="filterTable()">
    <table>
      <thead>
        <tr>
          <th>ID_Historique</th>
          <th>ID_Incident</th>
          <th>Date_Modification</th>
          <th>Statut_Avant</th>
          <th>Statut_Après</th>
          <th>Commentaire</th>
        </tr>
      </thead>
      <tbody id="incidentTable">
        <!-- Données dynamiques ici -->
      </tbody>
    </table>
  </main>

  <script>
    function loadHistoriques() {
      fetch('get_historiques.php')
        .then(response => response.json())
        .then(data => {
          const tableBody = document.getElementById('incidentTable');
          tableBody.innerHTML = ''; // Clear previous content

          data.forEach(hist => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${hist.ID_Historique}</td>
              <td>${hist.ID_Incident}</td>
              <td>${hist.Date_Modification}</td>
              <td>${hist.Statut_Avant}</td>
              <td>${hist.Statut_Après}</td>
              <td>${hist.Commentaire}</td>
            `;
            tableBody.appendChild(row);
          });
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des historiques:', error);
        });
    }

    function filterTable() {
      const input = document.getElementById('search').value.toLowerCase();
      const rows = document.querySelectorAll('#incidentTable tr');
      rows.forEach(row => {
        const cells = Array.from(row.getElementsByTagName('td'));
        const match = cells.some(cell => cell.textContent.toLowerCase().includes(input));
        row.style.display = match ? '' : 'none';
      });
    }

    window.onload = function () {
      loadHistoriques();
      setInterval(loadHistoriques, 5000); // Rafraîchir automatiquement toutes les 5 secondes
    };
  </script>
</body>
</html>
