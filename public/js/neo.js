// ===================================================================
// Theme Switcher
// ===================================================================
const themeSwitcher = document.getElementById("theme-switcher");
const html = document.documentElement;

// Set initial theme from localStorage or system preference
const currentTheme = localStorage.getItem("theme") || "light";
html.setAttribute("data-theme", currentTheme);

if (themeSwitcher) {
    themeSwitcher.addEventListener("click", () => {
        const newTheme = html.getAttribute("data-theme") === "light" ? "dark" : "light";
        html.setAttribute("data-theme", newTheme);
        localStorage.setItem("theme", newTheme);
    });
}

// ===================================================================
// Scroll Animations
// ===================================================================
const scrollElements = document.querySelectorAll(".reveal-on-scroll");

const elementInView = (el, dividend = 1) => {
    const elementTop = el.getBoundingClientRect().top;

    return (
        elementTop <=
        (window.innerHeight || document.documentElement.clientHeight) / dividend
    );
};

const displayScrollElement = (element) => {
    element.classList.add("is-visible");
};

const hideScrollElement = (element) => {
    element.classList.remove("is-visible");
};

const handleScrollAnimation = () => {
    scrollElements.forEach((el) => {
        if (elementInView(el, 1.25)) {
            displayScrollElement(el);
        } else {
            // Optional: hide element when it's out of view
            // hideScrollElement(el);
        }
    });
};

window.addEventListener("scroll", () => {
    handleScrollAnimation();
});

// ===================================================================
// Hamburger Menu
// ===================================================================
const hamburgerBtn = document.querySelector(".hamburger-btn");
const mobileNav = document.querySelector(".mobile-nav");

if (hamburgerBtn && mobileNav) {
    hamburgerBtn.addEventListener("click", () => {
        hamburgerBtn.classList.toggle("is-active");
        mobileNav.classList.toggle("is-active");
    });
}

