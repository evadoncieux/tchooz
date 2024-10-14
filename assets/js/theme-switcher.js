let checkbox = document.querySelector("input[name=theme_switch]");

if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
    document.documentElement.setAttribute("data-theme", "dark");
    checkbox.checked = true;
    console.log('dark theme toggled');
} else {
    document.documentElement.setAttribute("data-theme", "light");
    checkbox.checked = false;
    console.log('light theme toggled');
}

checkbox.addEventListener("change", (cb) => {
    document.documentElement.setAttribute(
        "data-theme",
        cb.target.checked ? "dark" : "light"
    );
});
