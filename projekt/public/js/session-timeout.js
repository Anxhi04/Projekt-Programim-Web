let idleTime = 0;
const MAX_IDLE_TIME = 15*60;

setInterval(() => {
    idleTime++;

    if (idleTime >= MAX_IDLE_TIME) {
        fetch("/projekt/public/logout.php", {
            method: "POST",
            credentials: "same-origin"
        }).finally(() => {
            window.location.replace("/projekt/public/login.html?timeout=1");
        });
    }
}, 1000);

// Reset idleTime
['mousemove', 'keydown', 'click', 'scroll'].forEach(event => {
    document.addEventListener(event, () => idleTime = 0);
});
