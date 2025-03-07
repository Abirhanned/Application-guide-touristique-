document.addEventListener("DOMContentLoaded", function () {
    let timerElement = document.getElementById("timer");
    let questionElement = document.getElementById("question");
    let answersElement = document.getElementById("answers");
    let questionNumberElement = document.getElementById("question-number");

    let questions = [
        { question: "Quelle ville du Languedoc est célèbre pour sa citadelle médiévale ?", options: ["Toulouse", "Toulon", "Montellmar", "Carcassonne"], correct: "Carcassonne" },
        { question: "Quelle ville est connue pour son festival de cinéma ?", options: ["Nice", "Cannes", "Lyon", "Bordeaux"], correct: "Cannes" },
        { question: "Dans quelle ville se trouve la cathédrale Notre-Dame ?", options: ["Marseille", "Strasbourg", "Paris", "Nantes"], correct: "Paris" },
        { question: "Quelle ville est la capitale de la région Provence-Alpes-Côte d'Azur ?", options: ["Marseille", "Nice", "Toulon", "Aix-en-Provence"], correct: "Marseille" },
        { question: "Quelle ville est célèbre pour son vin de Champagne ?", options: ["Bordeaux", "Reims", "Dijon", "Lyon"], correct: "Reims" },
        { question: "Dans quelle ville se trouve le Mont-Saint-Michel ?", options: ["Rennes", "Caen", "Nantes", "Le Mont-Saint-Michel"], correct: "Le Mont-Saint-Michel" },
        { question: "Quelle ville est connue pour son carnaval annuel ?", options: ["Nice", "Dunkerque", "Limoges", "Toulouse"], correct: "Nice" },
        { question: "Quelle ville est la capitale de la Bretagne ?", options: ["Brest", "Rennes", "Nantes", "Quimper"], correct: "Rennes" },
        { question: "Dans quelle ville se trouve le musée du Louvre ?", options: ["Paris", "Lyon", "Marseille", "Lille"], correct: "Paris" },
        { question: "Quelle ville est célèbre pour son festival de jazz ?", options: ["Nice", "Juan-les-Pins", "Paris", "Bordeaux"], correct: "Juan-les-Pins" }
    ];

    let currentQuestionIndex = 0;
    let score = 0;
    let timeLeft = 60;
    let userAnswers = []; // Pour stocker les réponses de l'utilisateur
    let timerInterval;

    // Fonction pour mettre à jour le timer
    function updateTimer() {
        timerElement.textContent = "Temps restant : " + timeLeft;
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            endGame();
        } else {
            timeLeft--;
        }
    }

    // Fonction pour arrêter le jeu
    function stopGame() {
        clearInterval(timerInterval);
        window.location.href = "jeux.php"; // Redirige vers la page jeux.php
    }

    // Fonction pour charger la question
    function loadQuestion() {
        if (currentQuestionIndex >= questions.length) {
            endGame();
            return;
        }

        let questionData = questions[currentQuestionIndex];
        questionElement.textContent = questionData.question;
        answersElement.innerHTML = "";
        questionNumberElement.textContent = `Question ${currentQuestionIndex + 1} / ${questions.length}`;

        // Ajouter un bouton "Arrêter le jeu"
        let stopButton = document.createElement("button");
        stopButton.textContent = "Arrêter le jeu";
        stopButton.onclick = stopGame; // Lorsqu'on clique, arrêter et revenir à la page jeux.php
        answersElement.appendChild(stopButton);

        // Créer les options pour la question
        questionData.options.forEach(option => {
            let button = document.createElement("button");
            button.textContent = option;
            button.onclick = function () {
                userAnswers.push({ question: questionData.question, chosenAnswer: option, correctAnswer: questionData.correct });
                if (option === questionData.correct) {
                    score++;
                }
                currentQuestionIndex++;
                loadQuestion();
            };
            answersElement.appendChild(button);
        });
    }

    // Fonction pour afficher les résultats à la fin du jeu
    function endGame() {
        clearInterval(timerInterval); // Arrêter le timer
        questionElement.textContent = "Quiz terminé ! Score : " + score + " / " + questions.length;

        // Afficher le message basé sur le score
        let resultMessage = "";
        if (score >= 7) {
            resultMessage = "🎉 Bravo ! Vous avez bien réussi !";
        } else if (score >= 3) {
            resultMessage = "😊 Pas mal, mais vous pouvez faire mieux !";
        } else {
            resultMessage = "😢 Dommage, essayez encore !";
        }
        answersElement.innerHTML = "";

        // Afficher les réponses de l'utilisateur
        displayUserAnswers();

        // Créer un élément pour afficher le message
        let messageElement = document.createElement("div");
        messageElement.style.marginTop = "20px";
        messageElement.style.fontSize = "20px";
        messageElement.style.fontWeight = "bold";
        messageElement.style.textAlign = "center";
        messageElement.textContent = resultMessage;
        answersElement.appendChild(messageElement);

        // Ajouter un bouton pour rejouer
        let playAgainButton = document.createElement("button");
        playAgainButton.textContent = "Rejouer";
        playAgainButton.onclick = function () {
            window.location.reload();
        };
        answersElement.appendChild(playAgainButton);
    }

    // Fonction pour afficher les réponses de l'utilisateur avec les réponses correctes
    function displayUserAnswers() {
        let resultElement = document.createElement("div");
        resultElement.style.marginTop = "20px";
        resultElement.style.textAlign = "left";
        resultElement.innerHTML = "<h3>Vos réponses :</h3>";

        userAnswers.forEach((answer, index) => {
            let answerDiv = document.createElement("div");
            answerDiv.style.marginBottom = "10px";
            answerDiv.style.padding = "10px";
            answerDiv.style.border = "1px solid #ddd";
            answerDiv.style.borderRadius = "8px";
            answerDiv.style.backgroundColor = answer.chosenAnswer === answer.correctAnswer ? "#d4edda" : "#f8d7da"; // couleur en fonction de la réponse

            answerDiv.innerHTML = `<strong>Question ${index + 1} :</strong> ${answer.question}<br>
                                    <strong>Votre réponse :</strong> ${answer.chosenAnswer}<br>
                                    <strong>Réponse correcte :</strong> ${answer.correctAnswer}`;
            resultElement.appendChild(answerDiv);
        });

        answersElement.appendChild(resultElement);
    }

    // Démarrage du timer et du quiz
    timerInterval = setInterval(updateTimer, 1000);
    loadQuestion();
});