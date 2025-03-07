let slideIndex = 0; // Index de la diapositive active
showSlides();

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // Masquer toutes les diapositives
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // Réinitialiser l'index si nécessaire
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}

    // Réinitialiser l'état des points
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Afficher la diapositive et activer le point correspondant
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";

    // Changer l'image toutes les 3 secondes
    setTimeout(showSlides, 3000);
}
