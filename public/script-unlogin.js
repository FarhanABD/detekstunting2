document.addEventListener("DOMContentLoaded", function () {
    const heroText = document.querySelector(".hero-content");
    heroText.style.opacity = "0";
    heroText.style.transform = "translateY(20px)";

    setTimeout(() => {
        heroText.style.opacity = "1";
        heroText.style.transform = "translateY(0)";
        heroText.style.transition = "opacity 1s ease-in-out, transform 1s ease-in-out";
    }, 500);
});


