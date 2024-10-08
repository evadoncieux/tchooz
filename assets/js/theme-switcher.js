// noinspection DuplicatedCode

let checkbox = document.querySelector("input[name=theme_switch]");

if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
    document.documentElement.setAttribute("data-theme", "dark");
    checkbox.checked = true;
    console.log('1');
} else {
    document.documentElement.setAttribute("data-theme", "light");
    checkbox.checked = false;
    console.log('0');
}

// switch theme if checkbox is engaged

checkbox.addEventListener("change", (cb) => {
    document.documentElement.setAttribute(
        "data-theme",
        cb.target.checked ? "dark" : "light"
    );
});