const targetSequence = "france";
let inputSequence = "";

document.addEventListener("keydown", (event) => {
  inputSequence += event.key.toLowerCase();
  inputSequence = inputSequence.slice(-targetSequence.length);

  if (inputSequence === targetSequence) {
    addGamesTab();
  }
});

function addGamesTab() {
  const navbarList = document.querySelector(".navbar-nav");

  // Vérifie si l'onglet existe déjà
  if (document.getElementById("games-tab")) return;

  // Création de l'élément pour l'onglet "JEUX"
  const gamesTab = document.createElement("li");
  gamesTab.id = "games-tab";
  gamesTab.classList.add("nav-item");

  const link = document.createElement("a");
  link.classList.add("nav-link");
  link.href = "jeux.php"; // Redirige vers une page pour les mini-jeux
  link.textContent = "Jeux";

  gamesTab.appendChild(link);

  // Sélectionner l'élément "Programme" et "Aide"
  const programmeTab = document.querySelector('a[href="programme.php"]').parentElement;
  const aideTab = document.querySelector('a[href="aide.php"]').parentElement;

  // Insérer l'onglet "Jeux" avant "Aide" et après "Programme"
  navbarList.insertBefore(gamesTab, aideTab);
}