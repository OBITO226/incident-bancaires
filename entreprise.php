<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Entreprises Bancaires - Incidents UEMOA</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f4f4;
    }

    .menu {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background-color: #0a75ad;
    }

    .dropdown {
      position: relative;
    }

    .dropdown-btn {
      background-color: #0a75ad;
      color: white;
      padding: 10px;
      border: none;
      font-size: 16px;
      cursor: pointer;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 40px;
      left: 0;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      z-index: 1000;
      min-width: 200px;
      border-radius: 6px;
    }

    .dropdown-content a {
      padding: 12px;
      display: block;
      color: #333;
      text-decoration: none;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .menu img {
      height: 40px;
    }

    .container {
      padding: 20px;
    }

    h1, h2 {
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background: white;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
    }

    th {
      background-color: #eaf6fc;
    }

    input, button {
      padding: 10px;
      margin: 10px 0;
      width: 100%;
      font-size: 16px;
      box-sizing: border-box;
    }

    #addButton {
      background-color: #007bff;
      color: white;
      border: none;
    }

    #addButton:hover {
      background-color: #0056b3;
    }

    .success-message {
      color: green;
    }

    #compteurEntreprises {
      margin-top: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="menu">
  <div class="dropdown">
    <button class="dropdown-btn" onclick="toggleMenu()">☰ Menu</button>
    <div class="dropdown-content" id="menuContent">
      <a href="#" onclick="exportTableToPDF()">📄 Exporter en PDF</a>
    </div>
  </div>
  <img src="photo/R (1).jpeg" alt="Logo UEMOA">
</div>

<div class="container">
  <h1>Entreprises Bancaires Touchées dans l'Espace UEMOA</h1>

  <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Rechercher une entreprise ou un incident...">

  <!-- Compteur -->
  <div id="compteurEntreprises"><strong>Total :</strong> <span id="totalCount">0</span> entreprises</div>

  <table id="incidentTable">
    <thead>
      <tr>
        <th>Nom de l'Entreprise</th>
        <th>Pays</th>
        <th>Type d'Incident</th>
        <th>Date</th>
        <th>Statut</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $conn = new mysqli("localhost", "root", "", "incidents_bancaires");

      if ($conn->connect_error) {
          echo "<tr><td colspan='5'>Erreur de connexion à la base de données</td></tr>";
      } else {
          $result = $conn->query("SELECT entreprise, pays, type_incident, date_incident, statut FROM incidents ORDER BY date_incident DESC");

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $date = $row['date_incident'] ? date("d/m/Y", strtotime($row['date_incident'])) : "Date inconnue";
                  echo "<tr>
                          <td>{$row['entreprise']}</td>
                          <td>{$row['pays']}</td>
                          <td>{$row['type_incident']}</td>
                          <td>{$date}</td>
                          <td>{$row['statut']}</td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Aucun incident enregistré.</td></tr>";
          }
          $conn->close();
      }
      ?>
    </tbody>
  </table>

  <h2>Ajouter une nouvelle entreprise</h2>
  <input type="text" id="entreprise" class="form-input" placeholder="Nom de l'entreprise">
  <input type="text" id="pays" class="form-input" placeholder="Pays">
  <input type="text" id="type" class="form-input" placeholder="Type d'incident">
  <input type="text" id="statut" class="form-input" placeholder="Statut">
  <button id="addButton" onclick="addIncident()">Ajouter une entreprise</button>
  <div id="message" class="success-message"></div>
</div>

<script>
  function toggleMenu() {
    const menu = document.getElementById("menuContent");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  }

  window.onclick = function(e) {
    if (!e.target.matches('.dropdown-btn')) {
      const menu = document.getElementById("menuContent");
      if (menu) menu.style.display = "none";
    }
  };

  function updateCount() {
    const rows = document.querySelectorAll("#incidentTable tbody tr");
    let count = 0;
    rows.forEach(row => {
      if (row.style.display !== "none") count++;
    });
    document.getElementById("totalCount").textContent = count;
  }

  function filterTable() {
    const input = document.getElementById("searchInput").value.toUpperCase();
    const rows = document.querySelectorAll("#incidentTable tbody tr");
    rows.forEach(row => {
      const cells = row.querySelectorAll("td");
      let visible = false;
      cells.forEach(cell => {
        if (cell.innerText.toUpperCase().includes(input)) visible = true;
      });
      row.style.display = visible ? "" : "none";
    });
    updateCount();
  }

  function getTodayDateForDB() {
    const today = new Date();
    return today.toISOString().split('T')[0];
  }

  function formatDateForDisplay(ymd) {
    const [year, month, day] = ymd.split("-");
    return `${day}/${month}/${year}`;
  }

  function addIncident() {
    const entreprise = document.getElementById("entreprise").value.trim();
    const pays = document.getElementById("pays").value.trim();
    const type = document.getElementById("type").value.trim();
    const statut = document.getElementById("statut").value.trim();
    const date = getTodayDateForDB();

    if (!entreprise || !pays || !type || !statut) {
      alert("Veuillez remplir tous les champs.");
      return;
    }

    fetch("ajouter_incident.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ entreprise, pays, type, date, statut })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const table = document.getElementById("incidentTable").getElementsByTagName("tbody")[0];
        const newRow = table.insertRow(0);
        newRow.innerHTML = `
          <td>${entreprise}</td>
          <td>${pays}</td>
          <td>${type}</td>
          <td>${formatDateForDisplay(date)}</td>
          <td>${statut}</td>
        `;
        document.getElementById("message").textContent = data.message;
        document.getElementById("entreprise").value = "";
        document.getElementById("pays").value = "";
        document.getElementById("type").value = "";
        document.getElementById("statut").value = "";
        updateCount();
      } else {
        alert("Erreur lors de l'ajout : " + data.message);
      }
    })
    .catch(error => {
      console.error("Erreur :", error);
      alert("Échec de l'enregistrement.");
    });
  }

  function exportTableToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');

    const img = new Image();
    img.src = "photo/R (1).jpeg";
    img.onload = function () {
      const pageWidth = doc.internal.pageSize.getWidth();
      doc.addImage(img, 'JPEG', (pageWidth - 50) / 2, 10, 50, 20);
      doc.setFontSize(14);
      doc.text("Entreprises Bancaires Touchées dans l'Espace UEMOA", pageWidth / 2, 35, { align: "center" });

      const headers = [["Entreprise", "Pays", "Type", "Date", "Statut"]];
      const rows = [];
      document.querySelectorAll("#incidentTable tbody tr").forEach(row => {
        const cells = row.querySelectorAll("td");
        const rowData = Array.from(cells).map(cell => cell.textContent);
        rows.push(rowData);
      });

      doc.autoTable({
        head: headers,
        body: rows,
        startY: 40,
        styles: { fontSize: 10 },
        headStyles: { fillColor: [10, 117, 173] }
      });

      doc.save("Entreprises_Bancaires_UEMOA.pdf");
    };
    img.onerror = () => alert("Erreur lors du chargement du logo.");
  }

  // Appel initial pour compter les lignes au chargement
  window.onload = updateCount;
</script>

</body>
</html>
