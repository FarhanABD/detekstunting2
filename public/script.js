const container = document.querySelector(".container");
const registerBtn = document.querySelector(".register-btn");
const loginBtn = document.querySelector(".login-btn");

// Toggle antara form login dan register
registerBtn.addEventListener("click", () => {
    container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
    container.classList.remove("active");
});

document.addEventListener("DOMContentLoaded", function () {
    // Toggle password visibility for login form
    const toggleLoginPassword = document.getElementById("toggleLoginPassword");
    const loginPasswordInput = document.getElementById("loginPassword");

    if (toggleLoginPassword && loginPasswordInput) {
        toggleLoginPassword.addEventListener("click", function () {
            const type =
                loginPasswordInput.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            loginPasswordInput.setAttribute("type", type);
            toggleLoginPassword.classList.toggle("bx-hide");
            toggleLoginPassword.classList.toggle("bx-show");
        });
    }

    // Toggle password visibility for registration form
    const toggleRegisterPassword = document.getElementById(
        "toggleRegisterPassword"
    );
    const registerPasswordInput = document.getElementById("registerPassword");

    if (toggleRegisterPassword && registerPasswordInput) {
        toggleRegisterPassword.addEventListener("click", function () {
            const type =
                registerPasswordInput.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            registerPasswordInput.setAttribute("type", type);
            toggleRegisterPassword.classList.toggle("bx-hide");
            toggleRegisterPassword.classList.toggle("bx-show");
        });
    }
});
