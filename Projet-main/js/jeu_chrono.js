// Liste des villes et leurs populations avec un range pour le tableau
const cities = [
    { range: 1, name: "Paris", population: 2113705 },
    { range: 2, name: "Marseille", population: 877215 },
    { range: 3, name: "Lyon", population: 520774 },
    { range: 4, name: "Toulouse", population: 511684 },
    { range: 5, name: "Nice", population: 353701 },
    { range: 6, name: "Nantes", population: 325070 },
    { range: 7, name: "Montpellier", population: 307101 },
    { range: 8, name: "Strasbourg", population: 291709 },
    { range: 9, name: "Bordeaux", population: 265328 },
    { range: 10, name: "Lille", population: 238695 },
    { range: 11, name: "Rennes", population: 227830 },
    { range: 12, name: "Toulon", population: 180834 },
    { range: 13, name: "Reims", population: 178478 },
    { range: 14, name: "Saint-Étienne", population: 172569 },
    { range: 15, name: "Le Havre", population: 166462 },
    { range: 16, name: "Dijon", population: 155090 },
    { range: 17, name: "Angers", population: 154508 },
    { range: 18, name: "Villeurbanne", population: 150148 },
    { range: 19, name: "Le Mans", population: 143431 },
    { range: 20, name: "Aix-en-Provence", population: 142149 },
    { range: 21, name: "Clermont-Ferrand", population: 141569 },
    { range: 22, name: "Brest", population: 139163 },
    { range: 23, name: "Tours", population: 136565 },
    { range: 24, name: "Amiens", population: 134057 },
    { range: 25, name: "Perpignan", population: 121875 },
    { range: 26, name: "Metz", population: 119738 },
    { range: 27, name: "Besançon", population: 116775 },
    { range: 28, name: "Orléans", population: 114286 },
    { range: 29, name: "Saint-Denis", population: 112000 },
    { range: 30, name: "Argenteuil", population: 110000 }
];

const tableBody = document.getElementById("cityTable").getElementsByTagName("tbody")[0];
let timeLeft = 90;  // Durée du chronomètre en secondes (90 secondes)
let timerInterval;
let addedCities = [];  // Liste des villes déjà ajoutées
let gameOver = false;  // Vérifier si le jeu est terminé

// Fonction pour démarrer le chronomètre
function startTimer() {
  timerInterval = setInterval(() => {
    timeLeft--;
    document.getElementById("timer").textContent = "Temps restant : " + timeLeft;

    if (timeLeft <= 0) {
      clearInterval(timerInterval);  // Arrêter le timer quand il atteint 0
      gameOver = true;
      displayScore();
    }
  }, 1000);  // Chaque seconde
}

// Fonction pour ajouter une ville au tableau avec animation
function addCityToTable(cityName) {
  const city = cities.find(c => c.name.toLowerCase() === cityName.toLowerCase());

  if (city) {
    // Vérifier si la ville a déjà été ajoutée
    if (addedCities.includes(city.name.toLowerCase())) {
      showError("Cette ville a déjà été ajoutée.");
      return;
    }

    // Créer une nouvelle ligne dans le tableau
    const row = tableBody.insertRow();
    row.classList.add("table-row");  // Ajouter la classe pour l'animation

    // Insérer les données des cellules
    const nameCell = row.insertCell(0);
    const populationCell = row.insertCell(1);

    nameCell.textContent = city.range + ". " + city.name;
    populationCell.textContent = city.population;

    // Ajouter la classe 'visible' pour activer l'animation
    setTimeout(() => row.classList.add("visible"), 100);

    // Ajouter la ville à la liste des villes ajoutées
    addedCities.push(city.name.toLowerCase());

    // Trier le tableau après ajout de la ville
    sortTable();
  } else {
    showError("Ville non trouvée.");
  }
}

// Fonction pour afficher le message d'erreur
function showError(message) {
  const errorText = document.getElementById("errorText");
  errorText.textContent = message;
  errorText.style.color = "red";  // Afficher le message en rouge

  // Disparition du message après 3 secondes
  setTimeout(() => {
    errorText.textContent = "";
  }, 3000);  // Disparaît après 3 secondes
}

// Permettre la soumission avec la touche Entrée
document.getElementById("cityInput").addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      submitCity();
    }
  });

// Fonction de tri du tableau par ordre décroissant de la population
function sortTable() {
  const rows = Array.from(tableBody.rows);
  rows.sort((a, b) => {
    const populationA = parseInt(a.cells[1].textContent.replace(/[^0-9]/g, ''));  // Extraire la population
    const populationB = parseInt(b.cells[1].textContent.replace(/[^0-9]/g, ''));  // Extraire la population
    return populationB - populationA; // Trier par ordre décroissant de la population
  });

  // Réorganiser les lignes du tableau après le tri
  rows.forEach(row => tableBody.appendChild(row));
}

// Fonction pour soumettre une ville
function submitCity() {
  const cityName = document.getElementById("cityInput").value.trim();
  if (cityName && !gameOver) {
    addCityToTable(cityName);
    document.getElementById("cityInput").value = "";  // Réinitialiser le champ de saisie
  } else if (gameOver) {
    showError("Le jeu est terminé !");
  } else {
    showError("Veuillez entrer une ville !");
  }
}

// Fonction pour afficher le score final
function displayScore() {
  const score = addedCities.length;
  const scoreText = `Vous avez trouvé ${score} villes.`;
  document.getElementById("score").textContent = scoreText;

  // Afficher des messages en fonction du score
  if (score === 0) {
    document.getElementById("message").textContent = "Dommage, essayez de mieux faire la prochaine fois !";
  } else if (score <= 10) {
    document.getElementById("message").textContent = "Pas mal ! Mais vous pouvez faire mieux.";
  } else if (score <= 20) {
    document.getElementById("message").textContent = "Bien joué ! Vous avez bien progressé.";
  } else {
    document.getElementById("message").textContent = "Excellent ! Vous êtes un expert des villes françaises !";
  }
}

// Lancer le jeu au chargement de la page
document.addEventListener("DOMContentLoaded", function() {
  startTimer();
});
