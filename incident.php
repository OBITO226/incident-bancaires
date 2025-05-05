<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Incidents informatiques UEMOA</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    h1, h2 {
      text-align: center;
      color: #333;
    }

    .menu {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      background-color: #0a75ad;
    }

    .menu img {
      height: 40px;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-btn {
      background-color: #0a75ad;
      color: white;
      padding: 10px 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      left: 0;
      background-color: white;
      min-width: 200px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 6px;
      z-index: 1000;
    }

    .dropdown-content a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .container {
      max-width: 900px;
      margin: 20px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    input[type="text"], button {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
    }

    th, td {
      padding: 10px;
      border-bottom: 1px solid #e0e0e0;
      text-align: left;
    }

    th {
      background-color: #eaf6fc;
      color: #333;
    }

    #incidentCount {
      font-weight: bold;
      color: #0a75ad;
    }

    .tr-animate {
      animation: fadeSlide 0.4s ease-in-out;
    }

    @keyframes fadeSlide {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="menu">
    <div class="dropdown">
      <button class="dropdown-btn" onclick="toggleMenu()">☰ Menu</button>
      <div class="dropdown-content" id="dropdownMenu">
        <a href="#" onclick="exportTableToPDF()">📄 Exporter en PDF</a>
      </div>
    </div>
    <img src="photo/R (1).jpeg" alt="Logo UEMOA">
  </div>

  <div class="container">
    <h1>Incidents informatiques - Espace UEMOA</h1>

    <input type="text" id="searchInput" placeholder="🔍 Rechercher un incident..." onkeyup="filterTable()">
    <p><strong>Nombre total d'incidents : <span id="incidentCount">0</span></strong></p>

    <table id="incidentTable">
      <thead>
        <tr>
          <th>Entreprise</th>
          <th>Gravité</th>
          <th>Type</th>
          <th>Date</th>
          <th>Statut</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <h2>Ajouter un nouvel incident</h2>
    <form id="incidentForm" onsubmit="ajouterIncident(event)">
      <input type="text" id="entreprise" placeholder="Nom de l'entreprise" oninput="remplirDate()" required>
      <input type="text" id="gravite" placeholder="Gravité (Faible, Moyenne, Élevée)" required>
      <input type="text" id="type" placeholder="Type d'incident" required>
      <input type="text" id="date" placeholder="Date (auto)" readonly required>
      <input type="text" id="statut" placeholder="Statut" required>
      <button type="submit">💾 Enregistrer</button>
    </form>
  </div>

  <script>
    function toggleMenu() {
      const menu = document.getElementById("dropdownMenu");
      menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
      if (!event.target.matches('.dropdown-btn')) {
        const menu = document.getElementById("dropdownMenu");
        if (menu) menu.style.display = "none";
      }
    };

    function getTodayDate() {
      const today = new Date();
      return `${String(today.getDate()).padStart(2, '0')}/${String(today.getMonth() + 1).padStart(2, '0')}/${today.getFullYear()}`;
    }

    function getDateForDB() {
      return new Date().toISOString().split('T')[0];
    }

    function remplirDate() {
      const dateInput = document.getElementById("date");
      if (!dateInput.value) {
        dateInput.value = getTodayDate();
      }
    }

    function ajouterIncident(event) {
      event.preventDefault();
      const entreprise = document.getElementById("entreprise").value;
      const gravite = document.getElementById("gravite").value;
      const type = document.getElementById("type").value;
      const statut = document.getElementById("statut").value;
      const date = getDateForDB();

      fetch("enregistrer_entreprise.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ entreprise, gravite, type, date, statut })
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        document.getElementById("incidentForm").reset();
        document.getElementById("date").value = "";
        chargerIncidents();
      })
      .catch(() => alert("Erreur lors de l'ajout."));
    }

    function chargerIncidents() {
      fetch("recuperer_entreprises.php")
        .then(res => res.json())
        .then(data => {
          const tbody = document.querySelector("#incidentTable tbody");
          const countSpan = document.getElementById("incidentCount");
          tbody.innerHTML = "";
          countSpan.textContent = data.length;

          data.forEach(item => {
            const tr = document.createElement("tr");
            tr.classList.add("tr-animate");
            tr.innerHTML = `
              <td>${item.entreprise}</td>
              <td>${item.gravite}</td>
              <td>${item.type_incident}</td>
              <td>${new Date(item.date_incident).toLocaleDateString()}</td>
              <td>${item.statut}</td>
            `;
            tbody.appendChild(tr);
          });
        });
    }

    function filterTable() {
      const filter = document.getElementById("searchInput").value.toUpperCase();
      const rows = document.querySelectorAll("#incidentTable tbody tr");
      rows.forEach(row => {
        const text = row.innerText.toUpperCase();
        row.style.display = text.includes(filter) ? "" : "none";
      });
    }

    function exportTableToExcel(tableID, filename = 'incidents_uemoa.xls') {
      const table = document.getElementById(tableID);
      const tableHTML = table.outerHTML.replace(/ /g, '%20');
      const downloadLink = document.createElement("a");
      downloadLink.href = 'data:application/vnd.ms-excel,' + tableHTML;
      downloadLink.download = filename;
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }

    function exportTableToPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF('landscape');

      const img = new Image();
      img.src = "photo/R (1).jpeg";

      img.onload = function () {
        const pageWidth = doc.internal.pageSize.getWidth();
        const logoWidth = 50;
        const logoHeight = 20;
        const logoX = (pageWidth - logoWidth) / 2;
        const logoY = 10;

        doc.addImage(img, 'JPEG', logoX, logoY, logoWidth, logoHeight);

        // Titre centré sous le logo
        doc.setFontSize(14);
        doc.text("Incidents informatiques - Espace UEMOA", pageWidth / 2, logoY + logoHeight + 10, { align: "center" });

        const rows = [];
        const headers = [["Entreprise", "Gravité", "Type", "Date", "Statut"]];
        const table = document.querySelectorAll("#incidentTable tbody tr");

        table.forEach(row => {
          const cells = row.querySelectorAll("td");
          const rowData = Array.from(cells).map(cell => cell.textContent);
          rows.push(rowData);
        });

        doc.autoTable({
          head: headers,
          body: rows,
          styles: { fontSize: 10 },
          headStyles: { fillColor: [10, 117, 173] },
          startY: logoY + logoHeight + 20
        });

        doc.save("incidents_uemoa.pdf");
      };

      img.onerror = function () {
        alert("Erreur de chargement du logo.");
      };
    }

    window.onload = chargerIncidents;
  </script>
</body>
</html>
