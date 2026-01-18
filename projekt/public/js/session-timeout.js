let idleTime = 0;
const MAX_IDLE_TIME = 15*60;

setInterval(() => {
    idleTime++;

    if (idleTime >= MAX_IDLE_TIME) {
        fetch("/Projekt-Programim-Web/projekt/public/logout.php", {
            method: "POST",
            credentials: "same-origin"
        }).finally(() => {
            window.location.replace("/Projekt-Programim-Web/projekt/public/login.php?timeout=1");
        });
    }
}, 1000);

['mousemove', 'keydown', 'click', 'scroll'].forEach(event => {
    document.addEventListener(event, () => idleTime = 0);
});
