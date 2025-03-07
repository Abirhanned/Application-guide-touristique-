var timeRemaining = 60; // Durée du jeu en secondes
        var timer = document.getElementById('time');
        var result = document.getElementById('result');

        // Met à jour le timer toutes les secondes
        var countdown = setInterval(function() {
            timeRemaining--;
            timer.textContent = timeRemaining + " secondes";

            if (timeRemaining <= 0) {
                clearInterval(countdown);
                checkGameEnd(); // Vérifie si le jeu est terminé
            }
        }, 1000);

        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text", event.target.id);
        }

        function drop(event) {
            event.preventDefault();
            var data = event.dataTransfer.getData("text");
            var droppedElement = document.getElementById(data);

            // Vérifie la correspondance région-specialité
            if ((event.target.id === 'bordeaux' && data === 'canele') ||
                (event.target.id === 'normandie' && data === 'camembert') ||
                (event.target.id === 'provence' && data === 'ratatouille') ||
                (event.target.id === 'alsace' && data === 'choucroute') ||
                (event.target.id === 'bourgogne' && data === 'escargots') ||
                (event.target.id === 'franche_comte' && data === 'cancoillote') ||
                (event.target.id === 'aquitaine' && data === 'pimentDEspelette')) {

                // Déplace la spécialité à la bonne région
                event.target.appendChild(droppedElement);
                droppedElement.setAttribute("draggable", "false"); // Désactive le drag
                droppedElement.style.backgroundColor = "#d4edda"; // Change la couleur si correct
            } else {
                droppedElement.style.backgroundColor = "#f8d7da"; // Indique erreur
                setTimeout(() => {
                    droppedElement.style.backgroundColor = "#e8e8e8"; // Restaure la couleur
                }, 500);
            }

            checkGameEnd(); // Vérifie si le jeu est terminé après chaque déplacement
        }

        // Vérifie si le jeu est terminé
        function checkGameEnd() {
            var allPlacedCorrectly = true;
            var regions = document.querySelectorAll('.region');

            regions.forEach(function(region) {
                if (region.children.length === 0) {
                    allPlacedCorrectly = false;
                }
            });

            if (allPlacedCorrectly || timeRemaining <= 0) {
                clearInterval(countdown);
                result.textContent = "Le jeu est terminé ! " + (timeRemaining <= 0 ? "Le temps est écoulé." : "Toutes les spécialités ont été correctement placées !");
            }
        }