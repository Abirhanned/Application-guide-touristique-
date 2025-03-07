document.addEventListener("DOMContentLoaded", function () {
    const images = [
      "images/corse.jpg",
      "images/lyon_2.jpg",
      "images/lille.jpg",
      "images/auvergne.jpg",
      "images/Bastille.jpg",
      "images/cosquer.webp",
      "images/hotel.jpg",
    ];
    const gameGrid = document.getElementById("game-grid");
    const endMessage = document.getElementById("end-message");
    const resultMessage = document.getElementById("result-message");
    const replayButton = document.getElementById("replay-button");
  
    let firstCard = null;
    let secondCard = null;
    let attempts = 0;
    let pairsFound = 0;
    let gameStarted = false;
  
    function createGrid() {
      const doubledImages = [...images, ...images]; // Duplique les images pour former des paires
      const shuffledImages = doubledImages.sort(() => 0.5 - Math.random()); // Mélange aléatoire
  
      shuffledImages.forEach((image, index) => {
        const card = document.createElement("div");
        card.classList.add("card");
        card.dataset.image = image;
        card.innerHTML = `
          <div class="card-front"></div>
          <div class="card-back" style="background-image: url('${image}');"></div>
        `;
        card.addEventListener("click", () => {
          if (gameStarted) flipCard(card);
        });
        gameGrid.appendChild(card);
      });
  
      // Révéler toutes les cartes pendant 5 secondes
      revealCardsTemporarily();
    }
  
    function revealCardsTemporarily() {
      const allCards = document.querySelectorAll(".card");
      allCards.forEach((card) => card.classList.add("flipped"));
  
      setTimeout(() => {
        allCards.forEach((card) => card.classList.remove("flipped"));
        gameStarted = true;
        document.getElementById("instruction").textContent = "Trouvez toutes les paires !";
      }, 5000);
    }
  
    function flipCard(card) {
      if (card.classList.contains("flipped") || secondCard) return;
  
      card.classList.add("flipped");
  
      if (!firstCard) {
        firstCard = card;
      } else {
        secondCard = card;
        checkMatch();
      }
    }
  
    function checkMatch() {
      attempts++;
      if (firstCard.dataset.image === secondCard.dataset.image) {
        pairsFound++;
        resetCards(true);
        if (pairsFound === images.length) {
          endGame();
        }
      } else {
        setTimeout(() => resetCards(false), 1000);
      }
    }
  
    function resetCards(isMatch) {
      if (!isMatch) {
        firstCard.classList.remove("flipped");
        secondCard.classList.remove("flipped");
      }
      firstCard = null;
      secondCard = null;
    }
  
    function endGame() {
      gameGrid.style.display = "none";
      endMessage.style.display = "block";
  
      if (attempts <= 10) {
        resultMessage.textContent = `🎉 Bravo ! Vous avez trouvé toutes les paires en ${attempts} essais !`;
      } else if (attempts <= 15) {
        resultMessage.textContent = `😊 Pas mal ! Vous avez terminé en ${attempts} essais.`;
      } else {
        resultMessage.textContent = `😢 Vous pouvez faire mieux ! ${attempts} essais nécessaires.`;
      }
    }
  
    replayButton.addEventListener("click", () => {
      gameGrid.innerHTML = "";
      gameGrid.style.display = "grid";
      endMessage.style.display = "none";
      attempts = 0;
      pairsFound = 0;
      firstCard = null;
      secondCard = null;
      gameStarted = false;
      createGrid();
    });
  
    createGrid();
  });
  